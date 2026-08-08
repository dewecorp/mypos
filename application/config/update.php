<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Sumber update (zip). Diisi manual / bukan UI.
 */
$config['update_repo'] = 'dewecorp/mypos';
$config['update_branch'] = 'main';
$config['update_zip_url'] = 'https://github.com/dewecorp/mypos/releases/latest/download/mypos.zip';
$config['update_check_url'] = 'https://api.github.com/repos/dewecorp/mypos/releases/latest';
/* Cadangan bila tidak ada release: versi dari file version.txt + arsip zip branch */
$config['update_raw_version_url'] = 'https://raw.githubusercontent.com/dewecorp/mypos/HEAD/version.txt';
$config['update_zip_fallback_url'] = 'https://codeload.github.com/dewecorp/mypos/zip/refs/heads/main';
