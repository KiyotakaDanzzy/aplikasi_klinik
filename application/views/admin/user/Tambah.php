<script type="text/javascript">
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
            url: '<?php echo base_url('admin/user/tambah_aksi') ?>',
            method: 'POST',
            data: $('#form_tambah').serialize(),
            dataType: 'json',
            beforeSend: function() {
                Swal.fire({
                    title: 'Mengupload...',
                    html: 'Mohon Ditunggu...',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
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
                                window.location.href = '<?php echo base_url() ?>admin/user'
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

    function loadPegawai(cari = '') {
        $.ajax({
            url: '<?php echo base_url("admin/user/get_pegawai_list"); ?>',
            type: 'POST',
            data: {
                cari: cari
            },
            dataType: 'json',
            success: function(response) {
                let rows = '';
                if (response.length > 0) {
                    response.forEach(item => {
                        rows += `<tr style="cursor:pointer;" onclick='selectPegawai(${JSON.stringify(item)})'>
                                    <td>${item.nama}</td> 
                                    <td>${item.nama_jabatan}</td>
                                </tr>`;
                    });
                } else {
                    rows = '<tr><td colspan="2" class="text-center">Pegawai tidak ditemukan.</td></tr>';
                }
                $('#pegawaiList').html(rows);
            }
        });
    }

    function selectPegawai(data) {
        $('#id_pegawai').val(data.id);
        $('#display_nama_pegawai').val(data.nama);
        $('#nama_pegawai_hidden').val(data.nama);
        $('#pegawaiSearchModal').modal('hide');
    }

    $(document).ready(function() {
        $('#btn-cari-pegawai').click(function() {
            $('#search_pegawai_keyword').val('');
            loadPegawai();
            $('#pegawaiSearchModal').modal('show');
        });

        $('#search_pegawai_keyword').keyup(function() {
            loadPegawai($(this).val());
        });
    });
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/user">User</a></li>
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
                                <label class="col-sm-2 col-form-label">Pegawai</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="display_nama_pegawai" placeholder="Pilih Pegawai..." readonly required>
                                        <button class="btn btn-primary" type="button" id="btn-cari-pegawai">
                                            <i class="fas fa-search"></i> Cari
                                        </button>
                                    </div>
                                    <input type="hidden" name="id_pegawai" id="id_pegawai">
                                    <input type="hidden" name="nama_pegawai" id="nama_pegawai_hidden">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="username" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Input Username Login" required autocomplete="off">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="password" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Input Password" required autocomplete="off">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="level" class="col-sm-2 col-form-label">Level</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="id_level" id="id_level" required>
                                        <option value="">Pilih Level Akses</option>
                                        <?php foreach ($level_list as $lvl) : ?>
                                            <option value="<?php echo $lvl->id; ?>"><?php echo $lvl->nama_level; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10 ms-auto">
                                    <button type="button" onclick="tambah(event);" class="btn btn-success">
                                        <i class="fas fa-save me-2"></i>Simpan
                                    </button>
                                    <a href="<?php echo base_url(); ?>admin/user">
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
        </div>
    </div>
</div>
<div class="modal fade" id="pegawaiSearchModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cari Data Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" id="search_pegawai_keyword" class="form-control" placeholder="Ketik Nama Pegawai atau Jabatan...">
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>Nama Pegawai</th>
                                <th>Jabatan</th>
                            </tr>
                        </thead>
                        <tbody id="pegawaiList">
                            <tr>
                                <td colspan="2" class="text-center">Silakan ketik kata kunci...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>