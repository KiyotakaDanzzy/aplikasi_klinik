<script type="text/javascript">
    function hitungUmur() {
        var tanggal_lahir_str = $('#tanggal_lahir').val();

        if (tanggal_lahir_str) {
            var parts = tanggal_lahir_str.split('-');
            var formattedDate = parts[2] + '-' + parts[1] + '-' + parts[0];
            var birthDate = new Date(formattedDate);
            var today = new Date();
            var age = today.getFullYear() - birthDate.getFullYear();
            var m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            if (!isNaN(age)) {
                $('#umur').val(age);
            } else {
                $('#umur').val('');
            }
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
                text: 'Harap isi semua kolom',
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
        $('#tanggal_lahir').on('changeDate', hitungUmur);
    });

    function tambah(e) {
        e.preventDefault();
        if (!validateForm('#form_tambah')) {
            return;
        }

        $.ajax({
            url: '<?php echo base_url('master_data/pasien/tambah_aksi') ?>',
            method: 'POST',
            data: $('#form_tambah').serialize(),
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
                <div class="card-header">
                    <h4 class="card-title">Tambah Data Pasien</h4>
                </div>
                <div class="card-body">
                    <form id="form_tambah">
                        <div class="mb-3 row">
                            <label for="nama_pasien" class="col-sm-2 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" placeholder="Nama Lengkap Pasien" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="nik" class="col-sm-2 col-form-label">NIK</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nik" name="nik" placeholder="Nomor Induk Kependudukan" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="">Pilih...</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="tanggal_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir" placeholder="Tanggal Lahir Pasien" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="umur" class="col-sm-2 col-form-label">Umur</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="umur" name="umur" placeholder="Umur" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat Pasien" required></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="pekerjaan" class="col-sm-2 col-form-label">Pekerjaan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" placeholder="Pekerjaan Pasien" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="no_telp" class="col-sm-2 col-form-label">No. Telepon</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Nomor Telepon" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="status_perkawinan" class="col-sm-2 col-form-label">Status Perkawinan</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="status_perkawinan" name="status_perkawinan">
                                    <option value="Belum Kawin">Belum Kawin</option>
                                    <option value="Kawin">Kawin</option>
                                    <option value="Cerai Hidup">Cerai Hidup</option>
                                    <option value="Cerai Mati">Cerai Mati</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="nama_wali" class="col-sm-2 col-form-label">Nama Wali</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama_wali" name="nama_wali" placeholder="Nama Wali Pasien" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="golongan_darah" class="col-sm-2 col-form-label">Golongan Darah</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="golongan_darah" name="golongan_darah" required>
                                    <option value="-">-</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="alergi" class="col-sm-2 col-form-label">Riwayat Alergi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="alergi" name="alergi" placeholder="Riwayat Alergi" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="status_operasi" class="col-sm-2 col-form-label">Riwayat Operasi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="status_operasi" name="status_operasi" placeholder="Riwayat Operasi" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-10 ms-auto">
                                <button type="button" class="btn btn-success" onclick="tambah(event)"><i class="fas fa-save me-2"></i>Simpan</button>
                                <a href="<?php echo base_url('master_data/pasien'); ?>" class="btn btn-warning"><i class="fas fa-reply me-2"></i>Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>