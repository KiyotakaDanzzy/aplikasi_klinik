<script type="text/javascript">
    $(document).ready(function() {
        new Selectr('#id_jenis_biaya');
    });

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
                text: 'Harap isi semua kolom yang wajib diisi',
                icon: 'error',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Oke'
            });
        }

        return isValid;
    }

    function tambah(e) {
        e.preventDefault()
        if (!validateForm('#form_tambah')) {
            return;
        }
        $.ajax({
            url: '<?php echo base_url('keuangan/pemasukan/tambah_aksi') ?>',
            method: 'POST',
            data: $('#form_tambah').serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.status == true) {
                    Swal.fire({
                            title: 'Berhasil!',
                            text: res.message,
                            icon: "success",
                            confirmButtonColor: "#35baf5",
                            confirmButtonText: "Oke"
                        })
                        .then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '<?php echo base_url() ?>keuangan/pemasukan'
                            }
                        })
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: res.message,
                        icon: "error",
                        confirmButtonColor: "#35baf5",
                        confirmButtonText: "Oke"
                    })
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
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>keuangan/pemasukan">Pemasukan</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
                <h4 class="page-title"><?php echo $title; ?></h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header pt-3 pb-3">
                    <h4 class="card-title">Tambah <?php echo $title; ?></h4>
                </div>
                <div class="card-body">
                    <div class="general-label">
                        <form id="form_tambah">
                            <div class="mb-3 row">
                                <label for="id_jenis_biaya" class="col-sm-2 col-form-label">Jenis Biaya</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="id_jenis_biaya" id="id_jenis_biaya" required>
                                        <option value="">Pilih Jenis Biaya</option>
                                        <?php foreach ($data_jenis as $jenis_biaya) {
                                            echo "<option value='{$jenis_biaya->id}'>{$jenis_biaya->nama}</option>";
                                        } ?>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="nama" class="col-sm-2 col-form-label">Keterangan</label>
                                <div class="col-sm-10">
                                    <textarea type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Input Keterangan" required autocomplete="off"></textarea>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="harga" class="col-sm-2 col-form-label">Nominal</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <div class="input-group-text">Rp</div>
                                        <input type="text" class="form-control" name="nominal" id="nominal" onkeyup="FormatCurrency(this);" placeholder="Masukkan Nominal" required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10 ms-auto">
                                    <button type="button" onclick="tambah(event);" class="btn btn-success"><i class="fas fa-save me-2"></i>Simpan</button>
                                    <a href="<?php echo base_url(); ?>keuangan/pemasukan"><button type="button" class="btn btn-warning"><i class="fas fa-reply me-2"></i>Kembali</button></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>