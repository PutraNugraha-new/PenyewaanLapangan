<div class="container my-3" style="height:75vh;">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">Selamat Datang</h2>
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
    <?php if ($this->session->flashdata('success_message')): ?>
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success_message'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <div class="row my-2 d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card bg-light">
                <div class="card-body">
                    <form action="<?= base_url() ?>welcome/loginUser" method="post">
                        <div class="row my-3">
                            <div class="col-sm-12 text-center">
                                <h4>Login Pelanggan</h4>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-4 col-form-label">Username</label>
                            <div class="col-sm-7">
                                <input type="username" class="form-control" id="username" name="username" placeholder="Masukan username">
                                <span class="text-danger">
                                    <?php echo form_error('username') ?>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-4 col-form-label">Password</label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control mb-2" id="password" name="password" placeholder="Masukan Password">
                                <span class="text-danger">
                                    <?php echo form_error('password') ?>
                                </span>
                                <a href="<?= base_url() ?>welcome/forgot">Lupa Password</a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="reset" class="btn btn-danger mx-1">Batal</button>
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <a href="<?= base_url() ?>welcome/registrasi">
                                Belum punya akun?
                            </a>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>