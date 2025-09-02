<script type="text/javascript">
  function FormatCurrency(input) {
        let value = input.value.replace(/[^0-9]/g, '');
        if (value) {
            input.value = new Intl.NumberFormat('id_ID').format(value);
        } else {
            input.value = '';
        }
    }

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
      url: '<?php echo base_url('master_data/tindakan/edit_aksi') ?>',
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
                window.location.href = '<?php echo base_url() ?>master_data/tindakan'
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
  $(document).ready(function() {
        let nominalInput = document.getElementById('harga');
        if (nominalInput.value) {
            FormatCurrency(nominalInput);
        }
    });
</script>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="page-title-box">
        <div class="float-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="<?php echo base_url(); ?>master_data/tindakan">Tindakan</a>
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
                <label for="nama" class="col-sm-2 col-form-label">Nama Tindakan</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $row['nama']; ?>" required autocomplete="off">
                </div>
              </div>
              <div class="mb-3 row">
                <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <div class="input-group-text">Rp</div>
                    <input type="text" class="form-control" name="harga" id="harga" onkeyup="FormatCurrency(this);" required autocomplete="off" value="<?php echo $row['harga']; ?>">
                  </div>
                </div>
              </div>
              <div class="mb-3 row">
                <label for="id_poli" class="col-sm-2 col-form-label">Poli</label>
                <div class="col-sm-10">
                  <select class="form-control" name="id_poli" id="id_poli" required>
                    <option value="">Pilih Poli</option><?php foreach ($data_poli as $poli) {
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
                  <a href="<?php echo base_url(); ?>master_data/tindakan">
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