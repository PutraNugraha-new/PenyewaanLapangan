<?php if ($this->session->flashdata('flash_message')): ?>
    <div class="alert alert-success alert-dismissible fade show mt-1" role="alert">
        <?= $this->session->flashdata('flash_message'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?><div class="card mt-3">
    <div class="card-header">
        <div class="row">
            <div class="col-md-5">
                <h2>Laporan</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="<?= base_url() ?>laporan/getData" method="get">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="start_date">Tanggal Awal:</label>
                            <input type="date" id="start_date" class="form-control" name="tgl_awal">
                        </div>
                        <div class="col-md-2">
                            <label for="end_date">Tanggal Akhir:</label>
                            <input type="date" id="end_date" class="form-control" name="tgl_akhir">
                        </div>
                        <div class="col-md-2">
                            <br>
                            <button type="submit" id="filter_button" class="btn btn-primary">Tampilkan</button>
                            <button type="reset" class="btn btn-danger">Batal</button>
                        </div>
                        <span class="text-warning">Rentang Berdasarkan Tanggal Main</span>
                    </div>
                </form>
                <a href="<?= base_url() ?>laporan/cetakLaporan?tgl_awal=<?= $this->input->get('tgl_awal') ?>&tgl_akhir=<?= $this->input->get('tgl_akhir') ?>" class="btn btn-success my-2">Cetak</a>
            </div>
        </div>
    </div>
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
                            <?= $data->status ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

