<script type="text/javascript">
    $(document).ready(function() {
        get_data();
        $("#jumlah_tampil, #filter_status").change(function() {
            get_data();
        });
        $('#cari').off('keyup').keyup(function() {
            get_data();
        });
    });

    function get_data() {
        let cari = $('#cari').val();
        let status_booking = $('#filter_status').val();
        let hitung_baris = $('#table-data thead tr th').length;
        $.ajax({
            url: '<?php echo base_url("resepsionis/booking/result_data"); ?>',
            type: "POST",
            data: {
                cari: cari,
                status_booking: status_booking
            },
            dataType: "json",
            // beforeSend: () => {
            //     $('#table-data tbody').html(`<tr id="tr-loading"><td colspan="${hitung_baris}" class="text-center">Memuat data...</td></tr>`);
            // },
            beforeSend : () => {
              let loading = `<tr id="tr-loading">
                                  <td colspan="${hitung_baris}" class="text-center">
                                      <div class="loader">
                                          <img src="<?php echo base_url(); ?>assets/loading-table.gif" width="60" alt="loading">
                                      </div>
                                  </td>
                              </tr>`;

              $(`#table-data tbody`).html(loading);
          },
            success: function(res) {
                let table = "";
                if (res.result) {
                    let i = 1;
                    for (const item of res.data) {
                        let statusBadge = '';
                        if (item.status_booking == 'Pending') {
                            statusBadge = '<span class="badge bg-warning">Pending</span>';
                        } else if (item.status_booking == 'Disetujui') {
                            statusBadge = '<span class="badge bg-success">Disetujui</span>';
                        } else {
                            statusBadge = `<span class="badge bg-secondary">${item.status_booking}</span>`;
                        }

                        let aksi = `
                            <button type="button" class="btn btn-sm btn-warning" title="Detail" onclick="showDetail(${item.id})"><i class="fas fa-eye"></i></button>
                            <a href="<?php echo base_url('resepsionis/booking/view_edit/'); ?>${item.id}" class="btn btn-sm btn-info" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                            <button type="button" class="btn btn-sm btn-danger" title="Hapus" onclick="hapus(${item.id})"><i class="fas fa-trash-alt"></i></button>`;

                        if (item.status_booking == 'Pending') {
                            aksi = `<button type="button" class="btn btn-sm btn-success" title="Konfirmasi Booking" onclick="konfirmasiBooking(${item.id})"><i class="fas fa-check"></i></button> ` + aksi;
                        }

                        table += `
                            <tr>
                                <td>${i++}</td>
                                <td>${item.kode_booking}</td>
                                <td>${item.nama_pasien}</td>
                                <td>${item.nama_poli}</td>
                                <td>${item.nama_dokter}</td>
                                <td>${item.tanggal}</td>
                                <td>${item.waktu || ''}</td>
                                <td>${statusBadge}</td>
                                <td class="text-center">${aksi}</td>
                            </tr>
                        `;
                    }
                } else {
                    table += `<tr><td colspan="${hitung_baris+1}" class="text-center">Data Kosong</td></tr>`;
                }
                $('#table-data tbody').html(table);
                paging();
            },
            complete: () => {
                $('#tr-loading').remove();
            }
        });
    }

    function konfirmasiBooking(id) {
        Swal.fire({
            title: "Konfirmasi Booking?",
            text: "Pasien akan didaftarkan dan masuk ke antrian.",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#28a745",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Ya, Konfirmasi",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url("resepsionis/booking/konfirmasi_booking"); ?>',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            Swal.fire('Berhasil!', response.message, 'success').then(() => get_data());
                        } else {
                            Swal.fire('Gagal!', response.message, 'error');
                        }
                    }
                });
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

    function hapus(id) {
        Swal.fire({
            title: "Anda Yakin?",
            text: "Data booking akan dihapus",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url("resepsionis/booking/hapus"); ?>',
                    method: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: res.message,
                                icon: "success"
                            }).then(() => get_data());
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: res.message,
                                icon: "error"
                            });
                        }
                    }
                })
            }
        })
    }

    function showDetail(id) {
        $.ajax({
            url: '<?php echo base_url("resepsionis/booking/get_detail_booking"); ?>',
            type: 'POST',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#detail_kode_booking').text(response.data.kode_booking || '-');
                    $('#detail_nama_pasien').text(response.data.nama_pasien || '-');
                    $('#detail_nik').text(response.data.nik || '-');
                    $('#detail_poli').text(response.data.nama_poli || '-');
                    $('#detail_dokter').text(response.data.nama_dokter || '-');
                    $('#detail_tanggal').text((response.data.tanggal || '') + ' ' + (response.data.waktu || ''));
                    $('#detail_dibuat').text(response.data.tanggal_booking || '-');
                    let badge = '';
                    if (response.data.status_booking === 'Pending') {
                        badge = '<span class="badge bg-warning">Pending</span>';
                    } else if (response.data.status_booking === 'Disetujui') {
                        badge = '<span class="badge bg-success">Disetujui</span>';
                    } else {
                        badge = `<span class="badge bg-secondary">${response.data.status_booking || '-'}</span>`;
                    }

                    $('#detail_status').html(badge);
                    $('#detailBookingModal').modal('show');
                } else {
                    Swal.fire('Gagal!', response.message, 'error');
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
                        <li class="breadcrumb-item"><?php echo $title; ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?php echo $title; ?></h4>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center pt-3 pb-3">
            <h4 class="card-title">Data <?php echo $title; ?></h4>
            <a href="<?php echo base_url(); ?>resepsionis/booking/view_tambah">
                <button type="button" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Tambah
                </button>
            </a>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-sm-3">
                    <select id="filter_status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="Pending">Pending</option>
                        <option value="Disetujui">Disetujui</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-warning w-100" onclick="$('#filter_status').val(''); get_data();">
                        <i class="fas fa-search me-2"></i>Reset Filter
                    </button>
                </div>
                <div class="col-sm-4 ms-auto">
                    <div class="input-group">
                        <div class="input-group-text">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" class="form-control" id="cari" placeholder="Cari Pasien/Kode/Poli/Dokter...">
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover" id="table-data">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Pasien</th>
                            <th>Poli</th>
                            <th>Dokter</th>
                            <th>Tanggal Kunjungan</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
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

<div class="modal fade" id="detailBookingModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <dl class="row">
                    <dt class="col-sm-4">Kode Booking</dt>
                    <dd class="col-sm-8" id="detail_kode_booking"></dd>
                    <dt class="col-sm-4">Nama Pasien</dt>
                    <dd class="col-sm-8" id="detail_nama_pasien"></dd>
                    <dt class="col-sm-4">NIK</dt>
                    <dd class="col-sm-8" id="detail_nik"></dd>
                    <dt class="col-sm-4">Poli Tujuan</dt>
                    <dd class="col-sm-8" id="detail_poli"></dd>
                    <dt class="col-sm-4">Dokter Tujuan</dt>
                    <dd class="col-sm-8" id="detail_dokter"></dd>
                    <dt class="col-sm-4">Jadwal Kunjungan</dt>
                    <dd class="col-sm-8" id="detail_tanggal"></dd>
                    <dt class="col-sm-4">Dibuat Pada</dt>
                    <dd class="col-sm-8" id="detail_dibuat"></dd>
                    <dt class="col-sm-4">Status</dt>
                    <dd class="col-sm-8" id="detail_status"></dd>
                </dl>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="far fa-window-close me-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>