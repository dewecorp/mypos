<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Semua Barcode</title>
    <style>
        .barcode-container {
            display: inline-block;
            width: 48%; /* Adjust for 2 columns per row */
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
            box-sizing: border-box;
        }
        @media print {
            .barcode-container {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <h3>Daftar Barcode Barang</h3>
    <?php
    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
    foreach($row as $data) {
        $barcode = trim((string)$data->barcode);
        if ($barcode !== '') {
    ?>
    <div class="barcode-container">
        <img src="data:image/png;base64,<?=base64_encode($generator->getBarcode($barcode, $generator::TYPE_CODE_128_B))?>" style="width: 200px;">
        <br>
        <?=$barcode?> - <?=$data->name?>
    </div>
    <?php 
        }
    } 
    ?>
    
    <script>
        window.print();
    </script>
</body>
</html>
