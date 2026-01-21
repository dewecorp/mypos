<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Pengguna | myPOS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Pengguna</a></li>
              <li class="breadcrumb-item active">Users</li>
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
                    <i class="fa fa-user-plus"></i> Tambah
                </button>
            </div>
            </br>
            </br>
            <div class="box-body table-responsive">                
                <table id="tabel" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pengguna</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach($row->result() as $key => $data) {   ?>                    

                        <tr>
                            <td style="width: 5%;"><?=$no++?>.</td>
                            <td><?=$data->username?></td>
                            <td><?=$data->name?></td>
                            <td><?=$data->address?></td>
                            <td><?=$data->level == 1 ? "Admin" : "Kasir"?></td>
                            <td class="text-center" width="160px">
                                <form action="<?=site_url('user/del')?>" method="post">
                                <button type="button" class="btn btn-primary btn-xs"
                                    data-toggle="modal" data-target="#modal-edit"
                                    data-userid="<?=$data->user_id?>"
                                    data-username="<?=$data->username?>"
                                    data-name="<?=$data->name?>"
                                    data-address="<?=$data->address?>"
                                    data-level="<?=$data->level?>"
                                    onclick="edit_user(this)">
                                <i class="fa fa-edit"></i> Edit
                                </button>                               
                                <input type="hidden" name="user_id" value="<?=$data->user_id?>">
                                <button onclick="return confirm('Apakah Anda Yakin?')" class="btn btn-danger btn-xs">
                                <i class="fa fa-trash"></i> Hapus
                                </button>                             
                                </form>
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
                <form action="<?=site_url('user/add')?>" method="post">
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
                        <label>Alamat</label>
                        <textarea name="address" class="form-control"><?=set_value('address')?></textarea>                             
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
                <form action="<?=site_url('user/edit')?>" method="post" id="form-edit">
                    <input type="hidden" name="user_id" id="edit_user_id">
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
                        <label>Alamat</label>
                        <textarea name="address" id="edit_address" class="form-control"></textarea>                             
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
function edit_user(btn) {
    var userid = $(btn).data('userid');
    var username = $(btn).data('username');
    var name = $(btn).data('name');
    var address = $(btn).data('address');
    var level = $(btn).data('level');

    $('#edit_user_id').val(userid);
    $('#edit_username').val(username);
    $('#edit_fullname').val(name);
    $('#edit_address').val(address);
    $('#edit_level').val(level);
    
    // Set form action dynamically? No, logic is in controller to handle post.
    // Actually, user/edit/ID is expected by standard method, but my modified edit() handles post without ID in URL if post has user_id.
    // Wait, my modified edit() checks input->post. If user_id is in post, it works.
    // But I kept edit($id = null) in signature.
}

<?php if(isset($modal_add)) { ?>
    $(document).ready(function(){
        $('#modal-add').modal('show');
    });
<?php } ?>

<?php if(isset($modal_edit)) { ?>
    $(document).ready(function(){
        // Repopulate form with submitted data
        $('#edit_user_id').val('<?=$edit_id ?? $row_edit->user_id?>');
        $('#edit_fullname').val('<?=$row_edit->fullname?>');
        $('#edit_username').val('<?=$row_edit->username?>');
        $('#edit_address').val('<?=$row_edit->address?>');
        $('#edit_level').val('<?=$row_edit->level?>');
        $('#modal-edit').modal('show');
    });
<?php } ?>
</script>

    <!-- /.content -->
</html>
 