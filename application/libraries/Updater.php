<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Updater {

    protected $ci;
    protected $zip_url;
    protected $version_url;
    protected $tmp_dir;

    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->config->load('update', true);
        $this->zip_url = $this->ci->config->item('update_zip_fallback_url', 'update');
        $this->version_url = $this->ci->config->item('update_raw_version_url', 'update');
        if(empty($this->zip_url)) { $this->zip_url = 'https://codeload.github.com/dewecorp/mypos/zip/refs/heads/main'; }
        if(empty($this->version_url)) { $this->version_url = 'https://raw.githubusercontent.com/dewecorp/mypos/HEAD/version.txt'; }
        $this->tmp_dir = FCPATH.'uploads/update';
    }

    public function current_version()
    {
        $f = FCPATH.'version.txt';
        return file_exists($f) ? trim(file_get_contents($f)) : '';
    }

    public function latest_version()
    {
        if(strpos($this->version_url, 'https://') !== 0) { return null; }
        $ch = curl_init($this->version_url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTPHEADER => array('User-Agent: MyPOS-Updater')
        ));
        $r = curl_exec($ch);
        $c = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($c !== 200 || !$r) { return null; }
        $v = trim($r);
        return preg_match('/^\d+(\.\d+)*/', $v) ? $v : null;
    }

    /** Tamat 1 >>> Proses update penuh. */
    public function run_update()
    {
        set_time_limit(0);
        if(!is_dir($this->tmp_dir)) { @mkdir($this->tmp_dir, 0777, true); }
        $zip = $this->tmp_dir.'/update.zip';
        @unlink($zip);

        // 1. Unduh
        $host = strtolower((string)parse_url($this->zip_url, PHP_URL_HOST));
        if(!in_array($host, array('codeload.github.com', 'github.com'), true) || strpos($this->zip_url, 'https://') !== 0) {
            return array('ok' => false, 'message' => 'Sumber pembaruan tidak valid');
        }
        $fp = fopen($zip, 'w');
        $ch = curl_init($this->zip_url);
        curl_setopt_array($ch, array(
            CURLOPT_FILE => $fp,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_TIMEOUT => 600,
            CURLOPT_HTTPHEADER => array('User-Agent: MyPOS-Updater')
        ));
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        fclose($fp);
        if($code != 200 || filesize($zip) < 100) {
            @unlink($zip);
            return array('ok' => false, 'message' => 'Gagal mengunduh pembaruan (HTTP '.$code.')');
        }

        // 2. Buka & validasi struktur
        $z = new MyZipReader($zip);
        if(!$z->open()) { @unlink($zip); return array('ok' => false, 'message' => 'Paket pembaruan rusak'); }
        $names = $z->names();
        $has_app = false;
        foreach($names as $n) {
            if(strpos(str_replace('\\','/',$n), 'application/') !== false) { $has_app = true; break; }
        }
        if(!$has_app) { @unlink($zip); return array('ok' => false, 'message' => 'Paket tidak berisi aplikasi yang sah'); }

        // 3. Ekstrak
        $ext = $this->tmp_dir.'/extract';
        $this->rrmdir($ext);
        @mkdir($ext, 0777, true);
        if(!$z->extractTo($ext)) { @unlink($zip); $this->rrmdir($ext); return array('ok' => false, 'message' => 'Gagal membongkar paket'); }

        // 4. Tentukan folder proyek (jika ada folder induk)
        $src = $ext;
        if(file_exists($ext.'/index.php') && is_dir($ext.'/application')) { $src = $ext; }
        else {
            $fav = null;
            foreach(array_diff(scandir($ext), array('.', '..')) as $it) {
                if(is_dir($ext.'/'.$it) && file_exists($ext.'/'.$it.'/index.php')) { $fav = $ext.'/'.$it; break; }
            }
            if($fav) { $src = $fav; }
        }

        // 5. Timpa (skip konfigurasi lingkungan & folder data)
        $skip = array('.git', 'uploads', 'version.txt', 'application/config/database.php', 'application/config/config.php');
        $this->copy_tree($src, FCPATH, $skip);

        // 6. Simpan versi terbaru
        $latest = $this->latest_version();
        if($latest) { @file_put_contents(FCPATH.'version.txt', $latest); }

        $this->rrmdir($ext);
        @unlink($zip);
        return array('ok' => true, 'message' => 'Sistem berhasil diperbarui'.($latest ? ' ke v'.$latest : ''));
    }

    protected function copy_tree($src, $dst, $skip)
    {
        foreach(array_diff(scandir($src), array('.', '..')) as $item) {
            if(in_array($item, $skip, true)) { continue; }
            $s = $src.'/'.$item;
            $d = $dst.'/'.$item;
            $rel = str_replace('\\', '/', str_replace(FCPATH, '', $d));
            if(in_array($rel, $skip, true)) { continue; }
            if(is_dir($s)) {
                if(!is_dir($d)) { @mkdir($d, 0777, true); }
                $this->copy_tree($s, $d, $skip);
            } else {
                @copy($s, $d);
                @chmod($d, 0644);
            }
        }
    }

    protected function rrmdir($dir)
    {
        if(!is_dir($dir)) { return; }
        foreach(array_diff(scandir($dir), array('.', '..')) as $it) {
            $p = $dir.'/'.$it;
            if(is_dir($p) && !is_link($p)) { $this->rrmdir($p); } else { @unlink($p); }
        }
        @rmdir($dir);
    }
}

