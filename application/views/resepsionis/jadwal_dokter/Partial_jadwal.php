<?php if (!empty($schedule_data)) { ?>
    <?php foreach ($schedule_data as $poli => $doctors) { ?>
        <div class="card">
            <div class="card-header bg-light">
                <h4 class="card-title mb-0"><?php echo $poli; ?></h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" style="width:100%;">
                        <thead>
                            <tr class="table-warning">
                                <th style="width: 20%;">Dokter</th>
                                <th>Senin</th>
                                <th>Selasa</th>
                                <th>Rabu</th>
                                <th>Kamis</th>
                                <th>Jumat</th>
                                <th>Sabtu</th>
                                <th>Minggu</th>
                                <th style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($doctors as $doctor_data) { ?>
                                <tr>
                                    <td><?php echo $doctor_data['nama_dokter']; ?></td>
                                    <td class="text-center"><?php echo $doctor_data['jadwal']['Senin']; ?></td>
                                    <td class="text-center"><?php echo $doctor_data['jadwal']['Selasa']; ?></td>
                                    <td class="text-center"><?php echo $doctor_data['jadwal']['Rabu']; ?></td>
                                    <td class="text-center"><?php echo $doctor_data['jadwal']['Kamis']; ?></td>
                                    <td class="text-center"><?php echo $doctor_data['jadwal']['Jumat']; ?></td>
                                    <td class="text-center"><?php echo $doctor_data['jadwal']['Sabtu']; ?></td>
                                    <td class="text-center"><?php echo $doctor_data['jadwal']['Minggu']; ?></td>
                                    <td class="text-center">
                                        <div class="text-center">
                                            <button type="button" class="btn btn-shadow btn-sm btn-warning" title="Detail" onclick="window.location.href='<?php echo base_url('resepsionis/jadwal_dokter/Jadwal_dokter/detail/' . $doctor_data['id_kpg_dokter']); ?>'">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-shadow btn-sm btn-info" title="Edit" onclick="window.location.href='<?php echo base_url('resepsionis/jadwal_dokter/Jadwal_dokter/view_edit/' . $doctor_data['id_kpg_dokter']); ?>'">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <button type="button" class="btn btn-shadow btn-sm btn-danger" title="Hapus" onclick="hapusJadwalDokter('<?php echo $doctor_data['id_kpg_dokter']; ?>', '<?php echo $doctor_data['nama_dokter']; ?>')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table><!--end /table-->
                </div>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <div class="card">
        <div class="card-body">
            <p class="text-center text-muted mt-3">Tidak ada jadwal yang sesuai dengan filter yang dipilih.</p>
        </div>
    </div>
<?php } ?>