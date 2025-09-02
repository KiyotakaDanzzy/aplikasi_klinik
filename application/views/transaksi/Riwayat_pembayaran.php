<script type="text/javascript">
    $(document).ready(function() {
        get_data();
        $("#jumlah_tampil").change(function() {
            get_data();
        });
        $('#cari').keyup(function() {
            get_data();
        });
    });

    function get_data() {
        let cari = $('#cari').val();
        let hitung_baris = $('#table-data thead tr th').length;
        $.ajax({
            url: '<?php echo base_url("transaksi/riwayat_pembayaran/result_data"); ?>',
            type: 'POST',
            data: {
                cari: cari
            },
            dataType: 'json',
            beforeSend: () => {
                let loading = `<tr id="tr-loading"><td colspan="${hitung_baris}" class="text-center"><div class="loader"><img src="<?php echo base_url(); ?>assets/loading-table.gif" width="60" alt="loading"></div></td></tr>`;
                $(`#table-data tbody`).html(loading);
            },
            success: function(res) {
                let table = "";
                if (res.result) {
                    let i = 1;
                    for (const item of res.data) {
                        table += `
                            <tr>
                                <td>${i++}</td>
                                <td>${item.kode_invoice}</td>
                                <td>${item.nama_pasien}</td>
                                <td>${formatRupiah(item.biaya_tindakan, 'Rp')}</td>
                                <td>${formatRupiah(item.biaya_resep, 'Rp')}</td>
                                <td>${formatRupiah(item.total_invoice, 'Rp')}</td>
                                <td>${item.metode_pembayaran}</td>
                                <td>${item.tanggal}</td>
                                <td>${item.waktu}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-warning" onclick="showDetail(${item.id})"><i class="fas fa-eye"></i></button>
                                </td>
                            </tr>
                        `;
                    }
                } else {
                    table += `<tr><td colspan="${hitung_baris}" class="text-center">Tidak ada riwayat pembayaran.</td></tr>`;
                }
                $('#table-data tbody').html(table);
                paging();
            }
        });
    }

    function paging($selector) {
        var jumlah_tampil = $('#jumlah_tampil').val();
        if (typeof $selector == 'undefined') {
            $selector = $("#table-data tbody tr");
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

    function showDetail(id) {
        $.ajax({
            url: '<?php echo base_url("transaksi/riwayat_pembayaran/get_detail_riwayat"); ?>',
            type: 'POST',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    let data = response.data;
                    let p = data.pembayaran;
                    $('#detail_kode_invoice').text(p.kode_invoice);
                    $('#detail_tanggal_transaksi').text(p.tanggal);
                    $('#detail_waktu_transaksi').text(p.waktu);
                    $('#detail_nama_pasien').text(p.nama_pasien);
                    $('#detail_nama_dokter').text(p.nama_dokter);
                    $('#detail_biaya_tindakan').text(formatRupiah(p.biaya_tindakan, 'Rp'));
                    // $('#detail_biaya_resep').text(formatRupiah(p.biaya_resep, 'Rp'));
                    $('#detail_total_invoice').text(formatRupiah(p.biaya_tindakan, 'Rp'));
                    $('#detail_metode_pembayaran').text(p.metode_pembayaran);
                    $('#detail_bank').text(p.bank || '-');
                    $('#detail_bayar').text(formatRupiah(p.bayar, 'Rp'));
                    $('#detail_kembali').text(formatRupiah(p.kembali, 'Rp'));

                    let detailHtml = '';
                    if (data.tindakan.length > 0) {
                        detailHtml += '<h6>Tindakan</h6><ul class="list-group mb-3">';
                        data.tindakan.forEach(item => {
                            detailHtml += `<li class="list-group-item d-flex justify-content-between align-items-center">${item.tindakan}<span class="badge bg-secondary rounded-pill">Rp${formatRupiah(item.harga)}</span></li>`;
                        });
                        detailHtml += '</ul>';
                    }
                    // if (data.resep.length > 0 || data.racikan.length > 0) {
                    //     detailHtml += '<h6>Resep Obat</h6><ul class="list-group">';
                    //     data.resep.forEach(item => {
                    //         let subtotal = (parseInt(item.harga) + parseInt(item.laba)) * parseInt(item.jumlah);
                    //         detailHtml += `<li class="list-group-item d-flex justify-content-between align-items-center">${item.nama_barang} x${item.jumlah}<span class="badge bg-secondary rounded-pill">Rp${formatRupiah(subtotal)}</span></li>`;
                    //     });
                    //     detailHtml += '<h6>Racikan Obat</h6><ul class="list-group">';
                    //     data.racikan.forEach(item => {
                    //         let subtotal = parseInt(item.sub_total_harga) + parseInt(item.sub_total_laba);
                    //         detailHtml += `<li class="list-group-item d-flex justify-content-between align-items-center">${item.nama_racikan} x${item.jumlah}<span class="badge bg-secondary rounded-pill">Rp${formatRupiah(subtotal)}</span></li>`;
                    //     });
                    //     detailHtml += '</ul>';
                    // }
                    $('#detail_rincian_biaya').html(detailHtml);
                    $('#btn-cetak-struk').attr('onclick', `cetak('struk', '${p.kode_invoice}')`);
                    $('#btn-cetak-kwitansi').attr('onclick', `cetak('kwitansi', '${p.kode_invoice}')`);
                    $('#detailRiwayatModal').modal('show');
                } else {
                    Swal.fire('Gagal!', 'Detail riwayat tidak ditemukan.', 'error');
                }
            }
        });
    }

    function cetak(jenis, kode_invoice) {
        window.open(`<?php echo base_url('transaksi/pembayaran/cetak_'); ?>${jenis}/${kode_invoice}`, '_blank');
    }

    function formatRupiah(angka, prefix) {
        let number_string = String(angka).replace(/[^.\d]/g, '').toString();
        let split = number_string.split('.');
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        if (ribuan) {
            let separator = sisa ? ',' : '';
            rupiah += separator + ribuan.join(',');
        }
        rupiah = split[1] !== undefined ? rupiah + '.' + split[1] : rupiah;
        return prefix === undefined ? rupiah : (rupiah ? 'Rp' + rupiah : '');
    }
