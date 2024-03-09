<div class="container" style="height:75vh;">
    <div class="row my-3" id="filteredResults">
        <div class="col-md-12 col-12 my-2">
            <div class="card shadow rounded-1">
                <div class="card-header text-center">
                    <p>Untuk Pembayaran silahkan Transfer ke</p>
                    <p>1234567 (Adrisuseno)</p>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Kode Pesanan</th>
                                <th>No Lapangan</th>
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
                                <th>Tanggal main</th>
                                <th>Jam Main</th>
                                <th>Lama Main</th>
                                <th>Total Bayar</th>
                                <th>Status</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach($riwayat as $data): ?>
                                <tr>
                                    <td><?= $data->kode_pemesanan ?></td>
                                    <td><?= $data->no_lapangan ?></td>
                                    <td><?= $data->tgl_main ?></td>
                                    <td><?= $data->jam_dipesan ?></td>
                                    <td><?= $data->jam_bermain ?> Jam</td>
                                    <td>Rp. <?= $data->total_bayar ?></td>
                                    <td>
                                        <span class="badge p-2 <?= $data->status == 'proses' ? 'badge-danger' : 'badge-primary'  ?>">
                                            <?php if($data->status == 'disewa') : ?>
                                                Berhasil Disewa
                                            <?php else: ?>
                                                <?= $data->status ?>
                                            <?php endif; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>               
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('.close').click(function(){
        // Merefresh halaman
        location.reload();
    });
    $('#exampleModal').on('hidden.bs.modal', function () {
        // Merefresh halaman
        alert('test');
    });

    $('.pra-pesan').click(function() {
        var id = $(this).data('id');
        $('.modal-title').html('Pesan Lapangan ' + id);
        $('#no_lapangan').val(id);
    });

    $('#tgl_main').change(function () {
        var tgl = $(this).val();
        var noLapangan = $('#no_lapangan').val();

        $.ajax({
            url: 'getJadwal',
            data: {
                tgl_main : tgl,
                no_lapangan : noLapangan,
            },
            method: 'post',
            dataType:'json',
            success:function(data){
                // console.log(data);
                handleResponse(data);
            }
        });

    });
    function handleResponse(data) {
        // Mengaktifkan kembali semua checkbox
        $('input[type="checkbox"]').prop('disabled', false);
        
        // Loop melalui data yang diterima
        $.each(data, function(index, jam) {
            // Men-disable checkbox dengan nilai jam yang diterima
            $('input[type="checkbox"][value="'+jam+'"]').prop('disabled', true);
        });
    }
    // Menambahkan event listener ke setiap checkbox
    $('input[type="checkbox"]').change(function(){
        var totalJam = 0;
        // Array untuk menyimpan waktu yang dipilih
        var selectedTimes = [];
        // Loop melalui checkbox yang dicentang
        $('input[type="checkbox"]:checked').each(function(){
            // Mendapatkan nilai checkbox (jam awal - jam akhir)
            var value = $(this).val();
            // Memisahkan jam awal dan jam akhir
            var times = value.split('-');
            // Menambahkan ke array selectedTimes
            selectedTimes.push({start: parseInt(times[0]), end: parseInt(times[1])});
        });
        // Jika ada waktu yang dipilih
        if (selectedTimes.length > 0) {
            // Mengurutkan waktu terkecil ke terbesar
            selectedTimes.sort(function(a, b) {
                return a.start - b.start;
            });
            // Menghitung selisih waktu antara jam awal dan jam akhir
            totalJam = selectedTimes[selectedTimes.length - 1].end - selectedTimes[0].start;
        }
        // Menetapkan nilai total jam ke elemen dengan id "total_jam"
        $('#total_jam').text(totalJam + " jam");

        // Menghitung total bayar
        var totalBayar = totalJam * 40000;
        // Menetapkan nilai total bayar ke elemen dengan id "total_bayar"
        $('#total_bayar').text("Rp " + totalBayar.toLocaleString());

        $('#jam_bermain').val(totalJam);
        $('#total_bayarr').val(totalBayar);
    });
});
</script>
