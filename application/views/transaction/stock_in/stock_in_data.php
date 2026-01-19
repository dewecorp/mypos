<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Tambah Stock | myPOS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Stock In</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Stock In</a></li>
              <li class="breadcrumb-item active">Tambah Stock Barang</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
     <?php $this->view('messages') ?>
        <div class="box">
                <div class="float-right">
                    <a href="<?=site_url('stock/in/add')?>" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Tambah Stock In
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
                            <td><?=$data->item_name?></td>
                            <td><?=$data->qty?></td>
                            <td class="text-center"><?=$data->date?></td>
                            <td class="text-center" width="160px">
                                <a id="set_dtl" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal-detail" data-barcode="<?=$data->barcode?>"
                                  data-itemname="<?=$data->item_name?>"
                                  data-detail="<?=$data->detail?>"
                                  data-suppliername="<?=$data->supplier_name?>"
                                  data-qty="<?=$data->qty?>"
                                  data-date="<?=$data->date?>">
                                        <i class="fa fa-eye"></i> Detail
                                </a>
                                <a href="<?=site_url('stock/in/del/'.$data->stock_id.'/'.$data->item_id)?>" onclick="return confirm('Yakin Menghapus Data?')" class="btn btn-danger btn-xs">
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

<div class="modal fade" id="modal-detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Stock In Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body table-responsive">
              <table class="table table-bordered no-margin">

                <tbody>
                  <tr>
                    <th style="width: 35%">Barcode</th>
                    <td><span id="barcode"></span></td>
                  </tr>
                   <tr>
                    <th>Item Name</th>
                    <td><span id="item_name"></span></td>
                  </tr>
                   <tr>
                    <th>Detail</th>
                    <td><span id="detail"></span></td>
                  </tr>
                   <tr>
                    <th>Supplier Name</th>
                    <td><span id="supplier_name"></span></td>
                  </tr>
                   <tr>
                    <th>Qty</th>
                    <td><span id="qty"></span></td>
                  </tr>
                  <tr>
                    <th>Date</th>
                    <td><span id="date"></span></td>
                  </tr>
                </tbody>
              </table>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).on('click', '#set_dtl', function(){
        var barcode = $(this).data('barcode');
        var itemname = $(this).data('itemname');
        var detail = $(this).data('detail');
        var suppliername = $(this).data('suppliername');
        var qty = $(this).data('qty');
        var date = $(this).data('date');
        $('#barcode').text(barcode);
        $('#item_name').text(itemname);
        $('#detail').text(detail);
        $('#supplier_name').text(suppliername);
        $('#qty').text(qty);
        $('#date').text(date);

        })
    })
</script>
