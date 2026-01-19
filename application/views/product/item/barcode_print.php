<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Product <?=$row->barcode?></title>
</head>
<body>
    <?php
        $barcode = isset($row->barcode) ? trim((string)$row->barcode) : '';
        if ($barcode === '') {
            echo '<span style="color:#dc3545;">Barcode tidak tersedia</span>';
        } else {
            $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
            echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcode, $generator::TYPE_CODE_128_B)) . '" style="width:500px;">';
        }
    ?>
    <br><br>
    <?=$barcode?>

</body>
</html>
