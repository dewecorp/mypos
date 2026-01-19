<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR-Code Product <?=$row->barcode?></title>
</head>
<body>
    
    <?php $barcode = isset($row->barcode) ? trim((string)$row->barcode) : ''; ?>
    <?php if ($barcode === '') { ?>
        <span style="color:#dc3545;">QR Code tidak tersedia</span>
    <?php } else { ?>
        <img src="uploads/qr-code/item-<?=$barcode?>.png" style="width: 200px;">
    <?php } ?>
    <br>
    <?=$barcode?>
</body>
</html>
