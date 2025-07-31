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
                text: 'Harap isi semua kolom',
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
            url: '<?php echo base_url('master_data/pasien/pasien/tambah_aksi') ?>',
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
                                window.location.href = '<?php echo base_url() ?>master_data/pasien/pasien'
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
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>master_data/pasien/pasien">Pasien</a></li>
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
                                <label for="nomor_rm" class="col-sm-2 col-form-label">Nomor Rekam Medis</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nomor_rm" id="nomor_rm" placeholder="Masukkan Nomor Rekaman" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="nama_pasien" class="col-sm-2 col-form-label">Nama Pasien</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nama_pasien" id="nama_pasien" placeholder="Masukkan Nama Pasien" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="nik" class="col-sm-2 col-form-label">NIK</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="nik" id="nik" placeholder="Masukkan NIK" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" required>
                                        <option value="">Pilih Jadwal Kelamin</option>
                                        <option value='Laki-Laki'>Laki-Laki</option>
                                        <option value='Perempuan'>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="tgl_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" placeholder="Tanggal Lahir Pasien" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="umur" class="col-sm-2 col-form-label">Umur Pasien</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="umur" id="umur" placeholder="Umur Pasien" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="alamat" id="alamat" required></textarea>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="pekerjaan" class="col-sm-2 col-form-label">Pekerjaan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="pekerjaan" id="pekerjaan" placeholder="Pekerjaan" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="jenis_kelamin" class="col-sm-2 col-form-label">Status Perkawian</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="jenis_kelamin" id="status_prkwn" required>
                                        <option value='belumkawin'>Belum Kawin</option>
                                        <option value='kawin'>Kawin</option>
                                        <option value='ceraihidup'>Cerai Hidup</option>
                                        <option value='ceraimati'>Cerai Mati</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="nomor_rm" class="col-sm-2 col-form-label">Nomor Rekam Medis</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nomor_rm" id="nomor_rm" placeholder="Masukkan Nomor Rekaman" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="nomor_rm" class="col-sm-2 col-form-label">Nomor Rekam Medis</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nomor_rm" id="nomor_rm" placeholder="Masukkan Nomor Rekaman" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="nomor_rm" class="col-sm-2 col-form-label">Nomor Rekam Medis</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nomor_rm" id="nomor_rm" placeholder="Masukkan Nomor Rekaman" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="nomor_rm" class="col-sm-2 col-form-label">Nomor Rekam Medis</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nomor_rm" id="nomor_rm" placeholder="Masukkan Nomor Rekaman" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="nomor_rm" class="col-sm-2 col-form-label">Nomor Rekam Medis</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nomor_rm" id="nomor_rm" placeholder="Masukkan Nomor Rekaman" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="nomor_rm" class="col-sm-2 col-form-label">Nomor Rekam Medis</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nomor_rm" id="nomor_rm" placeholder="Masukkan Nomor Rekaman" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="nomor_rm" class="col-sm-2 col-form-label">Nomor Rekam Medis</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nomor_rm" id="nomor_rm" placeholder="Masukkan Nomor Rekaman" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="id_poli" class="col-sm-2 col-form-label">Poli</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="id_poli" id="id_poli" required>
                                        <option value="">Pilih Poli</option>
                                        <?php foreach ($data_poli as $poli) {
                                            echo "<option value='{$poli->id}'>{$poli->nama}</option>";
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10 ms-auto">
                                    <button type="button" onclick="tambah(event);" class="btn btn-success">
                                        <i class="fas fa-save me-2"></i>Simpan</button>
                                    <a href="<?php echo base_url(); ?>master_data/diagnosa/diagnosa">
                                        <button type="button" class="btn btn-warning">
                                            <i class="fas fa-reply me-2"></i>Kembali</button>
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