<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cetak</title>
</head>

<body>
    <div style="width:auto; margin: auto;">
        <center>
            <h3>Laporan Kendaraan </h3>
            <table border="1" width="100%" style="border-collapse:collapse;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Pol</th>
                        <th>Jenis Ranmor</th>
                        <th>Merk</th>
                        <th>Tipe Ranmor</th>
                        <th>Unit Pengguna</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($kendaraan as $b) : ?>
                    <tr>
                        <td><?= $i; ?></td>
                        <td><?= $b['no_pol']; ?></td>
                        <td><?= $b['jenis_ranmor']; ?></td>
                        <td><?= $b['merk']; ?></td>
                        <td><?= $b['tipe_ranmor']; ?></td>
                        <td><?= $b['unit_pengguna']; ?></td>
                    </tr>
                    <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div style="width: 35%; text-align: center; float: right;">Surakarta, <?= $hariini; ?> <br>
                KANIT GAKKUM, <br> <br> <br> <br>
                <u>SUHARTO, SH</u> <br>
                IPTU NRP 69060262
            </div><br><br><br><br><br><br>
        </center>
    </div>
</body>

</html>