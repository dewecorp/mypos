<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Nota <?=$header->invoice?></title>
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/fontawesome-free/css/all.min.css">
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'Segoe UI', Roboto, Arial, sans-serif; background: #eef1f6; color: #26304a; }
  .wrap { max-width: 620px; margin: 2rem auto; background: #fff; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,.12); padding: 2.2rem 2.5rem; }
  .tools { display: flex; justify-content: flex-end; gap: .6rem; margin-bottom: 1rem; }
  .btn { display: inline-flex; align-items: center; gap: .4rem; border: none; border-radius: 9px; padding: .55rem 1rem; font-weight: 600; font-size: .85rem; cursor: pointer; text-decoration: none; }
  .btn-warning { background: #ffc107; color: #333; }
  .btn-primary { background: #3b5bdb; color: #fff; }
  .nota-header { text-align: center; border-bottom: 2px solid #26314b; padding-bottom: 1.1rem; margin-bottom: 1.2rem; }
  .nota-header .shop { font-size: 1.5rem; font-weight: 700; letter-spacing: .3px; }
  .nota-header .sub { font-size: .8rem; color: #6b7484; margin-top: .15rem; }
  .meta { display: flex; justify-content: space-between; font-size: .85rem; margin-bottom: .6rem; }
  .meta b { font-weight: 600; }
  .meta .right { text-align: right; }
  table.items { width: 100%; border-collapse: collapse; margin: .8rem 0 1.2rem; }
  table.items th { font-size: .78rem; text-transform: uppercase; letter-spacing: .4px; color: #667; border-bottom: 2px solid #e6e9f0; padding: .5rem .3rem; text-align: left; }
  table.items td { font-size: .9rem; padding: .55rem .3rem; border-bottom: 1px solid #f0f2f6; vertical-align: top; }
  table.items td.r, table.items th.r { text-align: right; }
  table.items td.c, table.items th.c { text-align: center; }
  .totals { margin-left: auto; width: 46%; }
  .totals .row { display: flex; justify-content: space-between; font-size: .9rem; padding: .28rem 0; }
  .totals .row.grand { font-size: 1.1rem; font-weight: 700; border-top: 2px solid #1a2b5c; margin-top: .4rem; padding-top: .55rem; }
  .note-box { margin-top: .8rem; border-top: 1px dashed #c9d0dd; padding-top: .6rem; font-size: .85rem; }
  .foot-box { margin-top: .9rem; border-top: 1px dashed #c9d0dd; padding-top: .6rem; font-size: .85rem; }
  .foot-box .l { font-weight: 700; font-size: .8rem; text-transform: uppercase; color: #667a; }
  .foot { margin-top: 1.5rem; text-align: center; font-size: .8rem; color: #9aa3b5; }
  @media print {
    body { background: #fff; }
    .wrap { box-shadow: none; margin: 0; max-width: none; border-radius: 0; padding: 1rem; }
    .btn { display: none !important; }
  }
</style>
</head>
<?php
$shop_name = "Toko";
$shop_address = "";
$shop_phone = "";
try {
  $ci =& get_instance();
  $ci->load->model('setting_m');
  $set = $ci->setting_m->get();
  if($set) {
    $shop_name = $set->shop_name ?: "Toko";
    $shop_address = $set->address ?: "";
    $shop_phone = $set->phone ?: "";
  }
} catch (Exception $e) {}
?>
<body>
<div class="wrap">
  <div class="tools no-print">
    <a class="btn btn-warning" href="<?=site_url('sale/cetak_struk/'.$header->sale_id)?>" target="_blank"><i class="fas fa-print"></i> Struk 58mm</a>
    <button class="btn btn-info" onclick="window.print()"><i class="fas fa-print"></i> Cetak</button>
  </div>

  <div class="nota-header">
    <div class="shop"><?=htmlspecialchars($shop_name)?></div>
    <div class="sub"><?=htmlspecialchars($shop_address)?> &middot; <?=htmlspecialchars($shop_phone)?></div>
  </div>

  <div class="meta">
    <div>
      <div><b>No. Nota:</b> <?=$header->invoice?></div>
      <div><b>Tanggal:</b> <?=$header->date?></div>
    </div>
    <div class="right">
      <div><b>Kasir:</b> <?=$header->user_name?></div>
    </div>
  </div>

  <table class="items">
    <thead>
      <tr>
        <th>Item</th>
        <th class="c">Jml</th>
        <th class="r">Harga</th>
        <th class="r">Total</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($details as $d) { ?>
      <tr>
        <td>
          <?=$d->item_name?>
          <?php if(!empty($d->discount)) { ?><div style="font-size:.75rem;color:#98a;color:#8a94a8;">diskon <?=number_format((float)$d->discount,0,',','.')?></div><?php } ?>
        </td>
        <td class="c"><?=$d->qty?></td>
        <td class="r"><?=number_format((float)$d->price,0,',','.')?></td>
        <td class="r"><?=number_format((float)$d->total,0,',','.')?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>

  <div class="totals">
    <div class="row"><span>Sub Total</span><span><?=number_format((float)$header->total_price,0,',','.')?></span></div>
    <div class="row"><span>Diskon</span><span><?=number_format((float)$header->discount,0,',','.')?></span></div>
    <div class="row grand"><span>Total</span><span><?=number_format((float)$header->final_price,0,',','.')?></span></div>
    <div class="row"><span>Tunai</span><span><?=number_format((float)$header->cash,0,',','.')?></span></div>
    <div class="row"><span>Kembalian</span><span><?=number_format((float)$header->remaining,0,',','.')?></span></div>
  </div>

  <?php if(!empty($header->note)) { ?>
  <div class="foot-box">
    <span class="l">Catatan:</span> <?=$header->note?>
  </div>
  <?php } ?>

  <div class="foot">Terima kasih &mdash; <?=htmlspecialchars($shop_name)?> &middot; <?=date('d/m/Y H:i')?></div>
</div>
</body>
</html>