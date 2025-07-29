<script type="text/javascript">
  function validateForm(formSelector) {
    let isValid = true;
    $(formSelector + ' [required]').removeClass('is-invalid');
    $(formSelector + ' [required]').each(function() {
      if (!$(this).val() || $(this).val().trim() === '') {
        isValid = false;
        $(this).addClass('is-invalid');
      }
    });

    if (!isValid) {
      Swal.fire({
        title: 'Gagal!',
        text: 'Harap isi semua kolom yang wajib diisi.',
        icon: 'error',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Oke'
      });
    }

    return isValid;
  }

  function tambah(e) {
    e.preventDefault()
    if (!validateForm('#form_tambah')) {
        return;
    }
    $.ajax({
      url: '<?php echo base_url('kepegawaian/pegawai/pegawai/tambah_aksi') ?>',
      method: 'POST',
      data: $('#form_tambah').serialize(),
      dataType: 'json',
      success: function(res) {
        if (res.status == true) {
          Swal.fire({
              title: 'Berhasil!',
              text: res.message,
              icon: "success",
              confirmButtonColor: "#35baf5",
              confirmButtonText: "Oke"
            })
            .then((result) => {
              if (result.isConfirmed) {
                window.location.href = '<?php echo base_url() ?>kepegawaian/pegawai/pegawai'
              }
            })
        } else {
          Swal.fire({
            title: 'Gagal!',
            text: res.message,
            icon: "error",
            confirmButtonColor: "#35baf5",
            confirmButtonText: "Oke"
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
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>kepegawaian/pegawai/pegawai">Data</a></li>
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
          <h4 class="card-title"><?php echo $title; ?></h4>
        </div>
        <div class="card-body">
          <div class="general-label">
            <form id="form_tambah">
              <div class="mb-3 row"><label for="nama" class="col-sm-2 col-form-label">Nama Pegawai</label>
                <div class="col-sm-10"><input type="text" class="form-control" name="nama" id="nama" placeholder="Input Nama Pegawai" required></div>
              </div>
              <div class="mb-3 row"><label for="no_telp" class="col-sm-2 col-form-label">No. Telepon</label>
                <div class="col-sm-10"><input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="Input No. Telepon" required></div>
              </div>
              <div class="mb-3 row"><label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10"><textarea class="form-control" name="alamat" id="alamat"></textarea></div>
              </div>
              <div class="mb-3 row"><label for="id_jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                <div class="col-sm-10"><select class="form-control" name="id_jabatan" id="id_jabatan" required>
                    <option value="">Pilih Jabatan</option><?php foreach ($data_jabatan as $jabatan) {
                                                              echo "<option value='{$jabatan->id}'>{$jabatan->nama}</option>";
                                                            } ?>
                  </select></div>
              </div>
              <div class="row">
                <div class="col-sm-10 ms-auto"><button type="button" onclick="tambah(event);" class="btn btn-success"><i class="fas fa-save me-2"></i>Simpan</button><a href="<?php echo base_url(); ?>kepegawaian/pegawai/pegawai"><button type="button" class="btn btn-warning"><i class="fas fa-reply me-2"></i>Kembali</button></a></div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>