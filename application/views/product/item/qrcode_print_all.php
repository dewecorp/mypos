<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Semua QR-Code</title>
    <style>
        .qrcode-container {
            display: inline-block;
            width: 32%; /* Adjust for 3 columns per row */
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
            box-sizing: border-box;
            vertical-align: top;
        }
        @media print {
            .qrcode-container {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <h3>Daftar QR-Code Barang</h3>
    <?php
    $writer = new Endroid\QrCode\Writer\PngWriter();
    foreach($row as $data) {
        $barcode = trim((string)$data->barcode);
        if ($barcode !== '') {
            // Generate QR Code on the fly or check if exists
            // Ideally check if file exists, if not generate it. 
            // For simplicity in bulk print, we can regenerate or check existence.
            // Using existing logic to check/generate file is better to avoid massive processing on render if many items.
            // But here we will assume files exist or use direct generation if needed.
            // Given the previous fix used file saving, let's use the file path if it exists, or generate.
            
            $filePath = 'uploads/qr-code/item-'.$barcode.'.png';
            if(!file_exists($filePath)) {
                 $qrCode = Endroid\QrCode\QrCode::create($barcode);
                 $result = $writer->write($qrCode);
                 $result->saveToFile($filePath);
            }
    ?>
    <div class="qrcode-container">
        <img src="<?=base_url($filePath)?>" style="width: 150px;">
        <br>
        <?=$barcode?> <br> <?=$data->name?>
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
