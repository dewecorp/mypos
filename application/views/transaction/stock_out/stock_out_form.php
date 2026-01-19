<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Stock Out | myPOS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Transaction</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Tambah Stock Out</a></li>
              <li class="breadcrumb-item active">Barang Keluar</li>
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
                    <a href="<?=site_url('stock/out')?>" class="btn btn-warning btn-sm">
                        <i class="fa fa-undo"></i> Kembali
                    </a>
                </div>
            </br>
            </br>
            <div class="box-body">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <?php echo validation_errors(); ?>
                        <form action="<?=site_url('stock/process') ?>" method="post">
                            <div class="form-group">
                                <label> Date *</label>
                                <input type="hidden" name="id">
                                <input type="date" name="date"  value="<?=date('Y-m-d')?>" class="form-control" required>
                            </div>
                            <div>
                                <label for="barcode"> Barcode *</label>
                            </div>
                            <div  class="form-group input-group">
                                <input type="hidden" name="item_id" id="item_id">
                                <input type="text" name="barcode" id="barcode" class="form-control" required autofocus readonly>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-item">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="item_name"> Item Name *</label>
                                <input type="text" name="item_name"   id="item_name" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="item_unit"> Item Unit</label>
                                        <input type="text" name="unit_name" id="unit_name" value="-" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="stock"> Initial Stock</label>
                                        <input type="text" name="stock" id="stock" value="-" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="detail"> Info *</label>
                                <input type="text" name="detail" id="detail"  class="form-control" placeholder="Rusak / hilang / kadaluwarsa / lainnya" required>
                            </div>
                            <div class="form-group">
                                <label for="detail"> Qty *</label>
                                <input type="number" name="qty" id="qty"  class="form-control" required>
                            </div>
                            <div class="form-group" >
                                <button type="submit" name="out_add" class="btn btn-success btn-sm">
                                    <i class="fa fa-paper-plane"></i> Simpan
                                </button>
                                <button type="reset" class="btn btn-secondary btn-sm">
                                    <i class="fa fa-arrow-left"></i> Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</html>

<div class="modal fade" id="modal-item">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Select Product Item</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered table-striped" id="tabel" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Barcode</th>
                            <th>Name</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($item as $i => $data) { ?>
                        <tr>
                            <td><?=$data->barcode?></td>
                            <td><?=$data->name?></td>
                            <td><?=$data->unit_name?></td>
                            <td class="text-right"><?=$data->price?></td>
                            <td class="text-right"><?=$data->stock?></td>
                            <td class="text-center">
                                <button class="btn btn-info" id="select"
                                    data-id="<?=$data->item_id?>"
                                    data-barcode="<?=$data->barcode?>"
                                    data-name="<?=$data->name?>"
                                    data-unit="<?=$data->unit_name?>"
                                    data-stock="<?=$data->stock?>">
                                    <i class="fa fa-check"></i> Select
                                </button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).on('click', '#select', function(){
        var item_id = $(this).data('id');
        var barcode = $(this).data('barcode');
        var name = $(this).data('name');
        var unit_name = $(this).data('unit');
        var stock = $(this).data('stock');
        $('#item_id').val(item_id);
        $('#barcode').val(barcode);
        $('#item_name').val(name);
        $('#unit_name').val(unit_name);
        $('#stock').val(stock);
        $('#modal-item').modal('hide');
        })
    })
</script>
