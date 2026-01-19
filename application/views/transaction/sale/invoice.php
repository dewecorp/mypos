<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Invoice</title>
<link rel="stylesheet" href="<?=base_url()?>assets/dist/css/adminlte.min.css">
</head>
<body>
<div class="container mt-3">
  <div class="row">
    <div class="col-8">
      <h3>Invoice <?=$header->invoice?></h3>
      <div>Tanggal: <?=$header->date?></div>
      <div>Customer: <?=$header->customer_id ? $header->customer_name : 'Umum'?></div>
      <div>Kasir: <?=$header->user_name?></div>
    </div>
    <div class="col-4 text-right">
      <button class="btn btn-primary" onclick="window.print()">Cetak</button>
    </div>
  </div>
  <hr>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Barcode</th>
        <th>Item</th>
        <th>Harga</th>
        <th>Qty</th>
        <th>Diskon</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($details as $d) { ?>
      <tr>
        <td><?=$d->barcode?></td>
        <td><?=$d->item_name?></td>
        <td><?=$d->price?></td>
        <td><?=$d->qty?></td>
        <td><?=$d->discount?></td>
        <td><?=$d->total?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <div class="row">
    <div class="col-6">
      <div>Catatan: <?=$header->note?></div>
    </div>
    <div class="col-6">
      <table class="table">
        <tr><td>Sub Total</td><td><?=$header->total_price?></td></tr>
        <tr><td>Discount</td><td><?=$header->discount?></td></tr>
        <tr><td>Grand Total</td><td><?=$header->final_price?></td></tr>
        <tr><td>Cash</td><td><?=$header->cash?></td></tr>
        <tr><td>Change</td><td><?=$header->remaining?></td></tr>
      </table>
    </div>
  </div>
</div>
</body>
</html>
