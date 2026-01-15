<div class="content-wrapper">
    <section class="content-header">
        <h1>Detail Peminjaman</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Informasi Peminjaman</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">ID Peminjaman</th>
                                <td><?= $peminjaman->PEMINJAMAN_ID ?></td>
                            </tr>
                            <tr>
                                <th>Nama Peminjam</th>
                                <td><?= htmlspecialchars($peminjaman->NAMA_PEMINJAM, ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?= htmlspecialchars($peminjaman->EMAIL, ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Pinjam</th>
                                <td><?= $peminjaman->TGL_PINJAM ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Kembali</th>
                                <td><?= $peminjaman->TGL_KEMBALI ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <?php if ($peminjaman->STATUS_PEMINJAMAN == 'Dipinjam'): ?>
                                        <span class="label label-warning">Dipinjam</span>
                                    <?php else: ?>
                                        <span class="label label-success">Dikembalikan</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Detail Barang yang Dipinjam</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Jumlah Pinjam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($detail as $d): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($d->KODE_BARANG, ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($d->NAMA_BARANG, ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($d->NAMA_KATEGORI, ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($d->NAMA_LOKASI, ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= $d->JUMLAH_PINJAM ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <a href="<?= site_url('peminjaman') ?>" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
                <?php if ($peminjaman->STATUS_PEMINJAMAN == 'Dipinjam' && in_array(get_role_name(), ['Admin', 'Petugas Inventaris'])): ?>
                    <a href="<?= site_url('pengembalian/proses/' . $peminjaman->PEMINJAMAN_ID) ?>"
                        class="btn btn-success">
                        <i class="fa fa-check"></i> Proses Pengembalian
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>