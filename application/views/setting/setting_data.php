<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Pengaturan Toko</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Settings</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <?php $this->view('messages') ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Toko</h3>
        </div>
        <div class="card-body">
            <form action="<?=site_url('setting/update')?>" method="post">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama Toko / Aplikasi</label>
                    <div class="col-sm-10">
                        <input type="text" name="shop_name" value="<?=$row->shop_name?>" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <textarea name="address" class="form-control" rows="3" required><?=$row->address?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">No. Telepon / HP</label>
                    <div class="col-sm-10">
                        <input type="text" name="phone" value="<?=$row->phone?>" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" name="update_setting" class="btn btn-success"><i class="fas fa-paper-plane"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>