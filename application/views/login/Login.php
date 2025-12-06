<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
</head>

<script>
    function login(e) {
        e.preventDefault();
        var form = $('#form_login')[0];
        var data = new FormData(form);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('login/login/login_aksi'); ?>",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                if (data == 'success') {
                    window.location.href = "<?php echo base_url('welcome'); ?>";
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Username atau password salah / Akun Nonaktif',
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Oke'
                    });
                }
            },
            error: function(e) {
                console.log(e);
                Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
            }
        });
    }
</script>

<body id="body" class="auth-page" style="background-image: url('<?php echo base_url(); ?>assets/images/p-2.png'); background-size: cover; background-position: center center;">
    <div class="container-md">
        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mx-auto">
                            <div class="card" style="border-radius: 10px;">
                                <div class="card-body auth-header-box" style="background-color: white; border-radius: 10px 10px 0px 0px;">
                                    <div class="text-center p-3">
                                        <a href="<?php echo base_url('login/login'); ?>" class="logo logo-admin">
                                            <img src="<?php echo base_url(); ?>assets/images/logo-sm.png" height="50" alt="logo" class="auth-logo">
                                        </a>
                                        <h4 class="mt-3 mb-1 fw-semibold text-black font-18">Sistem Informasi Klinik</h4>
                                        <p class="text-black mb-0">Masuk untuk akses halaman.</p>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <form class="my-4" id="form_login">
                                        <div class="form-group mb-2">
                                            <label class="form-label" for="username">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="password">Password</label>
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan password" required autocomplete="off">
                                        </div>
                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <div class="d-grid mt-3">
                                                    <button class="btn btn-primary" type="button" onclick="login(event);">Masuk <i class="fas fa-sign-in-alt ms-1"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/feather-icons/feather.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
</body>

</html>