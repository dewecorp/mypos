<html moznomarginboxes mozdisallowselectionprint>
<head>
    <title>Struk Pembayaran</title>
    <style>
        @page { margin: 0; }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 10px;
            margin: 0;
            padding: 2px;
            width: 58mm;
        }
        .content {
            width: 100%;
        }
        .title {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .border-bottom { border-bottom: 1px dashed #000; }
        .border-top { border-top: 1px dashed #000; }
        table { width: 100%; border-collapse: collapse; }
        td { vertical-align: top; }
        .qty { width: 15%; }
        .item { width: 55%; }
        .price { width: 30%; text-align: right; }
        .btn-print {
            display: none;
        }
        @media print {
            .btn-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <?php
    // Load setting data directly in view if not passed, or better yet, assume controller passes it or we fetch it via CI instance
    $ci =& get_instance();
    $ci->load->model('setting_m');
    $setting = $ci->setting_m->get();
    ?>
    <div class="content">
        <div class="title"><?=$setting->shop_name?></div>
        <div class="text-center"><?=$setting->address?></div>
        <div class="text-center">Telp: <?=$setting->phone?></div>
        <br>
        <div class="border-bottom"></div>
        <div>No: <?=$header->invoice?></div>
        <div>Tgl: <?=date('d/m/Y', strtotime($header->date))?></div>
        <div>Kasir: <?=$header->user_name?></div>
        <div>Cust: <?=$header->customer_id ? $header->customer_name : 'Umum'?></div>
        <div class="border-bottom"></div>
        <br>
        
        <table>
            <?php foreach($details as $d) { ?>
            <tr>
                <td colspan="3"><?=$d->item_name?></td>
            </tr>
            <tr>
                <td class="qty"><?=$d->qty?> x</td>
                <td class="item"><?=number_format($d->price, 0, ',', '.')?></td>
                <td class="price"><?=number_format($d->total, 0, ',', '.')?></td>
            </tr>
            <?php } ?>
        </table>
        
        <br>
        <div class="border-top"></div>
        <table>
            <tr>
                <td>Subtotal</td>
                <td class="text-right"><?=number_format($header->total_price, 0, ',', '.')?></td>
            </tr>
            <?php if($header->discount > 0) { ?>
            <tr>
                <td>Disc</td>
                <td class="text-right"><?=number_format($header->discount, 0, ',', '.')?></td>
            </tr>
            <?php } ?>
            <tr>
                <td style="font-weight:bold">Total</td>
                <td class="text-right" style="font-weight:bold"><?=number_format($header->final_price, 0, ',', '.')?></td>
            </tr>
            <tr>
                <td>Bayar</td>
                <td class="text-right"><?=number_format($header->cash, 0, ',', '.')?></td>
            </tr>
            <tr>
                <td>Kembali</td>
                <td class="text-right"><?=number_format($header->remaining, 0, ',', '.')?></td>
            </tr>
        </table>
        <div class="border-bottom"></div>
        <br>
        <div class="text-center">Terima Kasih</div>
    </div>
</body>
</html>