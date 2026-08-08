<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Updater {

    protected $ci;
    protected $zip_url;
    protected $tmp_dir;
    protected $backup_dir;
    protected $exclude = array('.git', 'uploads', '.htaccess', 'README.md', 'version.txt', 'vendor');

    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->config->load('update', true);
        $this->zip_url = $this->ci->config->item('update_zip_fallback_url', 'update');
        if(empty($this->zip_url)) {
            $this->zip_url = 'https://codeload.github.com/dewecorp/mypos/zip/refs/heads/main';
        }
        $this->tmp_dir = FCPATH.'uploads/update';
        $this->backup_dir = FCPATH.'uploads/backup';
    }

    public function run_update()
    {
        set_time_limit(0);
        @ini_set('max_execution_time', 0);

        $dl = $this->download();
        if(!$dl['status']) { return $dl; }

        $extract_dir = $this->tmp_dir.'/extract';
        $this->rrmdir($extract_dir);
        @mkdir($extract_dir, 0777, true);

        $ex = $this->extract_zip($dl['path'], $extract_dir);
        if(!$ex['status']) { return $ex; }

        $src = $this->detect_root($extract_dir);

        $backup = $this->backup();
        if(!$backup) { return array('status' => false, 'message' => 'Gagal membuat cadangan'); }

        $this->deploy($src);

        $this->rrmdir($extract_dir);
        @unlink($dl['path']);

        return array('status' => true, 'message' => 'Sistem berhasil diperbarui', 'backup' => $backup);
    }

    protected function download()
    {
        if(!is_dir($this->tmp_dir)) { @mkdir($this->tmp_dir, 0777, true); }
        $zip_path = $this->tmp_dir.'/update.zip';
        $fp = fopen($zip_path, 'w');
        $ch = curl_init($this->zip_url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => false,
            CURLOPT_FILE => $fp,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_TIMEOUT => 300,
            CURLOPT_HTTPHEADER => array('User-Agent: MyPOS-Updater')
        ));
        $ok = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        fclose($fp);
        if(!$ok || $code != 200 || filesize($zip_path) < 100) {
            @unlink($zip_path);
            return array('status' => false, 'message' => 'Gagal mengunduh paket update (HTTP '.$code.')');
        }
        return array('status' => true, 'path' => $zip_path);
    }

    public function extract_zip($zip_path, $dest)
    {
        $zip = new MyZipReader($zip_path);
        if(!$zip->open()) { return array('status' => false, 'message' => 'Paket update bukan file ZIP valid'); }
        $names = $zip->names();
        $has_index = false;
        $has_app = false;
        foreach($names as $n) {
            $base = str_replace('\\', '/', $n);
            if(strpos($base, 'index.php') !== false) { $has_index = true; }
            if(strpos($base, 'application/') !== false) { $has_app = true; }
        }
        if(!$has_index || !$has_app) {
            return array('status' => false, 'message' => 'Paket update tidak memiliki struktur aplikasi yang sah');
        }
        $ok = $zip->extractTo($dest);
        if(!$ok) { return array('status' => false, 'message' => 'Gagal membongkar paket update'); }
        return array('status' => true);
    }

    public function detect_root($dir)
    {
        if(file_exists($dir.'/index.php') && is_dir($dir.'/application')) { return $dir; }
        $items = array_diff(scandir($dir), array('.', '..'));
        foreach($items as $it) {
            $p = $dir.'/'.$it;
            if(is_dir($p) && file_exists($p.'/index.php')) { return $p; }
        }
        return $dir;
    }

    public function backup()
    {
        if(!is_dir($this->backup_dir)) { @mkdir($this->backup_dir, 0777, true); }
        $name = 'backup_'.date('Ymd_His');
        $dest = $this->backup_dir.'/'.$name;
        if(!mkdir($dest, 0777, true)) { return false; }
        $skip = array_merge($this->exclude, array('backup', 'update'));
        $this->recurse_copy(FCPATH, $dest, $skip);
        return $name;
    }

    public function deploy($src)
    {
        $skip = array_merge($this->exclude, array('application/config/database.php', 'application/config/config.php'));
        $this->recurse_copy($src, FCPATH, $skip);
    }

    protected function recurse_copy($src, $dst, $skip = array())
    {
        if(!is_dir($src)) { return; }
        $items = scandir($src);
        foreach($items as $item) {
            if($item === '.' || $item === '..') { continue; }
            if(in_array($item, $skip, true)) { continue; }
            $s = $src.'/'.$item;
            $d = $dst.'/'.$item;
            if(is_dir($s)) {
                if(!is_dir($d)) { @mkdir($d, 0777, true); }
                $this->recurse_copy($s, $d, $skip);
            } else {
                $rel = str_replace('\\', '/', str_replace(FCPATH, '', $d));
                if(in_array($rel, $skip, true)) { continue; }
                @copy($s, $d);
                @chmod($d, 0644);
            }
        }
    }

    protected function rrmdir($dir)
    {
        if(!is_dir($dir)) { return; }
        $items = scandir($dir);
        foreach($items as $item) {
            if($item === '.' || $item === '..') { continue; }
            $p = $dir.'/'.$item;
            if(is_dir($p) && !is_link($p)) { $this->rrmdir($p); } else { @unlink($p); }
        }
        @rmdir($dir);
    }
}

