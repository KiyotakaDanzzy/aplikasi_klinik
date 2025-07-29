<script type="text/javascript">
    function filterJadwal() {
        let id_poli = $('#filter_poli').val();
        let jam = $('#filter_jam').val();

        $.ajax({
            url: '<?php echo base_url("resepsionis/jadwal_dokter/Jadwal_dokter/filter_jadwal"); ?>',
            type: 'POST',
            data: {
                id_poli: id_poli,
                jam: jam
            },
            beforeSend: function() {
                $('#schedule-container').html('<div class="text-center p-5"><div class="spinner-border text-primary" role="status"></div><p>Memuat jadwal...</p></div>');
            },
            success: function(response) {
                $('#schedule-container').html(response);
            },
            error: function() {
                $('#schedule-container').html('<p class="text-danger text-center">Gagal memuat jadwal. Silakan coba lagi</p>');
            }
        });
    }

    function hapusJadwalDokter(id_dokter, nama_dokter) {
        Swal.fire({
            title: "Anda Yakin?",
            text: "Menghapus seluruh jadwal milik " + nama_dokter,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Hapus Semua!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo base_url("resepsionis/jadwal_dokter/Jadwal_dokter/hapus_by_dokter/"); ?>' + id_dokter,
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            Swal.fire('Terhapus!', response.message, 'success');
                            filterJadwal();
                        } else {
                            Swal.fire('Gagal!', response.message, 'error');
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
                        <li class="breadcrumb-item"><?php echo $title; ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?php echo $title; ?></h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex flex-wrap gap-2 align-items-center pt-3 pb-3">
                    <h4 class="card-title">Filter Jadwal</h4>
                    <a href="<?php echo base_url('resepsionis/jadwal_dokter/Jadwal_dokter/view_tambah'); ?>" class="btn btn-primary ms-auto">
                        <i class="fas fa-edit me-2"></i>Buat/Kelola Jadwal
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <label for="filter_poli" class="form-label">Filter Berdasarkan Poli</label>
                            <select id="filter_poli" class="form-control" onchange="filterJadwal()">
                                <option value="">Semua Poli</option>
                                <?php foreach ($data_poli as $poli) { ?>
                                    <option value="<?php echo $poli->id; ?>"><?php echo $poli->nama; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label for="filter_jam" class="form-label">Filter Berdasarkan Jam</label>
                            <input type="time" id="filter_jam" class="form-control" onchange="filterJadwal()">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-secondary w-100" onclick="$('#filter_poli').val(''); $('#filter_jam').val(''); filterJadwal();">Reset Filter</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="schedule-container">
        <?php $this->load->view('resepsionis/jadwal_dokter/Partial_jadwal', ['schedule_data' => $schedule_data]); ?>
    </div>
</div>