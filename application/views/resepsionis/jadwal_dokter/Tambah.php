<script type="text/javascript">
    $(document).ready(function() {
        $('.hari-checkbox').change(function() {
            var day = $(this).val();
            var isChecked = $(this).is(':checked');
            var jamMulaiInput = $('#jam_mulai_' + day);
            var jamSelesaiInput = $('#jam_selesai_' + day);

            jamMulaiInput.prop('disabled', !isChecked);
            jamSelesaiInput.prop('disabled', !isChecked);

            if (!isChecked) {
                jamMulaiInput.val('');
                jamSelesaiInput.val('');
            }
        });
    });

    function validateForm(formSelector) {
        let isValid = true;
        let errorMessage = 'Harap isi semua kolom yang wajib diisi.';

        $(formSelector + ' .is-invalid').removeClass('is-invalid');

        if ($(formSelector + ' #id_dokter').val() === '') {
            $(formSelector + ' #id_dokter').addClass('is-invalid');
            isValid = false;
        }

        if ($(formSelector + ' input[name="hari[]"]:checked').length === 0) {
            errorMessage = 'Harap pilih minimal satu hari praktik.';
            isValid = false;
        } else {
            $(formSelector + ' input[name="hari[]"]:checked').each(function() {
                let day = $(this).val();
                let jamMulai = $('#jam_mulai_' + day);
                let jamSelesai = $('#jam_selesai_' + day);

                if (jamMulai.val() === '') {
                    jamMulai.addClass('is-invalid');
                    isValid = false;
                }
                if (jamSelesai.val() === '') {
                    jamSelesai.addClass('is-invalid');
                    isValid = false;
                }
            });
        }

        if (!isValid) {
            Swal.fire({
                title: 'Gagal!',
                text: errorMessage,
                icon: 'error',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Oke'
            });
        }

        return isValid;
    }

    function tambah(e) {
        e.preventDefault();

        if (!validateForm('#form_tambah')) {
            return;
        }

        $.ajax({
            url: '<?php echo base_url("resepsionis/jadwal_dokter/Jadwal_dokter/tambah_aksi"); ?>',
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
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '<?php echo base_url("resepsionis/jadwal_dokter/Jadwal_dokter"); ?>';
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: res.message,
                        icon: "error",
                        confirmButtonColor: "#35baf5",
                        confirmButtonText: "Oke"
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
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url('resepsionis/jadwal_dokter/jadwal_dokter'); ?>">Jadwal Dokter</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
                <h4 class="page-title">
                    <?php echo $title; ?>
                </h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header pt-3 pb-3">
                    <h4 class="card-title">Buat Jadwal Baru</h4>
                </div>
                <div class="card-body">
                    <div class="general-label">
                        <form id="form_tambah">
                            <div class="mb-3 row">
                                <label for="id_dokter" class="col-sm-2 col-form-label">Dokter</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="id_dokter" id="id_dokter" required>
                                        <option value="">Pilih Dokter</option>
                                        <?php foreach ($data_dokter as $dokter) {
                                            echo "<option value='{$dokter->id}'>{$dokter->nama_pegawai} ({$dokter->nama_poli})</option>";
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <hr />
                            <?php $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']; ?>
                            <?php foreach ($days as $day) { ?>
                                <div class="mb-3 row align-items-center">
                                    <label class="col-sm-2 col-form-label">
                                        <div class="form-check">
                                            <input class="form-check-input hari-checkbox" type="checkbox" name="hari[]" value="<?php echo $day; ?>" id="check_<?php echo $day; ?>" required>
                                            <label class="form-check-label" for="check_<?php echo $day; ?>"><?php echo $day; ?>
                                            </label>
                                        </div>
                                    </label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-text">Mulai</span>
                                            <input type="time" class="form-control" name="jam_mulai[<?php echo $day; ?>]" id="jam_mulai_<?php echo $day; ?>" disabled required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <span class="input-group-text">Selesai</span>
                                            <input type="time" class="form-control" name="jam_selesai[<?php echo $day; ?>]" id="jam_selesai_<?php echo $day; ?>" disabled required>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="row mt-4">
                                <div class="col-sm-10 ms-auto">
                                    <button type="button" onclick="tambah(event);" class="btn btn-success">
                                        <i class="fas fa-save me-2"></i>Simpan Jadwal</button>
                                    <a href="<?php echo base_url(); ?>resepsionis/jadwal_dokter/jadwal_dokter">
                                        <button type="button" class="btn btn-warning"><i class="fas fa-reply me-2"></i>Kembali</button>
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