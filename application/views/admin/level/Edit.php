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
      Swal.fire('Gagal!', 'Harap isi semua kolom yang wajib diisi', 'error');
    }
    return isValid;
  }

  function edit(e) {
    e.preventDefault()
    if (!validateForm('#form_edit')) return;

    $.ajax({
      url: '<?php echo base_url('admin/level/edit_aksi') ?>',
      method: 'POST',
      data: $('#form_edit').serialize(),
      dataType: 'json',
      beforeSend: function() {
        Swal.showLoading();
      },
      success: function(res) {
        if (res.status) {
          Swal.fire('Berhasil!', res.message, 'success').then(() => {
            window.location.href = '<?php echo base_url() ?>admin/level'
          });
        } else {
          Swal.fire('Gagal!', res.message, 'error');
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
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/level">Level</a></li>
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
          <form id="form_edit">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="mb-3 row">
              <label class="col-sm-2 col-form-label">Nama Level</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="nama_level" value="<?php echo $row['nama_level']; ?>" required autocomplete="off">
              </div>
            </div>
            <div class="row">
              <div class="col-sm-10 ms-auto">
                <button type="button" onclick="edit(event);" class="btn btn-success">
                  <i class="fas fa-save me-2"></i>Simpan
                </button>
                <a href="<?php echo base_url(); ?>admin/level">
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