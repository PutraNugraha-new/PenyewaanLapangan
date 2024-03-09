<?php if ($this->session->flashdata('success_message')): ?>
    <div class="alert alert-success alert-dismissible fade show mt-1" role="alert">
        <?= $this->session->flashdata('success_message'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('flash_message')): ?>
    <div class="alert alert-danger alert-dismissible fade show mt-1" role="alert">
        <?= $this->session->flashdata('flash_message'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<div class="card mt-3">
    <div class="card-header">
        <div class="row">
            <div class="col-md-4">
                <button type="button" class="btn btn-tambah btn-warning text-light" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="bi bi-plus-circle"></i>
                    Tambah Data
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Username</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Username</th>
                    <th>Aksi</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach($pengguna as $data): ?>
                    <tr>
                        <td><?= $data->nama ?></td>
                        <td><?= $data->username ?></td>
                        <td>
                            <a href="#" data-bs-toggle="modal" data-id="<?= $data->id_admin ?>" data-bs-target="#exampleModal" class="tampilModalUbah btn btn-success">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            <a href="<?= base_url() ?>pengguna/hapus/<?= $data->id_admin ?>" onClick="return confirm('Apakah Anda Ingin Menghapus Data?')" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Pengguna</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="pengguna/add" class="form form-horizontal" method="POST">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Nama Pengguna</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="hidden" id="id" class="form-control" name="id_admin" placeholder="Nama Pengguna" required>
                        <input type="text" id="nama" class="form-control" name="nama" placeholder="Nama Pengguna" required>
                        <?php echo form_error('nama');?>
                    </div>
                    
                    <div class="col-md-4">
                        <label>Username</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" id="username" class="form-control my-2" name="username" placeholder="Username" required>
                        <?php echo form_error('username');?>
                    </div>
                    
                    <div class="col-md-4 lab-pass">
                        <label>Password</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" id="password" class="form-control" name="password" placeholder="password" required>
                        <?php echo form_error('password');?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        $('.btn-tambah').on('click', function() {
            $('#exampleModalLabel').html('Tambah Pengguna');
            $('.modal-body form').attr('action', 'pengguna/add');
            $('#nama').val('');
            $('#username').val('');
            $('#password').prop('disabled', false);
            $('#password').prop('hidden', false);
            $('.lab-pass').prop('hidden', false);
            $('#password').val('');
            $('#id').prop('disabled', true);
            $('#id').prop('hidden', true);
            
        });
        $('.tampilModalUbah').on('click', function() {
            const id = $(this).data('id');
            console.log(id);
            $('#exampleModalLabel').html('Ubah Pengguna');
            $('.modal-body form').attr('action', 'pengguna/update/'+id);

            $.ajax({
                url: 'pengguna/edit',
                data: {id : id},
                method: 'post',
                dataType:'json',
                success:function(data){
                    $('#nama').val(data.nama);
                    $('#username').val(data.username);
                    $('#id').prop('disabled', false);
                    $('#id').val(data.id_admin);
                    $('#password').prop('disabled', true);
                    $('#password').prop('hidden', true);
                    $('.lab-pass').prop('hidden', true);
                }
            });
        });
    });
</script>