  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Dashboard</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Admin</li>
          </ol>
        </div>
      </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?=$this->fungsi->count_item()?></h3>
                <p>Items</p>
              </div>
              <div class="icon">
                <i class="fas fa-list"></i>
              </div>
              <a href="<?=site_url('item')?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?=number_format($today_income, 0, ",", ".")?></h3>
                <p>Pendapatan Hari Ini</p>
              </div>
              <div class="icon">
                <i class="fas fa-money-bill-wave"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?=number_format($month_income, 0, ",", ".")?></h3>
                <p>Pendapatan Bulan Ini</p>
              </div>
              <div class="icon">
                <i class="fas fa-calendar-alt"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?=number_format($total_income, 0, ",", ".")?></h3>
                <p>Total Pendapatan</p>
              </div>
              <div class="icon">
                <i class="fas fa-chart-line"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Grafik Penjualan (30 hari)</h3>
              </div>
              <div class="card-body">
                <canvas id="salesChart" style="height:300px;"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Aktivitas Pengguna (24 jam)</h3>
              </div>
              <div class="card-body">
                <div style="max-height: 420px; overflow-y: auto;">
                <div class="timeline timeline-inverse">
                  <?php $lastDate = null; foreach($activities as $act) { $curDate = format_tz($act->created_at, 'Asia/Jakarta', 'Y-m-d'); if ($curDate !== $lastDate) { ?>
                  <div class="time-label">
                    <span class="bg-primary"><?=$curDate?></span>
                  </div>
                  <?php $lastDate = $curDate; } ?>
                  <div>
                    <i class="fas fa-user bg-blue"></i>
                    <div class="timeline-item">
                      <span class="time"><i class="far fa-clock"></i> <?=format_tz($act->created_at, 'Asia/Jakarta', 'Y-m-d H:i:s')?> (<?=time_ago($act->created_at)?>)</span>
                      <h3 class="timeline-header"><a href="#"><?=$act->user_name ?: 'System'?></a> <?=$act->type?> <?=$act->entity?></h3>
                      <?php if(!empty($act->message)) { ?>
                      <div class="timeline-body"><?=$act->message?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <?php } ?>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script>
          window.addEventListener('load', function(){
            if (window.Chart) {
              var ctx = document.getElementById('salesChart').getContext('2d');
              var labels = <?=json_encode($chart_labels)?>;
              var values = <?=json_encode($chart_values)?>;
              var optionsV2 = {
                responsive: true,
                maintainAspectRatio: false,
                scales: { yAxes: [{ ticks: { beginAtZero: true } }] }
              };
              var optionsV3 = {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
              };
              var opts = (Chart.register ? optionsV3 : optionsV2);
              new Chart(ctx, {
                type: 'line',
                data: {
                  labels: labels,
                  datasets: [{
                    label: 'Pendapatan',
                    data: values,
                    borderColor: 'rgba(60,141,188,1)',
                    backgroundColor: 'rgba(60,141,188,0.2)',
                    fill: true
                  }]
                },
                options: opts
              });
            }
          });
        </script>
      </section>
      <!-- /.content -->
