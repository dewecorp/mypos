
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?=base_url()?>assets/dist/img/sales_icon.svg">

  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
  <style>
    body, .content-wrapper, .main-header, .main-sidebar, .btn, .form-control, .nav-link, h1, h2, h3, h4, h5, h6, span, p, a, div, table, th, td, label {
      font-family: 'Poppins', sans-serif !important;
    }
    body, .content-wrapper, .main-header, .main-sidebar, .btn, .form-control, .nav-link, span, p, a, div, table, th, td, label {
      font-size: 11pt !important;
    }
  </style>
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>
<?php $is_pos_page = strtolower($this->router->fetch_class()) == 'sale' && strtolower($this->router->fetch_method()) == 'index'; ?>
<body class="hold-transition <?=$is_pos_page ? 'layout-top-nav' : 'sidebar-mini layout-navbar-fixed'?>">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-blue navbar-light">
    <!-- Left navbar links -->
    <?php if(!$is_pos_page) { ?>
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <?php } ?>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item d-none d-sm-inline-block">
        <span class="nav-link" id="live_clock" style="cursor: default; font-weight: bold;"></span>
      </li>
      <!-- Messages Dropdown Menu -->
      <?php if($is_pos_page) { ?>
        <li class="nav-item">
          <a href="<?=site_url('dashboard')?>" class="nav-link" target="_blank"> <i class="fas fa-user-cog"></i><strong> Login Admin</strong></a>
        </li>
      <?php } else { ?>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?=site_url('auth/logout')?>" class="nav-link"> <i class="fas fa-sign-out-alt"></i><strong> Log Out</strong></a>
      </li>
      <?php } ?>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <?php if(!$is_pos_page) { ?>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 sticky-top">
    <!-- Brand Logo -->
    <a href="<?=site_url('dashboard')?>" class="brand-link">
      <img src="<?=base_url()?>assets/dist/img/sales_icon.svg"
           alt="MyPOS Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light"><?= $this->fungsi->get_setting()->shop_name ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?=base_url()?>assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?=ucfirst($this->fungsi->user_login()->name)?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- <li class="nav-header">MENU UTAMA</li>  -->
          <li class="nav-item has-treeview">
            <a href="<?=site_url('dashboard')?>" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                 Dashboard
              </p>
            </a>
          </li>
        <li class="nav-header">MENU UTAMA</li>
          
          <li class="nav-item">
            <a href="<?=site_url('item')?>" class="nav-link">
              <i class="nav-icon fas fa-archive"></i>
              <p>Data Barang</p>
            </a>
          </li>
          <?php if ($this->fungsi->user_login()->level != 1) { ?>
          <li class="nav-item">
            <a href="<?=site_url('sale')?>" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>Penjualan</p>
            </a>
          </li>
          <?php } ?>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Laporan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=site_url('sale/report')?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Penjualan</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="<?=site_url('stock/report')?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Stok</p>
                </a>
              </li> -->

            </ul>
          </li>

          <?php if ($this->fungsi->user_login()->level == 1) { ?>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-header">PENGATURAN</li>  
          <li class="nav-item">
            <a href="<?=site_url('setting')?>" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>Toko</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=site_url('user')?>" class="nav-link">
              <i class="nav-icon fas fa-user"></i>              <p>
               Pengguna
              </p>
            </a>
          </li>
        </ul>
        <?php } ?>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <?php } ?>

  <script src="<?=base_url()?>assets/plugins/jquery/jquery.min.js"></script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php echo $contents  ?>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>Copyright &copy; <?php echo date('Y') ?>  <a href="">myPOS</a>.</strong> All rights
    reserved.
  </footer>

</div>
<!-- ./wrapper -->


<script src="<?=base_url()?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script src="<?=base_url()?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>assets/dist/js/adminlte.min.js"></script>
<script src="<?=base_url()?>assets/plugins/chart.js/Chart.min.js"></script>
<script src="<?=base_url()?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- overlayScrollbars -->
<script src="<?=base_url()?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?=base_url()?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?=base_url()?>assets/plugins/toastr/toastr.min.js"></script>
<script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url()?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url()?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script>
  $(function () {
    $('#tabel').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
    });
  });

  $(document).on('click', 'a.swal-delete-link', function(e){
    e.preventDefault();
    var href = $(this).attr('href');
    var title = $(this).data('title') || 'Yakin menghapus data ini?';
    Swal.fire({
      title: title,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus',
      cancelButtonText: 'Batal'
    }).then(function(res){
      if(res.isConfirmed) { window.location = href; }
    });
  });
  $(document).on('submit', 'form.swal-delete-form', function(e){
    e.preventDefault();
    var $form = $(this);
    var title = $form.data('title') || 'Yakin menghapus data ini?';
    Swal.fire({
      title: title,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus',
      cancelButtonText: 'Batal'
    }).then(function(res){
      if(res.isConfirmed) { $form.off('submit').submit(); }
    });
  });

  function updateClock() {
    var now = new Date();
    var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    
    var dayName = days[now.getDay()];
    var date = now.getDate();
    var monthName = months[now.getMonth()];
    var year = now.getFullYear();
    
    var hours = String(now.getHours()).padStart(2, '0');
    var minutes = String(now.getMinutes()).padStart(2, '0');
    var seconds = String(now.getSeconds()).padStart(2, '0');
    
    var timeString = dayName + ', ' + date + ' ' + monthName + ' ' + year + ' ' + hours + ':' + minutes + ':' + seconds;
    var clockElement = document.getElementById('live_clock');
    if(clockElement) {
        clockElement.textContent = timeString;
    }
  }
  
  setInterval(updateClock, 1000);
  updateClock();
</script>

</body>
</html>
