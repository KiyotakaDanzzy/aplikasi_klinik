<script type="text/javascript">
    $(document).ready(function () {
    let $rows = $('#data-jadwal tr');

    function paging($selector){
        let jumlah_tampil = $('#jumlah_tampil').val();

        if(typeof $selector == 'undefined') {
            $selector = $rows;
        }

        window.tp = new Pagination('#pagination', {
            itemsCount: $selector.length,
            pageSize: parseInt(jumlah_tampil),
            onPageSizeChange: function (ps) {
                console.log('Jumlah tampil berubah ke ' + ps);
            },
            onPageChange: function (paging) {
                var start = paging.pageSize * (paging.currentPage - 1),
                    end = start + paging.pageSize;

                $selector.hide();
                for (var i = start; i < end; i++) {
                    $selector.eq(i).show();
                }
            }
        });
    }

    paging();

    $('#jumlah_tampil').on('change', function () {
        paging();
    });
});

    function hapusEntry(id_jadwal, nama_dokter, hari) {
        Swal.fire({
            title: "Anda Yakin?",
            text: "Hapus jadwal " + nama_dokter + " pada hari " + hari + "?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url("kepegawaian/jadwal_dokter/hapus_entry/"); ?>' + id_jadwal,
                    type: 'POST',
                    dataType: 'json',
                    success: function(res) {
                        if (res.status) {
                            Swal.fire('Terhapus!', res.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Gagal!', res.message, 'error');
                        }
                    }
                });
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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('kepegawaian/jadwal_dokter'); ?>">Dokter</a></li>
                        <li class="breadcrumb-item active">Jadwal Dokter</li>
                    </ol>
                </div>
                <h4 class="page-title">Detail <?php echo $title; ?></h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center pt-3 pb-3">
                    <h4 class="card-title">Jadwal Dokter: <?php echo $dokter['nama_pegawai']; ?> (<?php echo $dokter['nama_poli']; ?>)</h4>
                    <div class="d-flex">
                    <a href="<?php echo base_url('kepegawaian/jadwal_dokter'); ?>">
                        <button type="button" class="btn btn-warning"><i class="fas fa-reply me-2"></i>Kembali</button>
                    </a>
                    <a href="<?php echo base_url('kepegawaian/jadwal_dokter/view_edit/' . $dokter['id']); ?>">
                        <button type="button" class="btn btn-success ms-2"><i class="fas fa-plus me-2"></i>Tambah</button>
                    </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0 table-centered">
                            <thead>
                                <tr class="table-info">
                                    <th>Hari</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="data-jadwal">
                                <?php if (!empty($jadwal)) {
                                    foreach ($jadwal as $j) { ?>
                                        <tr>
                                            <td><?php echo $j['hari']; ?></td>
                                            <td><?php echo $j['jam_mulai']; ?></td>
                                            <td><?php echo $j['jam_selesai']; ?></td>
                                            <td class="text-center">
                                                <a href="<?php echo base_url('kepegawaian/jadwal_dokter/view_edit_entry/' . $j['id']); ?>" class="btn btn-sm btn-info" title="Edit Hari Ini"><i class="fas fa-pencil-alt"></i></a>
                                                <button type="button" class="btn btn-sm btn-danger" title="Hapus Hari Ini" onclick="hapusEntry('<?php echo $j['id']; ?>', '<?php echo $j['nama_pegawai']; ?>', '<?php echo $j['hari']; ?>')"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Dokter ini belum memiliki jadwal</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-6">
                            <div id="pagination"></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-md-6">&nbsp;</div><label class="col-md-3 control-label d-flex align-items-center justify-content-end">Jumlah Tampil</label>
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
</div>