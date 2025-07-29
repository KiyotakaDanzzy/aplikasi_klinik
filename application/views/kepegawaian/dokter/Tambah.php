<script type="text/javascript">
  function tambah(e) {
      e.preventDefault()
      $.ajax({
          url : '<?php echo base_url('kepegawaian/dokter/dokter/tambah_aksi') ?>',
          method : 'POST', data : $('#form_tambah').serialize(), dataType : 'json',
          success: function (res){
              if (res.status == true) {
                Swal.fire({ title: 'Berhasil!', text: res.message, icon: "success", confirmButtonColor: "#35baf5", confirmButtonText: "Oke" })
                .then((result) => { if (result.isConfirmed) { window.location.href = '<?php echo base_url() ?>kepegawaian/dokter/dokter' } })
              } else {
                Swal.fire({ title: 'Gagal!', text: res.message, icon: "error", confirmButtonColor: "#35baf5", confirmButtonText: "Oke" })
              }
          }
      });
  }
</script>
<div class="container-fluid">
    <div class="row"><div class="col-sm-12"><div class="page-title-box"><div class="float-end"><ol class="breadcrumb"><li class="breadcrumb-item"><?php echo $title; ?></li><li class="breadcrumb-item"><a href="<?php echo base_url(); ?>kepegawaian/dokter/dokter">Data</a></li><li class="breadcrumb-item active">Tambah</li></ol></div><h4 class="page-title"><?php echo $title; ?></h4></div></div></div>
    <div class="row">
    <div class="col-lg-12">
      <div class="card">
          <div class="card-header pt-3 pb-3"><h4 class="card-title">Tambah <?php echo $title; ?></h4></div>
          <div class="card-body"><div class="general-label">
              <form id="form_tambah">
                <div class="mb-3 row"><label for="id_pegawai" class="col-sm-2 col-form-label">Pegawai (Dokter)</label><div class="col-sm-10"><select class="form-control" name="id_pegawai" id="id_pegawai"><option value="">Pilih Pegawai</option><?php foreach ($data_pegawai as $pegawai) { echo "<option value='{$pegawai->id}'>{$pegawai->nama}</option>"; } ?></select></div></div>
                <div class="mb-3 row"><label for="id_poli" class="col-sm-2 col-form-label">Poli</label><div class="col-sm-10"><select class="form-control" name="id_poli" id="id_poli"><option value="">Pilih Poli</option><?php foreach ($data_poli as $poli) { echo "<option value='{$poli->id}'>{$poli->nama}</option>"; } ?></select></div></div>
                <div class="row"><div class="col-sm-10 ms-auto"><button type="button" onclick="tambah(event);" class="btn btn-success"><i class="fas fa-save me-2"></i>Simpan</button><a href="<?php echo base_url(); ?>kepegawaian/dokter/dokter"><button type="button" class="btn btn-warning"><i class="fas fa-reply me-2"></i>Kembali</button></a></div></div>
              </form>
            </div></div>
      </div>
    </div>
  </div>
</div>