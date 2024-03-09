<div class="container pemesanan" style="height:75vh;">
    <div class="row my-3 d-flex justify-content-around" id="filteredResults">
        <div class="col-md-3 col-10 my-2">
            <div class="card shadow rounded-1">
                <div class="card-body">
                    <img src="<?= base_url() ?>assets/images/samples/lapangan1.jpeg" style="width:100%;height:200px;" class="img-fluid rounded-3" alt="Lapangan">                
                </div>
                <div class="card-footer">
                    <h4>Lapangan 1</h4>
                    <?php if($this->session->userdata('username')):  ?>
                    <!-- <a href="#" class="btn pra-pesan" data-id="">
                        <i class="fa-solid fa-cart-plus"></i>
                    </a> -->
                    <button type="button" class="btn btn-success pra-pesan" data-id="1" data-toggle="modal" data-target="#exampleModal">
                        Pesan
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-10 my-2">
            <div class="card shadow rounded-1">
                <div class="card-body">
                    <img src="<?= base_url() ?>assets/images/samples/lapangan2.jpeg" style="width:100%;height:200px;" class="img-fluid rounded-3" alt="Lapangan">                
                </div>
                <div class="card-footer">
                    <h4>Lapangan 2</h4>
                    <?php if($this->session->userdata('username')):  ?>
                    <!-- <a href="#" class="btn pra-pesan" data-id="">
                        <i class="fa-solid fa-cart-plus"></i>
                    </a> -->
                    <button type="button" class="btn btn-success pra-pesan" data-id="2" data-toggle="modal" data-target="#exampleModal">
                        Pesan
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-10 my-2">
            <div class="card shadow rounded-1">
                <div class="card-body">
                    <img src="<?= base_url() ?>assets/images/samples/lapangan1.jpeg" style="width:100%;height:200px;" class="img-fluid rounded-3" alt="Lapangan">                
                </div>
                <div class="card-footer">
                    <h4>Lapangan 3</h4>
                    <?php if($this->session->userdata('username')):  ?>
                    <!-- <a href="#" class="btn pra-pesan" data-id="">
                        <i class="fa-solid fa-cart-plus"></i>
                    </a> -->
                    <button type="button" class="btn btn-success pra-pesan" data-id="3" data-toggle="modal" data-target="#exampleModal">
                        Pesan
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row text-center">
            <div class="col-12">
                <span class="text-primary">Informasi Pemesanan :</span>
                <p>Tarif Lapangan Rp. 40.000 per Jam</p>
                <p>Setiap Pemesanan</p>
                <p>Tidak Termasuk Shuttlecock (Bola)</p>
            </div>
        </div>
        <div class="row mx-3">
            <hr>
            <label for="alamat" class="font-weight-bold">Pilih Waktu Pemesanan :</label>
            <form action="<?= base_url() ?>welcome/add" method="post">
                <div class="row mx-auto">
                    <div class="col-12 my-4">
                        <input type="date" id="tgl_main" class="form-control" name="tgl_main">
                    </div>
                    <div class="col-6">
                        <label><input type="checkbox" name="jam[]" value="8-9"> 08.00-09.00</label><br>
                        <label><input type="checkbox" name="jam[]" value="9-10"> 09.00-10.00</label><br>
                        <label><input type="checkbox" name="jam[]" value="10-11"> 10.00-11.00</label><br>
                        <label><input type="checkbox" name="jam[]" value="11-12"> 11.00-12.00</label><br>
                        <label><input type="checkbox" name="jam[]" value="12-13"> 12.00-13.00</label><br>
                        <label><input type="checkbox" name="jam[]" value="13-14"> 13.00-14.00</label><br>
                        <label><input type="checkbox" name="jam[]" value="14-15"> 14.00-15.00</label><br>
                        <label><input type="checkbox" name="jam[]" value="15-16"> 15.00-16.00</label><br>
                    </div>
                    <div class="col-6">
                        <label><input type="checkbox" name="jam[]" value="16-17"> 16.00-17.00</label><br>
                        <label><input type="checkbox" name="jam[]" value="17-18"> 17.00-18.00</label><br>
                        <label><input type="checkbox" name="jam[]" value="18-19"> 18.00-19.00</label><br>
                        <label><input type="checkbox" name="jam[]" value="19-20"> 19.00-20.00</label><br>
                        <label><input type="checkbox" name="jam[]" value="20-21"> 20.00-21.00</label><br>
                        <label><input type="checkbox" name="jam[]" value="21-22"> 21.00-22.00</label><br>
                        <label><input type="checkbox" name="jam[]" value="22-23"> 22.00-23.00</label><br>
                        <label><input type="checkbox" name="jam[]" value="23-24"> 23.00-24.00</label><br>
                    </div>
                </div>
                <input type="hidden" name="id_pelanggan" value="<?= $this->session->userdata('id_pelanggan') ?>" id="id_pelanggan">
                <input type="hidden" name="no_lapangan" id="no_lapangan">
                <input type="hidden" name="jam_bermain" id="jam_bermain">
                <input type="hidden" name="total_bayar" id="total_bayarr">
                <div>Total Jam: <span id="total_jam">0 jam</span></div>
                <div>Total Bayar: <span id="total_bayar">Rp 0</span></div>
                
            </div>
        </div>
        <div class="modal-footer" >
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-tambah" onClick="return confirm('Apakah Ingin Pesan Lapangan?')">Pesan Lapangan</button>
        </div>
    </form>
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
