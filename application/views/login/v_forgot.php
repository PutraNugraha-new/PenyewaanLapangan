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
    <div class="row my-2 d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card bg-light">
                <div class="card-body">
                    <form action="<?= base_url() ?>welcome/forgot" method="post">
                        <div class="row my-3">
                            <div class="col-sm-12 text-center">
                                <h4>Forgot Password</h4>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-7">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Masukan email Terdaftar">
                                <span class="text-danger">
                                    <?php echo form_error('email') ?>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="reset" class="btn btn-danger mx-1">Batal</button>
                                <button type="submit" class="btn btn-primary">Kirim Email</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <a href="<?= base_url() ?>welcome/login">
                                Sudah punya akun
                            </a>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>