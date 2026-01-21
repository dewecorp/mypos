<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Data Barang | myPOS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Barang</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Barang</a></li>
              <li class="breadcrumb-item active">Data Barang</li>
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
                  <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-add">
                      <i class="fa fa-plus"></i> Tambah Barang
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
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach($row->result() as $key => $data) {   ?>

                        <tr>
                            <td style="width: 5%;"><?=$no++?>.</td>
                            <td>
                              <?=$data->barcode?><br>
                              <a href="<?=site_url('item/barcode_qrcode/'.$data->item_id)?>" class="btn btn-default btn-xs">
                                      Generate <i class="fa fa-barcode"></i>
                              </a>
                            </td>
                            <td><?=$data->name?></td>
                            <td><?=$data->category_name?></td>
                            <td><?=$data->unit_name?></td>
                            <td>Rp. <?=number_format($data->price, 2, ",", ".")?></td>
                            <td><?=$data->stock?></td>
                            <td>
                              <?php if($data->image != null) { ?>
                                <img src="<?=base_url('uploads/product/'.$data->image)?>" style="width:80px">
                              <?php } ?>
                            </td>

                            <td class="text-center" width="160px">
                                <button type="button" class="btn btn-primary btn-xs"
                                    data-toggle="modal" data-target="#modal-edit"
                                    data-id="<?=$data->item_id?>"
                                    data-barcode="<?=$data->barcode?>"
                                    data-name="<?=$data->name?>"
                                    data-category="<?=$data->category_id?>"
                                    data-unit="<?=$data->unit_id?>"
                                    data-price="<?=$data->price?>"
                                    data-stock="<?=$data->stock?>"
                                    onclick="edit_item(this)">
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                                <a href="<?=site_url('item/del/'.$data->item_id)?>" class="btn btn-danger btn-xs swal-delete-link" data-title="Yakin menghapus barang ini?">
                                        <i class="fa fa-trash"></i> Hapus</a>
                            </td>
                        </tr>
                            <?php
                            }
                            ?>
                    </tbody>

                </table>
            </div>
        </div>
    </section>
    <!-- /.content -->

    <!-- Modal Add -->
    <div class="modal fade" id="modal-add">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Barang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?=form_open_multipart('item/process')?>
                        <div class="form-group">
                            <label>Barcode *</label>
                            <input type="text" name="barcode" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Barang *</label>
                            <input type="text" name="product_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori *</label>
                            <select name="category" class="form-control" required>
                                <option value="">- Pilih -</option>
                                <?php foreach($category->result() as $key => $cat) { ?>
                                    <option value="<?=$cat->category_id?>"><?=$cat->name?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Satuan *</label>
                            <select name="unit" class="form-control" required>
                                <option value="">- Pilih -</option>
                                <?php foreach($unit->result() as $key => $unt) { ?>
                                    <option value="<?=$unt->unit_id?>"><?=$unt->name?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Harga *</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Gambar</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="form-group" align="right">
                            <button type="submit" name="add" class="btn btn-success btn-sm">
                                <i class="fa fa-paper-plane"></i> Simpan
                            </button>
                            <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
                        </div>
                    <?=form_close()?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Barang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?=form_open_multipart('item/process')?>
                        <div class="form-group">
                            <label>Barcode *</label>
                            <input type="hidden" name="id" id="edit_id">
                            <input type="text" name="barcode" id="edit_barcode" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Barang *</label>
                            <input type="text" name="product_name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori *</label>
                            <select name="category" id="edit_category" class="form-control" required>
                                <option value="">- Pilih -</option>
                                <?php foreach($category->result() as $key => $cat) { ?>
                                    <option value="<?=$cat->category_id?>"><?=$cat->name?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Satuan *</label>
                            <select name="unit" id="edit_unit" class="form-control" required>
                                <option value="">- Pilih -</option>
                                <?php foreach($unit->result() as $key => $unt) { ?>
                                    <option value="<?=$unt->unit_id?>"><?=$unt->name?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Harga *</label>
                            <input type="number" name="price" id="edit_price" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="number" name="stock" id="edit_stock" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Gambar</label>
                            <input type="file" name="image" class="form-control">
                            <small>(Biarkan kosong jika tidak diganti)</small>
                        </div>
                        <div class="form-group" align="right">
                            <button type="submit" name="edit" class="btn btn-success btn-sm">
                                <i class="fa fa-paper-plane"></i> Simpan
                            </button>
                        </div>
                    <?=form_close()?>
                </div>
            </div>
        </div>
    </div>

</html>
<script>
    function edit_item(btn) {
        var id = $(btn).data('id');
        var barcode = $(btn).data('barcode');
        var name = $(btn).data('name');
        var category = $(btn).data('category');
        var unit = $(btn).data('unit');
        var price = $(btn).data('price');
        var stock = $(btn).data('stock');

        $('#edit_id').val(id);
        $('#edit_barcode').val(barcode);
        $('#edit_name').val(name);
        $('#edit_category').val(category);
        $('#edit_unit').val(unit);
        $('#edit_price').val(price);
        $('#edit_stock').val(stock);
    }
</script>