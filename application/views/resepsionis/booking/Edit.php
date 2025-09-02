<script type="text/javascript">
    // function loadPasien(cari = '') {
    //     $.ajax({
    //         url: '<php echo base_url("resepsionis/booking/get_pasien_list"); ?>',
    //         type: 'POST',
    //         data: {
    //             cari: cari
    //         },
    //         dataType: 'json',
    //         success: function(response) {
    //             let rows = '';
    //             if (response.length > 0) {
    //                 response.forEach(pasien => {
    //                     rows += `<tr style="cursor:pointer;" onclick='selectPasien(${JSON.stringify(pasien)})'>
    //                         <td>${pasien.no_rm}</td>
    //                         <td>${pasien.nama_pasien}</td>
    //                         <td>${pasien.nik}</td>
    //                     </tr>`;
    //                 });
    //             } else {
    //                 rows = '<tr><td colspan="3" class="text-center">Pasien tidak ditemukan.</td></tr>';
    //             }
    //             $('#pasienList').html(rows);
    //         }
    //     });
    // }

    // function selectPasien(pasienData) {
    //     $('#id_pasien').val(pasienData.id);
    //     $('#nama_pasien_display').val(pasienData.nama_pasien + ' (' + pasienData.no_rm + ')');
    //     $('#pasienSearchModal').modal('hide');
    // }

    function edit(e) {
        e.preventDefault();
        if (!validateForm('#form_edit')) {
            return;
        }
        $.ajax({
            url: '<?php echo base_url("resepsionis/booking/edit_aksi"); ?>',
            method: 'POST',
            data: $('#form_edit').serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.status) {
                    Swal.fire({
                            title: 'Berhasil!',
                            text: res.message,
                            icon: 'success'
                        })
                        .then(() => {
                            window.location.href = '<?php echo base_url('resepsionis/booking'); ?>';
                        });
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        html: res.message,
                        icon: 'error'
                    });
                }
            }
        });
    }

    function validateForm(formSelector) {
        let isValid = true;
        $(formSelector + ' [required]').removeClass('is-invalid');
        $(formSelector + ' [required]').each(function() {
            if (!$(this).val() || $(this).val().trim() === '') {
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

    $(document).ready(function() {
        const tanggalInput = document.getElementById('tanggal');
        const datepicker = new Datepicker(tanggalInput, {
            format: 'dd-mm-yyyy',
            autohide: true
        });

        // $('#btn-cari-pasien').click(function() {
        //     $('#search_pasien_keyword').val('');
        //     loadPasien();
        //     $('#pasienSearchModal').modal('show');
        // });

        // $('#search_pasien_keyword').keyup(function() {
        //     loadPasien($(this).val());
        // });

        var timeInput = document.getElementById('waktu');
        var timeMask = IMask(timeInput, {
            mask: 'HH:MM',
            blocks: {
                HH: {
                    mask: IMask.MaskedRange,
                    from: 0,
                    to: 23,
                    maxLength: 2
                },
                MM: {
                    mask: IMask.MaskedRange,
                    from: 0,
                    to: 59,
                    maxLength: 2
                }
            },
            lazy: false,
            placeholderChar: '_'
        });

        function getDokterTersedia() {
            let id_poli = $('#id_poli').val();
            let tanggal = $('#tanggal').val();
            let waktu = $('#waktu').val();
            let dokterDropdown = $('#id_dokter');
            let idDokterPilih = '<?php echo $booking['id_dokter']; ?>';

            dokterDropdown.html('<option value="">Memuat...</option>').prop('disabled', true);
            if (id_poli && tanggal) {
                $.ajax({
                    url: '<?php echo base_url("resepsionis/booking/get_dokter_ada"); ?>',
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
                                let isSelected = (dokter.id == idDokterPilih) ? 'selected' : '';
                                dokterDropdown.append(`<option value="${dokter.id}" ${isSelected}>${dokter.nama_pegawai} (${dokter.jam_mulai.substring(0, 5)} - ${dokter.jam_selesai.substring(0, 5)})</option>`);
                            });
                        } else {
                            dokterDropdown.html('<option value="">Tidak ada dokter tersedia</option>');
                        }
                    }
                });
            } else {
                dokterDropdown.html('<option value="">Pilih Poli, Tanggal, dan Waktu dulu</option>');
            }
        }
        $('#id_poli, #tanggal, #waktu').change(getDokterTersedia);
        $('#id_poli').trigger('change');
    });
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url(); ?>resepsionis/booking">Booking</a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
                <h4 class="page-title"><?php echo $title; ?></h4>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Edit Booking: <?php echo $booking['kode_booking']; ?></h4>
        </div>
        <div class="card-body">
            <form id="form_edit">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Pasien</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" id="nama_pasien_display" value="<?php echo $booking['nama_pasien'] ?>" readonly required>
                            <!-- <button class="btn btn-primary" type="button" id="btn-cari-pasien"><i class="fas fa-search"></i> Ganti</button> -->
                        </div>
                        <input type="hidden" name="id_pasien" id="id_pasien" value="<?php echo $booking['id_pasien']; ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">NIK</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="text" class="form-control" id="nik_pasien_display" value="<?php echo $booking['nik'] ?>" readonly required>
                        </div>
                    </div>
                </div>
                <hr>
                <input type="hidden" name="id" value="<?php echo $booking['id']; ?>">
                <div class="mb-3 row">
                    <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Kunjungan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="tanggal" id="tanggal" value="<?php echo $booking['tanggal']; ?>" required autocomplete="off">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="id_poli" class="col-sm-2 col-form-label">Poli Tujuan</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="id_poli" id="id_poli" required>
                            <option value="">Pilih Poli...</option>
                            <?php foreach ($data_poli as $poli) {
                                $selected = ($poli->id == $booking['id_poli']) ? 'selected' : '';
                                echo "<option value='{$poli->id}' {$selected}>{$poli->nama}</option>";
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="waktu" class="col-sm-2 col-form-label">Waktu Kunjungan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="waktu" id="waktu" autocomplete="off" value="<?php echo $booking['waktu']; ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="id_dokter" class="col-sm-2 col-form-label">Dokter Tersedia</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="id_dokter" id="id_dokter" required>
                            <option value="">Pilih Poli & Tanggal Dulu</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-sm-10 ms-auto">
                        <button type="button" onclick="edit(event);" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Simpan
                        </button>
                        <a href="<?php echo base_url(); ?>resepsionis/booking">
                            <button type="button" class="btn btn-warning">
                                <i class="fas fa-reply me-2"></i>Kembali
                            </button>
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
                    <input type="text" id="search_pasien_keyword" class="form-control" placeholder="Ketik No RM atau Nama Pasien untuk mencari...">
                </div>
                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No. RM</th>
                                <th>Nama</th>
                                <th>NIK</th>
                            </tr>
                        </thead>
                        <tbody id="pasienList"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>