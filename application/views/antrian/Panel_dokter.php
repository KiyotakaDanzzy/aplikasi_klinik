<script type="text/javascript">
    let statusSekarang = 'Menunggu';

    function loadUrutanAntri() {
        let id_poli = $('#select_poli').val();
        if (!id_poli) {
            $('#antrian-selanjutnya').html('<tr><td colspan="5" class="text-center">Silakan pilih poli terlebih dahulu.</td></tr>');
            return;
        }

        $.ajax({
            url: '<?php echo base_url("antrian/panel_dokter/get_urutan"); ?>',
            type: 'POST',
            data: {
                id_poli: id_poli,
                status: statusSekarang
            },
            dataType: 'json',
            beforeSend: () => {
                let loading = `<tr id="tr-loading"><td colspan="5" class="text-center"><img src="<?php echo base_url(); ?>assets/loading-table.gif" width="60" alt="loading"></td></tr>`;
                $('#antrian-selanjutnya').html(loading);
            },
            success: function(response) {
                let rows = '';
                if (response.length > 0) {
                    response.forEach((item, index) => {
                        let statusBadge = '';
                        let aksi = '';

                        if (item.status_antrian === 'Menunggu') {
                            statusBadge = '<span class="badge bg-warning">Menunggu</span>';
                            aksi = `<button class="btn btn-sm btn-success" onclick="panggilPasien(${item.id})"><i class="fas fa-volume-up me-2"></i>Panggil</button>`;
                        } else if (item.status_antrian === 'Dipanggil') {
                            statusBadge = '<span class="badge bg-info">Dipanggil</span>';
                            aksi = `<button class="btn btn-sm btn-info" onclick="panggilPasien(${item.id})"><i class="fas fa-redo-alt me-2"></i>Panggil Ulang</button>
                                    <button class="btn btn-sm btn-primary" onclick="konfirmasiPasien(${item.id}, ${item.id_poli}, '${item.kode_invoice}')"><i class="fas fa-check-circle me-2"></i>Konfirmasi</button>`;
                        } else {
                            statusBadge = `<span class="badge bg-success">Konfirmasi</span>`;
                            aksi = `<span class="text-muted">Kedatangan Dikonfirmasi</span>`;
                        }

                        rows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.no_antrian}</td>
                            <td>${item.nama_pasien}</td>
                            <td class="text-center">${statusBadge}</td>
                            <td class="text-center">${aksi}</td>
                        </tr>
                        `;
                    });
                } else {
                    rows = `<tr><td colspan="5" class="text-center">Tidak ada antrian saat ini.</td></tr>`;
                }
                $('#antrian-selanjutnya').html(rows);
                paging();
            }
        });
    }

    function panggilPasien(id_antrian) {
        $.ajax({
            url: `<?php echo base_url('antrian/panel_dokter/panggil/'); ?>${id_antrian}`,
            type: 'POST',
            dataType: 'json',
            success: function(res) {
                if (res.status) {
                    loadUrutanAntri();
                }
            }
        });
    }

    function konfirmasiPasien(id_antrian, id_poli, kode_invoice) {
        $.ajax({
            url: `<?php echo base_url('antrian/panel_dokter/konfirmasi/'); ?>${id_antrian}`,
            type: 'POST',
            dataType: 'json',
            success: function(res) {
                if (res.status) {
                    Swal.fire({
                            title: 'Berhasil!',
                            text: 'Kedatangan pasien dikonfirmasi.',
                            icon: 'success'
                        })
                        .then((result) => {
                            if (result.isConfirmed && id_poli == 4) {
                                window.location.href = `<?php echo base_url('poli/gigi/proses/'); ?>${kode_invoice}`;
                            } else {
                                loadUrutanAntri();
                            }
                        });
                }
            }
        });
    }

    function paging($selector) {
        var jumlah_tampil = $('#jumlah_tampil').val();
        if (typeof $selector == 'undefined') {
            $selector = $("#antrian-selanjutnya tr");
        }
        window.tp = new Pagination('#pagination', {
            itemsCount: $selector.length,
            pageSize: parseInt(jumlah_tampil),
            onPageChange: function(paging) {
                var start = paging.pageSize * (paging.currentPage - 1),
                    end = start + paging.pageSize,
                    $rows = $selector;
                $rows.hide();
                for (var i = start; i < end; i++) {
                    $rows.eq(i).show();
                }
            }
        });
    }

    $(document).ready(function() {
        $('#select_poli').change(loadUrutanAntri);

        $('.card-body .nav-link').click(function(e) {
            e.preventDefault();
            $('.card-body .nav-link').removeClass('active');
            $(this).addClass('active');
            statusSekarang = $(this).data('status');
            loadUrutanAntri();
        });
    });
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><?php echo $title; ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?php echo $title; ?></h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Antrian</h4>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <ul class="nav nav-tabs mb-0">
                            <li class="nav-item">
                                <a class="nav-link active" href="#" data-status="Menunggu">Antrian Menunggu</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-status="Dikonfirmasi">Antrian Terkonfirmasi</a>
                            </li>
                        </ul>

                        <div class="d-flex align-items-center">
                            <label for="select_poli" class="form-label me-2 mb-0">Poli:</label>
                            <select id="select_poli" class="form-select form-select-sm">
                                <option value="">-- Pilih Poli --</option>
                                <?php foreach ($data_poli as $poli) { ?>
                                    <option value="<?php echo $poli->id; ?>"><?php echo $poli->nama; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nomor Antrian</th>
                                    <th>Nama Pasien</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="antrian-selanjutnya">
                                <tr>
                                    <td colspan="5" class="text-center">Silakan pilih poli terlebih dahulu.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <div id="pagination"></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-md-6">&nbsp;</div>
                                <label class="col-md-3 control-label d-flex align-items-center justify-content-end">Jumlah Tampil</label>
                                <div class="col-md-3 pull-right">
                                    <select class="form-control" id="jumlah_tampil">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>