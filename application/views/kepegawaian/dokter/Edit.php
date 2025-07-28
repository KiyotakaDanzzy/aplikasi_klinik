<script type="text/javascript">
    function edit(e) {
        e.preventDefault()
        $.ajax({
            url: '<?php echo base_url('kepegawaian/dokter/dokter/edit_aksi') ?>',
            method: 'POST',
            data: $('#form_edit').serialize(),
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
                                window.location.href = '<?php echo base_url() ?>kepegawaian/dokter/dokter'
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
                        <li class="breadcrumb-item"><?php echo $title; ?></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>kepegawaian/dokter/dokter">Data</a></li>
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
                    <div class="general-label">
                        <form id="form_edit">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <div class="mb-3 row"><label for="id_pegawai" class="col-sm-2 col-form-label">ID Pegawai</label>
                                <div class="col-sm-10"><input type="text" class="form-control" name="id_pegawai" id="id_pegawai" value="<?php echo $row['id_pegawai']; ?>"></div>
                            </div>
                            <div class="mb-3 row"><label for="nama_pegawai" class="col-sm-2 col-form-label">Nama Dokter</label>
                                <div class="col-sm-10"><input type="text" class="form-control" name="nama_pegawai" id="nama_pegawai" value="<?php echo $row['nama_pegawai']; ?>"></div>
                            </div>
                            <div class="mb-3 row"><label for="id_poli" class="col-sm-2 col-form-label">Poli</label>
                                <div class="col-sm-10"><select class="form-control" name="id_poli" id="id_poli">
                                        <option value="">Pilih Poli</option><?php foreach ($data_poli as $poli) {
                                                                                $selected = ($poli->id == $row['id_poli']) ? 'selected' : '';
                                                                                echo "<option value='{$poli->id}' {$selected}>{$poli->nama}</option>";
                                                                            } ?>
                                    </select></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10 ms-auto"><button type="button" onclick="edit(event);" class="btn btn-success"><i class="fas fa-save me-2"></i>Simpan</button><a href="<?php echo base_url(); ?>kepegawaian/dokter/dokter"><button type="button" class="btn btn-warning"><i class="fas fa-reply me-2"></i>Kembali</button></a></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>