<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Laporan</title>

    <style>
        .cetakLaporan tr td{
            font-size:12pt;
        }

        .kop p{
            font-size:12pt;
            font-weight:bold;
            text-align:center;
            margin:0;
        }

        .judul{
            text-align:center;
            font-weight:bold;
        }

        /* Reset some default browser styles for the table */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        /* Add margin to the table headers */
        th {
            padding: 5px; /* Optional: Add padding for better appearance */
            text-align: left;
            background-color: #f2f2f2; /* Optional: Add background color for the headers */
            border:1px solid #000;
            margin-bottom: 10px; /* Add margin to the bottom of the headers */
        }

        /* Add some styles to the table data cells (optional) */
        td {
            padding: 10px; /* Optional: Add padding for better appearance */
            border: 1px solid #000; /* Optional: Add border to the cells */
        }

        /* Optional: Add some styles to the whole table for better appearance */
        .cetakLaporan {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px; /* Add margin to the top of the table */
        }

    </style>
</head>
<body>
<p class="judul">Laporan</p>

<table class="table cetakLaporan" border="1" cellspacing="0">
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

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>