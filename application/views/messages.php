<?php $success = $this->session->flashdata('success'); if (!empty($success)) { ?>
<script>
  window.addEventListener('load', function(){
    if(window.Swal){
      const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 2500, timerProgressBar: true });
      Toast.fire({ icon: 'success', title: 'Berhasil', html: '<?=addslashes($success)?>' });
    }
  });
  </script>
<?php $this->session->unset_userdata('success'); if(isset($_SESSION['__ci_vars']['success'])) { unset($_SESSION['__ci_vars']['success']); } ?>
<?php } ?>
<?php $error = $this->session->flashdata('error'); if (!empty($error)) { ?>
<script>
  window.addEventListener('load', function(){
    if(window.Swal){
      const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3500, timerProgressBar: true });
      Toast.fire({ icon: 'error', title: 'Gagal', html: '<?=addslashes(strip_tags(str_replace('</p>', '', $error)))?>' });
    }
  });
</script>
<?php $this->session->unset_userdata('error'); if(isset($_SESSION['__ci_vars']['error'])) { unset($_SESSION['__ci_vars']['error']); } ?>
<?php } ?>
