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
            <h1>Items</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Items</a></li>
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
                  <a href="<?=site_url('item/add')?>" class="btn btn-primary btn-sm">
                      <i class="fa fa-plus"></i> Tambah Barang
                  </a>
              </div>
            </br>
            </br>
            <div class="box-body table-responsive">
                <table id="tabel" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Barcode</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Image</th>
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
                            <td><?=$data->category_name?></td>
                            <td><?=$data->unit_name?></td>
                            <td>Rp. <?=number_format($data->price, 2, ",", ".")?></td>
                            <td><?=$data->stock?></td>
                            <td>
                              <?php if($data->image != null) { ?>
                                <img src="<?=base_url('uploads/product/'.$data->image)?>" style="width:80px">
                              <?php } ?>
                            </td>

                            <td class="text-center" width="160px">
                                <a href="<?=site_url('item/edit/'.$data->item_id)?>" class="btn btn-primary btn-xs">
                                        <i class="fa fa-edit"></i> Edit</a>
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
</html>
<script>
  // $(function () {
  //   $('#tabel').DataTable({
  //     "processing": true,
  //     "serverSide": true,
  //     "ajax": "<?=site_url('item/get_ajax')?>"
  //   });
  // });
</script>
