<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Updater — versi baru aplikasi diambil dari GitHub (zipball), dibongkar,
 * lalu file aplikasi ditimpa. Konfigurasi lingkungan dan data toko
 * (database, uploads, backup, sesi) TIDAK pernah disentuh.
 */
class Updater {

    protected $ci;
    protected $zip_url;
    protected $version_url;
    protected $tmp_dir;

    public function __construct()
    {
        $this->ci = get_instance();
        $this->ci->config->load('update', true);
        $this->zip_url     = $this->ci->config->item('update_zip_fallback_url', 'update');
        $this->version_url = $this->ci->config->item('update_raw_version_url', 'update');
        if (empty($this->zip_url))     { $this->zip_url     = 'https://codeload.github.com/dewecorp/mypos/zip/refs/heads/main'; }
        if (empty($this->version_url)) { $this->version_url = 'https://raw.githubusercontent.com/dewecorp/mypos/HEAD/version.txt'; }
        $this->tmp_dir = rtrim(FCPATH, '/\\').'/uploads/update';
    }

    /* ===== Info versi ===== */

    public function current_version()
    {
        $f = FCPATH.'version.txt';
        return file_exists($f) ? trim(file_get_contents($f)) : '';
    }

    public function latest_version()
    {
        $url = (string)$this->version_url;
        if (strpos($url, 'https://') !== 0) { return null; }
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT        => 20,
            CURLOPT_USERAGENT      => 'MyPOS-Updater'
        ));
        $out = curl_exec($ch);
        $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($code !== 200 || $out === false) { return null; }
        $v = trim($out);
        return preg_match('/^\d+(\.\d+)*/', $v) ? $v : null;
    }

    /* ------------------------------------------------------------------ Alur utama
    ------------------------------------------------------------------ */

    /**
     * Proses pembaruan penuh.
     * @return array {ok: bool, message: string}
     */
    public function run_update()
    {
        @set_time_limit(0);
        $this->prep_tmp_dir();

        // 1) Unduh paket dari GitHub.
        $dl = $this->download();
        if (!$dl['ok']) { return $this->result(false, $dl['message']); }
        $zip = $dl['path'];

        // 2) Buka arsip & cek integritas.
        $reader = new MyZipReader($zip);
        if (!$reader->open()) {
            return $this->fail_cleanup($zip, true, 'Paket pembaruan bukan arsip ZIP yang sah.');
        }

        // 3) Ekstrak ke folder sementara.
        $ext = $this->tmp_dir.'/extract';
        $this->rmdir_r($ext);
        @mkdir($ext, 0775, true);
        if (!$reader->extractTo($ext)) {
            return $this->fail_cleanup($zip, true, 'Arsip pembaruan tidak dapat dibongkar penuhli.');
        }

        // 4) Tentukan folder proyek (folder induk zipball) yang punya index.php + application/.
        $src = $this->find_project_root($ext);
        if ($src === null) {
            return $this->fail_cleanup($zip, true, 'Struktur proyek pada paket tidak dikenali (tidak ada index.php / application/).');
        }

        // 5) Timpa file applikas (path berbahaya & lingkungan DISKIP).
        if (!$this->copy_project($src, FCPATH)) {
            return $this->fail_cleanup($zip, true, 'Gagal menulis file pembaruan — periksa izin folder.');
        }

        // 6) Simpan versi terbaru.
        $latest = $this->latest_version();
        if ($latest) {
            $vf = FCPATH.'version.txt';
            @chmod($vf, 0644);
            file_put_contents($vf, $latest);
        }

        // 7) Bersihkan.
        $this->rmdir_r($ext);
        @unlink($zip);
        return $this->result(true, 'Sistem berhasil diperbarui'.($latest ? ' ke v'.$latest : '').'.');
    }

    /* ------------------------------------------------------------------ Bantuan ---
------------------------------------------------------------------------- */

    protected function prep_tmp_dir()
    {
        if (!is_dir($this->tmp_dir)) { @mkdir($this->tmp_dir, 0775, true); }
    }

    protected function result($ok, $msg)
    {
        return array('ok' => (bool)$ok, 'message' => $msg);
    }

    protected function fail_cleanup($zip, $rmExt, $msg)
    {
        if ($rmExt) { $this->rmdir_r($this->tmp_dir.'/extract'); }
        @unlink($zip);
        return $this->result(false, $msg);
    }

    protected function download()
    {
        $host = strtolower((string)parse_url($this->zip_url, PHP_URL_HOST));
        if (!in_array($host, array('codeload.github.com', 'github.com'), true)
            || strpos($this->zip_url, 'https://') !== 0) {
            return array('ok' => false, 'message' => 'Sumber pembaruan tidak valid.');
        }
        $zip = $this->tmp_dir.'/update.zip';
        @unlink($zip);
        $fh = @fopen($zip, 'wb');
        if (!$fh) {
            return array('ok' => false, 'message' => 'Folder sementara tidak dapat ditulis ('.$this->tmp_dir.').');
        }
        $ch = curl_init($this->zip_url);
        curl_setopt_array($ch, array(
            CURLOPT_FILE           => $fh,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 5,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_CONNECTTIMEOUT => 20,
            CURLOPT_TIMEOUT        => 600,
            CURLOPT_USERAGENT      => 'MyPOS-Updater'
        ));
        $ran = curl_exec($ch);
        $code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        fclose($fh);
        $size = (int)@filesize($zip);
        if ($ran === false || $code !== 200 || $size < 1000) {
            @unlink($zip);
            return array('ok' => false, 'message' => 'Gagal mengunduh pembaruan (HTTP '.$code.', '.$size.' byte).');
        }
        return array('ok' => true, 'path' => $zip);
    }

    /** Cari folder proyek di dalam hasil ekstrak (dalam zipball: folder *-main). */
    protected function find_project_root($ext)
    {
        if (is_file($ext.'/index.php') && is_dir($ext.'/application')) { return $ext; }
        foreach (array_diff(scandir($ext), array('.', '..')) as $item) {
            $p = $ext.'/'.$item;
            if (is_dir($p) && is_file($p.'/index.php') && is_dir($p.'/application')) { return $p; }
        }
        return null;
    }

    /**
     * Daftar jalur layanan yang TIDAK BOLEH katahaan saat pembaruan.
     * Relatif terhadap root (FCPATH), slash netral.
     */
    protected function protected_paths()
    {
        return array(
            '.git',
            'uploads',
            'backup',
            'sessions',
            'update',
            'version.txt',
            'application/config/database.php',
            'application/config/config.php',
            'application/config/update.php',
            'application/cache',
            'application/logs',
        );
    }

    /** True bila $rel (relatif root) masuk daftar proteksi. */
    protected function is_protected($rel)
    {
        $rel = trim(str_replace('\\', '/', $rel), '/');
        foreach ($this->protected_paths() as $p) {
            $p = trim($p, '/');
            if ($rel === $p || strpos($rel, $p.'/') === 0) { return true; }
        }
        return false;
    }

    /** Salin isi $src ke $dst (recurcive) dengan filter proteksi. */
    protected function copy_project($src, $dst)
    {
        $root = rtrim(str_replace('\\', '/', FCPATH), '/');
        foreach (array_diff(scandir($src), array('.', '..')) as $item) {
            $s = rtrim($src, '/\\').'/'.$item;
            $d = rtrim($dst, '/\\').'/'.$item;
            $dn = str_replace('\\', '/', $d);
            $rel = (strpos($dn, $root.'/') === 0) ? substr($dn, strlen($root) + 1) : $dn;
            if ($this->is_protected($rel)) { continue; }
            if (is_dir($s)) {
                if (!is_dir($d)) { if (!@mkdir($d, 0775, true)) { return false; } }
                if (!$this->copy_project($s, $d)) { return false; }
            } else {
                if (!@copy($s, $d)) { return false; }
                @chmod($d, 0644);
            }
        }
        return true;
    }

    protected function rmdir_r($dir)
    {
        if (!is_dir($dir)) { return; }
        foreach (array_diff(scandir($dir), array('.', '..')) as $it) {
            $p = $dir.'/'.$it;
            if (is_dir($p) && !is_link($p)) { $this->rmdir_r($p); } else { @unlink($p); }
        }
        @rmdir($dir);
    }
}

