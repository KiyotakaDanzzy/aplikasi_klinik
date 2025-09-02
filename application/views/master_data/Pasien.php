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
            url: '<?php echo base_url(); ?>master_data/pasien/result_data',
            data: {
                cari: cari
            },
            type: "POST",
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
                                <td>${i}</td>
                                <td>${item.no_rm}</td>
                                <td>${item.nama_pasien}</td>
                                <td>${item.nik}</td>
                                <td>${item.jenis_kelamin}</td>
                                <td>${item.no_telp}</td>
                                <td>${item.alamat}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-warning" title="Detail" onclick="tampilModal(${item.id})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="<?php echo base_url('master_data/pasien/view_edit/'); ?>${item.id}" class="btn btn-sm btn-info" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                    <button type="button" class="btn btn-sm btn-danger" title="Hapus" onclick="hapus(${item.id})"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        `;
                        i++;
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

    function tampilModal(id) {
        $.ajax({
            url: '<?php echo base_url(); ?>master_data/pasien/get_detail_pasien',
            type: 'POST',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#data_no_rm').text(response.data.no_rm);
                    $('#data_nama_pasien').text(response.data.nama_pasien);
                    $('#data_nik').text(response.data.nik);
                    // $('#data_username').text(response.data.username);
                    $('#data_jenis_kelamin').text(response.data.jenis_kelamin);
                    $('#data_tanggal_lahir').text(response.data.tanggal_lahir);
                    $('#data_umur').text(response.data.umur);
                    $('#data_alamat').text(response.data.alamat);
                    $('#data_pekerjaan').text(response.data.pekerjaan);
                    $('#data_no_telp').text(response.data.no_telp);
                    $('#data_status_perkawinan').text(response.data.status_perkawinan);
                    $('#data_nama_wali').text(response.data.nama_wali);
                    $('#data_golongan_darah').text(response.data.golongan_darah);
                    $('#data_alergi').text(response.data.alergi);
                    $('#data_status_operasi').text(response.data.status_operasi);

                    var detailModal = new bootstrap.Modal(document.getElementById('modalPasien'));
                    detailModal.show();
                } else {
                    Swal.fire('Gagal!', response.message, 'error');
                }
            }
        });
    }

    function hapus(id) {
        Swal.fire({
            title: "Anda Yakin?",
            text: "Data pasien akan dihapus",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url(); ?>master_data/pasien/hapus',
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
                                })
                                .then(() => get_data());
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

    <div class="modal fade bd-example-modal-lg" id="modalPasien" tabindex="-1" role="dialog" aria-labelledby="detailPasienLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="detailPasienLabel">Detail Pasien</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Data Identitas -->
                        <div class="col-lg-6 mb-4">
                            <h5 class="mb-3">Informasi Utama</h5>
                            <dl class="row">
                                <dt class="col-sm-5">Nomor Rekam Medis</dt>
                                <dd class="col-sm-7">: <span id="data_no_rm"></span></dd>
                                <dt class="col-sm-5">Nama Pasien</dt>
                                <dd class="col-sm-7">: <span id="data_nama_pasien"></span></dd>
                                <dt class="col-sm-5">NIK</dt>
                                <dd class="col-sm-7">: <span id="data_nik"></span></dd>
                                <!-- <dt class="col-sm-5">Username</dt>
                                <dd class="col-sm-7">: <span id="data_username"></span></dd> -->
                                <dt class="col-sm-5">Jenis Kelamin</dt>
                                <dd class="col-sm-7">: <span id="data_jenis_kelamin"></span></dd>
                                <dt class="col-sm-5">Tanggal Lahir</dt>
                                <dd class="col-sm-7">: <span id="data_tanggal_lahir"></span></dd>
                                <dt class="col-sm-5">Umur</dt>
                                <dd class="col-sm-7">: <span id="data_umur"></span> tahun</dd>
                            </dl>
                        </div>

                        <!-- Data Kontak & Sosial -->
                        <div class="col-lg-6 mb-4">
                            <h5 class="mb-3">Kontak & Domisili</h5>
                            <dl class="row">
                                <dt class="col-sm-5">Alamat</dt>
                                <dd class="col-sm-7">: <span id="data_alamat"></span></dd>
                                <dt class="col-sm-5">Pekerjaan</dt>
                                <dd class="col-sm-7">: <span id="data_pekerjaan"></span></dd>
                                <dt class="col-sm-5">Nomor Telepon</dt>
                                <dd class="col-sm-7">: <span id="data_no_telp"></span></dd>
                                <dt class="col-sm-5">Status Perkawinan</dt>
                                <dd class="col-sm-7">: <span id="data_status_perkawinan"></span></dd>
                                <dt class="col-sm-5">Nama Wali</dt>
                                <dd class="col-sm-7">: <span id="data_nama_wali"></span></dd>
                            </dl>
                        </div>

                        <!-- Data Medis -->
                        <div class="col-12">
                            <h5 class="mb-3">Kesehatan</h5>
                            <dl class="row">
                                <dt class="col-sm-2">Golongan Darah</dt>
                                <dd class="col-sm-4">: <span id="data_golongan_darah"></span></dd>
                                <dt class="col-sm-2">Alergi</dt>
                                <dd class="col-sm-4">: <span id="data_alergi"></span></dd>
                                <dt class="col-sm-2">Riwayat Operasi</dt>
                                <dd class="col-sm-4">: <span id="data_status_operasi"></span></dd>
                            </dl>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="far fa-window-close me-2"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

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
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center pt-3 pb-3">
                    <h4 class="card-title">Data <?php echo $title; ?></h4>
                    <a href="<?php echo base_url(); ?>master_data/pasien/view_tambah">
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
                                <input type="text" class="form-control" id="cari" placeholder="Cari No. RM/Nama/NIK..">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0 table-hover" id="table-data">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>No. RM</th>
                                    <th>Nama Pasien</th>
                                    <th>NIK</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Nomor Telepon</th>
                                    <th>Alamat</th>
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