<script type="text/javascript">
  $(document).ready(function() {
    get_data()
    $("#jumlah_tampil").change(function() {
      get_data();
    })
  })

  function get_data() {
    let cari = $('#cari').val();
    let hitung_baris = $(`#table-data thead tr th`).length
    $.ajax({
      url: '<?php echo base_url(); ?>admin/user/result_data',
      data: {
        cari
      },
      type: "POST",
      dataType: "json",
      beforeSend: () => {
        let loading = `<tr id="tr-loading"><td colspan="${hitung_baris}" class="text-center"><img src="<?php echo base_url(); ?>assets/loading-table.gif" width="60" alt="loading"></td></tr>`;
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
                              <td>${item.nama}</td>
                              <td>${item.username}</td>
                              <td>${item.level}</td>
                              <td>${item.status}</td>
                              <td>
                                  <div class="text-center">
                                      <button type="button" class="btn btn-shadow btn-sm btn-warning" title="Detail" onclick="showDetail(${item.id})"><i class="fas fa-eye"></i></button>
                                      <a href="<?php echo base_url(); ?>admin/user/view_edit/${item.id}"><button type="button" class="btn btn-shadow btn-sm btn-info" title="Edit"><i class="fas fa-pencil-alt"></i></button></a>
                                      <button type="button" class="btn btn-shadow btn-sm btn-danger" title="Hapus" onclick="hapus(${item.id})"><i class="fas fa-trash-alt"></i></button>
                                  </div>
                              </td>
                          </tr>
                      `;
            i++
          }
        } else {
          table += `<tr><td colspan="${hitung_baris}" class="text-center">Data Kosong</td></tr>`;
        }
        $('#table-data tbody').html(table);
        paging();
      },
      complete: () => {
        $(`#tr-loading`).hide()
      }
    });
    $('#cari').off('keyup').keyup(function() {
      get_data();
    });
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

  function showDetail(id) {
    $.ajax({
      url: '<?php echo base_url("admin/user/get_detail_user"); ?>',
      type: 'POST',
      data: {
        id: id
      },
      dataType: 'json',
      success: function(data) {
        if (data) {
          $('#det_nama').text(data.nama_pegawai);
          $('#det_username').text(data.username);
          $('#det_level').text(data.nama_level);
          $('#det_status').text(data.status);
          $('#det_jabatan').text(data.jabatan_asli);
          $('#detailUserModal').modal('show');
        }
      }
    });
  }

  function hapus(id) {
    Swal.fire({
      title: "Apakah Anda Yakin?",
      text: "Menghapus Data Saat Ini",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Iya, Dihapus",
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?php echo base_url(); ?>admin/user/hapus',
          method: 'POST',
          data: {
            id
          },
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
                    get_data();
                  }
                })
            } else {
              Swal.fire({
                title: 'Gagal!',
                text: res.message,
                icon: "error",
                confirmButtonColor: "#35baf5",
                confirmButtonText: "Oke"
              });
            }
          }
        })
      }
    })
  }
</script>
<div class="container-fluid">
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
          <a href="<?php echo base_url(); ?>admin/user/view_tambah">
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
                <input type="text" class="form-control" id="cari" placeholder="Cari Nama / Username">
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table mb-0 table-hover" id="table-data">
              <thead class="thead-light">
                <tr>
                  <th>#</th>
                  <th>Nama Pegawai</th>
                  <th>Username</th>
                  <th>Level</th>
                  <th>Status</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody></tbody>
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
<div class="modal fade" id="detailUserModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title m-0" id="detailUserLabel">Detail User</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-4">
          <label class="form-label fw-bold mb-0">Nama Pegawai:</label>
          <div class="text-muted" id="det_nama">-</div>
        </div>

        <div class="mb-4">
          <label class="form-label fw-bold mb-0">Username:</label>
          <div class="text-muted" id="det_username">-</div>
        </div>

        <div class="mb-4">
          <label class="form-label fw-bold mb-0">Level Akses:</label>
          <div class="text-muted" id="det_level">-</div>
        </div>

        <div class="mb-4">
          <label class="form-label fw-bold mb-0">Jabatan (Kepegawaian):</label>
          <div class="text-muted" id="det_jabatan">-</div>
        </div>

        <div class="mb-3">
          <label class="form-label fw-bold d-block mb-1">Status Akun:</label>
          <span class="badge bg-success" id="det_status">Active</span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>