<script type="text/javascript">
  function hitungUmur() {
    var tanggal_lahir = $('#tanggal_lahir').val();
    if (tanggal_lahir) {
      var today = new Date();
      var birthDate = new Date(tanggal_lahir);
      var age = today.getFullYear() - birthDate.getFullYear();
      var m = today.getMonth() - birthDate.getMonth();
      if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }
      $('#umur').val(age);
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

  $(document).ready(function() {
        const tanggalInput = document.getElementById('tanggal_lahir');
        const datepicker = new Datepicker(tanggalInput, {
            format: 'dd-mm-yyyy',
            autohide: true
        });
    });

  function edit(e) {
    e.preventDefault();
    if (!validateForm('#form_edit')) {
      return;
    }
    $.ajax({
      url: '<?php echo base_url('master_data/pasien/edit_aksi') ?>',
      method: 'POST',
      data: $('#form_edit').serialize(),
      dataType: 'json',
      success: function(res) {
        if (res.status) {
          Swal.fire({
              title: 'Berhasil!',
              text: res.message,
              icon: 'success'
            })
            .then(() => {
              window.location.href = '<?php echo base_url('master_data/pasien'); ?>';
            });
        } else {
          Swal.fire({
            title: 'Gagal!',
            html: res.message,
            icon: 'error'
          });
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
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>master_data/pasien">Pasien</a></li>
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
        <div class="card-header">
          <h4 class="card-title">Edit Data Pasien: <?php echo $pasien['nama_pasien']; ?> (<?php echo $pasien['no_rm']; ?>)</h4>
        </div>
        <div class="card-body">
          <form id="form_edit">
            <input type="hidden" name="id" value="<?php echo $pasien['id']; ?>">
            <div class="row mb-3">
              <label for="nama_pasien" class="col-sm-2 col-form-label">Nama Lengkap</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" value="<?php echo $pasien['nama_pasien']; ?>" required>
              </div>
            </div>
            <div class="row mb-3">
              <label for="nik" class="col-sm-2 col-form-label">NIK</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $pasien['nik']; ?>" required>
              </div>
            </div>
            <div class="row mb-3">
              <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
              <div class="col-sm-10">
                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                  <option value="Laki-laki" <?php echo ($pasien['jenis_kelamin'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                  <option value="Perempuan" <?php echo ($pasien['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <label for="tanggal_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir" onchange="hitungUmur()" value="<?php echo $pasien['tanggal_lahir']; ?>" required>
              </div>
            </div>
            <div class="row mb-3">
              <label for="umur" class="col-sm-2 col-form-label">Umur</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="umur" name="umur" value="<?php echo $pasien['umur']; ?>" readonly>
              </div>
            </div>
            <div class="row mb-3">
              <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="alamat" name="alamat" required><?php echo $pasien['alamat']; ?></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <label for="pekerjaan" class="col-sm-2 col-form-label">Pekerjaan</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="<?php echo $pasien['pekerjaan']; ?>" required>
              </div>
            </div>
            <div class="row mb-3">
              <label for="no_telp" class="col-sm-2 col-form-label">No. Telepon</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?php echo $pasien['no_telp']; ?>" required>
              </div>
            </div>
            <div class="row mb-3">
              <label for="status_perkawinan" class="col-sm-2 col-form-label">Status Perkawinan</label>
              <div class="col-sm-10">
                <select class="form-control" id="status_perkawinan" name="status_perkawinan" required>
                  <option value="Belum Kawin" <?php echo ($pasien['status_perkawinan'] == 'Belum Kawin') ? 'selected' : ''; ?>>Belum Kawin</option>
                  <option value="Kawin" <?php echo ($pasien['status_perkawinan'] == 'Kawin') ? 'selected' : ''; ?>>Kawin</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <label for="nama_wali" class="col-sm-2 col-form-label">Nama Wali</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="nama_wali" name="nama_wali" value="<?php echo $pasien['nama_wali']; ?>" required>
              </div>
            </div>
            <div class="row mb-3">
              <label for="golongan_darah" class="col-sm-2 col-form-label">Golongan Darah</label>
              <div class="col-sm-10">
                <select class="form-control" id="golongan_darah" name="golongan_darah">
                  <option value="-" <?php echo ($pasien['golongan_darah'] == '-') ? 'selected' : ''; ?>>-</option>
                  <option value="A" <?php echo ($pasien['golongan_darah'] == 'A') ? 'selected' : ''; ?>>A</option>
                  <option value="B" <?php echo ($pasien['golongan_darah'] == 'B') ? 'selected' : ''; ?>>B</option>
                  <option value="AB" <?php echo ($pasien['golongan_darah'] == 'AB') ? 'selected' : ''; ?>>AB</option>
                  <option value="O" <?php echo ($pasien['golongan_darah'] == 'O') ? 'selected' : ''; ?>>O</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <label for="alergi" class="col-sm-2 col-form-label">Riwayat Alergi</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="alergi" name="alergi" value="<?php echo $pasien['alergi']; ?>" required>
              </div>
            </div>
            <div class="row mb-3">
              <label for="status_operasi" class="col-sm-2 col-form-label">Riwayat Operasi</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="status_operasi" name="status_operasi" value="<?php echo $pasien['status_operasi']; ?>" required>
              </div>
            </div>
            <div class="row">
                <div class="col-sm-10 ms-auto">
                  <button type="button" onclick="edit(event);" class="btn btn-success"><i class="fas fa-save me-2"></i>Simpan</button>
                  <a href="<?php echo base_url('master_data/pasien'); ?>" class="btn btn-warning"><i class="fas fa-reply me-2"></i>Kembali</a>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>