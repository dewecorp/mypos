<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Barcode Barang | myPOS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Barcode Barang</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Barcode</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box"> 
        <div class="float-right">
              <a href="<?=site_url('item')?>" class="btn btn-warning btn-sm">
                  <i class="fa fa-undo"></i> Kembali
              </a>
          </div>
        <div class="box-header">
          <h3 class="box-title"> Barcode Generator <i class="fa fa-barcode"></i></h3>
        </div> 
          
              </br>
              </br>
          <div class="box-body">
             <div class="row justify-content-center">
                    <div class="col-md-4"> 
                        <?php

                          $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                          echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($row->barcode, $generator::TYPE_CODE_128)) . '" style="width:200px;">';
                        ?>
                        <br>
                        <?=$row->barcode?>
                        <br><br>
                        <a href="<?=site_url('item/barcode_print/'.$row->item_id)?>" target="_blank" class="btn btn-info btn-sm">
                        <i class="fa fa-print"></i> Print
                        </a>
                    </div>
            </div>
          </div>
<br><br>
        <div class="box-header">
          <h3 class="box-title"> QR-Code Generator <i class="fa fa-qrcode"></i></h3>
        </div> 
         <br><br>
          <div class="box-body">
             <div class="row justify-content-center">
                    <div class="col-md-4"> 
                        <?php

                        $qrCode = new Endroid\QrCode\QrCode($row->barcode);
                        $qrCode->writeFile('uploads/qr-code/item-'.$row->barcode.'.png');
                        ?>
                        <img src="<?=base_url('uploads/qr-code/item-'.$row->barcode.'.png')?>" style="width: 200px;">
                        <br>
                        <?=$row->barcode?>
                        <br><br>
                        <a href="<?=site_url('item/qrcode_print/'.$row->item_id)?>" target="_blank" class="btn btn-info btn-sm">
                        <i class="fa fa-print"></i> Print
                        </a>
                        <br><br>
                    </div>
            </div>
          </div>
      </div>

      
    </section>
    <!-- /.content -->
</html>
