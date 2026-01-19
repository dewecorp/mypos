<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Stock Out | Barang myPOS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Stock Out</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Stock Out</a></li>
              <li class="breadcrumb-item active">Tambah Stock Out</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
     <?php $this->view('messages') ?>
        <div class="box">
                <div class="float-right">
                    <a href="<?=site_url('stock/out/add')?>" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Tambah Stock Out
                    </a>
                </div>
            </br>
            </br>
            <div class="box-body table-responsive">                
                <table id="tabel" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Barcode</th>   
                            <th>Product Item</th>        
                            <th>Qty</th> 
                            <th>Info</th>  
                            <th>Date</th>                                     
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php $no = 1;
                       foreach($row as $key => $data) { ?>
                        <tr>
                            <td style="width: 5%;"><?=$no++?></td>
                            <td><?=$data->barcode?></td>
                            <td><?=$data->name?></td>
                            <td><?=$data->qty?></td>
                            <td><?=$data->detail?></td>
                            <td class="text-center"><?=$data->date?></td>
                            <td class="text-center" width="160px">                              
                                <a href="<?=site_url('stock/out/del/'.$data->stock_id.'/'.$data->item_id)?>" class="btn btn-danger btn-xs swal-delete-link" data-title="Yakin menghapus data Stock Out?">
                                        <i class="fa fa-trash"></i> Hapus
                                </a>                                   
                            </td>
                        </tr>
                      <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>
    </section>
</html>
