<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengembalian</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 8px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; margin-bottom: 5px; }
        p { text-align: center; font-size: 11px; margin-top: 0; }
    </style>
</head>
<body>
    <h2>LAPORAN PENGEMBALIAN BARANG</h2>
    <p>Periode: <?= $periode; ?></p>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">ID Kembali</th>
                <th width="30%">Nama Peminjam</th>
                <th width="20%">Tgl Kembali</th>
                <th width="30%">Catatan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pengembalian)) : ?>
                <?php $no = 1; foreach ($pengembalian as $p) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>#<?= $p->PENGEMBALIAN_ID ?></td>
                        <td><?= $p->NAMA_PEMINJAM ?></td>
                        <td><?= $p->TANGGAL_DIKEMBALIKAN ?></td>
                        <td><?= $p->CATATAN ? $p->CATATAN : '-' ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr><td colspan="5" align="center">Data tidak ditemukan</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>