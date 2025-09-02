<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <title>Aplikasi Klinik</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta content="Panel Monitor Antrian Klinik" name="description" />
  <meta content="" name="author" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">
  <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/css/app.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>assets/libs/animate.css/animate.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url(); ?>assets/libs/vanillajs-datepicker/css/datepicker.min.css" rel="stylesheet" type="text/css" />
  <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
  <style>
    body {
      background-color: #f5f7f9;
    }

    #back-button {
      position: fixed;
      top: 20px;
      left: 20px;
      font-size: 1.5rem;
      color: #fff;
      background-color: rgba(0, 0, 0, 0.5);
      border-radius: 50%;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      opacity: 0;
      transition: opacity 0.3s ease-in-out;
      z-index: 1000;
    }

    #back-button:hover {
      opacity: 1;
    }

    .info-card .display-4 {
      font-weight: 600;
      color: #333;
    }

    .table-antrian tbody tr td {
      padding-top: 1rem;
      padding-bottom: 1rem;
      font-size: 1.1rem;
      vertical-align: middle;
    }
  </style>
</head>

<body>
  <script>
    function updateMonitor() {
      $.ajax({
        url: '<?php echo base_url("antrian/panel_antrian/get_update"); ?>',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response.dipanggil) {
            $('#nomor_panggil').text(response.dipanggil.no_antrian);
            $('#poli_panggil').text(response.dipanggil.nama_poli);
            $('#dokter_panggil').text(response.dipanggil.nama_dokter);
          } else {
            $('#nomor_panggil').text('-');
            $('#poli_panggil').text('Belum ada panggilan');
            $('#dokter_panggil').text('-');
          }

          if (response.stats) {
            $('#total_antrian').text(response.stats.total_antrian);
          }

          let tableRows = '';
          if (response.selanjutnya && response.selanjutnya.length > 0) {
            response.selanjutnya.forEach(item => {
              tableRows += `
                                <tr>
                                    <td class="text-center h5 fw-bold">${item.no_antrian}</td>
                                    <td>${item.nama_pasien}</td>
                                    <td>${item.nama_poli}</td>
                                </tr>
                            `;
            });
          } else {
            tableRows = '<tr><td colspan="3" class="text-center">Tidak ada antrian lagi</td></tr>';
          }
          $('#antrian_selanjutnya').html(tableRows);
        }
      });
    }

    $(document).ready(function() {
      updateMonitor();
      setInterval(updateMonitor, 5000);
    });
  </script>

  <a href="javascript:history.back()" id="back-button" title="Kembali">
    <i class="fas fa-arrow-left"></i>
  </a>

  <div class="container-fluid">
    <div class="row mt-5">
      <div class="col-12 col-md-4">
        <div class="card info-card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <i class="las la-list-ol display-4 text-primary"></i>
              </div>
              <div class="flex-grow-1 ms-3">
                <span class="display-4" id="nomor_panggil"><?php echo $dipanggil->no_antrian ?? '-'; ?></span>
                <h6 class="text-uppercase text-muted mt-2 m-0 font-12">Antrian Dipanggil</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="card info-card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <i class="las la-clinic-medical display-4 text-success"></i>
              </div>
              <div class="flex-grow-1 ms-3">
                <div>
                  <h6 class="text-uppercase text-muted m-0 font-12">NAMA POLI</h6>
                  <h4 class="fw-bold" id="poli_panggil"><?php echo $dipanggil->nama_poli ?? '-'; ?></h4>
                </div>
                <hr class="my-2">
                <div>
                  <h6 class="text-uppercase text-muted m-0 font-12">NAMA DOKTER</h6>
                  <p class="m-0 font-14" id="dokter_panggil"><?php echo $dipanggil->nama_dokter ?? '-'; ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="card info-card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <i class="las la-users display-4 text-warning"></i>
              </div>
              <div class="flex-grow-1 ms-3">
                <span class="display-4" id="total_antrian"><?php echo $stats['total_antrian'] ?? 0; ?></span>
                <h6 class="text-uppercase text-muted mt-2 m-0 font-12">Total Antrian Hari Ini</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Antrian Berikutnya</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped mb-0 table-antrian">
            <thead class="thead-light">
              <tr>
                <th class="text-center">Nomor</th>
                <th>Nama Pasien</th>
                <th>Poli</th>
              </tr>
            </thead>
            <tbody id="antrian_selanjutnya"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src="<?php echo base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/libs/feather-icons/feather.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/pages/sweet-alert.init.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
  <script src="<?php echo base_url() ?>/assets/js/pagination.js"></script>
  <script src="<?php echo base_url() ?>/assets/js/js-form.js"></script>
  <script src="<?php echo base_url() ?>assets/libs/vanillajs-datepicker/js/datepicker-full.min.js"></script>
</body>

</html>