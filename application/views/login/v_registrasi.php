<div class="container my-3">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">Registrasi</h2>
        </div>
    </div>
    <?php if ($this->session->flashdata('flash_message')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('flash_message'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <div class="row my-2 d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card bg-light">
                <div class="card-body">
                    <form action="<?= base_url() ?>welcome/adduserPengguna" method="post">
                        <div class="form-group row">
                            <label for="nama_pelanggan" class="col-sm-4 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" placeholder="Masukan Nama Lengkap">
                                <span class="text-danger">
                                    <?php echo form_error('nama_pelanggan');?>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-4 col-form-label">Username</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Masukan Username">
                                <span class="text-danger">
                                    <?php echo form_error('username');?>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tanggal_lahir" class="col-sm-4 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-7">
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                                <span class="text-danger">
                                    <?php echo form_error('tanggal_lahir');?>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Jenis Kelamin</label>
                            <div class="ms-3 col-sm-7">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin1" value="Laki-Laki">
                                <label class="form-check-label" for="jenis_kelamin1">
                                    Laki-Laki
                                </label><br>
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin2" value="Perempuan">
                                <label class="form-check-label" for="jenis_kelamin2">
                                    Perempuan
                                </label>
                                <span class="text-danger">
                                    <?php echo form_error('jenis_kelamin');?>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="no_hp" class="col-sm-4 col-form-label">No HP</label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" id="no_hp" name="no_hp" placeholder="Masukan No Hp">
                                <span class="text-danger">
                                    <?php echo form_error('no_hp');?>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-7">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Masukan Email">
                                <span class="text-danger">
                                    <?php echo form_error('email') ?>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-4 col-form-label">Password</label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukan Password">
                                <span class="text-danger">
                                    <?php echo form_error('password') ?>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="passconf" class="col-sm-4 col-form-label">Konfirmasi Password</label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control" id="passconf" name="passconf" placeholder="Konfirmasi Password">
                                <span class="text-danger">
                                    <?php echo form_error('passconf') ?>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10 d-flex justify-content-end">
                                <button type="reset" class="btn btn-danger mx-1">Batal</button>
                                <button type="submit" class="btn btn-primary">Daftar</button>
                            </div>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
    </div>
</div>