<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Pengguna</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Pengguna</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <?php $this->view('messages') ?>
        <div class="box">
            <div class="box-header d-flex justify-content-between align-items-center">
                <div class="box-title"><i class="fa fa-users"></i> Daftar Pengguna</div>
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-add">
                    <i class="fa fa-user-plus"></i> Tambah
                </button>
            </div>
            <div class="box-body table-responsive">
                <table id="tabel" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Foto</th>
                            <th>Nama Pengguna</th>
                            <th>Nama</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach($row->result() as $key => $data) {
                            $ph = (!empty($data->photo) && file_exists(FCPATH.'uploads/user/'.$data->photo)) ? base_url('uploads/user/'.$data->photo) : '';
                        ?>
                        <tr>
                            <td style="width: 5%;"><?=$no++?>.</td>
                            <td class="text-center" style="width:70px;">
                                <?php if($ph) { ?>
                                    <img src="<?=$ph?>" class="rounded-circle" style="width:44px;height:44px;object-fit:cover;">
                                <?php } else { ?>
                                    <span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center font-weight-bold" style="width:44px;height:44px;font-size:1.1rem;"><?=strtoupper(substr($data->name, 0, 1))?></span>
                                <?php } ?>
                            </td>
                            <td><?=$data->username?></td>
                            <td><?=$data->name?></td>
                            <td><?=$data->level == 1 ? "Admin" : "Kasir"?></td>
                            <td class="text-center" width="120px">
                                <button type="button" class="btn btn-primary btn-xs"
                                    data-toggle="modal" data-target="#modal-edit"
                                    data-userid="<?=$data->user_id?>"
                                    data-username="<?=$data->username?>"
                                    data-name="<?=$data->name?>"
                                    data-level="<?=$data->level?>"
                                    data-photo="<?=$ph?>"
                                    onclick="edit_user(this)" title="Edit">
                                <i class="fa fa-edit"></i>
                                </button>
                                <a href="<?=site_url('user/del/'.$data->user_id)?>" class="btn btn-danger btn-xs swal-delete-link" data-title="Yakin menghapus pengguna <?=$data->username?>?" title="Hapus">
                                <i class="fa fa-trash"></i>
                                </a>
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

<!-- Modal Add -->
<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Pengguna</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?=site_url('user/add')?>" method="post" enctype="multipart/form-data">
                    <div class="form-group <?=form_error('fullname') ? 'has-error' : null?>">
                        <label>Nama *</label>
                        <input type="text" name="fullname" value="<?=set_value('fullname')?>" class="form-control" required>
                        <?=form_error('fullname')?>
                    </div>
                    <div class="form-group <?=form_error('username') ? 'has-error' : null?>">
                        <label>Nama Pengguna *</label>
                        <input type="text" name="username" value="<?=set_value('username')?>" class="form-control" required>
                        <?=form_error('username')?>
                    </div>
                    <div class="form-group <?=form_error('password') ? 'has-error' : null?>">
                        <label>Kata Sandi *</label>
                        <input type="password" name="password" value="<?=set_value('password')?>" class="form-control" required>
                        <?=form_error('password')?>
                    </div>
                    <div class="form-group <?=form_error('passconf') ? 'has-error' : null?>">
                        <label>Konfirmasi Kata Sandi *</label>
                        <input type="password" name="passconf" value="<?=set_value('passconf')?>" class="form-control" required>
                        <?=form_error('passconf')?>
                    </div>
                    <div class="form-group">
                        <label>Foto</label>
                        <input type="file" name="photo" accept="image/*" class="form-control-file">
                        <small class="form-text text-muted">Format jpg/jpeg/png/webp, maks 2MB. Kosongkan jika tanpa foto.</small>
                    </div>
                    <div class="form-group <?=form_error('level') ? 'has-error' : null?>">
                        <label>Level *</label>
                       <select name="level" class="form-control" required>
                           <option value="">- Pilih -</option>
                           <option value="1" <?=set_value('level') == 1 ? "selected" : null?>>Admin</option>
                           <option value="2" <?=set_value('level') == 2 ? "selected" : null?>>Kasir</option>
                       </select>
                       <?=form_error('level')?>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
                <h4 class="modal-title">Edit Pengguna</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?=site_url('user/edit')?>" method="post" id="form-edit" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" id="edit_user_id">
                    <div class="form-group text-center">
                        <div id="edit_photo_preview" class="d-inline-block"></div>
                    </div>
                    <div class="form-group <?=form_error('fullname') ? 'has-error' : null?>">
                        <label>Nama *</label>
                        <input type="text" name="fullname" id="edit_fullname" class="form-control" required>
                        <?=form_error('fullname')?>
                    </div>
                    <div class="form-group <?=form_error('username') ? 'has-error' : null?>">
                        <label>Nama Pengguna *</label>
                        <input type="text" name="username" id="edit_username" class="form-control" required>
                        <?=form_error('username')?>
                    </div>
                    <div class="form-group <?=form_error('password') ? 'has-error' : null?>">
                        <label>Kata Sandi</label> <small>(Biarkan kosong jika tidak diganti)</small>
                        <input type="password" name="password" class="form-control">
                        <?=form_error('password')?>
                    </div>
                    <div class="form-group <?=form_error('passconf') ? 'has-error' : null?>">
                        <label>Konfirmasi Kata Sandi</label>
                        <input type="password" name="passconf" class="form-control">
                        <?=form_error('passconf')?>
                    </div>
                    <div class="form-group">
                        <label>Foto</label>
                        <input type="file" name="photo" accept="image/*" class="form-control-file">
                        <small class="form-text text-muted">Kosongkan jika tidak mengganti foto.</small>
                    </div>
                    <div class="form-group <?=form_error('level') ? 'has-error' : null?>">
                        <label>Level *</label>
                       <select name="level" id="edit_level" class="form-control" required>
                           <option value="">- Pilih -</option>
                           <option value="1">Admin</option>
                           <option value="2">Kasir</option>
                       </select>
                       <?=form_error('level')?>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function avatarHtml(name, photo) {
    if(photo) {
        return '<img src="'+photo+'" class="rounded-circle" style="width:70px;height:70px;object-fit:cover;">';
    }
    var ini = name && name.length ? name.charAt(0).toUpperCase() : '?';
    return '<span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center font-weight-bold" style="width:70px;height:70px;font-size:1.6rem;">'+ini+'</span>';
}
function edit_user(btn) {
    var userid = $(btn).data('userid');
    var username = $(btn).data('username');
    var name = $(btn).data('name');
    var level = $(btn).data('level');
    var photo = $(btn).data('photo');

    $('#edit_user_id').val(userid);
    $('#edit_username').val(username);
    $('#edit_fullname').val(name);
    $('#edit_level').val(level);
    $('#edit_photo_preview').html(avatarHtml(name, photo));
}

<?php if(isset($modal_add)) { ?>
    $(document).ready(function(){
        $('#modal-add').modal('show');
    });
<?php } ?>

<?php if(isset($modal_edit)) { ?>
    $(document).ready(function(){
        $('#edit_user_id').val('<?=$edit_id ?? $row_edit->user_id?>');
        $('#edit_fullname').val('<?=$row_edit->fullname?>');
        $('#edit_username').val('<?=$row_edit->username?>');
        $('#edit_level').val('<?=$row_edit->level?>');
        $('#edit_photo_preview').html(avatarHtml('<?=addslashes($row_edit->fullname)?>', ''));
        $('#modal-edit').modal('show');
    });
<?php } ?>
</script>
</html>
