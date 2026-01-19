<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Penjualan | myPOS</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Transaction</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
              <li class="breadcrumb-item active">Penjualan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="row">
        <div class="col-lg-4">
          <div class="box box-widget">
            <div class="box-body">
              <table width="100%">
                <tr>
                  <td style="vertical-align:top">
                    <label for="date">Date</label>
                  </td>
                  <td>
                  <div class="form-group">
                    <input type="date" id="date"  value="<?=date('Y-m-d')?>" class="form-control">
                  </div>
                  </td>
                </tr>
                <tr>
                  <td style="vertical-align:top; width:30%">
                    <label for="user">Kasir</label>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" id="user"  value="<?=$this->fungsi->user_login()->name?>" class="form-control" readonly>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td style="vertical-align:top">
                    <label for="customer">Customer</label>
                  </td>
                  <td>
                    <div >
                      <select id="customer"class="form-control">
                        <option value="">Umum</option>
                        <?php foreach($customer as $cust => $value) {
                          echo '<option value="'.$value->customer_id.'">'.$value->name.'</option>';
                        } ?>
                      </select>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="box box-widget">
            <div class="box-body">
              <table width="100%">
                <tr>
                  <td style="vertical-align:top; width:30%">
                    <label for="barcode">Barcode</label>
                  </td>
                  <td>
                    <div class="form-group input-group">
                      <input type="hidden" id="item_id">
                      <input type="hidden" id="item_name">
                      <input type="hidden" id="price">
                      <input type="hidden" id="stock">
                      <input type="text" id="barcode" class="form-control" autofocus>
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-item">
                          <i class="fa fa-search"></i>
                        </button>
                      </span>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td style="vertical-align:top">
                    <label for="qty">Qty</label>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="number" id="qty" value="1" min="1" class="form-control">
                    </div>
                  </td>
                </tr>
                <td></td>
                <td>
                  <div>
                    <button type="button" id="add_cart" class="btn btn-primary">
                      <i class="fa fa-cart-plus"></i> Add
                    </button>
                  </div>
                </td>
              </table>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="box box-widget">
            <div class="box-body">
              <div align="right">
                <h4>Invoice <b><span id="invoice"><?=$invoice?></span></b></h4>
                  <h1><b><span id="grand_total2" style="font-size:50pt">0</span></b></h1>
              </div>
            </div>
          </div>
        </div>
      </div>

      <br>

      <div class="row">
        <div class="col-lg-12">
          <div class="box box-widget">
            <div class="box-body table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Barcode</th>
                    <th>Product Item</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th width="10%">Discount</th>
                    <th width="15%">Total</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="cart_table">
                  <tr>
                    <td colspan="9" class="text-center">Tidak Ada Item</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

       <div class="row">
        <div class="col-lg-3">
          <div class="box box-widget">
            <div class="box-body">
              <table width="100%">
                  <tr>
                   <td style="vertical-align: top; width: 30%">
                   <label for="sub_total">Sub Total</label>
                   </td>
                   <td>
                     <div class="form-group">
                        <input type="number" id="sub_total" value="" class="form-control" readonly>
                     </div>
                   </td>
                  </tr>
                  <tr>
                    <td style="vertical-align: top;">
                        <label for="discount">Discount</label>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="number" id="discount" value="0" min="0" class="form-control">
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td style="vertical-align: top;">
                        <label for="grand_total">Grand Total</label>
                    </td>
                    <td>
                        <div class="form-group">
                          <input type="number" id="grand_total" class="form-control" readonly>
                        </div>
                    </td>
                  </tr>
              </table>
            </div>
          </div>
        </div>


        <div class="col-lg-3">
          <div class="box box-widget">
            <div class="box-body">
              <table width="100%">
                  <tr>
                   <td style="vertical-align: top; width: 30%">
                   <label for="cash">Cash</label>
                   </td>
                   <td>
                     <div class="form-group">
                        <input type="number" id="cash" value="0" min="0" class="form-control">
                     </div>
                   </td>
                  </tr>
                  <tr>
                    <td style="vertical-align: top;">
                        <label for="change">Change</label>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="number" id="Change" class="form-control" readonly>
                      </div>
                    </td>
                  </tr>
              </table>
            </div>
          </div>
        </div>


        <div class="col-lg-3">
          <div class="box box-widget">
            <div class="box-body">
              <table width="100%">
                  <tr>
                   <td style="vertical-align: top">
                   <label for="note">Note</label>
                   </td>
                   <td>
                     <div>
                       <textarea  id="note"  rows="3" class="form-control"></textarea>
                     </div>
                   </td>
                  </tr>
              </table>
            </div>
          </div>
        </div>

        <div class="col-lg-3">
            <div>
             <button id="cancel_payment" class="btn btn-warning">
               <i class="fa fa-ban"></i> Cancel Payment
             </button><br><br>
             <button id="reset_transaction" class="btn btn-secondary">
               <i class="fa fa-refresh"></i> Reset Transaction
             </button><br><br>
             <button id="process_payment" class="btn btn-success">
               <i class="fa fa-paper-plane"></i> Process Payment
             </button>
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
              <th>Stok</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($items as $it) { ?>
            <tr>
              <td><?=$it->barcode?></td>
              <td><?=$it->name?></td>
              <td><?=$it->price?></td>
              <td><?=$it->stock?></td>
              <td>
                <button type="button"
                  class="btn btn-primary btn-sm select-item"
                  data-item_id="<?=$it->item_id?>"
                  data-barcode="<?=$it->barcode?>"
                  data-name="<?=$it->name?>"
                  data-price="<?=$it->price?>"
                  data-stock="<?=$it->stock?>">
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
  var cart = [];
  function renderCart() {
    var tbody = $('#cart_table');
    tbody.empty();
    if(cart.length === 0) {
      tbody.append('<tr><td colspan="9" class="text-center">Tidak Ada Item</td></tr>');
    } else {
      var subTotal = 0;
      cart.forEach(function(it, idx) {
        var rowTotal = (parseInt(it.price) * parseInt(it.qty)) - parseInt(it.discount || 0);
        if(rowTotal < 0) rowTotal = 0;
        it.total = rowTotal;
        subTotal += rowTotal;
        var row = '<tr>'+
          '<td>'+(idx+1)+'</td>'+
          '<td>'+it.barcode+'</td>'+
          '<td>'+it.name+'</td>'+
          '<td>'+it.price+'</td>'+
          '<td>'+it.qty+'</td>'+
          '<td>'+it.discount+'</td>'+
          '<td>'+rowTotal+'</td>'+
          '<td><button class="btn btn-danger btn-sm" data-index="'+idx+'" id="del_row">Hapus</button></td>'+
        '</tr>';
        tbody.append(row);
      });
      $('#sub_total').val(subTotal);
      var disc = parseInt($('#discount').val() || 0);
      var grand = subTotal - disc;
      if(grand < 0) grand = 0;
      $('#grand_total').val(grand);
      $('#grand_total2').text(grand);
      var cash = parseInt($('#cash').val() || 0);
      var change = cash - grand;
      if(change < 0) change = 0;
      $('#Change').val(change);
    }
  }
  $('#discount, #cash').on('input', function() { renderCart(); });
  $(document).on('click', '#del_row', function(){
    var i = parseInt($(this).data('index'));
    cart.splice(i,1);
    renderCart();
  });
  $('#barcode').on('change', function(){
    var bc = $(this).val();
    if(!bc) return;
    $.getJSON('<?=site_url('sale/get_item')?>', {barcode: bc}, function(res){
      if(res && res.success) {
        $('#item_id').val(res.item_id);
        $('#item_name').val(res.name);
        $('#price').val(res.price);
        $('#stock').val(res.stock);
      } else {
        Swal.fire({title:'Barcode tidak ditemukan', icon:'error'});
      }
    });
  });
  $('#add_cart').on('click', function(){
    var item_id = $('#item_id').val();
    if(item_id) {
      var bc = $('#barcode').val();
      var name = $('#item_name').val();
      var price = parseInt($('#price').val() || 0);
      var stock = parseInt($('#stock').val() || 0);
      var qty = parseInt($('#qty').val() || 1);
      if(qty > stock) { Swal.fire({title:'Stok tidak mencukupi', icon:'error'}); return; }
      var discount = 0;
      var total = (price * qty) - discount;
      var existingIndex = cart.findIndex(function(c){ return c.item_id == item_id; });
      if(existingIndex >= 0) {
        var existing = cart[existingIndex];
        var newQty = existing.qty + qty;
        if(newQty > stock) { Swal.fire({title:'Stok tidak mencukupi', icon:'error'}); return; }
        existing.qty = newQty;
        existing.total = (existing.price * existing.qty) - existing.discount;
        cart[existingIndex] = existing;
      } else {
        cart.push({
          item_id: parseInt(item_id),
          barcode: bc,
          name: name,
          price: price,
          qty: qty,
          discount: discount,
          total: total
        });
      }
      renderCart();
      $('#barcode').val('');
      $('#item_id').val('');
      $('#item_name').val('');
      $('#price').val('');
      $('#stock').val('');
      $('#qty').val(1);
    } else {
      Swal.fire({title:'Silakan pilih barang terlebih dahulu', icon:'info', timer:1200, showConfirmButton:false});
    }
  });
  $(document).on('click', '.select-item', function(){
    var item_id = $(this).data('item_id');
    var name = $(this).data('name');
    var bc = $(this).data('barcode');
    var price = parseInt($(this).data('price'));
    var stock = parseInt($(this).data('stock'));
    $('#barcode').val(bc);
    $('#item_id').val(item_id);
    $('#item_name').val(name);
    $('#price').val(price);
    $('#stock').val(stock);
    $('#qty').val(1);
    $('#modal-item').modal('hide');
    $('#qty').focus();
  });
  $('#process_payment').on('click', function(){
    if(cart.length === 0) { Swal.fire({title:'Tidak ada item', icon:'info'}); return; }
    var data = {
      invoice: $('#invoice').text(),
      date: $('#date').val(),
      customer: $('#customer').val(),
      sub_total: $('#sub_total').val(),
      discount: $('#discount').val(),
      grand_total: $('#grand_total').val(),
      cash: $('#cash').val(),
      change: $('#Change').val(),
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
          window.open('<?=site_url('sale/invoice/')?>'+res.sale_id, '_blank');
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
    $('#stock').val('');
    $('#qty').val(1);
    $('#discount').val(0);
    $('#cash').val(0);
    $('#Change').val(0);
    $('#note').val('');
    renderCart();
    location.reload();
  });
</script>
