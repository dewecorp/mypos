<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Tambah Pengguna | myPOS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1> Tambah Pengguna</h1>
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
            <!-- <div class="box-header">               
                <h3 class="box-title">Tambah Pengguna</h3>               
            </div> -->
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
                        <?php //echo validation_errors(); ?>
                        <form action="" method="post">
                            <div class="form-group <?=form_error('fullname') ? 'has-error' : null?>">
                                <label>Name *</label>
                                <input type="text" name="fullname" value="<?=set_value('fullname')?>" class="form-control">
                                <?=form_error('fullname')?>
                            </div>
                            <div class="form-group <?=form_error('username') ? 'has-error' : null?>">
                                <label>Username *</label>
                                <input type="text" name="username" value="<?=set_value('username')?>" class="form-control">
                                <?=form_error('username')?>
                            </div>
                            <div class="form-group <?=form_error('password') ? 'has-error' : null?>">
                                <label>Password *</label>
                                <input type="password" name="password" value="<?=set_value('password')?>" class="form-control">
                                <?=form_error('password')?>
                            </div>
                            <div class="form-group <?=form_error('passconf') ? 'has-error' : null?>">
                                <label>Password Confirmation *</label>
                                <input type="password" name="passconf" value="<?=set_value('passconf')?>" class="form-control">
                                <?=form_error('passconf')?>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <textarea name="address" class="form-control"><?=set_value('address')?></textarea>                             
                            </div>
                            <div class="form-group <?=form_error('level') ? 'has-error' : null?>">
                                <label>Level *</label>
                               <select name="level" class="form-control">
                                   <option value="">- Pilih -</option>
                                   <option value="1" <?=set_value('level') == 1 ? "selected" : null?>>Admin</option>
                                   <option value="2" <?=set_value('level') == 2 ? "selected" : null?>>Kasir</option>
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
 