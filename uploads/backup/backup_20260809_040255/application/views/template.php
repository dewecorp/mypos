<!DOCTYPE html>
<?php
  $__brand = $this->fungsi->get_setting();
  $shop_name = (isset($__brand->shop_name) && $__brand->shop_name) ? $__brand->shop_name : 'myPOS';
  $shop_logo = isset($__brand->logo) ? $__brand->logo : '';
  $__cls = strtolower($this->router->fetch_class());
  $__met = strtolower($this->router->fetch_method());
  $__ver = file_exists(FCPATH.'version.txt') ? trim(file_get_contents(FCPATH.'version.txt')) : '';
  if (!isset($title) || !$title) {
    $__map = ['dashboard' => 'Dashboard', 'item' => 'Data Barang', 'sale' => 'Transaksi Penjualan', 'setting' => 'Pengaturan Toko', 'user' => 'Pengguna'];
    $__mapmet = ['report' => 'Laporan', 'add' => 'Tambah', 'edit' => 'Ubah', 'print' => 'Cetak'];
    $__nama = isset($__map[$__cls]) ? $__map[$__cls] : ucfirst(str_replace('_', ' ', $__cls));
    if ($__cls == 'sale' && $__met == 'report') { $__nama = 'Laporan Penjualan'; }
    elseif ($__met != 'index' && isset($__mapmet[$__met])) { $__nama .= ' &mdash; '.$__mapmet[$__met]; }
    $__title = $__nama.' | '.$shop_name;
  } else { $__title = $title; }
  $__is_pos = $__cls == 'sale' && $__met == 'index';
