<!-- Sidebar -->
<aside class="main-sidebar">
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <i class="fa fa-user-circle fa-3x" style="color: #fff;"></i>
            </div>
            <div class="pull-left info">
                <p><?= $this->session->userdata('nama') ?></p>
                <small><?= $this->session->userdata('nama_role') ?></small>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENU NAVIGASI</li>

            <li class="<?= $this->uri->segment(1) == 'dashboard' ? 'active' : '' ?>">
                <a href="<?= site_url('dashboard') ?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <?php if (in_array(get_role_name(), ['Administrator', 'Admin', 'Petugas Inventaris'])): ?>
                <li class="header">MASTER DATA</li>

                <li class="<?= $this->uri->segment(1) == 'barang' ? 'active' : '' ?>">
                    <a href="<?= site_url('barang') ?>">
                        <i class="fa fa-cube"></i> <span>Data Barang</span>
                    </a>
                </li>

                <li class="<?= $this->uri->segment(1) == 'kategori' ? 'active' : '' ?>">
                    <a href="<?= site_url('kategori') ?>">
                        <i class="fa fa-tags"></i> <span>Data Kategori</span>
                    </a>
                </li>

                <li class="<?= $this->uri->segment(1) == 'lokasi' ? 'active' : '' ?>">
                    <a href="<?= site_url('lokasi') ?>">
                        <i class="fa fa-map-marker"></i> <span>Data Lokasi</span>
                    </a>
                </li>

                <li class="<?= $this->uri->segment(1) == 'kondisi' ? 'active' : '' ?>">
                    <a href="<?= site_url('kondisi') ?>">
                        <i class="fa fa-check-circle"></i> <span>Data Kondisi</span>
                    </a>
                </li>
            <?php endif; ?>

            <li class="header">TRANSAKSI</li>

            <li class="<?= $this->uri->segment(1) == 'peminjaman' ? 'active' : '' ?>">
                <a href="<?= site_url('peminjaman') ?>">
                    <i class="fa fa-shopping-cart"></i> <span>Peminjaman</span>
                </a>
            </li>

            <?php if (in_array(get_role_name(), ['Administrator', 'Admin', 'Petugas Inventaris'])): ?>
                <li class="<?= $this->uri->segment(1) == 'pengembalian' ? 'active' : '' ?>">
                    <a href="<?= site_url('pengembalian') ?>">
                        <i class="fa fa-undo"></i> <span>Pengembalian</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if (in_array(get_role_name(), ['Administrator', 'Admin', 'Petugas Inventaris'])): ?>
                <li class="header">LAPORAN</li>

                <li class="<?= $this->uri->segment(1) == 'laporan' ? 'active' : '' ?>">
                    <a href="<?= site_url('laporan') ?>">
                        <i class="fa fa-file-text"></i> <span>Laporan</span>
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </section>
</aside>