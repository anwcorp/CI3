<div class="content-wrapper">
    <section class="content-header">
        <h1>Laporan Sistem Inventaris</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <i class="fa fa-cube fa-5x text-center" style="display: block; color: #3c8dbc; margin-bottom:10px;"></i>
                        <h3 class="profile-username text-center">Laporan Data Barang</h3>
                        <p class="text-muted text-center">Laporan keseluruhan data barang inventaris</p>
                        <a href="<?= site_url('laporan/barang') ?>" class="btn btn-primary btn-block">
                            <i class="fa fa-file-text-o"></i> Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="box box-warning">
                    <div class="box-body box-profile">
                        <i class="fa fa-shopping-cart fa-5x text-center" style="display: block; color: #f39c12; margin-bottom:10px;"></i>
                        <h3 class="profile-username text-center">Laporan Peminjaman</h3>
                        <p class="text-muted text-center">Laporan transaksi peminjaman barang</p>
                        <a href="<?= site_url('laporan/peminjaman') ?>" class="btn btn-warning btn-block">
                            <i class="fa fa-file-text-o"></i> Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="box box-success">
                    <div class="box-body box-profile">
                        <i class="fa fa-check-circle fa-5x text-center" style="display: block; color: #00a65a; margin-bottom:10px;"></i>
                        <h3 class="profile-username text-center">Laporan Pengembalian</h3>
                        <p class="text-muted text-center">Laporan transaksi pengembalian barang</p>
                        <a href="<?= site_url('laporan/pengembalian') ?>" class="btn btn-success btn-block">
                            <i class="fa fa-file-text-o"></i> Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>