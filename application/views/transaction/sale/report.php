<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Penjualan</title>
</head>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3>Laporan Penjualan</h3>
      </div>
    </div>
  </div>
</section>
<section class="content">
  <div class="card">
    <div class="card-body">
      <form method="get" action="<?=site_url('sale/report')?>">
        <div class="row">
          <div class="col-md-3">
            <label>Start</label>
            <input type="date" name="start" value="<?=$start?>" class="form-control">
          </div>
          <div class="col-md-3">
            <label>End</label>
            <input type="date" name="end" value="<?=$end?>" class="form-control">
          </div>
          <div class="col-md-3 align-self-end">
            <button class="btn btn-primary">Filter</button>
          </div>
        </div>
      </form>
      <hr>
      <table class="table table-bordered table-striped" id="report_table">
        <thead>
          <tr>
            <th><input type="checkbox" id="check_all"></th>
            <th>Tanggal</th>
            <th>Invoice</th>
            <th>Kasir</th>
            <th>Grand Total</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($rows as $r) { ?>
          <tr>
            <td><input type="checkbox" class="row_check" value="<?=$r->sale_id?>"></td>
            <td><?=$r->date?></td>
            <td><?=$r->invoice?></td>
            <td><?=$r->user_name?></td>
            <td><?=$r->final_price?></td>
            <td>
              <button type="button" class="btn btn-sm btn-info btn-detail" data-id="<?=site_url('sale/invoice/'.$r->sale_id)?>" title="Detail"><i class="fa fa-eye"></i></button>
              <a href="<?=site_url('sale/delete/'.$r->sale_id)?>" class="btn btn-sm btn-danger swal-delete-link" data-title="Hapus transaksi <?=$r->invoice?>?" title="Hapus"><i class="fa fa-trash"></i></a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="mt-2">
        <button type="button" class="btn btn-danger" id="delete_selected">Hapus Terpilih</button>
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="detail_modal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fas fa-file-invoice"></i> Detail Transaksi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="height:70vh;">
        <iframe id="detail_frame" src="" style="width:100%;height:100%;border:0;"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(function () {
    $('#report_table').DataTable({
      paging: true,
      lengthChange: true,
      searching: true,
      ordering: true,
      info: true,
      autoWidth: true,
      responsive: true
    });
  });
  $(document).on('click', '.btn-detail', function(){
    $('#detail_frame').attr('src', $(this).data('id'));
    $('#detail_modal').modal('show');
  });
  $('#check_all').on('change', function(){
    var checked = $(this).is(':checked');
    $('.row_check').prop('checked', checked);
  });
  $(document).on('click', '.btn-delete', function(){
    var id = $(this).data('id');
    var inv = $(this).data('invoice');
    Swal.fire({
      title: 'Hapus transaksi '+inv+'?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus',
      cancelButtonText: 'Batal'
    }).then(function(res){
      if(res.isConfirmed) {
        $.ajax({
          url: '<?=site_url('sale/delete_one')?>',
          method: 'POST',
          data: { id: id },
          dataType: 'json',
          success: function(r){
            if(r && r.success) {
              Swal.fire({title:'Berhasil dihapus', icon:'success', timer:1200, showConfirmButton:false}).then(function(){ location.reload(); });
            } else {
              Swal.fire({title:(r && r.message ? r.message : 'Gagal menghapus'), icon:'error'});
            }
          },
          error: function(){
            Swal.fire({title:'Gagal menghapus', icon:'error'});
          }
        });
      }
    });
  });
  $('#delete_selected').on('click', function(){
    var ids = $('.row_check:checked').map(function(){ return parseInt($(this).val()); }).get();
    if(ids.length === 0) {
      Swal.fire({title:'Tidak ada data dipilih', icon:'info', timer:1500, showConfirmButton:false});
      return;
    }
    Swal.fire({
      title: 'Hapus '+ids.length+' transaksi terpilih?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus',
      cancelButtonText: 'Batal'
    }).then(function(res){
      if(res.isConfirmed) {
        $.ajax({
          url: '<?=site_url('sale/delete_bulk')?>',
          method: 'POST',
          data: { ids: ids },
          dataType: 'json',
          traditional: true,
          success: function(r){
            if(r && r.success) {
              Swal.fire({title:'Berhasil dihapus', icon:'success', timer:1500, showConfirmButton:false}).then(function(){ location.reload(); });
            } else {
              Swal.fire({title:(r && r.message ? r.message : 'Gagal menghapus'), icon:'error'});
            }
          },
          error: function(){
            Swal.fire({title:'Gagal menghapus', icon:'error'});
          }
        });
      }
    });
  });
</script>
