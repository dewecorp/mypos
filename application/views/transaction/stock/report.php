<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Stok</title>
</head>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3>Laporan Stok</h3>
      </div>
    </div>
  </div>
</section>
<section class="content">
  <div class="card">
    <div class="card-body">
      <form method="get" action="<?=site_url('stock/report')?>">
        <div class="row">
          <div class="col-md-3">
            <label>Start</label>
            <input type="date" name="start" value="<?=$start?>" class="form-control">
          </div>
          <div class="col-md-3">
            <label>End</label>
            <input type="date" name="end" value="<?=$end?>" class="form-control">
          </div>
          <div class="col-md-3 align-self-end">
            <button class="btn btn-primary">Filter</button>
          </div>
        </div>
      </form>
      <hr>
      <table class="table table-bordered table-striped" id="stock_report_table">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Barcode</th>
            <th>Item</th>
            <th>Jenis</th>
            <th>Qty</th>
            <th>Detail</th>
            <th>Supplier</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($rows as $r) { ?>
          <tr>
            <td><?=$r->date?></td>
            <td><?=$r->barcode?></td>
            <td><?=$r->item_name?></td>
            <td><?=strtoupper($r->type)?></td>
            <td><?=$r->qty?></td>
            <td><?=$r->detail?></td>
            <td><?=$r->supplier_name?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <script>
    $(function () {
      $('#stock_report_table').DataTable({
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: true,
        responsive: true
      });
    });
  </script>
</section>
