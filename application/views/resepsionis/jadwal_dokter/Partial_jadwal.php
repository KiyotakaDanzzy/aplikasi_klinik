<?php if (!empty($schedule_data)) { ?>
    <?php foreach ($schedule_data as $poli => $doctors) { ?>
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="card-title text-white"><?php echo $poli; ?></h4>
            </div><!--end card-header-->
            <div class="card-body">
                <div class="table-responsive-sm">
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($doctors as $doctor) { ?>
                                <tr>
                                    <td><?php echo $doctor['nama_dokter']; ?></td>
                                    <td class="text-center"><?php echo $doctor['jadwal']['Senin']; ?></td>
                                    <td class="text-center"><?php echo $doctor['jadwal']['Selasa']; ?></td>
                                    <td class="text-center"><?php echo $doctor['jadwal']['Rabu']; ?></td>
                                    <td class="text-center"><?php echo $doctor['jadwal']['Kamis']; ?></td>
                                    <td class="text-center"><?php echo $doctor['jadwal']['Jumat']; ?></td>
                                    <td class="text-center"><?php echo $doctor['jadwal']['Sabtu']; ?></td>
                                    <td class="text-center"><?php echo $doctor['jadwal']['Minggu']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <div class="card">
        <div class="card-body">
            <p class="text-center text-muted mt-3">Tidak ada jadwal yang sesuai dengan filter</p>
        </div>
    </div>
<?php } ?>