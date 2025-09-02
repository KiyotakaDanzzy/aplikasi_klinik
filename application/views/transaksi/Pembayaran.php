<script type="text/javascript">
    $(document).ready(function() {
        get_data();
        $("#jumlah_tampil").change(function() {
            get_data();
        });
        $('#cari').keyup(function() {
            get_data();
        });

        $('#metode_pembayaran').change(function() {
            if ($(this).val() === 'Transfer Bank') {
                $('#bank_form').slideDown();
                $('#bank').prop('required', true);
            } else {
                $('#bank_form').slideUp();
                $('#bank').prop('required', false);
            }
        });

        $('#bayar').on('keyup', function() {
            let total_string = $('#total_invoice').val() || '0';
            let bayar_string = $(this).val();
            const bayarInput = $('#bayar');

            let number_only = bayar_string.replace(/[^0-9]/g, '');

            if (parseInt(bayar_string.replace(/[^0-9]/g, '')) < parseInt(total_string.replace(/[^0-9]/g, ''))) {
                bayarInput.addClass('is-invalid');
            } else {
                bayarInput.removeClass('is-invalid');
            }

            if (number_only === '') {
                this.value = '';
                $('#kembali').val('');
                return;
            }

            this.value = formatRupiah(number_only);

            let total = parseInt(total_string.replace(/[^0-9]/g, '')) || 0;
            let bayar = parseInt(number_only) || 0;
            let kembali = bayar - total;

            $('#kembali').val(formatRupiah(kembali > 0 ? kembali : 0));
        });
    });

    function get_data() {
        let cari = $('#cari').val();
        let hitung_baris = $('#table-data thead tr th').length;
        $.ajax({
            url: '<?php echo base_url("transaksi/pembayaran/result_data"); ?>',
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
                                <td>${item.nik}</td>
                                <td>${item.nama_dokter}</td>
                                <td>${formatRupiah(item.biaya_tindakan, 'Rp')}</td>
                                <td>${formatRupiah(item.biaya_resep, 'Rp')}</td>
                                <td>${formatRupiah(item.total_invoice, 'Rp')}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-success" onclick="showModalBayar('${item.kode_invoice}')"><i class="fas fa-money-bill-wave me-2"></i>Bayar</button>
                                </td>
                            </tr>
                        `;
                    }
                } else {
                    table += `<tr><td colspan="${hitung_baris}" class="text-center">Tidak ada pasien yang perlu membayar.</td></tr>`;
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

    function showModalBayar(kode_invoice) {
        $.ajax({
            url: '<?php echo base_url("transaksi/pembayaran/get_detail_pembayaran"); ?>',
            type: 'POST',
            data: {
                kode_invoice: kode_invoice
            },
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#form_bayar')[0].reset();
                    let data = response.data;
                    $('#form_bayar #kode_invoice').val(data.pembayaran.kode_invoice);
                    $('#form_bayar #nama_pasien').val(data.pembayaran.nama_pasien);
                    $('#form_bayar #biaya_tindakan').val(formatRupiah(data.pembayaran.biaya_tindakan));
                    // $('#form_bayar #biaya_resep').val(formatRupiah(data.pembayaran.biaya_resep));
                    $('#form_bayar #total_invoice').val(formatRupiah(data.pembayaran.biaya_tindakan));

                    let detailHtml = '';
                    if (data.tindakan.length > 0) {
                        detailHtml += '<h6>Tindakan</h6><ul class="list-group mb-3">';
                        data.tindakan.forEach(item => {
                            detailHtml += `<li class="list-group-item d-flex justify-content-between align-items-center">${item.tindakan}<span class="badge bg-primary rounded-pill">Rp${formatRupiah(item.harga)}</span></li>`;
                        });
                        detailHtml += '</ul>';
                    }
                    // if (data.resep.length > 0 || data.racikan.length > 0) {
                    //     detailHtml += '<h6>Resep Obat</h6><ul class="list-group">';
                    //     data.resep.forEach(item => {
                    //         let subtotal = (parseInt(item.harga) + parseInt(item.laba)) * parseInt(item.jumlah);
                    //         detailHtml += `<li class="list-group-item d-flex justify-content-between align-items-center">${item.nama_barang} x${item.jumlah}<span class="badge bg-primary rounded-pill">Rp${formatRupiah(subtotal)}</span></li>`;
                    //     });
                    //     detailHtml += '<h6>Racikan Obat</h6><ul class="list-group">';
                    //     data.racikan.forEach(item => {
                    //         let subtotal = parseInt(item.sub_total_harga) + parseInt(item.sub_total_laba);
                    //         detailHtml += `<li class="list-group-item d-flex justify-content-between align-items-center">${item.nama_racikan} x${item.jumlah}<span class="badge bg-primary rounded-pill">Rp${formatRupiah(subtotal)}</span></li>`;
                    //     });
                    //     detailHtml += '</ul>';
                    // }
                    $('#rincian_biaya').html(detailHtml);

                    $('#bank_form').hide();
                    $('#bank').prop('required', false);
                    $('#pembayaranModal').modal('show');
                } else {
                    Swal.fire('Gagal!', 'Detail pembayaran tidak ditemukan.', 'error');
                }
            }
        });
    }

    function simpanPembayaran(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url("transaksi/pembayaran/bayar_aksi"); ?>',
            type: 'POST',
            data: $('#form_bayar').serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.status) {
                    $('#pembayaranModal').modal('hide');
                    get_data();
                    Swal.fire({
                        title: 'Berhasil!',
                        text: res.message,
                        icon: 'success',
                        html: `
                            <div class="text-start mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="cetak_struk_check" checked>
                                    <label class="form-check-label" for="cetak_struk_check">
                                        Cetak Struk
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="cetak_kwitansi_check" checked>
                                    <label class="form-check-label" for="cetak_kwitansi_check">
                                        Cetak Kwitansi
                                    </label>
                                </div>
                            </div>
                        `,
                        confirmButtonText: '<i class="fas fa-print"></i> Cetak',
                        showDenyButton: true,
                        denyButtonText: 'Tutup',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if ($('#cetak_struk_check').is(':checked')) {
                                window.open(`<?php echo base_url('transaksi/pembayaran/cetak_struk/'); ?>${res.kode_invoice}`, '_blank');
                            }
                            if ($('#cetak_kwitansi_check').is(':checked')) {
                                window.open(`<?php echo base_url('transaksi/pembayaran/cetak_kwitansi/'); ?>${res.kode_invoice}`, '_blank');
                            }
                        }
                    });
                } else {
                    Swal.fire('Gagal!', res.message, 'error');
                }
            }
        });
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
                        <li class="breadcrumb-item">Pembayaran</li>
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
                    <h4 class="card-title">Data Pembayaran</h4>
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
                                    <th>NIK</th>
                                    <th>Dokter</th>
                                    <th>Biaya Tindakan</th>
                                    <th>Biaya Resep</th>
                                    <th>Total</th>
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

<div class="modal fade" id="pembayaranModal" tabindex="-1" role="dialog" aria-labelledby="modalLabelPembayaran" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalLabelPembayaran">
                    <i class="fas fa-cash-register me-2"></i> Pembayaran Pasien
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <form id="form_bayar">
                            <input type="hidden" id="kode_invoice" name="kode_invoice">
                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label">Nama Pasien</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label">Biaya Tindakan</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control" id="biaya_tindakan" name="biaya_tindakan" readonly>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label">Biaya Resep</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control" id="biaya_resep" name="biaya_resep" readonly>
                                    </div>
                                </div>
                            </div> -->
                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label fw-bold">Total Tagihan</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control fw-bold bg-light text-success" id="total_invoice" name="total_invoice" readonly>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label">Metode
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Transfer Bank">Transfer Bank</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row" id="bank_form" style="display:none;">
                                <label class="col-sm-4 col-form-label">Bank
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <select class="form-select" id="bank" name="bank">
                                        <option value="">-- Pilih Bank --</option>
                                        <option value="BCA">BCA</option>
                                        <option value="BRI">BRI</option>
                                        <option value="Mandiri">Mandiri</option>
                                        <option value="BNI">BNI</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label">Jumlah Bayar
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control" id="bayar" name="bayar" required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label">Kembali</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control bg-light" id="kembali" name="kembali" readonly>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <h5>Rincian Biaya</h5>
                        <div id="rincian_biaya" style="max-height: 400px; overflow-y: auto;"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="far fa-window-close me-2"></i> Batal
                </button>
                <button type="button" class="btn btn-success" id="btn-simpan-pembayaran" onclick="simpanPembayaran(event)">
                    <i class="fas fa-save me-2"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>