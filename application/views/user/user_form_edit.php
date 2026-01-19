<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Edit Pengguna | myPOS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Pengguna</h1>
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
        <div class="box">
            <div class="float-right">
                <a href="<?=site_url('user')?>" class="btn btn-warning btn-sm">
                    <i class="fa fa-undo"></i> Kembali
                </a>
            </div>
            </br>
            </br>
            <div class="box-body">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <form action="" method="post">
                            <div class="form-group <?=form_error('fullname') ? 'has-error' : null?>">
                                <label>Name *</label>
                                <input type="hidden" name="user_id" value="<?=$row->user_id?>">
                                <input type="text" name="fullname" value="<?=$this->input->post('fullname') ?? $row->name?>" class="form-control">
                                <?=form_error('fullname')?>
                            </div>
                            <div class="form-group <?=form_error('username') ? 'has-error' : null?>">
                                <label>Username *</label>
                                <input type="text" name="username" value="<?=$this->input->post('username') ?? $row->username?>" class="form-control">
                                <?=form_error('username')?>
                            </div>
                            <div class="form-group <?=form_error('password') ? 'has-error' : null?>">
                                <label>Password *</label><small> (Biarkan kosong jika tidak diganti)</small>
                                <input type="password" name="password" value="<?=$this->input->post('password')?>" class="form-control">
                                <?=form_error('password')?>
                            </div>
                            <div class="form-group <?=form_error('passconf') ? 'has-error' : null?>">
                                <label>Password Confirmation</label>
                                <input type="password" name="passconf" value="<?=$this->input->post('passconf')?>" class="form-control">
                                <?=form_error('passconf')?>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <textarea name="address" class="form-control"><?=$this->input->post('address') ?? $row->address?></textarea>                             
                            </div>
                            <div class="form-group <?=form_error('level') ? 'has-error' : null?>">
                                <label>Level *</label>
                               <select name="level" class="form-control">
                                   <?php $level = $this->input->post('level') ? $this->input->post('level') :  $row->level ?>
                                   <option value="">- Pilih -</option>
                                   <option value="1" <?=$level == 1 ? 'selected' : null?>>Admin</option>
                                   <option value="2" <?=$level == 2 ? 'selected' : null?>>Kasir</option>
                               </select>
                               <?=form_error('level')?>
                            </div>
                            <div class="form-group" >
                                <button type="submit" class="btn btn-success btn-sm">
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
    <!-- /.content -->
</html>
 