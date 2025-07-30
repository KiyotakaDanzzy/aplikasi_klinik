<script type="text/javascript">
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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('resepsionis/jadwal_dokter/Jadwal_dokter'); ?>">Jadwal Dokter</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
                <h4 class="page-title"><?php echo $title; ?></h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center pt-3 pb-3">
                    <h4 class="card-title">Jadwal Praktik: <?php echo $dokter['nama_pegawai']; ?> (<?php echo $dokter['nama_poli']; ?>)</h4>
                    <a href="<?php echo base_url('resepsionis/jadwal_dokter/Jadwal_dokter/view_edit/' . $dokter['id']); ?>">
                        <button type="button" class="btn btn-success"><i class="fas fa-plus me-2"></i>Tambah Hari</button>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0 table-centered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($jadwal)) {
                                    foreach ($jadwal as $j) { ?>
                                        <tr>
                                            <td><?php echo $j['hari']; ?></td>
                                            <td><?php echo $j['jam_mulai']; ?></td>
                                            <td><?php echo $j['jam_selesai']; ?></td>
                                            <td class="text-center">
                                                <a href="<?php echo base_url('resepsionis/jadwal_dokter/Jadwal_dokter/view_edit_entry/' . $j['id']); ?>" class="btn btn-sm btn-info" title="Edit Hari Ini"><i class="fas fa-pencil-alt"></i></a>
                                                <button type="button" class="btn btn-sm btn-danger" title="Hapus Hari Ini" onclick="hapusEntry('<?php echo $j['id']; ?>', '<?php echo $j['nama_pegawai']; ?>', '<?php echo $j['hari']; ?>')"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Dokter ini belum memiliki jadwal</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <a href="<?php echo base_url('resepsionis/jadwal_dokter/Jadwal_dokter'); ?>">
                            <button type="button" class="btn btn-warning"><i class="fas fa-reply me-2"></i>Kembali</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>