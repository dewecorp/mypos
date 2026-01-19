<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Suppliers | myPOS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Suppliers</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Suppliers</a></li>
              <li class="breadcrumb-item active">Pemasok Barang</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box">
                <div class="float-right">
                    <a href="<?=site_url('supplier/add')?>" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Tambah
                    </a>
                </div>
            </br>
            </br>
            <div class="box-body table-responsive">
                <table id="tabel" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Telephon</th>
                            <th>Alamat</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach($row->result() as $key => $data) {   ?>

                        <tr>
                            <td style="width: 5%;"><?=$no++?>.</td>
                            <td><?=$data->name?></td>
                            <td><?=$data->phone?></td>
                            <td><?=$data->address?></td>
                            <td><?=$data->description?></td>
                            <td class="text-center" width="160px">
                                <a href="<?=site_url('supplier/edit/'.$data->supplier_id)?>" class="btn btn-primary btn-xs">
                                        <i class="fa fa-edit"></i> Edit
                                </a>
                                <!-- <a href="<?=site_url('supplier/del/'.$data->supplier_id)?>" onclick="return confirm('Yakin Menghapus Data?')" class="btn btn-danger btn-xs">
                                        <i class="fa fa-trash"></i> Hapus
                                </a>   -->
                                <a href="#modalDelete" data-toggle="modal" onclick="$('modalDelete #formDelete').attr('action'. '<?=site_url('supplier/del/'.$data->supplier_id)?>')" class="btn btn-danger btn-xs">
                                        <i class="fa fa-trash"></i> Hapus
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

    <div class="modal fade" id="modalDelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Yakin Akan Menghapus Data Ini?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <form id="formDelete" action="" method="post">
                  <button class="btn btn-default" data-dismiss="modal">Tidak</button>
                  <button class="btn btn-danger" type="submit">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
</html>
