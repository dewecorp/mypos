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
                  <a href="<?=site_url('item/barcode_print_all')?>" class="btn btn-info btn-sm" target="_blank">
                      <i class="fa fa-barcode"></i> Cetak Semua Barcode
                  </a>
                  <a href="<?=site_url('item/qrcode_print_all')?>" class="btn btn-info btn-sm" target="_blank">
                      <i class="fa fa-qrcode"></i> Cetak Semua QR-Code
                  </a>
                  <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-import">
                      <i class="fa fa-file-excel"></i> Import Excel
                  </button>
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
                            <th>Harga</th>
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
                            <td>Rp. <?=number_format($data->price, 2, ",", ".")?></td>

                            <td class="text-center" width="160px">
                                <button type="button" class="btn btn-primary btn-xs"
                                    data-toggle="modal" data-target="#modal-edit"
                                    data-id="<?=$data->item_id?>"
                                    data-barcode="<?=$data->barcode?>"
                                    data-name="<?=$data->name?>"
                                    data-price="<?=$data->price?>"
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
                            <label>Nama Barang *</label>
                            <input type="text" name="product_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Harga *</label>
                            <input type="number" name="price" class="form-control" required>
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
                        <input type="hidden" name="id" id="edit_id">
                        <div class="form-group">
                            <label>Nama Barang *</label>
                            <input type="text" name="product_name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Harga *</label>
                            <input type="number" name="price" id="edit_price" class="form-control" required>
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

    <!-- Modal Import -->
    <div class="modal fade" id="modal-import">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Import Data Barang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-import" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>File Excel</label>
                            <input type="file" name="file" class="form-control" required accept=".xlsx, .xls">
                            <small class="text-muted">Gunakan template yang disediakan. <a href="<?=site_url('item/download_template')?>">Download Template</a></small>
                        </div>
                        <div class="progress mb-3" style="display:none;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                        </div>
                        <div id="import-result" class="alert" style="display:none;"></div>
                        <div class="form-group" align="right">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-upload"></i> Upload & Import
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</html>
<script>
    $(document).ready(function() {
        $('#form-import').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var progressBar = $('.progress-bar');
            var progressContainer = $('.progress');
            var resultDiv = $('#import-result');
            
            progressContainer.show();
            progressBar.width('0%');
            resultDiv.hide().removeClass('alert-success alert-danger');
            
            $.ajax({
                url: '<?=site_url('item/import')?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            progressBar.width(percentComplete + '%');
                            progressBar.html(Math.round(percentComplete) + '%');
                        }
                    }, false);
                    return xhr;
                },
                success: function(response) {
                    try {
                        var res = JSON.parse(response);
                        if(res.success) {
                            resultDiv.addClass('alert-success').html(res.message).show();
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            resultDiv.addClass('alert-danger').html(res.message).show();
                        }
                    } catch(e) {
                         resultDiv.addClass('alert-danger').html('Respon tidak valid').show();
                    }
                },
                error: function() {
                    resultDiv.addClass('alert-danger').html('Terjadi kesalahan saat upload').show();
                }
            });
        });
    });

    function edit_item(btn) {
        var id = $(btn).data('id');
        var name = $(btn).data('name');
        var price = $(btn).data('price');

        $('#edit_id').val(id);
        $('#edit_name').val(name);
        $('#edit_price').val(price);
    }
</script>