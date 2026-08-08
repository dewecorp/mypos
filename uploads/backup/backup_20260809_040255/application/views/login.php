<!DOCTYPE html>
<?php
  $__lg = $this->fungsi->get_setting();
  $lg_name = ($__lg && !empty($__lg->shop_name)) ? $__lg->shop_name : 'myPOS';
  $lg_logo = ($__lg && !empty($__lg->logo)) ? $__lg->logo : '';
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=htmlspecialchars($lg_name, ENT_QUOTES)?> | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?=base_url()?>assets/dist/img/sales_icon.svg">
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/sweetalert2.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/animate.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
    <style>
      * { font-family: 'Plus Jakarta Sans', sans-serif; }
      html, body { height: 100%; }
      body.login-modern {
        background: #eef2f8;
        margin: 0;
        padding: 0;
      }
      .login-wrap {
        display: flex;
        min-height: 100vh;
        width: 100%;
      }
      .login-brand {
        flex: 0 0 46%;
        background: linear-gradient(135deg, #26314b 0%, #4b5f93 100%);
        color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 3rem 3.5rem;
        position: relative;
        overflow: hidden;
      }
      .login-brand::before,
      .login-brand::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,.06);
      }
      .login-brand::before { width: 340px; height: 340px; top: -120px; right: -120px; }
      .login-brand::after { width: 260px; height: 260px; bottom: -90px; left: -90px; }
      .brand-top { display: flex; align-items: center; gap: 1rem; }
      .brand-top img, .brand-avatar {
        width: 56px; height: 56px; border-radius: 14px; object-fit: cover;
        background: #fff; box-shadow: 0 6px 18px rgba(0,0,0,.25);
      }
      .brand-avatar { color:#26314b; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:1.5rem; background:#fff; }
      .brand-top .brand-name { font-weight: 700; font-size: 1.35rem; letter-spacing: .3px; }
      .brand-hero h1 { font-weight: 800; font-size: 2.1rem; line-height: 1.25; margin: 0 0 1rem; }
      .brand-hero p { color: #c9d3ea; font-size: 1rem; margin: 0; }
      .brand-features { display: flex; flex-direction: column; gap: .9rem; }
      .brand-feature {
        display: flex; align-items: center; gap: .9rem;
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.14);
        border-radius: 14px; padding: .85rem 1.1rem;
        backdrop-filter: blur(4px);
      }
      .brand-feature i {
        width: 40px; height: 40px; flex: 0 0 40px; border-radius: 11px;
        background: rgba(255,255,255,.16);
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
      }
      .brand-feature b { display: block; font-size: .95rem; }
      .brand-feature small { color: #b9c4e0; }
      .brand-foot { color: #8f9cc0; font-size: .85rem; }
      .login-form-side {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
      }
      .login-card {
        width: 100%;
        max-width: 420px;
        background: #fff;
        border-radius: 20px;
        padding: 2.5rem 2.5rem 2rem;
        box-shadow: 0 12px 40px rgba(23, 38, 80, .12);
      }
      .login-card h2 { font-weight: 800; color: #26304a; margin: 0 0 .35rem; font-size: 1.6rem; text-align: center; }
      .login-card .sub { color: #7a8397; margin: 0 0 1.6rem; font-size: .95rem; text-align: center; }
      .form-label { font-size: .82rem; font-weight: 600; color: #4a5368; margin-bottom: .35rem; }
      .inp {
        border-radius: 11px; border: 1.6px solid #dfe3ec; padding: .62rem .9rem;
        box-shadow: none !important; transition: border-color .15s ease;
      }
      .inp:focus { border-color: #4b5f93; }
      .inp-icon { border-radius: 11px; border: 1.6px solid #dfe3ec; }
      .btn-login {
        width: 100%; border-radius: 11px; padding: .72rem;
        font-weight: 700; font-size: .98rem;
        background: linear-gradient(135deg, #2f3b56, #4b5f93);
        border: none; color: #fff; box-shadow: 0 8px 20px rgba(43, 60, 110, .28);
        transition: transform .12s ease, box-shadow .12s ease;
      }
      .btn-login:hover { color: #fff; transform: translateY(-1px); box-shadow: 0 10px 24px rgba(43, 60, 110, .36); }
      .login-hint { text-align: center; color: #9aa3b5; font-size: .82rem; margin-top: 1.4rem; }
      .toast-wrap { position: fixed; top: 1.2rem; right: 1.2rem; z-index: 9999; }
      @media (max-width: 900px) {
        .login-wrap { flex-direction: column; }
        .login-brand { flex: none; padding: 2rem 1.5rem; }
        .brand-hero h1 { font-size: 1.6rem; }
        .brand-features { display: none; }
        .login-form-side { padding: 1.5rem 1rem; }
      }
    </style>
  </head>
  <body class="login-modern">
    <div class="login-wrap">
      <!-- Panel Kiri: Branding -->
      <div class="login-brand">
        <div class="brand-top">
          <?php if($lg_logo && file_exists(FCPATH.'uploads/logo/'.$lg_logo)) { ?>
            <img src="<?=base_url('uploads/logo/').$lg_logo?>" alt="<?=htmlspecialchars($lg_name, ENT_QUOTES)?>">
          <?php } else { ?>
            <div class="brand-avatar"><?=strtoupper(substr($lg_name,0,1))?></div>
          <?php } ?>
          <span class="brand-name"><?=htmlspecialchars($lg_name, ENT_QUOTES)?></span>
        </div>

        <div class="brand-hero">
          <h1>Kelola Penjualan Toko Anda.<br>Semua dalam Satu Tempat.</h1>
          <p>Sistem POS modern untuk mencatat transaksi, mengatur stok, dan memantau pendapatan secara real-time.</p>
        </div>

        <div class="brand-features">
          <div class="brand-feature">
            <i class="fas fa-bolt"></i>
            <div><b>Transaksi Cepat</b><small>Proses kasir hanya hitungan detik</small></div>
          </div>
          <div class="brand-feature">
            <i class="fas fa-chart-line"></i>
            <div><b>Laporan Otomatis</b><small>Pantau pendapatan harian & bulanan</small></div>
          </div>
          <div class="brand-feature">
            <i class="fas fa-boxes"></i>
            <div><b>Kontrol Stok</b><small>Data barang terpusat dan akurat</small></div>
          </div>
        </div>

        <div class="brand-foot">© <?=date('Y')?> <?=htmlspecialchars($lg_name, ENT_QUOTES)?></div>
      </div>

      <!-- Panel Kanan: Form -->
      <div class="login-form-side">
        <div class="login-card">
          <?php if(!isset($login_ok) || !$login_ok) { $this->view('messages'); } ?>
          <?php if(isset($login_ok) && $login_ok) {
            $this->session->unset_userdata('success');
            if(isset($_SESSION['__ci_vars']['success'])) unset($_SESSION['__ci_vars']['success']);
          ?>
          <script>
            window.addEventListener('load', function(){
              if(window.Swal){
                var lvl = <?=isset($user_level) ? (int)$user_level : 0?>;
                var target = (lvl == 1) ? '<?=site_url('dashboard')?>' : '<?=site_url('sale')?>';
                var toText = (lvl == 1) ? 'Mengarahkan ke dashboard...' : 'Mengarahkan ke form penjualan...';
                Swal.fire({
                  title: 'Memproses...',
                  html: '<i class="fas fa-spinner fa-spin" style="font-size:3rem;color:#4f67a6;display:block;margin-bottom:.5rem;"></i><span class="text-muted">Mohon tunggu sebentar...</span>',
                  showConfirmButton: false,
                  allowOutsideClick: false,
                  allowEscapeKey: false
                });
                setTimeout(function(){
                  Swal.fire({
                    title: 'Login Berhasil!',
                    html: '<i class="fas fa-check-circle" style="font-size:3rem;color:#28a745;display:block;margin-bottom:.5rem;"></i><strong>Selamat datang kembali.</strong><br><small>'+toText+'</small>',
                    timer: 1800,
                    timerProgressBar: true,
                    showConfirmButton: false
                  });
                  setTimeout(function(){ window.location.href = target; }, 2100);
                }, 1500);
              }
            });
          </script>
          <?php } ?>
          <h2>Selamat Datang! 👋</h2>
          <p class="sub">Masuk untuk melanjutkan ke dashboard.</p>

          <form action="<?=site_url()?>auth/process" method="post">
            <div class="form-group">
              <label class="form-label">Nama Pengguna</label>
              <div class="input-group">
                <input type="text" name="username" class="form-control inp" placeholder="Masukkan username" required autofocus>
                <div class="input-group-append">
                  <div class="input-group-text inp-icon"><span class="fas fa-user"></span></div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label">Kata Sandi</label>
              <div class="input-group">
                <input type="password" name="password" class="form-control inp" placeholder="Masukkan kata sandi" required>
                <div class="input-group-append">
                  <div class="input-group-text inp-icon"><span class="fas fa-lock"></span></div>
                </div>
              </div>
            </div>
            <button type="submit" name="login" class="btn btn-login mt-2">
              <i class="fas fa-sign-in-alt"></i> Masuk
            </button>
          </form>

          <div class="login-hint">Belum punya akun? Hubungi admin toko.</div>
        </div>
      </div>
    </div>

    <script src="<?=base_url()?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?=base_url()?>assets/js/jquery.min.js"></script>
    <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
    <script src="<?=base_url()?>assets/js/sweetalert2.min.js"></script>
  </body>
</html>
