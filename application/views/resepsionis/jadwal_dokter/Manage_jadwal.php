<script type="text/javascript">
    function hapus(id_dokter, nama_dokter) {
        Swal.fire({
            title: "Apakah Anda Yakin?",
            text: "Menghapus seluruh jadwal milik " + nama_dokter,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Iya, Hapus Semua!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url(); ?>resepsionis/jadwal_dokter/jadwal_dokter/hapus_by_dokter/' + id_dokter,
                    method: 'POST',
                    dataType: 'json',
                    success: function(res) {
                        if (res.status == true) {
                            Swal.fire('Terhapus!', 'Jadwal untuk ' + nama_dokter + ' telah dihapus', 'success')
                                .then(() => {
                                    location.reload();
                                });
                        } else {
                            Swal.fire('Gagal!', 'Jadwal gagal dihapus', 'error');
                        }
                    }
                })
            }
        })
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
                        <li class="breadcrumb-item active">Kelola Jadwal</li>
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
                    <h4 class="card-title">Daftar Dokter</h4>
                    <div>
                        <a href="<?php echo base_url('resepsionis/jadwal_dokter/jadwal_dokter/view_tambah'); ?>" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Buat Jadwal Baru
                        </a>
                        <a href="<?php echo base_url('resepsionis/jadwal_dokter/jadwal_dokter'); ?>" class="btn btn-secondary">
                            <i class="fas fa-eye me-2"></i>Lihat Jadwal Keseluruhan
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0 table-hover" id="table-data">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Dokter</th>
                                    <th>Poli</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($data_dokter)) {
                                    $i = 1;
                                    foreach ($data_dokter as $dokter) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $dokter->nama_pegawai; ?></td>
                                            <td><?php echo $dokter->nama_poli; ?></td>
                                            <td>
                                                <div class="text-center">
                                                    <a href="<?php echo base_url('resepsionis/jadwal_dokter/jadwal_dokter/detail/' . $dokter->id); ?>" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye me-2"></i>Detail
                                                    </a>
                                                    <a href="<?php echo base_url('resepsionis/jadwal_dokter/jadwal_dokter/view_edit/' . $dokter->id); ?>" class="btn btn-sm btn-info">
                                                        <i class="fas fa-pencil-alt me-2"></i>Edit
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="hapus('<?php echo $dokter->id; ?>', '<?php echo $dokter->nama_pegawai; ?>')">
                                                        <i class="fas fa-trash-alt me-2"></i>Hapus
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada data dokter yang ditugaskan</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>