class MyZipReader {

    private $handle = null;
    private $entries = array();

    public function __construct($path)
    {
        $this->handle = fopen($path, 'rb');
    }

    public function open()
    {
        if(!$this->handle) { return false; }
        $size = filesize_from_handle($this->handle);
        if($size < 22) { return false; }
        $tail = 65536;
        fseek($this->handle, max(0, $size - $tail));
        $chunk = fread($this->handle, $tail);
        $pos = strrpos($chunk, "PK\x05\x06");
        if($pos === false) { return false; }
        $eocd = substr($chunk, $pos);
        $total = unpack('vtotal', substr($eocd, 10, 2))['total'];
        $cd_offset = unpack('Voff', substr($eocd, 16, 4))['off'];
        fseek($this->handle, $cd_offset);
        for($i = 0; $i < $total; $i++) {
            $sig = fread($this->handle, 4);
            if($sig !== "PK\x01\x02") { return false; }
            $hdr = fread($this->handle, 42);
            $d = unpack('vmade/vneed/vflags/vmethod/vtime/vdate/Vcrc/Vcsize/Vusize/vnlen/vextra/vcmlen/vdisk/vint/Vext/Voffset', $hdr);
            $name = fread($this->handle, $d['nlen']);
            fseek($this->handle, $d['extra'] + $d['cmlen'], SEEK_CUR);
            $this->entries[] = array(
                'name' => $name,
                'method' => $d['method'],
                'crc' => $d['crc'],
                'csize' => $d['csize'],
                'usize' => $d['usize'],
                'offset' => $d['offset']
            );
        }
        return true;
    }

    public function names()
    {
        return array_column($this->entries, 'name');
    }

    public function getEntries()
    {
        return $this->entries;
    }

    public function extractTo($dest)
    {
        if(!is_dir($dest)) { @mkdir($dest, 0777, true); }
        foreach($this->entries as $e) {
            $name = str_replace('\\', '/', $e['name']);
            if($name === '' || strpos($name, '..') !== false || strpos($name, '../') !== false || $name[0] === '/') {
                return false;
            }
            if(substr($name, -1) === '/') {
                $p = $dest.'/'.$name;
                if(!is_dir($p)) { @mkdir($p, 0777, true); }
                continue;
            }
            if(!$this->locate($e)) { return false; }
            if((int)$e['csize'] > 0) {
                $data = fread($this->handle, $e['csize']);
            } else {
                $data = '';
            }
            if($e['method'] === 0) {
                $raw = $data;
            } elseif($e['method'] === 8) {
                $raw = $data === '' ? '' : @gzinflate($data);
                if($raw === false) { return false; }
            } else {
                return false;
            }
            if(strlen($raw) !== (int)$e['usize']) { return false; }
            if(hash('crc32b', $raw) !== str_pad(dechex($e['crc']), 8, '0', STR_PAD_LEFT)) { return false; }
            $full = $dest.'/'.$name;
            $base = str_replace('\\', '/', realpath($dest));
            if(strpos(str_replace('\\', '/', $full), $base.'/') !== 0) { return false; }
            $dir = dirname($full);
            if(!is_dir($dir)) { @mkdir($dir, 0777, true); }
            file_put_contents($full, $raw);
            @chmod($full, 0644);
        }
        return true;
    }

    private function locate($e)
    {
        fseek($this->handle, $e['offset']);
        $sig = fread($this->handle, 4);
        if($sig !== "PK\x03\x04") { return false; }
        $hdr = fread($this->handle, 26);
        $d = unpack('vneed/vflag/vmethod/vtime/vdate/Vcrc/Vcsize/Vusize/vnlen/vextra', $hdr);
        fseek($this->handle, $d['nlen'] + $d['extra'], SEEK_CUR);
        return ftell($this->handle);
    }
}

function filesize_from_handle($h)
{
    $st = fstat($h);
    return $st['size'];
}