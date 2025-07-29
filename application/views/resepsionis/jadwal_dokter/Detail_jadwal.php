<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url('resepsionis/jadwal_dokter/jadwal_dokter'); ?>">Jadwal Dokter</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url('resepsionis/jadwal_dokter/jadwal_dokter/manage'); ?>">Kelola Jadwal</a>
                        </li>
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
                <div class="card-header pt-3 pb-3">
                    <h4 class="card-title">Jadwal Praktik: <?php echo $dokter['nama_pegawai']; ?> (<?php echo $dokter['nama_poli']; ?>)</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0 table-centered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($jadwal)) {
                                    foreach ($jadwal as $j) { ?>
                                        <tr>
                                            <td><?php echo $j['hari']; ?></td>
                                            <td><?php echo $j['jam_mulai']; ?></td>
                                            <td><?php echo $j['jam_selesai']; ?></td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="3" class="text-center">Dokter ini tidak ada jadwal</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <a href="<?php echo base_url('resepsionis/jadwal_dokter/jadwal_dokter/manage'); ?>">
                            <button type="button" class="btn btn-warning">
                                <i class="fas fa-reply me-2"></i>Kembali</button>
                            </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>