/* ====================================================================== *
 * MyZipReader — pembaca ZIP tanpa ekstensi zip (store + deflate).        *
 * ====================================================================== */

class MyZipReader {

    private $h;
    private $entries = array();
    private $failed = array();

    public function __construct($path) { $this->h = @fopen($path, 'rb'); }

    public function getFailed() { return $this->failed; }

    public function open()
    {
        if (!$this->h) { return false; }
        $size = fstat($this->h)['size'];
        if ($size < 22) { return false; }
        fseek($this->h, max(0, $size - 65536));
        $chunk = fread($this->h, min(65536, $size));
        $pos = strrpos($chunk, "PK\x05\x06");
        if ($pos === false) { return false; }
        $eocd = substr($chunk, $pos);
        $total = unpack('v', substr($eocd, 10, 2))[1];
        $off   = unpack('V', substr($eocd, 16, 4))[1];
        fseek($this->h, $off);
        for ($i = 0; $i < $total; $i++) {
            $sig = fread($this->h, 4);
            if ($sig === "PK\x05\x06" || $sig === '') { break; }
            if ($sig !== "PK\x01\x02") { return false; }
            $d = unpack('vmade/vneed/vflag/vmethod/vtime/vdate/Vcrc/Vcsize/Vusize/vnlen/vextra/vcmlen/vdisk/vint/Vext/Voffset', fread($this->h, 42));
            $name = $d['nlen'] > 0 ? fread($this->h, $d['nlen']) : '';
            fseek($this->h, $d['extra'] + $d['cmlen'], SEEK_CUR);
            $this->entries[] = array(
                'name'   => $name,
                'method' => $d['method'],
                'crc'    => $d['crc'],
                'csize'  => $d['csize'],
                'usize'  => $d['usize'],
                'offset' => $d['offset'],
            );
        }
        return true;
    }

