<script>
    $(document).ready(function() {
        $('#id_poli').change(function() {
            let id_poli = $(this).val();
            let dokterDropdown = $('#id_dokter');
            let selectedDokterId = '<?php echo $registrasi['id_dokter']; ?>';
            dokterDropdown.html('<option value="">Memuat...</option>').prop('disabled', true);
            if (id_poli) {
                $.ajax({
                    url: '<?php echo base_url("resepsionis/booking/get_available_doctors"); ?>',
                    type: 'POST',
                    data: {
                        id_poli: id_poli,
                        tanggal: '<?php echo date('d-m-Y', strtotime($registrasi['tanggal'])); ?>',
                        waktu: '<?php echo $registrasi['waktu']; ?>'
                    },
                    dataType: 'json',
                    success: function(response) {
                        dokterDropdown.html('<option value="">Pilih Dokter...</option>').prop('disabled', false);
                        if (response.length > 0) {
                            response.forEach(dokter => {
                                let isSelected = (dokter.id == selectedDokterId) ? 'selected' : '';
                                dokterDropdown.append(`<option value="${dokter.id}" ${isSelected}>${dokter.nama_pegawai}</option>`);
                            });
                        }
                    }
                });
            } else {
                dokterDropdown.html('<option value="">Pilih Poli Dulu</option>');
            }
        });
        $('#id_poli').trigger('change');
    });

    function edit(e) {
        e.preventDefault();
        if (!validateForm('#form_edit')) {
            return;
        }
        $.ajax({
            url: '<?php echo base_url("resepsionis/registrasi/edit_aksi"); ?>',
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
                            window.location.href = '<?php echo base_url('resepsionis/registrasi'); ?>';
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
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>resepsionis/booking">Registrasi</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
                <h4 class="page-title"><?php echo $title; ?></h4>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Edit Registrasi</h4>
        </div>
        <div class="card-body">
            <form id="form_edit">
                <input type="hidden" name="id" value="<?php echo $registrasi['id']; ?>">
                <div class="mb-3 row"><label class="col-sm-3 col-form-label">Kode Invoice</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext"><?php echo $registrasi['kode_invoice']; ?></p>
                    </div>
                </div>
                <div class="mb-3 row"><label class="col-sm-3 col-form-label">Pasien</label>
                    <div class="col-sm-9">
                        <p class="form-control-plaintext"><?php echo $registrasi['nama_pasien']; ?></p>
                    </div>
                </div>
                <hr>
                <div class="mb-3 row"><label for="id_poli" class="col-sm-3 col-form-label">Poli Tujuan</label>
                    <div class="col-sm-9"><select class="form-control" name="id_poli" id="id_poli" required>
                            <option value="">Pilih Poli...</option>
                            <?php foreach ($data_poli as $poli) {$selected = ($poli->id == $registrasi['id_poli']) ? 'selected' : '';echo "<option value='{$poli->id}' {$selected}>{$poli->nama}</option>";} ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row"><label for="id_dokter" class="col-sm-3 col-form-label">Dokter Tujuan</label>
                    <div class="col-sm-9"><select class="form-control" name="id_dokter" id="id_dokter" required>
                            <option value="">Pilih Poli Dulu</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-sm-9 ms-auto">
                        <button type="button" onclick="edit(event);" class="btn btn-success"><i class="fas fa-save me-2"></i>Simpan</button>
                        <a href="<?php echo base_url(); ?>resepsionis/registrasi"><button type="button" class="btn btn-warning"><i class="fas fa-reply me-2"></i>Kembali</button></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>