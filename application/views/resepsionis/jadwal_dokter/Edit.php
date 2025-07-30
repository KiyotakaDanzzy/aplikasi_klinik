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
                text: 'Harap isi semua kolom.',
                icon: 'error'
            });
        }
        return isValid;
    }

    function tambahHari(e) {
        e.preventDefault();
        if (!validateForm('#form_tambah_hari')) {
            return;
        }

        $.ajax({
            url: '<?php echo base_url("resepsionis/jadwal_dokter/Jadwal_dokter/tambah_entry_aksi"); ?>',
            type: 'POST',
            data: $('#form_tambah_hari').serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.status) {
                    Swal.fire({
                            title: 'Berhasil!',
                            text: res.message,
                            icon: 'success'
                        })
                        .then(() => {
                            window.location.href = '<?php echo base_url('resepsionis/jadwal_dokter/Jadwal_dokter/detail/' . $dokter['id']); ?>';
                        });
                } else {
                    Swal.fire('Gagal!', res.message, 'error');
                }
            }
        });
    }

    function hapusEntry(id_jadwal, nama_dokter, hari) {
        Swal.fire({
            title: "Anda Yakin?",
            text: "Hapus jadwal " + nama_dokter + " pada hari " + hari + "?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url("resepsionis/jadwal_dokter/Jadwal_dokter/hapus_entry/"); ?>' + id_jadwal,
                    type: 'POST',
                    dataType: 'json',
                    success: function(res) {
                        if (res.status) {
                            Swal.fire('Terhapus!', res.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Gagal!', res.message, 'error');
                        }
                    }
                });
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
                    <h4 class="card-title">Edit Jadwal: <?php echo $dokter['nama_pegawai']; ?></h4>
                </div>
                <div class="card-body">
                    <hr class="mt-4 mb-4">
                    <h5 class="card-title">Tambah Jadwal Hari Baru</h5>
                    <form id="form_tambah_hari">
                        <input type="hidden" name="id_dokter" value="<?php echo $dokter['id']; ?>">

                        <div class="mb-3">
                            <label for="hari" class="form-label">Hari</label>
                            <select name="hari" id="hari" class="form-control" required>
                                <option value="">Pilih Hari</option>
                                <?php foreach ($hari_tersedia as $hari) { ?>
                                    <option value="<?php echo $hari; ?>"><?php echo $hari; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jam_mulai" class="form-label">Jam Mulai</label>
                            <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="jam_selesai" class="form-label">Jam Selesai</label>
                            <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" required>
                        </div>

                        <div class="mt-4">
                            <button type="button" class="btn btn-success" onclick="tambahHari(event)">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                            <a href="<?php echo base_url('resepsionis/jadwal_dokter/Jadwal_dokter/detail/' . $dokter['id']); ?>" class="btn btn-warning">
                                <i class="fas fa-reply me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>