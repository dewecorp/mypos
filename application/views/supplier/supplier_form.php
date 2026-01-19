<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Tambah Suppliers | myPOS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?=ucfirst($page)?> Suppliers</h1>
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
                    <a href="<?=site_url('supplier')?>" class="btn btn-warning btn-sm">
                        <i class="fa fa-undo"></i> Kembali
                    </a>
                </div>
            </br>
            </br>
            <div class="box-body">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <?php echo validation_errors(); ?>
                        <form action="<?=site_url('supplier/process') ?>" method="post">
                            <div class="form-group">
                                <label> Supplier Name *</label>
                                <input type="hidden" name="id" value="<?=$row->supplier_id?>">
                                <input type="text" name="supplier_name" value="<?=$row->name?>" class="form-control" required>                                
                            </div>
                            <div class="form-group">
                                <label> Phone *</label>
                                <input type="number" name="phone" value="<?=$row->phone?>" class="form-control" required>                                
                            </div>
                            <div class="form-group">
                                <label> Address *</label>
                                <textarea name="addr" class="form-control" required><?=$row->address?></textarea>                                
                            </div>
                            
                            <div class="form-group">
                                <label> Description *</label>
                                <textarea name="desc" class="form-control" required><?=$row->description?></textarea>                                
                            </div>
                           
                            <div class="form-group" >
                                <button type="submit" name="<?=$page?>" class="btn btn-success btn-sm">
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
 