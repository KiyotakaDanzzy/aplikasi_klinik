<script type="text/javascript">
    function hitungUmur() {
        var tanggal_lahir_str = $('#tanggal_lahir').val();

        if (tanggal_lahir_str) {
            var parts = tanggal_lahir_str.split('-');
            var formattedDate = parts[2] + '-' + parts[1] + '-' + parts[0];
            var birthDate = new Date(formattedDate);
            var today = new Date();
            var age = today.getFullYear() - birthDate.getFullYear();
            var m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            if (!isNaN(age)) {
                $('#umur').val(age);
            } else {
                $('#umur').val('');
            }
        }
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

    function loadPasien(cari = '') {
        $.ajax({
            url: '<?php echo base_url("resepsionis/booking/get_pasien_list"); ?>',
            type: 'POST',
            data: {
                cari: cari
            },
            dataType: 'json',
            success: function(response) {
                let rows = '';
                if (response.length > 0) {
                    response.forEach(pasien => {
                        rows += `<tr style="cursor:pointer;" onclick='selectPasien(${JSON.stringify(pasien)})'>
                            <td>${pasien.no_rm}</td> 
                            <td>${pasien.nama_pasien}</td> 
                            <td>${pasien.nik}</td>
                        </tr>`;
                    });
                } else {
                    rows = '<tr><td colspan="3" class="text-center">Pasien tidak ditemukan.</td></tr>';
                }
                $('#pasienList').html(rows);
                paging();
            }
        });
    }

    function selectPasien(pasienData) {
        $('#id_pasien').val(pasienData.id);
        $('#display_nama_pasien').val(pasienData.nama_pasien + ' (' + pasienData.no_rm + ')');
        $('#display_no_rm').val(pasienData.no_rm);
        $('#display_nik').val(pasienData.nik);
        $('#display_jenis_kelamin').val(pasienData.jenis_kelamin);
        $('#display_tanggal_lahir').val(pasienData.tanggal_lahir);
        $('#display_umur').val(pasienData.umur);
        $('#display_alamat').val(pasienData.alamat);
        $('#display_pekerjaan').val(pasienData.pekerjaan);
        $('#display_no_telp').val(pasienData.no_telp);
        $('#display_status_perkawinan').val(pasienData.status_perkawinan);
        $('#display_nama_wali').val(pasienData.nama_wali);
        $('#display_golongan_darah').val(pasienData.golongan_darah);
        $('#display_alergi').val(pasienData.alergi);
        $('#display_status_operasi').val(pasienData.status_operasi);
        $('#pasienSearchModal').modal('hide');
    }

    $(document).ready(function() {
        const tanggalInput = document.getElementById('tanggal');
        const datepicker = new Datepicker(tanggalInput, {
            format: 'dd-mm-yyyy',
            autohide: true
        });
        $('#tanggal_lahir').on('changeDate', hitungUmur);

        $('#btn-cari-pasien').click(function() {
            $('#search_pasien_keyword').val('');
            loadPasien();
            $('#pasienSearchModal').modal('show');
        });
        $('#search_pasien_keyword').keyup(function() {
            loadPasien($(this).val());
        });

        function getDokterTersedia() {
            let id_poli = $('#id_poli').val();
            let tanggal = $('#tanggal').val();
            let waktu = $('#waktu').val();
            let dokterDropdown = $('#id_dokter');

            dokterDropdown.html('<option value="">Memuat...</option>').prop('disabled', true);
            if (id_poli && tanggal && waktu) {
                $.ajax({
                    url: '<?php echo base_url("resepsionis/booking/get_available_doctors"); ?>',
                    type: 'POST',
                    data: {
                        id_poli: id_poli,
                        tanggal: tanggal,
                        waktu: waktu
                    },
                    dataType: 'json',
                    success: function(response) {
                        dokterDropdown.html('<option value="">Pilih Dokter...</option>').prop('disabled', false);
                        if (response.length > 0) {
                            response.forEach(dokter => {
                                dokterDropdown.append(`<option value="${dokter.id}">${dokter.nama_pegawai}</option>`);
                            });
                        } else {
                            dokterDropdown.html('<option value="">Tidak ada dokter tersedia pada jam ini</option>');
                        }
                    }
                });
            } else {
                dokterDropdown.html('<option value="">Pilih Poli, Tanggal, & Waktu Dulu</option>');
            }
        }
        $('#id_poli, #tanggal, #waktu').change(getDokterTersedia);
    });

    function tambah(e) {
        e.preventDefault();
        if (!validateForm('#form_tambah')) {
            return;
        }

        $.ajax({
            url: '<?php echo base_url('resepsionis/booking/tambah_aksi') ?>',
            method: 'POST',
            data: $('#form_tambah').serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.status == true) {
                    Swal.fire({
                            title: 'Berhasil!',
                            text: res.message,
                            icon: "success"
                        })
                        .then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '<?php echo base_url() ?>resepsionis/booking'
                            }
                        });
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: res.message,
                        icon: "error"
                    });
                }
            }
        });
    }

    function validateForm(formSelector) {
        let isValid = true;
        $(formSelector + ' [required]').removeClass('is-invalid');
        $(formSelector + ' [required]').each(function() {
            if (!$(this).is(':disabled') && ($(this).val() === '' || $(this).val() === null)) {
                isValid = false;
                $(this).addClass('is-invalid');
            }
        });
        if (!isValid) {
            Swal.fire({
                title: 'Gagal!',
                text: 'Harap isi semua kolom yang wajib diisi.',
                icon: 'error'
            });
        }
        return isValid;
    }
