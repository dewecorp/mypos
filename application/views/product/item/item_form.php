<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Tambah Barang | myPOS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?=ucfirst($page)?> Barang</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Barang</a></li>
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
                    <a href="<?=site_url('item')?>" class="btn btn-warning btn-sm">
                        <i class="fa fa-undo"></i> Kembali
                    </a>
                </div>
            </br>
            </br>
            <div class="box-body">
                <div class="row justify-content-center">
                    <div class="col-md-4"> 
                        <?php echo form_open_multipart('item/process') ?>                      
                        <form action="<?=site_url('item/process') ?>" method="post">
                            <div class="form-group">
                                <label> Barcode *</label>
                                <input type="hidden" name="id" value="<?=$row->item_id?>">
                                <input type="text" name="barcode" value="<?=$row->barcode?>" class="form-control" required>                                
                            </div>  
                            <div class="form-group">
                                <label for="product_name"> Product Name *</label>                                
                                <input type="text" name="product_name" id="product_name" value="<?=$row->name?>" class="form-control" required>                                
                            </div>  
                            <div class="form-group">
                                <label for="category"> Category *</label>                                
                                <select name="category" class="form-control" required>
                                    <option value="">- Pilih -</option>
                                    <?php foreach($category->result() as $key => $data) { ?>
                                    <option value="<?=$data->category_id?>" <?=$data->category_id == $row->category_id ? 'selected' : null?>><?=$data->name?></option>                                     
                                    <?php } ?>
                                </select>                               
                            </div>  
                            <div class="form-group">
                                <label> Satuan *</label>
                                <select name="unit" id="" class="form-control">
                                <option <?php echo form_dropdown('unit', $unit, $selectedunit,
                                    ['class' => 'from-control', 'required' => 'required'])  ?>
                                </option>
                                </select>                
                            </div>  
                            <div class="form-group">
                                <label> Harga *</label>                               
                                <input type="number" name="price" value="<?=$row->price?>" class="form-control" required>                                
                            </div>
                            <div class="form-group">
                                <label> Stok</label>                               
                                <input type="number" name="stock" value="<?=$row->stock?>" class="form-control" value="0">                                
                            </div>
                            <div class="form-group">
                                <label> Gambar</label> 
                                <?php if($page == 'edit') {
                                    if($row->image != null) { ?>
                                    <div style="margin-bottom: 5px;">
                                    <img src="<?=base_url('uploads/product/'.$row->image)?>" style="width:80%">
                                    </div>
                                    <?php
                                    }
                                } ?>                         
                                <input type="file" name="image" value="" class="form-control">   
                                <small>(Biarkan kosong jika tidak <?=$page == 'edit' ? 'diganti' : 'ada'?>)</small>                             
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
 