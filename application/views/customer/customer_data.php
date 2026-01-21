<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Customers | myPOS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Customers</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Customers</a></li>
              <li class="breadcrumb-item active">Pelanggan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <?php $this->view('messages') ?>
        <div class="box">
            <!-- <div class="box-header">               
                <h4 class="box-title">Data Pemasok Barang</h4>               
            </div> -->
                <div class="float-right">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-add">
                        <i class="fa fa-plus"></i> Tambah
                    </button>
                </div>
            </br>
            </br>
            <div class="box-body table-responsive">                
                <table id="tabel" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach($row->result() as $key => $data) {   ?>                    

                        <tr>
                            <td style="width: 5%;"><?=$no++?>.</td>
                            <td><?=$data->name?></td>
                            <td><?=$data->gender == 'L' ? 'Laki-laki' : 'Perempuan'?></td>
                            <td><?=$data->phone?></td>
                            <td><?=$data->address?></td>
                            <td class="text-center" width="160px">                              
                                <button type="button" class="btn btn-primary btn-xs"
                                    data-toggle="modal" data-target="#modal-edit"
                                    data-id="<?=$data->customer_id?>"
                                    data-name="<?=$data->name?>"
                                    data-gender="<?=$data->gender?>"
                                    data-phone="<?=$data->phone?>"
                                    data-address="<?=$data->address?>"
                                    onclick="edit_customer(this)">
                                        <i class="fa fa-edit"></i> Edit
                                </button>  
                                <a href="<?=site_url('customer/del/'.$data->customer_id)?>" class="btn btn-danger btn-xs swal-delete-link" data-title="Yakin menghapus customer ini?">
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

<!-- Modal Add -->
<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Pelanggan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?=site_url('customer/process')?>" method="post">
                    <div class="form-group">
                        <label>Nama Pelanggan *</label>
                        <input type="text" name="customer_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin *</label>
                        <select name="gender" class="form-control" required>
                            <option value="">- Pilih -</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Telepon *</label>
                        <input type="number" name="phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat *</label>
                        <textarea name="addr" class="form-control" required></textarea>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" name="add" class="btn btn-primary">Simpan</button>
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
                <h4 class="modal-title">Edit Pelanggan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?=site_url('customer/process')?>" method="post">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group">
                        <label>Nama Pelanggan *</label>
                        <input type="text" name="customer_name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin *</label>
                        <select name="gender" id="edit_gender" class="form-control" required>
                            <option value="">- Pilih -</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Telepon *</label>
                        <input type="number" name="phone" id="edit_phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat *</label>
                        <textarea name="addr" id="edit_addr" class="form-control" required></textarea>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function edit_customer(btn) {
    var id = $(btn).data('id');
    var name = $(btn).data('name');
    var gender = $(btn).data('gender');
    var phone = $(btn).data('phone');
    var address = $(btn).data('address');

    $('#edit_id').val(id);
    $('#edit_name').val(name);
    $('#edit_gender').val(gender);
    $('#edit_phone').val(phone);
    $('#edit_addr').val(address);
    $('#modal-edit').modal('show');
}
</script>
    <!-- /.content -->
</html>
 
