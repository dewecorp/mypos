<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Satuan Barang | myPOS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Satuan Barang</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Satuan</a></li>
              <li class="breadcrumb-item active">Satuan Barang</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
     <?php $this->view('messages') ?>
        <div class="box">
               <?php if($this->fungsi->user_login()->level == 1) { ?>
                <div class="float-right">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-add">
                        <i class="fa fa-plus"></i> Tambah
                    </button>
                </div>
               <?php } ?>
            </br>
            </br>
            <div class="box-body table-responsive">
                <table id="tabel" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Satuan</th>
                            <?php if($this->fungsi->user_login()->level == 1) { ?>
                            <th>Aksi</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach($row->result() as $key => $data) {   ?>
                        <tr>
                            <td style="width: 5%;"><?=$no++?>.</td>
                            <td><?=$data->name?></td>

                            <?php if($this->fungsi->user_login()->level == 1) { ?>
                            <td class="text-center" width="160px">
                                <button type="button" class="btn btn-primary btn-xs"
                                    data-toggle="modal" data-target="#modal-edit"
                                    data-id="<?=$data->unit_id?>"
                                    data-name="<?=$data->name?>"
                                    onclick="edit_unit(this)">
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                                <a href="<?=site_url('unit/del/'.$data->unit_id)?>" class="btn btn-danger btn-xs swal-delete-link" data-title="Yakin menghapus satuan ini?">
                                        <i class="fa fa-trash"></i> Hapus
                                </a>
                            </td>
                            <?php } ?>
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
                    <h4 class="modal-title">Tambah Satuan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?=site_url('unit/process')?>" method="post">
                        <div class="form-group">
                            <label>Nama Satuan *</label>
                            <input type="text" name="unit_name" class="form-control" required>
                        </div>
                        <div class="form-group" align="right">
                            <button type="submit" name="add" class="btn btn-success btn-sm">
                                <i class="fa fa-paper-plane"></i> Simpan
                            </button>
                            <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Satuan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?=site_url('unit/process')?>" method="post">
                        <div class="form-group">
                            <label>Nama Satuan *</label>
                            <input type="hidden" name="id" id="edit_id">
                            <input type="text" name="unit_name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="form-group" align="right">
                            <button type="submit" name="edit" class="btn btn-success btn-sm">
                                <i class="fa fa-paper-plane"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</html>
<script>
    function edit_unit(btn) {
        var id = $(btn).data('id');
        var name = $(btn).data('name');

        $('#edit_id').val(id);
        $('#edit_name').val(name);
    }
</script>