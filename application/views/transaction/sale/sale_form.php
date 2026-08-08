<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Penjualan | myPOS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- AdminLTE css biar font ikut template -->
  <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/fontawesome-free/css/all.min.css">
  <style>
    .content-wrapper > .content { padding: 1.4rem 2.2rem; max-width: 1500px; }
    .card-modern {
      border: none;
      border-radius: 14px;
      box-shadow: 0 2px 14px rgba(15, 30, 65, .08);
      overflow: hidden;
    }
    .card-modern .card-header {
      background: #fff;
      border-bottom: 1px solid #eef1f6;
      padding: .9rem 1.5rem;
    }
    .card-modern .card-header .card-title {
      font-weight: 600;
      color: #26304a;
      font-size: .95rem;
    }
    .card-modern .card-body { padding: 1.25rem 1.5rem; }
    .field-label {
      font-size: 11pt;
      color: #6b7484;
      font-weight: 500;
      padding-top: .35rem;
    }
    .input-modern {
      border-radius: 9px;
      border: 1.5px solid #dfe3ec;
      padding: .5rem .8rem;
      box-shadow: none !important;
    }
    .input-modern:focus { border-color: #4f67a6; }
    .summarizer {
      background: linear-gradient(135deg, #2f3b56 0%, #4b5f93 100%);
      border-radius: 14px;
      color: #fff;
      padding: 1.25rem 1.5rem;
    }
    .summarizer .info-label { color: #cdd6ea; font-size: .8rem; }
    .summarizer .info-val { font-weight: 600; font-size: 1.05rem; }
    .btn-rounded { border-radius: 9px; padding: .5rem 1.1rem; font-weight: 500; }
    .cart-table thead th {
      background: #f5f7fb;
      color: #4a5368;
      font-weight: 600;
      border-bottom: 1px solid #e6eaf1;
    }
    .total-badge {
      font-size: 2.4rem;
      font-weight: 700;
      line-height: 1;
      color: #22c48b;
    }
  </style>
</head>
    <section class="content">
      <?php $__st = $this->fungsi->get_setting(); $__stn = $__st && !empty($__st->shop_name) ? $__st->shop_name : 'Toko'; $__sad = $__st && !empty($__st->address) ? $__st->address : ''; $__spn = $__st && !empty($__st->phone) ? $__st->phone : ''; $__slo = $__st && !empty($__st->logo) ? $__st->logo : ''; ?>
      <div class="card card-modern mb-3">
        <div class="card-body">
          <div class="d-flex align-items-center flex-wrap">
            <?php if($__slo && file_exists(FCPATH.'uploads/logo/'.$__slo)) { ?>
              <img src="<?=base_url('uploads/logo/').$__slo?>" alt="<?=htmlspecialchars($__stn, ENT_QUOTES)?>" class="mr-3 rounded-circle bg-white object-fit-cover" style="height:56px;width:56px;">
            <?php } else { ?>
              <span class="rounded-circle bg-primary text-white font-weight-bold d-flex align-items-center justify-content-center mr-3" style="width:56px;height:56px;font-size:1.4rem;"><?=strtoupper(substr($__stn,0,1))?></span>
            <?php } ?>
            <div class="mr-4">
              <div class="font-weight-bold" style="font-size:1.15rem;"><?=htmlspecialchars($__stn, ENT_QUOTES)?></div>
              <?php if($__sad) { ?><div class="text-muted small"><i class="fas fa-map-marker-alt mr-1" style="color:#4f67a6"></i><?=htmlspecialchars($__sad, ENT_QUOTES)?></div><?php } ?>
              <?php if($__spn) { ?><div class="text-muted small"><i class="fas fa-phone mr-1" style="color:#4f67a6"></i><?=htmlspecialchars($__spn, ENT_QUOTES)?></div><?php } ?>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4">
          <div class="card card-modern mb-3">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-calendar-alt mr-1" style="color:#4f67a6"></i> Informasi Transaksi</h3>
            </div>
            <div class="card-body">
              <div class="row mb-2">
                <label for="date" class="col-4 field-label">Tanggal</label>
                <div class="col-8">
                  <input type="date" id="date"  value="<?=date('Y-m-d')?>" class="form-control input-modern">
                </div>
              </div>
              <div class="row">
                <label for="user" class="col-4 field-label">Kasir</label>
                <div class="col-8">
                  <input type="text" id="user"  value="<?=$this->fungsi->user_login()->name?>" class="form-control input-modern" readonly>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card card-modern mb-3">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-barcode mr-1" style="color:#4f67a9"></i> Input Barang</h3>
            </div>
            <div class="card-body">
              <input type="hidden" id="item_id">
              <input type="hidden" id="item_name">
              <input type="hidden" id="price">
              <div class="row mb-2">
                <label for="barcode" class="col-4 field-label">Barcode</label>
                <div class="col-8 input-group">
                  <input type="text" id="barcode" class="form-control input-modern" autofocus>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-item">
                      <i class="fa fa-search"></i>
                    </button>
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <label for="qty" class="col-4 field-label">Jumlah</label>
                <div class="col-8">
                  <input type="number" id="qty" value="1" min="1" class="form-control input-modern">
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <button type="button" id="add_cart" class="btn btn-primary btn-block btn-rounded">
                    <i class="fa fa-cart-plus"></i> Tambah ke Keranjang
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card card-modern mb-3">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-file-invoice-dollar mr-1" style="color:#4f67a9"></i> Ringkasan Transaksi</h3>
            </div>
            <div class="card-body">
              <div class="summarizer">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="info-label">Invoice</span>
                  <span class="info-val"><span id="invoice"><?=$invoice?></span></span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="info-label">Jumlah Item</span>
                  <span class="info-val" id="item_count">0</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <span class="info-label">Total</span>
                  <span class="total-badge" id="grand_total2">0</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <br>

      <div class="row">
        <div class="col-lg-12">
          <div class="card card-modern mb-3">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-shopping-cart mr-1" style="color:#4f67a9"></i> Keranjang Belanja <span class="badge badge-primary ml-1" id="cart_badge">0 item</span></h3>
            </div>
            <div class="card-body table-responsive p-0">
              <table class="table cart-table table-striped mb-0">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Barcode</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Jml</th>
                    <?php if($discount_enabled) { ?>
                    <th width="16%" class="disc-col">Diskon</th>
                    <?php } ?>
                    <th width="15%">Total</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody id="cart_table">
                  <tr>
<td colspan="<?= $discount_enabled ? 9 : 8 ?>" class="text-center py-4 text-muted">Belum ada item di keranjang</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

       <div class="row">
        <div class="col-lg-3">
          <div class="card card-modern mb-3 h-100">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-calculator mr-1" style="color:#4f67a9"></i> Perhitungan</h3>
            </div>
            <div class="card-body">
              <div class="row mb-2">
                <label for="sub_total" class="col-6 field-label">Sub Total</label>
                <div class="col-6">
                  <input type="text" id="sub_total" value="" class="form-control input-modern text-right font-weight-bold" readonly data-raw="0">
                </div>
              </div>
              <?php if($discount_enabled && $auto_discount_percent > 0) { ?>
              <div class="row mb-2">
                <label class="col-6 field-label">Diskon Otomatis</label>
                <div class="col-6">
                  <input type="text" id="auto_disc" value="0" class="form-control input-modern text-right font-weight-bold text-info" readonly data-raw="0">
                </div>
              </div>
              <?php } ?>
              <?php if($discount_enabled) { ?>
              <div class="row mb-2">
                <label for="discount" class="col-6 field-label">Diskon Manual</label>
                <div class="col-6">
                  <input type="number" id="discount" value="0" min="0" class="form-control input-modern text-right">
                </div>
              </div>
              <?php } ?>
              <div class="row">
                <label for="grand_total" class="col-6 field-label font-weight-bold">Total Akhir</label>
                <div class="col-6">
                  <input type="text" id="grand_total" class="form-control input-modern text-right font-weight-bold" readonly data-raw="0">
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-lg-3">
          <div class="card card-modern mb-3 h-100">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-money-bill-wave mr-1" style="color:#4f67a9"></i> Pembayaran</h3>
            </div>
            <div class="card-body">
              <div class="row mb-2">
                <label for="cash" class="col-6 field-label">Tunai</label>
                <div class="col-6">
                  <input type="text" id="cash" value="0" class="form-control input-modern text-right" data-raw="0" inputmode="numeric">
                </div>
              </div>
              <div class="row">
                <label for="change" class="col-6 field-label font-weight-bold">Kembalian</label>
                <div class="col-6">
                  <input type="text" id="Change" class="form-control input-modern text-right font-weight-bold text-success" data-raw="0" readonly>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-lg-3">
          <div class="card card-modern mb-3 h-100">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-sticky-note mr-1" style="color:#4f67a9"></i> Catatan</h3>
            </div>
            <div class="card-body">
              <textarea id="note" rows="3" class="form-control input-modern" placeholder="Catatan transaksi..."></textarea>
            </div>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="card card-modern mb-3 h-100">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-credit-card mr-1" style="color:#4f67a9"></i> Aksi</h3>
            </div>
            <div class="card-body">
              <button id="cancel_payment" class="btn btn-warning btn-block btn-rounded mb-2">
                <i class="fa fa-ban"></i> Batal
              </button>
              <button id="reset_transaction" class="btn btn-secondary btn-block btn-rounded mb-2">
                <i class="fa fa-refresh"></i> Reset
              </button>
              <button id="process_payment" class="btn btn-success btn-block btn-rounded">
                <i class="fa fa-paper-plane"></i> Proses Bayar
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="modal fade" id="invoice_modal">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Invoice</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="height:75vh">
            <iframe id="invoice_frame" src="" style="width:100%; height:100%; border:0;"></iframe>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
<div class="modal fade" id="modal-item">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Pilih Barang</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped" id="item_table">
          <thead>
            <tr>
              <th>Barcode</th>
              <th>Nama</th>
              <th>Harga</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($items as $it) { ?>
            <tr>
              <td><?=$it->barcode?></td>
              <td><?=$it->name?></td>
              <td><?=$it->price?></td>
              <td>
                <button type="button"
                  class="btn btn-primary btn-sm select-item"
                  data-item_id="<?=$it->item_id?>"
                  data-barcode="<?=$it->barcode?>"
                  data-name="<?=$it->name?>"
                  data-price="<?=$it->price?>">
                  Pilih
                </button>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>
<script>
  $(document).ready(function() {
    var table = $('#item_table').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true
    });
    
    // Fix DataTable width issue inside modal
    $('#modal-item').on('shown.bs.modal', function () {
       table.columns.adjust().responsive.recalc();
    });
  });

  var cart = [];
  var DISCOUNT_ON = <?= (int)$discount_enabled ? 'true' : 'false' ?>;
  var AUTO_PERCENT = <?= (float)$auto_discount_percent ?>;
  function rupiah(n) {
    return parseInt(n || 0).toLocaleString('id-ID');
  }
  function itemDisc(it) {
    var v = parseFloat(it.disc_val || 0);
    if(it.disc_mode === 'pct') { return Math.round(parseInt(it.price) * parseInt(it.qty) * v / 100); }
    return Math.round(v);
  }
  function renderCart() {
    var tbody = $('#cart_table');
    tbody.empty();
    $('#item_count').text('0');
    $('#cart_badge').text('0 item');
    $('#sub_total').val('0').data('raw', 0);
    $('#grand_total').val('0').data('raw', 0);
    if(cart.length === 0) {
      tbody.append('<tr><td colspan="'+(DISCOUNT_ON ? 9 : 8)+'" class="text-center py-4 text-muted">Belum ada item di keranjang</td></tr>');
    } else {
      var totalQty = 0;
      cart.forEach(function(it) { totalQty += parseInt(it.qty || 0); });
      $('#item_count').text(totalQty);
      $('#cart_badge').text(totalQty+' item');
      var subTotal = 0;
      cart.forEach(function(it, idx) {
        it.discount = itemDisc(it);
        var rowTotal = (parseInt(it.price) * parseInt(it.qty)) - it.discount;
        if(rowTotal < 0) rowTotal = 0;
        it.total = rowTotal;
        subTotal += rowTotal;
        var discCell = '';
        if(DISCOUNT_ON) {
          var modeRp = (it.disc_mode !== 'pct');
          discCell = '<td><div class="input-group input-group-sm">'+
            '<input type="number" class="form-control row-disc" data-index="'+idx+'" value="'+(it.disc_val||0)+'" min="0">'+
            '<select class="custom-select row-disc-mode" data-index="'+idx+'">'+
            '<option value="rp"'+(modeRp?' selected':'')+'>Rp</option>'+
            '<option value="pct"'+(modeRp?'':' selected')+'>%</option>'+
            '</select></div></td>';
        }
        var row = '<tr>'+
          '<td>'+(idx+1)+'</td>'+
          '<td>'+it.barcode+'</td>'+
          '<td>'+it.name+'</td>'+
          '<td>Rp '+rupiah(it.price)+'</td>'+
          '<td>'+it.qty+'</td>'+
          discCell+
          '<td class="font-weight-bold">Rp '+rupiah(rowTotal)+'</td>'+
          '<td><button class="btn btn-danger btn-sm" data-index="'+idx+'" id="del_row" title="Hapus"><i class="fa fa-trash"></i></button></td>'+
        '</tr>';
        tbody.append(row);
      });
      $('#sub_total').val(rupiah(subTotal)).data('raw', subTotal);
      var discAuto = (AUTO_PERCENT > 0) ? Math.round(subTotal * AUTO_PERCENT / 100) : 0;
      if($('#auto_disc').length) { $('#auto_disc').val(rupiah(discAuto)).data('raw', discAuto); }
      var discManual = DISCOUNT_ON ? (parseInt($('#discount').val() || 0)) : 0;
      var grand = subTotal - discAuto - discManual;
      if(grand < 0) grand = 0;
      $('#grand_total').val(rupiah(grand)).data('raw', grand);
      $('#grand_total2').text(rupiah(grand));
      var cash = parseInt($('#cash').data('raw') || 0);
      var change = cash - grand;
      if(change < 0) change = 0;
      $('#Change').val(rupiah(change)).data('raw', change);
    }
  }
  $('#discount').on('input', function() { renderCart(); });
  $(document).on('input change', '.row-disc, .row-disc-mode', function(){
    var i = parseInt($(this).data('index'));
    var it = cart[i];
    if(!it) return;
    if($(this).hasClass('row-disc')) { it.disc_val = $(this).val(); }
    else { it.disc_mode = $(this).val(); }
    it.discount = itemDisc(it);
    renderCart();
  });
  $('#cash').on('input', function() {
    var raw = $(this).val().replace(/\D/g, '');
    $(this).val(raw ? rupiah(raw) : '').data('raw', parseInt(raw || 0));
    renderCart();
  });
  $(document).on('click', '#del_row', function(){
    var i = parseInt($(this).data('index'));
    cart.splice(i,1);
    renderCart();
  });
  function addToCart() {
    var item_id = $('#item_id').val();
    if(item_id) {
      var bc = $('#barcode').val();
      var name = $('#item_name').val();
      var price = parseInt($('#price').val() || 0);
      var qty = parseInt($('#qty').val() || 1);
      var discount = 0;
      var total = (price * qty) - discount;
      var existingIndex = cart.findIndex(function(c){ return c.item_id == item_id; });
      if(existingIndex >= 0) {
        var existing = cart[existingIndex];
        var newQty = existing.qty + qty;
        existing.qty = newQty;
        existing.discount = itemDisc(existing);
        existing.total = (existing.price * existing.qty) - existing.discount;
        cart[existingIndex] = existing;
      } else {
        cart.push({
          item_id: parseInt(item_id),
          barcode: bc,
          name: name,
          price: price,
          qty: qty,
          disc_val: 0,
          disc_mode: 'rp',
          discount: discount,
          total: total
        });
      }
      renderCart();
      $('#barcode').val('');
      $('#item_id').val('');
      $('#item_name').val('');
      $('#price').val('');
      $('#qty').val(1);
      $('#barcode').focus();
    } else {
      Swal.fire({title:'Silakan pilih barang terlebih dahulu', icon:'info', timer:1200, showConfirmButton:false});
    }
  }
  $('#add_cart').on('click', addToCart);
  $('#barcode').on('keydown', function(e){
    if(e.key === 'Enter') {
      e.preventDefault();
      var bc = $(this).val();
      if(!bc) return;
      $.getJSON('<?=site_url('sale/get_item')?>', {barcode: bc}, function(res){
        if(res && res.success) {
          $('#item_id').val(res.item_id);
          $('#item_name').val(res.name);
          $('#price').val(res.price);
          addToCart();
        } else {
          Swal.fire({title:'Barcode tidak ditemukan', icon:'error'});
          $('#barcode').select();
        }
      });
    }
  });
  $(document).on('click', '.select-item', function(){
    var item_id = $(this).data('item_id');
    var name = $(this).data('name');
    var bc = $(this).data('barcode');
    var price = parseInt($(this).data('price'));
    $('#barcode').val(bc);
    $('#item_id').val(item_id);
    $('#item_name').val(name);
    $('#price').val(price);
    $('#qty').val(1);
    $('#modal-item').modal('hide');
    $('#qty').focus();
  });
  $('#process_payment').on('click', function(){
    if(cart.length === 0) { Swal.fire({title:'Tidak ada item', icon:'info'}); return; }
    var autoDisc = ($('#auto_disc').length) ? (parseInt($('#auto_disc').data('raw') || 0)) : 0;
    var manDisc = DISCOUNT_ON ? (parseInt($('#discount').val() || 0)) : 0;
    var totalDisc = autoDisc + manDisc;
    var data = {
      invoice: $('#invoice').text(),
      date: $('#date').val(),
      customer: $('#customer').val(),
      sub_total: $('#sub_total').data('raw') || 0,
      discount: totalDisc,
      grand_total: $('#grand_total').data('raw') || 0,
      cash: $('#cash').data('raw') || 0,
      change: $('#Change').data('raw') || 0,
      note: $('#note').val(),
      items: JSON.stringify(cart)
    };
    $.ajax({
      url: '<?=site_url('sale/process')?>',
      method: 'POST',
      data: data,
      dataType: 'json',
      success: function(res){
        if(res && res.success) {
          Swal.fire({title:'Transaksi berhasil', icon:'success', timer:1500, showConfirmButton:false});
          setTimeout(function() {
            window.open('<?=site_url('sale/cetak/')?>'+res.sale_id, '_blank');
          }, 1000);
        } else {
          Swal.fire({title:(res && res.message ? res.message : 'Gagal simpan transaksi'), icon:'error'});
        }
      },
      error: function(){
        Swal.fire({title:'Gagal memproses', icon:'error'});
      }
    });
  });
  $('#reset_transaction').on('click', function(){
    cart = [];
    $('#barcode').val('');
    $('#item_id').val('');
    $('#item_name').val('');
    $('#price').val('');
    $('#qty').val(1);
    $('#discount').val(0);
    $('#auto_disc').val('0').data('raw', 0);
    $('#cash').val('0').data('raw', 0);
    $('#Change').val('0').data('raw', 0);
    $('#note').val('');
    renderCart();
    location.reload();
  });
</script>
