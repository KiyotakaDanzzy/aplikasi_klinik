<script type="text/javascript">
  $(document).ready(function() {
    function togglePoliContainer() {
      var selectedJabatan = $('#id_jabatan').find('option:selected').text();
      if (selectedJabatan === 'Dokter') {
        $('#poli-container').slideDown();
        $('#id_poli').prop('required', true);
      } else {
        $('#poli-container').hide();
        $('#id_poli').prop('required', false);
      }
    }
    togglePoliContainer();
    $('#id_jabatan').change(function() {
      togglePoliContainer();
    });
  });

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

  function edit(e) {
    e.preventDefault()
    if (!validateForm('#form_edit')) {
      return;
    }

    $.ajax({
      url: '<?php echo base_url('kepegawaian/pegawai/edit_aksi') ?>',
      method: 'POST',
      data: $('#form_edit').serialize(),
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
                window.location.href = '<?php echo base_url() ?>kepegawaian/pegawai'
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
            <li class="breadcrumb-item">
              <a href="<?php echo base_url(); ?>kepegawaian/pegawai">Pegawai</a>
            </li>
            <li class="breadcrumb-item active">Edit</li>
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
          <h4 class="card-title">Edit <?php echo $title; ?></h4>
        </div>
        <div class="card-body">
          <div class="general-label">
            <form id="form_edit">
              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
              <div class="mb-3 row">
                <label for="nama" class="col-sm-2 col-form-label">Nama Pegawai</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $row['nama']; ?>" required autocomplete="off">
                </div>
              </div>
              <div class="mb-3 row">
                <label for="no_telp" class="col-sm-2 col-form-label">Nomor Telepon</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="no_telp" id="no_telp" value="<?php echo $row['no_telp']; ?>" required autocomplete="off">
                </div>
              </div>
              <div class="mb-3 row">
                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="alamat" id="alamat" autocomplete="off"><?php echo $row['alamat']; ?></textarea>
                </div>
              </div>
              <div class="mb-3 row">
                <label for="id_jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                <div class="col-sm-10">
                  <select class="form-control" name="id_jabatan" id="id_jabatan" required>
                    <option value="">Pilih Jabatan</option><?php foreach ($data_jabatan as $jabatan) {
                                                              $selected = ($jabatan->id == $row['id_jabatan']) ? 'selected' : '';
                                                              echo "<option value='{$jabatan->id}' {$selected}>{$jabatan->nama}</option>";
                                                            } ?>
                  </select>
                </div>
              </div>
              <div class="mb-3 row" id="poli-container" style="display: none;">
                <label for="id_poli" class="col-sm-2 col-form-label">Poli</label>
                <div class="col-sm-10">
                  <select class="form-control" name="id_poli" id="id_poli">
                    <option value="">Pilih Poli</option>
                    <?php foreach ($data_poli as $poli) {
                      $selected = ($poli->id == $row['id_poli']) ? 'selected' : '';
                      echo "<option value='{$poli->id}' {$selected}>{$poli->nama}</option>";
                    } ?>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-10 ms-auto">
                  <button type="button" onclick="edit(event);" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>Simpan
                  </button>
                  <a href="<?php echo base_url(); ?>kepegawaian/pegawai">
                    <button type="button" class="btn btn-warning">
                      <i class="fas fa-reply me-2"></i>Kembali
                    </button>
                  </a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>