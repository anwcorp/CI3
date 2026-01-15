<!DOCTYPE html>
<html>

<head>
    <title><?= $title ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th {
            background-color: #f0f0f0;
            padding: 8px;
            text-align: left;
        }

        td {
            padding: 6px;
        }

        .footer {
            margin-top: 50px;
            text-align: right;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>SISTEM INVENTARIS BARANG</h2>
        <h3>LAPORAN DATA BARANG</h3>
        <p>Tanggal Cetak: <?= date('d-m-Y H:i:s') ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Kondisi</th>
                <th>Jumlah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($barang) > 0): ?>
                <?php $no = 1;
                foreach ($barang as $b): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $b->KODE_BARANG ?></td>
                        <td><?= $b->NAMA_BARANG ?></td>
                        <td><?= $b->NAMA_KATEGORI ?></td>
                        <td><?= $b->NAMA_LOKASI ?> (Lt. <?= $b->LANTAI ?>)</td>
                        <td><?= $b->NAMA_KONDISI ?></td>
                        <td><?= $b->JUMLAH ?></td>
                        <td><?= $b->STATUS_BARANG ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>
            <?= date('d-m-Y') ?><br>
            Petugas Inventaris<br><br><br><br>
            (_________________)
        </p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 30px; font-size: 16px;">
            🖨️ Print Laporan
        </button>
        <button onclick="window.close()" style="padding: 10px 30px; font-size: 16px;">
            ❌ Tutup
        </button>
    </div>

    <script>
        // Auto print saat halaman dibuka (opsional)
        // window.onload = function() { window.print(); }
    </script>
</body>

</html>