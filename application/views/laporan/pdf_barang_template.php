<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok Barang</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 8px; text-align: left; font-size: 11px; }
        th { background-color: #f2f2f2; text-transform: uppercase; }
        h2 { text-align: center; margin-bottom: 5px; }
        .footer { margin-top: 20px; text-align: right; font-size: 10px; }
    </style>
</head>
<body>
    <h2>LAPORAN DATA STOK BARANG</h2>
    <p style="text-align:center; font-size:10px;">Dicetak pada: <?= date('d-m-Y H:i'); ?></p>
    
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode Barang</th>
                <th width="30%">Nama Barang</th>
                <th width="20%">Kategori</th>
                <th width="10%">Stok</th>
                <th width="20%">Lokasi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($barang)) : ?>
                <?php $no = 1; foreach ($barang as $b) : ?>
                    <tr>
                        <td align="center"><?= $no++ ?></td>
                        <td><?= $b->KODE_BARANG ?></td>
                        <td><?= htmlspecialchars($b->NAMA_BARANG) ?></td>
                        <td><?= $b->NAMA_KATEGORI ?></td>
                        <td align="center"><?= $b->JUMLAH ?></td>
                        <td><?= $b->NAMA_LOKASI ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr><td colspan="6" align="center">Data barang kosong</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Sistem Informasi Inventaris</p>
    </div>
</body>
</html>