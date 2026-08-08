<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekspor Data Barang</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Roboto, Arial, sans-serif; color: #222; margin: 0; padding: 28px 40px; }
        .head { text-align: center; border-bottom: 2px solid #333; padding-bottom: 12px; margin-bottom: 16px; }
        .head h2 { margin: 0; font-size: 20px; }
        .head small { color: #666; }
        .meta { font-size: 12px; color: #555; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #bbb; padding: 6px 8px; text-align: left; }
        th { background: #f0f0f0; font-weight: 600; }
        td.r { text-align: right; }
        @page { margin: 15mm; }
        @media print {
            body { padding: 0; }
        }
    </style>
</head>
<body>
    <?php $__st = $this->fungsi->get_setting(); $__stn = ($__st && !empty($__st->shop_name)) ? $__st->shop_name : 'Toko'; $__sad = ($__st && !empty($__st->address)) ? $__st->address : ''; $__spn = ($__st && !empty($__st->phone)) ? $__st->phone : ''; $__slo = ($__st && !empty($__st->logo)) ? $__st->logo : ''; ?>
    <div class="head">
        <?php if($__slo && file_exists(FCPATH.'uploads/logo/'.$__slo)) { ?>
            <img src="<?=base_url('uploads/logo/').$__slo?>" style="height:56px;margin-bottom:6px;" alt="Logo">
        <?php } ?>
        <h2><?=htmlspecialchars($__stn, ENT_QUOTES)?></h2>
        <?php if($__sad) { ?><div><?=htmlspecialchars($__sad, ENT_QUOTES)?></div><?php } ?>
        <?php if($__spn) { ?><div>Telp/HP: <?=htmlspecialchars($__spn, ENT_QUOTES)?></div><?php } ?>
        <div style="font-weight:700;text-transform:uppercase;font-size:14px;">Data Barang</div>
        <small>Dicetak: <?=date('d/m/Y H:i')?></small>
    </div>
    <div class="meta">Jumlah: <?=count($row)?> barang</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Barcode</th>
                <th>Nama Barang</th>
                <th class="r">Harga</th>
                <th>Tanggal Input</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($row as $d) { ?>
            <tr>
                <td><?=$no++?></td>
                <td><?=$d->barcode?></td>
                <td><?=$d->name?></td>
                <td class="r">Rp <?=number_format((float)$d->price, 2, ',', '.')?></td>
                <td><?=!empty($d->created) ? date('d/m/Y', strtotime($d->created)) : '-'?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <script>
        window.onload = function() {
            setTimeout(function(){ window.print(); }, 300);
        };
    </script>
</body>
</html>
