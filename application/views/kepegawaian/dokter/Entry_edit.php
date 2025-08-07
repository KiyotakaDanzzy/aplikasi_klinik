<script type="text/javascript">
    function validateForm(formSelector) {
        let isValid = true;
        $(formSelector + ' [required]').each(function() {
            if (!$(this).val()) {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        if (!isValid) {
            Swal.fire({
                title: 'Gagal!',
                text: 'Jam mulai dan selesai tidak boleh kosong',
                icon: 'error'
            });
        }
        return isValid;
    }

    function edit_entry(e) {
        e.preventDefault();
        if (!validateForm('#form_edit_entry')) {
            return;
        }

        $.ajax({
            url: '<?php echo base_url("kepegawaian/jadwal_dokter/edit_entry_aksi"); ?>',
            type: 'POST',
            data: $('#form_edit_entry').serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.status) {
                    Swal.fire({
                            title: 'Berhasil!',
                            text: res.message,
                            icon: 'success'
                        })
                        .then(() => {
                            window.location.href = '<?php echo base_url('kepegawaian/jadwal_dokter/detail/' . $dokter['id']); ?>';
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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('kepegawaian/jadwal_dokter'); ?>">Dokter</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('kepegawaian/jadwal_dokter/detail/' . $dokter['id']); ?>">Jadwal Dokter</a></li>
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
                    <h4 class="card-title">Edit Jadwal: <?php echo $jadwal_entry['nama_pegawai']; ?></h4>
                </div>
                <div class="card-body">
                    <form id="form_edit_entry">
                        <input type="hidden" name="id_jadwal" value="<?php echo $jadwal_entry['id']; ?>">
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Hari</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $jadwal_entry['hari']; ?>" readonly></div>
                        </div>
                        <div class="mb-3 row">
                            <label for="jam_mulai" class="col-sm-2 col-form-label">Jam Mulai</label>
                            <div class="col-sm-10"><input type="time" step="1" class="form-control" id="jam_mulai" name="jam_mulai" value="<?php echo $jadwal_entry['jam_mulai']; ?>" required></div>
                        </div>
                        <div class="mb-3 row">
                            <label for="jam_selesai" class="col-sm-2 col-form-label">Jam Selesai</label>
                            <div class="col-sm-10"><input type="time" step="1" class="form-control" id="jam_selesai" name="jam_selesai" value="<?php echo $jadwal_entry['jam_selesai']; ?>" required></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-10 ms-auto">
                                <button type="button" onclick="edit_entry(event);" class="btn btn-success"><i class="fas fa-save me-2"></i>Simpan</button>
                                <a href="<?php echo base_url('kepegawaian/jadwal_dokter/detail/' . $dokter['id']); ?>" class="btn btn-warning"><i class="fas fa-reply me-2"></i>Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>