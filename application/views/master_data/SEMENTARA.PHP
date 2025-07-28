<!-- Main-body start-->
  <div class="main-body">
      <div class="page-wrapper">
          <div class="page-header">
              <div class="page-header-title">
                  <h4>Pengeluaran</h4>
              </div>
              <div class="page-header-breadcrumb">
                  <ul class="breadcrumb-title">
                      <li class="breadcrumb-item">
                              <i class="ti-money"></i>
                      </li>
                      <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>pengeluaran">Pengeluaran</a>
                      </li>
                      <li class="breadcrumb-item">Tambah Pengeluaran
                      </li>
                  </ul>
              </div>
          </div>
          <div class="page-body">
              <div class="row">
                <div class="col-sm-12">
                        <!-- Panel card start -->
                        <div class="card">
                            <div class="card-header">
                                <h5>Tambah Pengeluaran</h5>
                                <div class="card-header-right">
                                    <i class="icofont icofont-rounded-down"></i>
                                </div>
                            </div>
                            <div class="card-block panels-wells">
                              <form action="<?php echo base_url(); ?>pengeluaran/tambah" method="POST">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Outlet</label>
                                        <div class="col-sm-10">
                                          <input readonly type="text" name="nama_outlet" class="form-control" value="<?php echo $this->session->userdata('nama_outlet'); ?>" required>
                                          <input type="hidden" name="id_outlet" value="<?php echo $this->session->userdata('id_outlet'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Jenis Biaya</label>
                                        <div class="col-sm-10">
                                            <select class="js-example-basic-single col-sm-12" name="nama_pengeluaran">
                                                <?php foreach ($jenis_biaya as $j): ?>
                                                <option value="<?php echo $j['id']; ?>"><?php echo $j['nama_jenis_biaya']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Nominal</label>
                                        <div class="col-sm-10">
                                          <div class="input-group">
                                            <span class="input-group-addon">Rp</span>
                                            <input type="text" name="nominal" class="form-control" onkeyup="FormatCurrency(this);" required>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Keterangan</label>
                                        <div class="col-sm-10">
                                            <textarea rows="5" cols="5" name="keterangan" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Tanggal</label>
                                        <div class="col-sm-10">
                                            <input type="date" name="tanggal" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2"></label>
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-primary m-b-0 mr-2"><i class="fa fa-save mr-2"></i>Simpan</button>
                                            <a href="<?php echo base_url('pengeluaran') ?>" name="button" class="btn btn-secondary m-b-0"><i class="fa fa-mail-reply mr-2"></i>Kembali</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Panel card end -->
                    </div>
              </div>
          </div>
      </div>
  </div>
  <!-- Main-body end-->