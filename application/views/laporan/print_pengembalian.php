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

        .periode {
            text-align: center;
            margin: 10px 0;
            font-weight: bold;
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
        <h3>LAPORAN PENGEMBALIAN BARANG</h3>
        <p>Tanggal Cetak: <?= date('d-m-Y H:i:s') ?></p>
    </div>

    <div class="periode">
        Periode: <?= date('d-m-Y', strtotime($tanggal_dari)) ?> s/d <?= date('d-m-Y', strtotime($tanggal_sampai)) ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Pengembalian</th>
                <th>Nama Peminjam</th>
                <th>Tanggal Dikembalikan</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($pengembalian) > 0): ?>
                <?php $no = 1;
                foreach ($pengembalian as $p): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>#<?= $p->PENGEMBALIAN_ID ?></td>
                        <td><?= $p->NAMA_PEMINJAM ?></td>
                        <td><?= $p->TANGGAL_DIKEMBALIKAN ?></td>
                        <td><?= $p->CATATAN ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data</td>
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
</body>

</html>