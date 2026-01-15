<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
            <small>Sistem Informasi Inventaris Barang</small>
        </h1>
    </section>

    <section class="content">
        <!-- Pesan Selamat Datang -->
        <div class="callout callout-info">
            <h4><i class="fa fa-info"></i> Selamat Datang!</h4>
            <p>Halo <strong><?= $this->session->userdata('nama') ?></strong>,
                Anda login sebagai <strong><?= $this->session->userdata('nama_role') ?></strong></p>
        </div>

        <?php if (in_array(get_role_name(), ['Admin', 'Petugas Inventaris'])): ?>
            <!-- Widget Statistik untuk Admin & Petugas -->
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?= $total_barang ?></h3>
                            <p>Total Barang</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-cube"></i>
                        </div>
                        <a href="<?= site_url('barang') ?>" class="small-box-footer">
                            Lihat Detail <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?= $total_peminjaman_aktif ?></h3>
                            <p>Peminjaman Aktif</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <a href="<?= site_url('peminjaman') ?>" class="small-box-footer">
                            Lihat Detail <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?= $total_pengembalian ?></h3>
                            <p>Total Pengembalian</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-check-circle"></i>
                        </div>
                        <a href="<?= site_url('pengembalian') ?>" class="small-box-footer">
                            Lihat Detail <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?= count($barang_stok_menipis) ?></h3>
                            <p>Stok Menipis</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-exclamation-triangle"></i>
                        </div>
                        <a href="<?= site_url('barang') ?>" class="small-box-footer">
                            Lihat Detail <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tabel Barang Stok Menipis -->
            <?php if (count($barang_stok_menipis) > 0): ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-warning"></i> Barang dengan Stok Menipis</h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah Tersisa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($barang_stok_menipis as $b): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($b->KODE_BARANG, ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= htmlspecialchars($b->NAMA_BARANG, ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><span class="label label-danger"><?= $b->JUMLAH ?></span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Peminjaman User -->
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-list"></i> Peminjaman Saya</h3>
                    </div>
                    <div class="box-body">
                        <?php if (count($peminjaman_user) > 0): ?>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($peminjaman_user as $p): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $p->TANGGAL_PINJAM ?></td>
                                            <td><?= $p->TANGGAL_KEMBALI ?></td>
                                            <td>
                                                <?php if ($p->STATUS_PEMINJAMAN == 'Dipinjam'): ?>
                                                    <span class="label label-warning">Dipinjam</span>
                                                <?php else: ?>
                                                    <span class="label label-success">Dikembalikan</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?= site_url('peminjaman/detail/' . $p->PEMINJAMAN_ID) ?>"
                                                    class="btn btn-xs btn-info">
                                                    <i class="fa fa-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="text-muted">Anda belum memiliki riwayat peminjaman.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Log Aktivitas -->
            <div class="col-md-4">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-history"></i> Log Aktivitas Saya</h3>
                    </div>
                    <div class="box-body">
                        <?php if (count($log_aktivitas) > 0): ?>
                            <ul class="list-unstyled">
                                <?php foreach ($log_aktivitas as $log): ?>
                                    <li style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #f4f4f4;">
                                        <small class="text-muted"><?= $log->WAKTU ?></small><br>
                                        <span><?= htmlspecialchars($log->AKTIVITAS, ENT_QUOTES, 'UTF-8') ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-muted">Belum ada aktivitas.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>