?>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$__title?></title>
  <link rel="icon" href="<?=base_url()?>assets/dist/img/sales_icon.svg">
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap">
  <style>
    * { font-family: 'Plus Jakarta Sans', sans-serif; }
    body { background: #f3f5fa; color: #26304a; font-size: 14px; margin: 0; }
    .app { display: flex; flex-direction: column; min-height: 100vh; }

    /* ===== Topbar ===== */
    .topbar {
      position: sticky; top: 0; z-index: 1000;
      background: linear-gradient(90deg, #0d9488, #10b981);
      border-bottom: none;
      display: flex; align-items: center; height: 62px; padding: 0 22px;
      box-shadow: 0 2px 10px rgba(6, 78, 59, .25);
    }
    .topbar .brand { display: flex; align-items: center; gap: .7rem; text-decoration: none; }
    .topbar .brand img, .topbar .brand .brand-avatar {
      width: 40px; height: 40px; border-radius: 11px; object-fit: cover;
    }
    .topbar .brand .brand-avatar {
      background: #fff; color: #047857;
      display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem;
    }
    .topbar .brand .brand-name { font-weight: 800; font-size: 1.15rem; color: #fff; white-space: nowrap; }
    .topbar .clock { color: #d1fae5; font-weight: 600; font-size: 13px; }
    .topbar .user-name { color: #ecfdf5; font-weight: 600; }
    .topbar .dropdown-menu { border-radius: 12px; box-shadow: 0 10px 30px rgba(6,78,59,.18); border: 1px solid #e7ebf2; padding: .4rem 0; }
    .topbar .dropdown-item { border-radius: 8px; margin: 2px 6px; padding: 8px 12px; font-size: 14px; }
    .topbar .dropdown-item i { width: 18px; text-align: center; }
    .dropdown-toggle-no-caret::after { display: none; }
    .topbar .btn-outline-light { color: #fff; border-color: rgba(255,255,255,.55); }
    .topbar .btn-outline-light:hover { background: rgba(255,255,255,.15); color: #fff; border-color: #fff; }
    .sidebar-toggle {
      background: none; border: none; color: #fff; font-size: 1.2rem; cursor: pointer; padding: 6px 10px; border-radius: 8px; margin-right: 14px;
    }
    .sidebar-toggle:hover { background: rgba(255,255,255,.15); }

    /* ===== Layout ===== */
    .layout { display: flex; min-height: 100vh; }
    .main-sidebar {
      width: 250px; flex: 0 0 250px;
      background: linear-gradient(180deg, #064e3b, #047857);
      color: #d1fae5;
      transition: margin-left .25s ease; padding: 16px 0; position: sticky; top: 0; height: 100vh; overflow-y: auto;
    }
    .sidebar-collapsed .main-sidebar { margin-left: -250px; }
    .main-content { flex: 1; min-width: 0; display: flex; flex-direction: column; }
    .content-wrap { padding: 24px; flex: 1; }
    .main-footer { padding: 14px 24px; border-top: 1px solid #e7ebf2; background: #fff; font-size: 13px; color: #7a8397; text-align: center; }

    /* ===== Sidebar menu ===== */
    .menu-label { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,.5); padding: 14px 22px 6px; }
    .menu-item { display: flex; align-items: center; gap: .75rem; padding: 11px 22px; color: #d1fae5; text-decoration: none; font-weight: 500; transition: background .15s; }
    .menu-item i { width: 20px; text-align: center; }
    .menu-item:hover { background: rgba(255,255,255,.09); color: #fff; text-decoration: none; }
    .menu-item.active { background: #0f766e; color: #fff; box-shadow: inset 3px 0 0 #34d399; }

    /* ===== Components (shim lama) ===== */
    .card { border: none; border-radius: 14px; box-shadow: 0 2px 12px rgba(20,35,70,.07); margin-bottom: 1.25rem; }
    .card-header { background: #fff; border-bottom: 1px solid #eef1f6; border-radius: 14px 14px 0 0 !important; padding: 16px 20px; }
    .card-header .card-title { font-weight: 700; color: #26304a; font-size: 1rem; margin: 0; }
    .card-body { padding: 20px; }
    .box { background: #fff; border-radius: 14px; box-shadow: 0 2px 12px rgba(20,35,70,.07); margin-bottom: 1.25rem; }
    .box-header { padding: 16px 20px; border-bottom: 1px solid #eef1f6; }
    .box-title { font-weight: 700; color: #26304a; font-size: 1rem; margin: 0; }
    .box-body { padding: 20px; }
    .content-header { margin-bottom: 20px; }
    .content-header h1 { font-weight: 800; color: #26304a; margin: 0; font-size: 1.25rem; }
    .content-header h3 { font-weight: 800; color: #26304a; margin: 0; font-size: 1.05rem; }
    .breadcrumb { background: transparent; padding: 0; margin: 0; font-size: 13px; }
    .small-box { border-radius: 14px; color: #fff; padding: 22px; position: relative; overflow: hidden; box-shadow: 0 4px 16px rgba(20,35,70,.14); margin-bottom: 1.25rem; }
    .content .row { margin-bottom: 1.25rem; }
    .small-box .inner h3 { font-size: 1.9rem; font-weight: 800; margin: 0 0 4px; }
    .small-box .inner p { margin: 0; opacity: .92; font-weight: 500; }
    .small-box .icon { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); font-size: 3.4rem; opacity: .35; }
    .bg-info { background: #3b82f6; } .bg-success { background: #22c48b; } .bg-warning { background: #f59e0b; } .bg-danger { background: #ef4444; }
    .bg-primary { background: #4b5f93; } .bg-secondary { background: #8a94a8; } .bg-gray { background: #6b7280; }
    .text-info { color: #3b82f6; } .text-success { color: #22c48b; } .text-danger { color: #ef4444; }
    .elevation-1 { box-shadow: 0 1px 4px rgba(0,0,0,.12); } .elevation-2 { box-shadow: 0 3px 8px rgba(0,0,0,.16); }
    .elevation-3 { box-shadow: 0 6px 14px rgba(0,0,0,.18); } .elevation-4 { box-shadow: 0 10px 24px rgba(0,0,0,.22); }
    .timeline { position: relative; padding-left: 30px; }
    .timeline::before { content: ''; position: absolute; left: 11px; top: 6px; bottom: 6px; width: 2px; background: #e4e8f0; }
    .timeline > div { position: relative; margin-bottom: 18px; }
    .timeline > div > i { position: absolute; left: -30px; top: 2px; width: 24px; height: 24px; border-radius: 50%; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 11px; }
    .timeline .time-label { margin: 0 0 16px !important; }
    .timeline .time-label span { background: #4b5f93; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .timeline-item { background: #fff; border: 1px solid #eef1f6; border-radius: 12px; padding: 14px 16px; box-shadow: 0 1px 6px rgba(20,35,70,.05); }
    .timeline-header { font-size: 13px; margin: 0 0 6px; }
    .timeline-header a { color: #26304a; font-weight: 700; }
    .timeline-body { font-size: 13px; color: #55607a; }
    .timeline .time { font-size: 12px; color: #9aa3b5; }

    /* ===== Forms & buttons ===== */
    .btn { border-radius: 9px; font-weight: 500; }
    .btn-primary { background: #4b5f93; border-color: #4b5f93; }
    .btn-primary:hover { background: #3d4f7d; border-color: #3d4f7d; }
    .form-control { border-radius: 9px; border-color: #dfe3ec; }
    .form-control:focus { border-color: #4b5f93; box-shadow: 0 0 0 .2rem rgba(75,95,147,.12); }
    .table thead th { border-bottom: 2px solid #e4e8f0; color: #4a5368; font-weight: 600; }
    .table-striped tbody tr:nth-of-type(odd) { background: #f8f9fc; }
    .badge { font-weight: 600; }

    /* ===== POS layout ===== */
    .pos-wrap .main-sidebar { display: none; }
    .pos-wrap .content-wrap { padding: 22px; }

    @media (max-width: 992px) {
      .main-sidebar { margin-left: -250px; position: fixed; z-index: 1050; }
      .sidebar-collapsed .main-sidebar { margin-left: 0; }
    }
  </style>
</head>
<body class="<?=$__is_pos ? 'pos-wrap' : ''?>">
<div class="app">
  <!-- Topbar -->
  <div class="topbar">
    <button type="button" class="sidebar-toggle" id="sidebar_toggle" <?=$__is_pos ? 'style="display:none"' : ''?>>
      <i class="fas fa-bars"></i>
    </button>
    <a class="brand" href="<?=site_url($__is_pos ? 'sale' : 'dashboard')?>">
      <?php if(!empty($shop_logo) && file_exists(FCPATH.'uploads/logo/'.$shop_logo)) { ?>
        <img src="<?=base_url('uploads/logo/').$shop_logo?>" alt="<?=htmlspecialchars($shop_name, ENT_QUOTES)?>">
      <?php } else { ?>
        <span class="brand-avatar"><?=strtoupper(substr($shop_name, 0, 1))?></span>
      <?php } ?>
      <span class="brand-name"><?=htmlspecialchars($shop_name, ENT_QUOTES)?></span>
    </a>
    <div class="ml-auto d-flex align-items-center" style="gap:.8rem">
      <span class="clock d-none d-sm-block" id="live_clock"></span>
      <?php
        $__usr = $this->fungsi->user_login();
        $__lv = $__usr ? (int)$__usr->level : 0;
      ?>
      <?php if($__is_pos) { ?>
        <?php if($__lv == 1) { ?>
          <a href="<?=site_url('auth/login')?>" class="btn btn-outline-light btn-sm" target="_blank"><i class="fas fa-user-cog"></i> Login Admin</a>
        <?php } else { ?>
          <a href="<?=site_url('auth/logout')?>" class="btn btn-outline-light btn-sm" id="logout_link"><i class="fas fa-sign-out-alt"></i> Logout</a>
        <?php } ?>
      <?php } else { ?>
        <?php $__uname = ucfirst($__usr ? $__usr->name : ''); ?>
        <?php $__up = ($__usr && !empty($__usr->photo) && file_exists(FCPATH.'uploads/user/'.$__usr->photo)) ? base_url('uploads/user/'.$__usr->photo) : ''; ?>
        <span class="user-name d-none d-sm-inline-block"><?=$__uname?></span>
        <div class="dropdown">
          <button type="button" class="btn p-0 border-0 bg-transparent dropdown-toggle dropdown-toggle-no-caret" data-toggle="dropdown">
            <?php if($__up) { ?>
              <img src="<?=$__up?>" class="rounded-circle" style="width:36px;height:36px;object-fit:cover;border:2px solid rgba(255,255,255,.6);" alt="Foto">
            <?php } else { ?>
              <span class="rounded-circle d-inline-flex align-items-center justify-content-center font-weight-bold" style="width:36px;height:36px;background:#fff;color:#047857;font-size:1rem;"><?=strtoupper(substr($__usr ? $__usr->name : 'U', 0, 1))?></span>
            <?php } ?>
          </button>
          <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-item disabled" style="white-space:normal;color:#26304a;">
              <strong><?=$__uname?></strong><br>
              <small class="text-muted"><?=$__lv == 1 ? 'Admin' : 'Kasir'?></small>
            </div>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?=site_url('dashboard')?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <?php if($__lv == 1) { ?>
            <a class="dropdown-item" href="#" id="update_system"><i class="fas fa-sync-alt"></i> Update Sistem</a>
            <?php } ?>
            <a class="dropdown-item text-danger" href="<?=site_url('auth/logout')?>" id="logout_link"><i class="fas fa-sign-out-alt"></i> Logout</a>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>

  <div class="layout" style="flex:1;">
    <?php if(!$__is_pos) { ?>
    <aside class="main-sidebar" id="main_sidebar">
      <div class="menu-label">Menu Utama</div>
      <a href="<?=site_url('dashboard')?>" class="menu-item <?=$__cls == 'dashboard' ? 'active' : ''?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
      <a href="<?=site_url('item')?>" class="menu-item <?=$__cls == 'item' ? 'active' : ''?>"><i class="fas fa-archive"></i> Data Barang</a>
      <?php if($__lv != 1) { ?>
      <a href="<?=site_url('sale')?>" class="menu-item <?=$__cls == 'sale' && $__met == 'index' ? 'active' : ''?>"><i class="fas fa-shopping-cart"></i> Penjualan</a>
      <?php } ?>
      <a href="<?=site_url('sale/report')?>" class="menu-item <?=$__cls == 'sale' && $__met == 'report' ? 'active' : ''?>"><i class="fas fa-chart-pie"></i> Laporan Penjualan</a>
      <?php if($__lv == 1) { ?>
      <div class="menu-label">Pengaturan</div>
      <a href="<?=site_url('setting')?>" class="menu-item <?=$__cls == 'setting' ? 'active' : ''?>"><i class="fas fa-cogs"></i> Toko</a>
      <a href="<?=site_url('user')?>" class="menu-item <?=$__cls == 'user' ? 'active' : ''?>"><i class="fas fa-user"></i> Pengguna</a>
      <?php } ?>
      <div class="menu-label">Akun</div>
      <a href="<?=site_url('auth/logout')?>" class="menu-item" id="logout_link"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </aside>
    <?php } ?>

    <div class="main-content">
      <div class="content-wrap">
        <?php echo $contents ?>
      </div>
      <footer class="main-footer">
        <strong>Copyright &copy; <?=date('Y')?> <?=htmlspecialchars($shop_name, ENT_QUOTES)?>.</strong> All rights reserved. <span class="float-right">v<?=$__ver?></span>
      </footer>
    </div>
  </div>
</div>

  <script src="<?=base_url()?>assets/plugins/jquery/jquery.min.js"></script>
  <script src="<?=base_url()?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?=base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?=base_url()?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?=base_url()?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?=base_url()?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="<?=base_url()?>assets/plugins/toastr/toastr.min.js"></script>
  <script src="<?=base_url()?>assets/plugins/chart.js/Chart.min.js"></script>
  <script>
    $(function(){
      $('#sidebar_toggle').on('click', function(){
        $('body').toggleClass('sidebar-collapsed');
      });
      $('#tabel').DataTable({
        paging: true, lengthChange: true, searching: true, ordering: true, info: true, autoWidth: true, responsive: true
      });
    });

    $(document).on('click', 'a.swal-delete-link', function(e){
      e.preventDefault();
      var href = $(this).attr('href');
      var title = $(this).data('title') || 'Yakin menghapus data ini?';
      Swal.fire({
        title: title, icon: 'warning', showCancelButton: true,
        confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal'
      }).then(function(res){
        if(res && (res.isConfirmed === true || res.value === true)) { window.location.href = href; }
      });
    });

    $(document).on('submit', 'form.swal-delete-form', function(e){
      var $form = $(this);
      if($form.data('confirmed')) { $form.removeData('confirmed'); return true; }
      e.preventDefault();
      var title = $form.data('title') || 'Yakin menghapus data ini?';
      Swal.fire({
        title: title, icon: 'warning', showCancelButton: true,
        confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal'
      }).then(function(res){
        if(res.isConfirmed) {
          $form.data('confirmed', true);
          $form[0].submit();
        }
      });
    });

    $(document).on('click', '#logout_link', function(e){
      e.preventDefault();
      var href = $(this).attr('href') || '<?=site_url('auth/logout')?>';
      Swal.fire({
        title: 'Yakin ingin keluar?', text: 'Sesi akun Anda akan berakhir.', icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#dc3545',
        confirmButtonText: 'Ya, keluar', cancelButtonText: 'Tidak'
      }).then(function(result){
        if(result && (result.isConfirmed === true || result.value === true)) { window.location.href = href; }
      });
    });

    <?php if(!$__is_pos && $__lv == 1) { ?>
    $(document).on('click', '#update_system', function(e){
      e.preventDefault();
      Swal.fire({
        title: 'Konfirmasi Update',
        html: 'Perbarui sistem dari repositori?<br><strong>Pastikan koneksi stabil.</strong>',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Update',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#047857'
      }).then(function(r){
        if(!r.isConfirmed) { return; }
        Swal.fire({
          title: 'Memproses Update...',
          html: '<i class="fas fa-spinner fa-spin" style="font-size:3rem;color:#047857;display:block;margin-bottom:.5rem;"></i><span class="text-muted">Mengunduh & memasang pembaruan.<br>Proses ini bisa memakan beberapa saat. Mohon tunggu, jangan tutup halaman.</span>',
          showConfirmButton: false, allowOutsideClick: false, allowEscapeKey: false
        });
        $.ajax({
          url: '<?=site_url('update/run')?>',
          method: 'POST',
          data: {},
          dataType: 'json',
          timeout: 0,
          success: function(res){
            if(res && res.success) {
              Swal.fire({ title: 'Update Berhasil!', text: res.message, icon: 'success', confirmButtonColor: '#047857' }).then(function(){ location.reload(); });
            } else {
              Swal.fire({ title: 'Update Gagal', text: (res && res.message ? res.message : 'Terjadi kesalahan'), icon: 'error' });
            }
          },
          error: function(xhr){
            Swal.fire({ title: 'Update Gagal', text: 'Terjadi kesalahan koneksi (' + xhr.status + ')', icon: 'error' });
          }
        });
      });
    });
    <?php } ?>

    function updateClock() {
      var now = new Date();
      var days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
      var months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
      var timeString = days[now.getDay()] + ', ' + now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear() +
        ' ' + String(now.getHours()).padStart(2,'0') + ':' + String(now.getMinutes()).padStart(2,'0') + ':' + String(now.getSeconds()).padStart(2,'0');
      var el = document.getElementById('live_clock');
      if(el) { el.textContent = timeString; }
    }
    setInterval(updateClock, 1000);
    updateClock();
  </script>
</body>
</html>