    public function names()
    {
        $out = array();
        foreach ($this->entries as $e) { $out[] = $e['name']; }
        return $out;
    }

    /** Ekstrak semua entri ke $dest. True bila tak hegang entri bermasalah. */
    public function extractTo($dest)
    {
        if (!is_dir($dest)) { @mkdir($dest, 0775, true); }
        $base = rtrim(str_replace('\\', '/', realpath($dest)), '/');
        foreach ($this->entries as $e) {
            $name = str_replace('\\', '/', $e['name']);

            // Keamanan path.
            if ($name === '' || $name[0] === '/' || strpos($name, '../') !== false
                || strpos($name, '..\\') !== false) {
                $this->failed[] = ($name === '' ? '(tanpa nama)' : $name);
                continue;
            }

            if (substr($name, -1) === '/') { // direktori
                @mkdir($dest.'/'.$name, 0775, true);
                continue;
            }

            // Baca data dari offset local file header.
            fseek($this->h, $e['offset']);
            if (fread($this->h, 4) !== "PK\x03\x04") { $this->failed[] = $name; continue; }
            $d = unpack('vver/vflag/vmethod/vtime/vdate/Vcrc/Vcsize/Vusize/vnlen/vextra', fread($this->h, 26));
            fseek($this->h, $d['nlen'] + $d['extra'], SEEK_CUR);
            $data = $e['csize'] > 0 ? fread($this->h, $e['csize']) : '';

            if ($e['method'] === 0)        { $raw = $data; }
            elseif ($e['method'] === 8)    { $raw = @gzinflate($data); }
            else                           { $this->failed[] = $name; continue; }

            if ($raw === false || strlen($raw) !== (int)$e['usize']) { $this->failed[] = $name; continue; }
            $crcGot = str_pad(dechex($e['crc']), 8, '0', STR_PAD_LEFT);
            if ($crcGot !== hash('crc32b', $raw)) { $this->failed[] = $name; continue; }

            $full = str_replace('\\', '/', $dest.'/'.$name);
            if (strpos($full, $base.'/') !== 0) { $this->failed[] = $name; continue; }

            $dir = dirname($full);
            if (!is_dir($dir)) { @mkdir($dir, 0775, true); }
            file_put_contents($full, $raw);
        }
        return empty($this->failed);
    }
}