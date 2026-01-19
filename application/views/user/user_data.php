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
                <a href="<?=site_url('user/add')?>" class="btn btn-primary btn-sm">
                    <i class="fa fa-user-plus"></i> Tambah
                </a>
            </div>
            </br>
            </br>
            <div class="box-body table-responsive">                
                <table id="tabel" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Level</th>
                            <th>Actions</th>
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
                                <a href="<?=site_url('user/edit/'.$data->user_id)?>" class="btn btn-primary btn-xs">
                                <i class="fa fa-edit"></i> Edit
                                </a>                               
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
    <!-- /.content -->
</html>
 