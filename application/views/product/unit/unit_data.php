<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Units | myPOS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Units</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Units</a></li>
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
                    <a href="<?=site_url('unit/add')?>" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Tambah
                    </a>
                </div>
               <?php } ?>
            </br>
            </br>
            <div class="box-body table-responsive">
                <table id="tabel" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
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
                                <a href="<?=site_url('unit/edit/'.$data->unit_id)?>" class="btn btn-primary btn-xs">
                                        <i class="fa fa-edit"></i> Edit
                                </a>
                                <a href="<?=site_url('unit/del/'.$data->unit_id)?>" onclick="return confirm('Yakin Menghapus Data?')" class="btn btn-danger btn-xs">
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
</html>
