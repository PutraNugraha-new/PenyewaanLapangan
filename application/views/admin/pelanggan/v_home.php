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
                <a href="<?= base_url() ?>pelanggan/add" class="btn btn-warning text-light">
                    <i class="fa-solid fa-plus-circle"></i>
                    Tambah Data
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Id Pel</th>
                    <th>Nama Pel</th>
                    <th>Username</th>
                    <th>No Hp</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Id Pel</th>
                    <th>Nama Pel</th>
                    <th>Username</th>
                    <th>No Hp</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach($pelanggan as $data): ?>
                    <tr>
                        <td><?= $data->id_pelanggan ?></td>
                        <td><?= $data->nama_pelanggan ?></td>
                        <td><?= $data->username ?></td>
                        <td><?= $data->no_hp ?></td>
                        <td><?= $data->email ?></td>
                        <td>
                            <a href="#" data-bs-toggle="modal" data-id="<?= $data->id_pelanggan ?>" data-bs-target="#exampleModal" class="tampilModalUbah btn btn-success">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            <a href="<?= base_url() ?>pelanggan/hapus/<?= $data->id_pelanggan ?>" onClick="return confirm('Apakah Anda Ingin Menghapus Data?')" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
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
        <h5 class="modal-title" id="exampleModalLabel">Edit Pelanggan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="pelanggan/update" class="form form-horizontal" method="POST">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Nama Pelanggan</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="hidden" id="id_pelanggan" class="form-control" name="id_pelanggan" placeholder="Nama Pelanggan" required>
                        <input type="text" id="nama_pelanggan" class="form-control" name="nama_pelanggan" placeholder="Nama Pelanggan" required>
                        <?php echo form_error('nama_pelanggan');?>
                    </div>
                    
                    <div class="col-md-4">
                        <label>Username</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" id="username" class="form-control my-2" name="username" placeholder="Username" required>
                        <?php echo form_error('username');?>
                    </div>
                    
                    <div class="col-md-4">
                        <label>No HP</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="number" id="no_hp" class="form-control  my-2" name="no_hp" placeholder="No HP" required>
                        <?php echo form_error('no_hp');?>
                    </div>
                    
                    <div class="col-md-4">
                        <label>Email</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="email" id="email" class="form-control  my-2" name="email" placeholder="Email" required>
                        <?php echo form_error('email');?>
                    </div>
                    <div class="col-md-4">
                        <label>Jenis Kelamin</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control  my-2">
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        <?php echo form_error('jenis_kelamin');?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="reset" class="btn btn-success me-1 mb-1">Reset</button>
            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        $('.tampilModalUbah').on('click', function() {
            const id = $(this).data('id');
            console.log(id);

            $.ajax({
                url: 'pelanggan/edit',
                data: {id : id},
                method: 'post',
                dataType:'json',
                success:function(data){
                    $('#id_pelanggan').val(data.id_pelanggan);
                    $('#nama_pelanggan').val(data.nama_pelanggan);
                    $('#username').val(data.username);
                    $('#no_hp').val(data.no_hp);
                    $('#email').val(data.email);
                }
            });
        });
    });
</script>