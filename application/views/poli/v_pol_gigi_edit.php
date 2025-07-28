
<script type="text/javascript">
    function edit(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo base_url('poli/pol_gigi/edit') ?>',
            method: 'POST',
            data: $('#form_edit').serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.status == true) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: res.message,
                        icon: "success"
                    }).then(() => {
                        window.location.href = '<?php echo base_url('poli/pol_gigi') ?>';
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
</script>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><?php echo $title; ?></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('poli/pol_gigi'); ?>">Data</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                    <h4 class="card-title">Edit <?php echo $title; ?></h4>
                </div>
                <div class="card-body">
                    <form id="form_edit" onsubmit="edit(event);">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Kode Invoice</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="kode_invoice" value="<?php echo $row['kode_invoice']; ?>"></div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">NIK</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="nik" value="<?php echo $row['nik']; ?>"></div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Nama Pasien</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="nama_pasien" value="<?php echo $row['nama_pasien']; ?>"></div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Nama Dokter</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="nama_dokter" value="<?php echo $row['nama_dokter']; ?>"></div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Keluhan</label>
                            <div class="col-sm-10"><textarea class="form-control" name="keluhan"><?php echo $row['keluhan']; ?></textarea></div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Catatan</label>
                            <div class="col-sm-10"><textarea class="form-control" name="catatan"><?php echo $row['catatan']; ?></textarea></div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Tanggal</label>
                            <div class="col-sm-4"><input type="date" class="form-control" name="tanggal" value="<?php echo $row['tanggal']; ?>"></div>
                            <label class="col-sm-2 col-form-label">Waktu</label>
                            <div class="col-sm-4"><input type="time" class="form-control" name="waktu" value="<?php echo $row['waktu']; ?>"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-10 ms-auto">
                                <button type="submit" class="btn btn-success"><i class="fas fa-save me-2"></i>Simpan</button>
                                <a href="<?php echo base_url('poli/pol_gigi'); ?>" class="btn btn-warning"><i class="fas fa-reply me-2"></i>Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>