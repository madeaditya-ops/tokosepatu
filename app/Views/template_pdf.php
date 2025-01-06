<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .kop {
            text-align: center;
            margin-bottom: 20px;
        }
        .kop img {
            width: 80px; /* Sesuaikan ukuran logo */
        }
        .kop h1 {
            margin: 0;
            font-size: 20px;
        }
        .kop p {
            margin: 2px 0;
            font-size: 12px;
        }
        .line {
            border-bottom: 2px solid black;
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="kop">
        <h1>Nama Instansi</h1>
        <p>Alamat: Jl. Contoh No. 123, Kota, Provinsi</p>
        <p>Telepon: (021) 123456789 | Email: info@contoh.com</p>
        <div class="line"></div>
    </div>

    <h2><?= $title ?></h2>
    <table>
    <thead>
                <tr>
                    <th scope="col" class="text-start">No Faktur</th>
                    <th scope="col" >Tanggal</th>
                    <th scope="col" >Nama Pelanggan</th>
                    <th scope="col" >Nama Produk</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Diskon</th>
                    <th scope="col">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($laporan)): ?>
                    <?php foreach ($laporan as $row): ?>
                        <tr>
                            <td><?= esc($row['faktur']); ?></td>
                            <td><?= esc($row['tanggal']); ?></td>
                            <td><?= esc($row['namaMember']); ?></td>
                            <td><?= esc($row['namaProduk']); ?></td>
                            <td><?= esc($row['jml']); ?></td>
                            <td><?='Rp  '.esc(number_format($row['harga'], 0, ',', '.')); ?></td>
                            <td><?= esc($row['diskon']); ?></td>
                            <td><?='Rp  '.esc(number_format($row['totalharga'], 0, ',', '.')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data user</td>
                    </tr>
                <?php endif; ?>
            </tbody>
    </table>
</body>
</html>