/* Ekstraktor ZIP berbasis PHP murni (tanpa ekstensi zip) */
class MyZipReader {

    private $h = null;
    private $entries = array();
    private $failed = array();

    public function getFailed() { return $this->failed; }

    public function __construct($path) { $this->h = fopen($path, 'rb'); }

    public function open()
    {
        if(!$this->h) { return false; }
        $size = fstat($this->h)['size'];
        if($size < 22) { return false; }
        fseek($this->h, max(0, $size - 65536));
        $chunk = fread($this->h, min(65536, $size));
        $pos = strrpos($chunk, "PK\x05\x06");
        if($pos === false) { return false; }
        $eocd = substr($chunk, $pos);
        $total = unpack('v', substr($eocd, 10, 2))[1];
        $off = unpack('V', substr($eocd, 16, 4))[1];
        fseek($this->h, $off);
        for($i = 0; $i < $total; $i++) {
            $sig = fread($this->h, 4);
            if($sig === "PK\x05\x06" || $sig === '' ) { break; }
            if($sig !== "PK\x01\x02") { return false; }
            $d = unpack('vmade/vneed/vflag/vmethod/vtime/vdate/Vcrc/Vcsize/Vusize/vnlen/vextra/vcmlen/vdisk/vint/Vext/Voffset', fread($this->h, 42));
            $name = $d['nlen'] > 0 ? fread($this->h, $d['nlen']) : '';
            fseek($this->h, $d['extra'] + $d['cmlen'], SEEK_CUR);
            $this->entries[] = array('name' => $name, 'method' => $d['method'], 'crc' => $d['crc'],
                'csize' => $d['csize'], 'usize' => $d['usize'], 'offset' => $d['offset']);
        }
        return true;
    }

    public function names() { return array_column($this->entries, 'name'); }

    public function getEntries() { return $this->entries; }

    public function extractTo($dest)
    {
        if(!is_dir($dest)) { @mkdir($dest, 0777, true); }
        $base = str_replace('\\', '/', realpath($dest));
        foreach($this->entries as $e) {
            $name = str_replace('\\', '/', $e['name']);
            if($name === '' || $name[0] === '/' || strpos($name, '..') !== false || strpos($name, '../') !== false) {
                $this->failed[] = $name; continue;
            }
            if(substr($name, -1) === '/') { if(!is_dir($dest.'/'.$name)) { @mkdir($dest.'/'.$name, 0777, true); } continue; }
            fseek($this->h, $e['offset']);
            if(fread($this->h, 4) !== "PK\x03\x04") { $this->failed[] = $name; continue; }
            $d = unpack('vx4/vtime/vdate/Vcrc/Vcsize/Vusize/vnlen/vextra', fread($this->h, 26));
            fseek($this->h, $d['nlen'] + $d['extra'], SEEK_CUR);
            $data = $e['csize'] > 0 ? fread($this->h, $e['csize']) : '';
            if($e['method'] === 0) {
                $raw = $data;
            } elseif($e['method'] === 8) {
                $raw = $data === '' ? '' : @gzinflate($data);
            } else {
                $this->failed[] = $name; continue; // metode lain (bzip2/dll) dilewati
            }
            if($raw === false || strlen($raw) !== (int)$e['usize']) { $this->failed[] = $name; continue; }
            if(str_pad(dechex($e['crc']), 8, '0', STR_PAD_LEFT) !== hash('crc32b', $raw)) { $this->failed[] = $name; continue; }
            $full = str_replace('\\', '/', $dest.'/'.$name);
            if(strpos($full, $base.'/') !== 0) { $this->failed[] = $name; continue; }
            $dir = dirname($full);
            if(!is_dir($dir)) { @mkdir($dir, 0777, true); }
            file_put_contents($full, $raw);
        }
        return true;
    }
}