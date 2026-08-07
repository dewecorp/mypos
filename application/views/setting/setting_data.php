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
    <form action="<?=site_url('setting/update')?>" method="post" enctype="multipart/form-data">
        <?php $disc = property_exists($row, 'enable_discount') ? $row->enable_discount : 0; ?>
        <?php $auto = property_exists($row, 'auto_discount_percent') ? $row->auto_discount_percent : 0; ?>
        <?php $logo = property_exists($row, 'logo') ? $row->logo : ''; ?>
        <div class="card border-warning mb-4">
            <div class="card-header bg-warning">
                <h3 class="card-title"><i class="fas fa-image"></i> Logo Toko</h3>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-sm-2 text-center">
                        <?php if(!empty($logo) && file_exists(FCPATH.'uploads/logo/'.$logo)) { ?>
                            <img src="<?=base_url('uploads/logo/').$logo?>" alt="Logo" style="height:90px; max-width:90px;" class="img-thumbnail">
                        <?php } else { ?>
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center font-weight-bold"
                                 style="width:90px;height:90px;font-size:2rem;margin:0 auto;">
                                <?=strtoupper(substr($row->shop_name, 0, 1))?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-upload"></i></span></div>
                            <input type="file" name="logo" accept="image/*" class="form-control">
                        </div>
                        <small class="form-text text-muted">Format jpg/jpeg/png/svg/webp, maks 2MB. Kosongkan jika tidak mengganti logo.</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-info mb-4">
            <div class="card-header bg-info">
                <h3 class="card-title"><i class="fas fa-percent"></i> Pengaturan Diskon</h3>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Aktifkan Diskon</label>
                    <div class="col-sm-10">
                        <select name="enable_discount" class="form-control">
                            <option value="1" <?=$disc == 1 ? 'selected' : ''?>>Aktif</option>
                            <option value="0" <?=$disc != 1 ? 'selected' : ''?>>Nonaktif</option>
                        </select>
                        <small class="form-text text-muted">Jika nonaktif, kolom diskon di halaman transaksi disembunyikan.</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Diskon Otomatis (%)</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="number" name="auto_discount_percent" value="<?=$auto?>" step="0.01" min="0" max="100" class="form-control">
                            <div class="input-group-append"><span class="input-group-text">%</span></div>
                        </div>
                        <small class="form-text text-muted">Diskon global yang otomatis dipotong dari setiap transaksi. Isi 0 untuk nonaktif.</small>
                    </div>
                </div>
            </div>
        </div>
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