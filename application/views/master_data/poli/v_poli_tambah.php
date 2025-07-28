<script type="text/javascript">
  function tambah(e) {
      e.preventDefault()

      $.ajax({
          url : '<?php echo base_url('master_data/poli/poli/tambah_aksi') ?>',
          method : 'POST',
          data : $('#form_tambah').serialize(),
          dataType : 'json',
          success: function (res){
              if (res.status == true) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: res.message,
                    icon: "success",
                    showCancelButton: false,
                    showConfirmButton: true,
                    confirmButtonColor: "#35baf5",
                    confirmButtonText: "Oke",
                    closeOnConfirm: false,
                    allowOutsideClick : false
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = '<?php echo base_url() ?>master_data/poli/poli'
                    }
                })
              } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: res.message,
                    icon: "error",
                    showCancelButton: false,
                    showConfirmButton: true,
                    confirmButtonColor: "#35baf5",
                    confirmButtonText: "Oke",
                    closeOnConfirm: false,
                    allowOutsideClick : false
                  })
              }
          }
      });
  }
</script>
<div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
          <div class="page-title-box">
              <div class="float-end">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><?php echo $title; ?></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>master_data/poli/poli">Data</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                  </ol>
              </div>
              <h4 class="page-title"><?php echo $title; ?></h4>
          </div>
      </div>
    </div>
    <div class="row">
    <div class="col-lg-12">
      <div class="card">
          <div class="card-header pt-3 pb-3">
              <h4 class="card-title">Tambah <?php echo $title; ?></h4>
          </div>
          <div class="card-body">
            <div class="general-label">
              <form id="form_tambah">
                <div class="mb-3 row">
                  <label for="kode" class="col-sm-2 col-form-label">Kode Poli</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" name="kode" id="kode" placeholder="Input Kode Poli" required>
                  </div>
                </div>
                <div class="mb-3 row">
                  <label for="nama" class="col-sm-2 col-form-label">Nama Poli</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" name="nama" id="nama" placeholder="Input Nama Poli" required>
                  </div>
                </div>
                <div class="row">
                    <div class="col-sm-10 ms-auto">
                        <button type="button" onclick="tambah(event);" class="btn btn-success"><i class="fas fa-save me-2"></i>Simpan</button>
                        <a href="<?php echo base_url(); ?>master_data/poli/poli"><button type="button" class="btn btn-warning"><i class="fas fa-reply me-2"></i>Kembali</button></a>
                    </div>
                </div>
              </form>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>