</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a>Riwayat</a>
                        </li>
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
                    <h4 class="card-title">Data Riwayat Pembayaran</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </div>
                                <input type="text" class="form-control" id="cari" placeholder="Cari Invoice/Pasien/NIK...">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="table-data">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Kode Invoice</th>
                                    <th>Nama Pasien</th>
                                    <th>Biaya Tindakan</th>
                                    <th>Biaya Resep</th>
                                    <th>Total</th>
                                    <th>Metode</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Waktu Bayar</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <div id="pagination"></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-md-7">&nbsp;</div>
                                <label class="col-md-2 control-label d-flex align-items-center justify-content-end">Tampil</label>
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

<div class="modal fade" id="detailRiwayatModal" tabindex="-1" aria-labelledby="detailRiwayatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle me-2"></i> Detail Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="text fw-bold">Informasi Umum & Pembayaran</h5>
                        <dl class="row">
                            <dt class="col-sm-4 text-muted">Invoice</dt>
                            <dd class="col-sm-8" id="detail_kode_invoice"></dd>
                            <dt class="col-sm-4 text-muted">Tanggal</dt>
                            <dd class="col-sm-8" id="detail_tanggal_transaksi"></dd>
                            <dt class="col-sm-4 text-muted">Waktu</dt>
                            <dd class="col-sm-8" id="detail_waktu_transaksi"></dd>
                            <dt class="col-sm-4 text-muted">Pasien</dt>
                            <dd class="col-sm-8" id="detail_nama_pasien"></dd>
                            <dt class="col-sm-4 text-muted">Dokter</dt>
                            <dd class="col-sm-8" id="detail_nama_dokter"></dd>
                            <hr class="my-2">
                            <dt class="col-sm-4 text-muted">Metode</dt>
                            <dd class="col-sm-8" id="detail_metode_pembayaran"></dd>
                            <dt class="col-sm-4 text-muted">Bank</dt>
                            <dd class="col-sm-8" id="detail_bank"></dd>
                            <dt class="col-sm-4 text-muted">Jumlah Bayar</dt>
                            <dd class="col-sm-8" id="detail_bayar"></dd>
                            <dt class="col-sm-4 text-muted">Kembali</dt>
                            <dd class="col-sm-8" id="detail_kembali"></dd>
                            <hr class="my-2">
                            <dt class="col-sm-4 text-muted">Total Tagihan</dt>
                            <dd class="col-sm-8">
                                <span class="fs-5 fw-bold text-success" id="detail_total_invoice"></span>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text fw-bold">Rincian Layanan</h5>
                        <div id="detail_rincian_biaya" style="max-height: 400px; overflow-y: auto;"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer p-3 bg-light border-top-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="far fa-window-close me-2"></i>Tutup
                </button>
                <button type="button" class="btn btn-success" id="btn-cetak-struk">
                    <i class="fas fa-print me-2"></i> Cetak Struk
                </button>
                <button type="button" class="btn btn-primary" id="btn-cetak-kwitansi">
                    <i class="fas fa-file-invoice me-2"></i> Cetak Kwitansi
                </button>
            </div>
        </div>
    </div>
</div>