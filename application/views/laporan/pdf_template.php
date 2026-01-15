<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 8px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; margin-bottom: 5px; }
        p { text-align: center; font-size: 10px; margin-top: 0; }
    </style>
</head>
<body>
    <h2>LAPORAN PEMINJAMAN BARANG</h2>
    <p>Periode: <?= $periode; ?></p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Peminjaman</th>
                <th>Nama Peminjam</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($peminjaman as $p): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td>#<?= $p->PEMINJAMAN_ID ?></td>
                    <td><?= $p->NAMA_PEMINJAM ?></td>
                    <td><?= $p->TANGGAL_PINJAM ?></td>
                    <td><?= $p->TANGGAL_KEMBALI ?></td>
                    <td><?= $p->STATUS_PEMINJAMAN ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>