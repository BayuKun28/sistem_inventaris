<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cetak</title>
</head>

<body>
    <div style="width:auto; margin: auto;">
        <center>
            <h3>Laporan Elektronik </h3>
            <table border="1" width="100%" style="border-collapse:collapse;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Nomor Seri</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($elektronik as $b) : ?>
                    <tr>
                        <td><?= $i; ?></td>
                        <td><?= $b['nama_barang']; ?></td>
                        <td><?= $b['nomor_seri_barang']; ?></td>
                        <td><?= $b['jumlah']; ?> Buah</td>
                        <td><?= $b['kondisi']; ?></td>
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