<div class="content-wrapper">
    <section class="content-header">
        <h1>Detail Pengembalian Barang</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Informasi Pengembalian</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">ID Pengembalian</th>
                                <td><span class="label label-success">#<?= $pengembalian->PENGEMBALIAN_ID ?></span></td>
                            </tr>
                            <tr>
                                <th>ID Peminjaman</th>
                                <td><span class="label label-warning">#<?= $pengembalian->PEMINJAMAN_ID ?></span></td>
                            </tr>
                            <tr>
                                <th>Nama Peminjam</th>
                                <td><?= htmlspecialchars($pengembalian->NAMA_PEMINJAM, ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?= htmlspecialchars($pengembalian->EMAIL, ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Dikembalikan</th>
                                <td><i class="fa fa-calendar"></i> <?= $pengembalian->TGL_DIKEMBALIKAN ?></td>
                            </tr>
                            <tr>
                                <th>Catatan</th>
                                <td><?= htmlspecialchars($pengembalian->CATATAN, ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Detail Barang yang Dikembalikan</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Kembali</th>
                            <th>Kondisi Setelah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($detail as $d): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($d->KODE_BARANG, ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($d->NAMA_BARANG, ENT_QUOTES, 'UTF-8') ?></td>
                                <td><span class="badge bg-blue"><?= $d->JUMLAH_KEMBALI ?></span></td>
                                <td>
                                    <span class="label label-<?= $d->KONDISI_SETELAH_NAMA == 'Baik' ? 'success' : ($d->KONDISI_SETELAH_NAMA == 'Rusak Ringan' ? 'warning' : 'danger') ?>">
                                        <?= htmlspecialchars($d->KONDISI_SETELAH_NAMA, ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <a href="<?= site_url('pengembalian') ?>" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </section>
</div>