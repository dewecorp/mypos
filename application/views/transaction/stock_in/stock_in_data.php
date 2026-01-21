<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Barang Masuk | myPOS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Barang Masuk</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Barang Masuk</a></li>
              <li class="breadcrumb-item active">Barang Masuk</li>
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
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-add">
                        <i class="fa fa-plus"></i> Tambah
                    </button>
                </div>
            </br>
            </br>
            <div class="box-body table-responsive">
                <table id="tabel" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Barcode</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
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
                                <a id="set_dtl" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal-detail"
                                  data-barcode="<?=$data->barcode?>"
                                  data-itemname="<?=$data->item_name?>"
                                  data-detail="<?=$data->detail?>"
                                  data-suppliername="<?=$data->supplier_name?>"
                                  data-qty="<?=$data->qty?>"
                                  data-date="<?=$data->date?>">
                                        <i class="fa fa-eye"></i> Detail
                                </a>
                                <a href="<?=site_url('stock/in/del/'.$data->stock_id.'/'.$data->item_id)?>" class="btn btn-danger btn-xs swal-delete-link" data-title="Yakin menghapus data Stock In?">
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

    <!-- Modal Add -->
    <div class="modal fade" id="modal-add">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Barang Masuk</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?=site_url('stock/process') ?>" method="post">
                        <div class="form-group">
                            <label>Tanggal *</label>
                            <input type="date" name="date" value="<?=date('Y-m-d')?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Barcode *</label>
                            <div class="input-group">
                                <input type="hidden" name="item_id" id="item_id">
                                <input type="text" name="barcode" id="barcode" class="form-control" required readonly>
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-item">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nama Barang *</label>
                            <input type="text" name="item_name" id="item_name" class="form-control" readonly>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input type="text" name="unit_name" id="unit_name" value="-" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Stok Awal</label>
                                    <input type="text" name="stock" id="stock" value="-" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Detail *</label>
                            <input type="text" name="detail" class="form-control" placeholder="Kulakan / tambahan / lainnya" required>
                        </div>
                        <div class="form-group">
                            <label>Supplier *</label>
                            <select name="supplier" class="form-control">
                                <option value="">- Pilih Supplier -</option>
                                <?php foreach($supplier as $i => $data) {
                                    echo '<option value="'.$data->supplier_id.'">'.$data->name.'</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jumlah *</label>
                            <input type="number" name="qty" class="form-control" required>
                        </div>
                        <div class="form-group" align="right">
                            <button type="submit" name="in_add" class="btn btn-success btn-sm">
                                <i class="fa fa-paper-plane"></i> Simpan
                            </button>
                            <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Item Select -->
    <div class="modal fade" id="modal-item">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih Produk</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body table-responsive">
                    <table class="table table-bordered table-striped" id="tabel2" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Nama</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($item as $i => $data) { ?>
                            <tr>
                                <td><?=$data->barcode?></td>
                                <td><?=$data->name?></td>
                                <td><?=$data->unit_name?></td>
                                <td class="text-right"><?=number_format($data->price)?></td>
                                <td class="text-right"><?=$data->stock?></td>
                                <td class="text-center">
                                    <button class="btn btn-info btn-xs select-item"
                                        data-id="<?=$data->item_id?>"
                                        data-barcode="<?=$data->barcode?>"
                                        data-name="<?=$data->name?>"
                                        data-unit="<?=$data->unit_name?>"
                                        data-stock="<?=$data->stock?>">
                                        <i class="fa fa-check"></i> Pilih
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

    <!-- Modal Detail -->
    <div class="modal fade" id="modal-detail">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Barang Masuk</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body table-responsive">
                  <table class="table table-bordered no-margin">
                    <tbody>
                      <tr>
                        <th style="width: 35%">Barcode</th>
                        <td><span id="dtl_barcode"></span></td>
                      </tr>
                       <tr>
                        <th>Nama Barang</th>
                        <td><span id="dtl_itemname"></span></td>
                      </tr>
                       <tr>
                        <th>Detail</th>
                        <td><span id="dtl_detail"></span></td>
                      </tr>
                       <tr>
                        <th>Supplier</th>
                        <td><span id="dtl_suppliername"></span></td>
                      </tr>
                       <tr>
                        <th>Jumlah</th>
                        <td><span id="dtl_qty"></span></td>
                      </tr>
                       <tr>
                        <th>Tanggal</th>
                        <td><span id="dtl_date"></span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>

</html>

<script>
    $(document).ready(function() {
        // Handle Item Selection
        $(document).on('click', '.select-item', function(){
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
        });

        // Handle Detail Modal
        $(document).on('click', '#set_dtl', function() {
            var barcode = $(this).data('barcode');
            var itemname = $(this).data('itemname');
            var detail = $(this).data('detail');
            var suppliername = $(this).data('suppliername');
            var qty = $(this).data('qty');
            var date = $(this).data('date');

            $('#dtl_barcode').text(barcode);
            $('#dtl_itemname').text(itemname);
            $('#dtl_detail').text(detail);
            $('#dtl_suppliername').text(suppliername);
            $('#dtl_qty').text(qty);
            $('#dtl_date').text(date);
        });
    });
</script>