</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>resepsionis/booking">Booking</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
                <h4 class="page-title"><?php echo $title; ?></h4>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Tambah <?php echo $title; ?></h4>
        </div>
        <div class="card-body">
            <form id="form_tambah">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Pilih Pasien</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" id="display_nama_pasien" placeholder="Klik tombol Cari..." readonly required>
                            <button class="btn btn-primary" type="button" id="btn-cari-pasien"><i class="fas fa-search"></i> Cari</button>
                        </div>
                        <input type="hidden" name="id_pasien" id="id_pasien">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">No. RM</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="display_no_rm" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">NIK</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="display_nik" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="display_jenis_kelamin" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="display_tanggal_lahir" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Umur</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="display_umur" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Alamat</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="display_alamat" readonly></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Pekerjaan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="display_pekerjaan" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">No. Telepon</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="display_no_telp" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Status Kawin</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="display_status_perkawinan" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Nama Wali</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="display_nama_wali" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Gol. Darah</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="display_golongan_darah" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Alergi</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="display_alergi" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Riwayat Operasi</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="display_status_operasi" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="mt-4 mb-4">

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Tanggal Kunjungan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="tanggal" id="tanggal" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Waktu Kunjungan</label>
                    <div class="col-sm-10">
                        <input type="time" class="form-control" name="waktu" id="waktu" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Poli Tujuan</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="id_poli" id="id_poli" required>
                            <option value="">Pilih Poli...</option><?php foreach ($data_poli as $poli) {
                                                                        echo "<option value='{$poli->id}'>{$poli->nama}</option>";
                                                                    } ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row"><label class="col-sm-2 col-form-label">Dokter Tersedia</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="id_dokter" id="id_dokter" required disabled>
                            <option value="">Pilih Poli, Tanggal, & Waktu Dulu</option>
                        </select>
                    </div>
                </div>

                <div class="mt-3 row">
                    <div class="col-sm-10 ms-auto">
                        <button type="button" onclick="tambah(event);" class="btn btn-success"><i class="fas fa-save me-2"></i>Simpan</button>
                        <a href="<?php echo base_url(); ?>resepsionis/booking"><button type="button" class="btn btn-warning">
                                <i class="fas fa-reply me-2"></i>Kembali</button>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="pasienSearchModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cari Data Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" id="search_pasien_keyword" class="form-control" placeholder="Cari No RM atau Nama Pasien...">
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="table-data">
                        <thead class="thead-light">
                            <tr>
                                <th>No. RM</th>
                                <th>Nama</th>
                                <th>NIK</th>
                            </tr>
                        </thead>
                        <tbody id="pasienList"></tbody>
                    </table>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-6">
                        <div id="pagination"></div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-md-7">&nbsp;</div><label class="col-md-2 control-label d-flex align-items-center justify-content-end">Tampil</label>
                            <div class="col-md-3 pull-right"><select class="form-control" id="jumlah_tampil">
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