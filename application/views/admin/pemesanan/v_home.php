<div class="card mt-3">
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Kode Pesanan</th>
                    <th>No Lapangan</th>
                    <th>Nama Pelanggan</th>
                    <th>No Hp</th>
                    <th>Tanggal main</th>
                    <th>Jam Main</th>
                    <th>Lama Main</th>
                    <th>Total Bayar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Kode Pesanan</th>
                    <th>No Lapangan</th>
                    <th>Nama Pelanggan</th>
                    <th>No Hp</th>
                    <th>Tanggal main</th>
                    <th>Jam Main</th>
                    <th>Lama Main</th>
                    <th>Total Bayar</th>
                    <th>Status</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach($pemesanan as $data): ?>
                    <tr>
                        <td><?= $data->kode_pemesanan ?></td>
                        <td><?= $data->no_lapangan ?></td>
                        <td><?= $data->nama_pelanggan ?></td>
                        <td><?= $data->no_hp ?></td>
                        <td><?= $data->tgl_main ?></td>
                        <td><?= $data->jam_dipesan ?></td>
                        <td><?= $data->jam_bermain ?> Jam</td>
                        <td>Rp. <?= $data->total_bayar ?></td>
                        <td>
                            <select class="form-select status" data-id="<?= $data->kode_pemesanan ?>">
                                <option value="proses" <?= ($data->status == 'proses') ? 'selected' : '' ?>>Proses</option>
                                <option value="disewa" <?= ($data->status == 'disewa') ? 'selected' : '' ?>>Disewa</option>
                                <option value="selesai" <?= ($data->status == 'selesai') ? 'selected' : '' ?>>Selesai</option>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>       
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.status').on('change', function() {
            var id = $(this).data('id');
            var newStatus = $(this).val();

            $.ajax({
                url: '<?= base_url("pemesanan/updateProses") ?>',
                data: {
                    id : id,
                    status: newStatus
                },
                method: 'post',
                dataType:'json',
                success:function(response){
                    console.log(response);
                    location.reload();
                }, 
                error: function (xhr, status, error) {
                    console.error("Error: " + status, error);
                }
            });
        });
    });
</script>