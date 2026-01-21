<!DOCTYPE html>
<html moznomarginboxes mozdisallowselectionprint>
<head>
    <title>Print Struk</title>
    <style type="text/css">
        html { font-family: "Verdana", Arial, sans-serif; font-size: 10pt; }
        .content { width: 80mm; padding: 5px; }
        .title { text-align: center; font-size: 12pt; font-weight: bold; margin-bottom: 5px; }
        .head { margin-bottom: 10px; border-bottom: 1px solid #000; padding-bottom: 5px; }
        table { width: 100%; font-size: 10pt; border-collapse: collapse; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .thanks { margin-top: 10px; text-align: center; font-style: italic; border-top: 1px dashed #000; padding-top: 5px; }
        @media print {
            @page { width: 80mm; margin: 0; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="content">
        <div class="title">
            myPOS Store<br>
            <small>Jl. Raya No. 123</small>
        </div>
        <div class="head">
            <table cellspacing="0" cellpadding="0">
                <tr>
                    <td style="width: 20mm"><?=date('d/m/y', strtotime($sale->date))?></td>
                    <td style="width: 20mm"><?=date('H:i', strtotime($sale->created ?? date('H:i:s')))?></td>
                    <td class="text-right">Kasir: <?=$sale->user_name?></td>
                </tr>
                <tr>
                    <td colspan="3">No: <?=$sale->invoice?></td>
                </tr>
            </table>
        </div>
        <div class="transaction">
            <table cellspacing="0" cellpadding="0">
                <?php foreach($sale_detail as $row) { ?>
                <tr>
                    <td colspan="3" style="padding-top: 3px;"><?=$row->name ?? $row->item_name?></td>
                </tr>
                <tr>
                    <td><?=$row->qty?> x <?=number_format($row->price,0,',','.')?></td>
                    <td class="text-right"><?=number_format($row->total,0,',','.')?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="3" style="border-top: 1px dashed #000; padding: 3px 0;"></td>
                </tr>
                <tr>
                    <td class="text-right" colspan="2">Sub Total:</td>
                    <td class="text-right"><?=number_format($sale->total_price,0,',','.')?></td>
                </tr>
                <?php if($sale->discount > 0) { ?>
                <tr>
                    <td class="text-right" colspan="2">Diskon:</td>
                    <td class="text-right"><?=number_format($sale->discount,0,',','.')?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td class="text-right" colspan="2" style="font-weight: bold;">Grand Total:</td>
                    <td class="text-right" style="font-weight: bold;"><?=number_format($sale->final_price,0,',','.')?></td>
                </tr>
                <tr>
                    <td class="text-right" colspan="2">Tunai:</td>
                    <td class="text-right"><?=number_format($sale->cash,0,',','.')?></td>
                </tr>
                <tr>
                    <td class="text-right" colspan="2">Kembali:</td>
                    <td class="text-right"><?=number_format($sale->remaining,0,',','.')?></td>
                </tr>
            </table>
        </div>
        <div class="thanks">
            Terima Kasih atas kunjungan Anda
        </div>
    </div>
</body>
</html>