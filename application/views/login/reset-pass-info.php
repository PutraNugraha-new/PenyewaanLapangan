<div class="container my-3" style="height:75vh;">
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
                    <p>Mohon Cek Inbox atau folder Spam anda di Gmail</p>
                </div> 
            </div>
        </div>
    </div>
</div>