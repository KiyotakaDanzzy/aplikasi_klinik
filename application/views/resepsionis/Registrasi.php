<script type="text/javascript">
    $(document).ready(function() {
        get_data();
        $("#jumlah_tampil").change(function() {
            get_data();
        });
    });

    function get_data() {
        let cari = $('#cari').val();
        let hitung_baris = $('#table-data thead tr th').length;
        $.ajax({
            url: '<?php echo base_url("resepsionis/registrasi/result_data"); ?>',
            type: "POST",
            data: {
                cari: cari
            },
            dataType: "json",
            beforeSend: () => {
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
                        table += `
                            <tr>
                                <td>${i++}</td>
                                <td>${item.kode_invoice}</td>
                                <td>${item.no_antrian}</td>
                                <td>${item.nama_pasien}</td>
                                <td>${item.nama_poli}</td>
                                <td>${item.nama_dokter}</td>
                                <td>${item.tanggal}</td>
                                <td>${item.waktu}</td>
                                <td>
                                    <span class="badge bg-success">${item.status_registrasi}</span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-warning" title="Detail" onclick="showDetail(${item.id})"><i class="fas fa-eye"></i></button>
                                    <a href="<?php echo base_url('resepsionis/registrasi/view_edit/'); ?>${item.id}" class="btn btn-sm btn-info" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                    <button type="button" class="btn btn-sm btn-danger" title="Hapus" onclick="hapus(${item.id})"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        `;
                    }
                } else {
                    table += `<tr><td colspan="${hitung_baris}" class="text-center">Data Kosong</td></tr>`;
                }
                $('#table-data tbody').html(table);
                paging();
            },
            complete: () => {
                $('#tr-loading').remove();
            }
        });
        $('#cari').off('keyup').keyup(function() {
            get_data();
        });
    }

    function showDetail(id) {
        $.ajax({
            url: '<?php echo base_url("resepsionis/registrasi/get_detail_registrasi"); ?>',
            type: 'POST',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    Object.keys(response.data).forEach(key => {
                        $('#detail_' + key).text(response.data[key] || '-');
                    });
                    $('#detailRegistrasiModal').modal('show');
                } else {
                    Swal.fire('Gagal!', response.message, 'error');
                }
            }
        });
    }

    function hapus(id) {
        Swal.fire({
            title: "Anda Yakin?",
            text: "Registrasi dan antrian terkait akan dihapus.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url("resepsionis/registrasi/hapus"); ?>',
                    method: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status) {
                            Swal.fire('Berhasil!', res.message, 'success').then(() => get_data());
                        } else {
                            Swal.fire('Gagal!', res.message, 'error');
                        }
                    }
                })
            }
        })
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
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Data <?php echo $title; ?></h4>
            <a href="<?php echo base_url(); ?>resepsionis/registrasi/view_tambah">
                <button type="button" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Tambah
                </button>
            </a>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-sm-3">
                    <div class="input-group">
                        <div class="input-group-text">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" class="form-control" id="cari" placeholder="Cari Invoice/Pasien/Poli...">
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover" id="table-data">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Invoice</th>
                            <th>Nomor Antrian</th>
                            <th>Pasien</th>
                            <th>Poli</th>
                            <th>Dokter</th>
                            <th>Tanggal Registrasi</th>
                            <th>Waktu Registrasi</th>
                            <th>Status</th>
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

<div class="modal fade" id="detailRegistrasiModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Registrasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <dl class="row">
                    <dt class="col-sm-4">Kode Invoice</dt>
                    <dd class="col-sm-8" id="detail_kode_invoice"></dd>
                    <dt class="col-sm-4">Kode Booking</dt>
                    <dd class="col-sm-8" id="detail_kode_booking"></dd>
                    <dt class="col-sm-4">Nomor Antrian</dt>
                    <dd class="col-sm-8" id="detail_no_antrian"></dd>
                    <dt class="col-sm-4">Nama Pasien</dt>
                    <dd class="col-sm-8" id="detail_nama_pasien"></dd>
                    <dt class="col-sm-4">NIK</dt>
                    <dd class="col-sm-8" id="detail_nik"></dd>
                    <dt class="col-sm-4">Nomor Telepon</dt>
                    <dd class="col-sm-8" id="detail_no_telp"></dd>
                    <dt class="col-sm-4">Alamat</dt>
                    <dd class="col-sm-8" id="detail_alamat"></dd>
                    <dt class="col-sm-4">Poli Tujuan</dt>
                    <dd class="col-sm-8" id="detail_nama_poli"></dd>
                    <dt class="col-sm-4">Dokter</dt>
                    <dd class="col-sm-8" id="detail_nama_dokter"></dd>
                    <dt class="col-sm-4">Waktu Registrasi</dt>
                    <dd class="col-sm-8" id="detail_waktu"></dd>
                    <dt class="col-sm-4">Status</dt>
                    <dd class="col-sm-8" id="detail_status_registrasi"></dd>
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