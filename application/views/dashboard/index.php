<style>
/* ==================== DASHBOARD MODERN STYLES ==================== */

/* Card Statistik */
.stat-card {
    border-radius: 15px;
    padding: 25px;
    color: #fff;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
    margin-bottom: 20px;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
}

.stat-card .stat-icon {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 60px;
    opacity: 0.3;
}

.stat-card .stat-number {
    font-size: 42px;
    font-weight: 700;
    margin-bottom: 5px;
    line-height: 1;
}

.stat-card .stat-label {
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.9;
}

.stat-card .stat-footer {
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid rgba(255,255,255,0.2);
}

.stat-card .stat-footer a {
    color: #fff;
    text-decoration: none;
    font-size: 13px;
    opacity: 0.9;
}

.stat-card .stat-footer a:hover {
    opacity: 1;
}

/* Gradient Backgrounds - Blue Theme */
.bg-gradient-primary { background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); }
.bg-gradient-success { background: linear-gradient(135deg, #0052d4 0%, #4364f7 50%, #6fb1fc 100%); }
.bg-gradient-warning { background: linear-gradient(135deg, #005c97 0%, #363795 100%); }
.bg-gradient-danger { background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%); }
.bg-gradient-info { background: linear-gradient(135deg, #00c6ff 0%, #0072ff 100%); }
.bg-gradient-dark { background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%); }

/* Chart Box */
.chart-box {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    margin-bottom: 25px;
    overflow: hidden;
}

.chart-box .chart-header {
    padding: 20px 25px;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chart-box .chart-title {
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin: 0;
}

.chart-box .chart-title i {
    margin-right: 10px;
    color: #1e3c72;
}

.chart-box .chart-body {
    padding: 20px;
}

/* Welcome Card - Blue Theme */
.welcome-card {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    border-radius: 15px;
    padding: 30px;
    color: #fff;
    margin-bottom: 25px;
    position: relative;
    overflow: hidden;
}

.welcome-card::before {
    content: '';
    position: absolute;
    right: -50px;
    top: -50px;
    width: 200px;
    height: 200px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
}

.welcome-card::after {
    content: '';
    position: absolute;
    right: 50px;
    bottom: -80px;
    width: 150px;
    height: 150px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
}

.welcome-card h2 {
    font-size: 28px;
    margin-bottom: 10px;
}

.welcome-card p {
    opacity: 0.9;
    margin: 0;
}

/* Table Modern */
.table-modern {
    margin: 0;
}

.table-modern thead th {
    background: #f8f9fa;
    border: none;
    padding: 15px;
    font-weight: 600;
    color: #555;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
}

.table-modern tbody td {
    padding: 15px;
    vertical-align: middle;
    border-color: #f0f0f0;
}

.table-modern tbody tr:hover {
    background: #f8f9fa;
}

/* Badge Modern */
.badge-modern {
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.badge-warning-soft { background: #fff3cd; color: #856404; }
.badge-success-soft { background: #d4edda; color: #155724; }
.badge-danger-soft { background: #f8d7da; color: #721c24; }

/* Activity List */
.activity-list {
    max-height: 400px;
    overflow-y: auto;
}

.activity-item {
    padding: 15px;
    border-bottom: 1px solid #f0f0f0;
    transition: background 0.2s;
}

.activity-item:hover {
    background: #f8f9fa;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-time {
    font-size: 12px;
    color: #999;
    margin-bottom: 5px;
}

.activity-text {
    color: #333;
    font-size: 14px;
}

/* Alert Stock */
.stock-alert-table tbody tr {
    transition: all 0.2s;
}

.stock-alert-table tbody tr:hover {
    background: #fff5f5;
}

/* Button Modern */
.btn-modern {
    border-radius: 8px;
    padding: 8px 16px;
    font-size: 12px;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.15);
}

/* Responsive */
@media (max-width: 768px) {
    .stat-card .stat-number { font-size: 32px; }
    .stat-card .stat-icon { font-size: 40px; }
    .welcome-card h2 { font-size: 22px; }
    .chart-box .chart-header { padding: 15px; }
    .chart-box .chart-body { padding: 15px; }
}

/* Scrollbar Custom */
.activity-list::-webkit-scrollbar {
    width: 6px;
}

.activity-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.activity-list::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.activity-list::-webkit-scrollbar-thumb:hover {
    background: #a1a1a1;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #999;
}

.empty-state i {
    font-size: 50px;
    margin-bottom: 15px;
    opacity: 0.5;
}

.empty-state p {
    margin: 0;
}
</style>

<div class="content-wrapper">
    <section class="content-header">
        <div class="dashboard-title">
            <h1>
                <i class="fa fa-dashboard"></i> 
                <span class="title-text">Dashboard</span>
                <span class="title-badge">Live</span>
            </h1>
            <p class="title-subtitle">Sistem Informasi Inventaris Barang</p>
        </div>
    </section>

    <style>
    .dashboard-title {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        padding: 25px 30px;
        border-radius: 15px;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
    }
    .dashboard-title::before {
        content: '';
        position: absolute;
        right: -30px;
        top: -30px;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
    .dashboard-title::after {
        content: '';
        position: absolute;
        right: 80px;
        bottom: -50px;
        width: 100px;
        height: 100px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .dashboard-title h1 {
        color: #fff;
        font-size: 32px;
        font-weight: 700;
        margin: 0 0 8px 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .dashboard-title h1 i {
        font-size: 28px;
        opacity: 0.9;
    }
    .dashboard-title .title-text {
        background: linear-gradient(90deg, #fff 0%, #a8d4ff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .dashboard-title .title-badge {
        background: rgba(255,255,255,0.2);
        color: #7cffcb;
        font-size: 11px;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }
    .dashboard-title .title-subtitle {
        color: rgba(255,255,255,0.8);
        font-size: 14px;
        margin: 0;
        letter-spacing: 0.5px;
    }
    </style>

    <section class="content">
        <!-- Welcome Card -->
        <div class="welcome-card">
            <h2><i class="fa fa-hand-peace-o"></i> Selamat Datang!</h2>
            <p>Halo <strong><?= $this->session->userdata('nama') ?></strong>, Anda login sebagai <strong><?= $this->session->userdata('nama_role') ?></strong></p>
        </div>

        <?php if (in_array(get_role_name(), ['Administrator', 'Admin', 'Petugas Inventaris'])): ?>
            <!-- Statistik Cards -->
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="stat-card bg-gradient-primary">
                        <div class="stat-icon"><i class="fa fa-cubes"></i></div>
                        <div class="stat-number"><?= $total_barang ?></div>
                        <div class="stat-label">Total Barang</div>
                        <div class="stat-footer">
                            <a href="<?= site_url('barang') ?>">Lihat Detail <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="stat-card bg-gradient-warning">
                        <div class="stat-icon"><i class="fa fa-shopping-cart"></i></div>
                        <div class="stat-number"><?= $total_peminjaman_aktif ?></div>
                        <div class="stat-label">Peminjaman Aktif</div>
                        <div class="stat-footer">
                            <a href="<?= site_url('peminjaman') ?>">Lihat Detail <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="stat-card bg-gradient-success">
                        <div class="stat-icon"><i class="fa fa-check-circle"></i></div>
                        <div class="stat-number"><?= $total_pengembalian ?></div>
                        <div class="stat-label">Total Pengembalian</div>
                        <div class="stat-footer">
                            <a href="<?= site_url('pengembalian') ?>">Lihat Detail <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="stat-card bg-gradient-danger">
                        <div class="stat-icon"><i class="fa fa-exclamation-triangle"></i></div>
                        <div class="stat-number"><?= isset($barang_stok_menipis) ? count($barang_stok_menipis) : 0 ?></div>
                        <div class="stat-label">Stok Menipis</div>
                        <div class="stat-footer">
                            <a href="<?= site_url('barang') ?>">Lihat Detail <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row Grafik Utama -->
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="chart-box">
                        <div class="chart-header">
                            <h4 class="chart-title"><i class="fa fa-bar-chart"></i> Statistik Peminjaman & Pengembalian</h4>
                            <span class="text-muted" style="font-size: 12px;">6 Bulan Terakhir</span>
                        </div>
                        <div class="chart-body">
                            <canvas id="chartPeminjamanBulanan" height="100"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12">
                    <div class="chart-box">
                        <div class="chart-header">
                            <h4 class="chart-title"><i class="fa fa-pie-chart"></i> Status Peminjaman</h4>
                        </div>
                        <div class="chart-body">
                            <canvas id="chartStatusPeminjaman" height="180"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row Grafik Kedua -->
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="chart-box">
                        <div class="chart-header">
                            <h4 class="chart-title"><i class="fa fa-trophy"></i> Top 10 Barang Terpopuler</h4>
                        </div>
                        <div class="chart-body">
                            <canvas id="chartTopBarang" height="220"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="chart-box">
                        <div class="chart-header">
                            <h4 class="chart-title"><i class="fa fa-tags"></i> Distribusi per Kategori</h4>
                        </div>
                        <div class="chart-body">
                            <canvas id="chartKategori" height="220"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row Grafik Ketiga -->
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="chart-box">
                        <div class="chart-header">
                            <h4 class="chart-title"><i class="fa fa-heartbeat"></i> Kondisi Barang</h4>
                        </div>
                        <div class="chart-body">
                            <canvas id="chartKondisi" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-md-6">
                    <div class="chart-box">
                        <div class="chart-header">
                            <h4 class="chart-title"><i class="fa fa-map-marker"></i> Distribusi per Lokasi</h4>
                        </div>
                        <div class="chart-body">
                            <canvas id="chartLokasi" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Stok Menipis -->
            <?php if (isset($barang_stok_menipis) && count($barang_stok_menipis) > 0): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="chart-box">
                        <div class="chart-header" style="background: linear-gradient(135deg, #fff5f5 0%, #fff 100%);">
                            <h4 class="chart-title" style="color: #e74c3c;">
                                <i class="fa fa-exclamation-circle"></i> Peringatan Stok Menipis
                            </h4>
                            <span class="badge badge-danger-soft"><?= count($barang_stok_menipis) ?> Barang</span>
                        </div>
                        <div class="chart-body" style="padding: 0;">
                            <table class="table table-modern stock-alert-table">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Lokasi</th>
                                        <th>Stok</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($barang_stok_menipis as $b): ?>
                                    <tr>
                                        <td><code><?= htmlspecialchars($b->KODE_BARANG, ENT_QUOTES, 'UTF-8') ?></code></td>
                                        <td><strong><?= htmlspecialchars($b->NAMA_BARANG, ENT_QUOTES, 'UTF-8') ?></strong></td>
                                        <td><?= isset($b->NAMA_KATEGORI) ? htmlspecialchars($b->NAMA_KATEGORI, ENT_QUOTES, 'UTF-8') : '-' ?></td>
                                        <td><?= isset($b->NAMA_LOKASI) ? htmlspecialchars($b->NAMA_LOKASI, ENT_QUOTES, 'UTF-8') : '-' ?></td>
                                        <td><span class="badge badge-danger-soft"><?= $b->JUMLAH ?> unit</span></td>
                                        <td>
                                            <a href="<?= site_url('barang/tambah_stok/' . $b->BARANG_ID) ?>" class="btn btn-sm btn-success btn-modern">
                                                <i class="fa fa-plus"></i> Tambah Stok
                                            </a>
                                        </td>
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

        <!-- Peminjaman Saya & Log Aktivitas -->
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="chart-box">
                    <div class="chart-header">
                        <h4 class="chart-title"><i class="fa fa-list-alt"></i> Peminjaman Saya</h4>
                        <a href="<?= site_url('peminjaman') ?>" class="btn btn-sm btn-primary btn-modern">
                            Lihat Semua <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="chart-body" style="padding: 0;">
                        <?php if (isset($peminjaman_user) && count($peminjaman_user) > 0): ?>
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($peminjaman_user as $p): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= date('d M Y', strtotime($p->TANGGAL_PINJAM)) ?></td>
                                    <td><?= date('d M Y', strtotime($p->TANGGAL_KEMBALI)) ?></td>
                                    <td>
                                        <?php if ($p->STATUS_PEMINJAMAN == 'Dipinjam'): ?>
                                            <span class="badge badge-warning-soft">
                                                <i class="fa fa-clock-o"></i> Dipinjam
                                            </span>
                                        <?php else: ?>
                                            <span class="badge badge-success-soft">
                                                <i class="fa fa-check"></i> Dikembalikan
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= site_url('peminjaman/detail/' . $p->PEMINJAMAN_ID) ?>" class="btn btn-sm btn-info btn-modern">
                                            <i class="fa fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <div class="empty-state">
                            <i class="fa fa-inbox"></i>
                            <p>Belum ada riwayat peminjaman</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="chart-box">
                    <div class="chart-header">
                        <h4 class="chart-title"><i class="fa fa-history"></i> Aktivitas Terbaru</h4>
                    </div>
                    <div class="chart-body" style="padding: 0;">
                        <?php if (isset($log_aktivitas) && count($log_aktivitas) > 0): ?>
                        <div class="activity-list">
                            <?php foreach ($log_aktivitas as $log): ?>
                            <div class="activity-item">
                                <div class="activity-time">
                                    <i class="fa fa-clock-o"></i> <?= date('d M Y H:i', strtotime($log->waktu)) ?>
                                </div>
                                <div class="activity-text">
                                    <?= htmlspecialchars($log->aktivitas, ENT_QUOTES, 'UTF-8') ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php else: ?>
                        <div class="empty-state">
                            <i class="fa fa-clock-o"></i>
                            <p>Belum ada aktivitas</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
<?php if (in_array(get_role_name(), ['Administrator', 'Admin', 'Petugas Inventaris'])): ?>

// Data dari Controller
const dataPeminjamanBulanan = <?= json_encode($peminjaman_bulanan ?? []) ?>;
const dataPengembalianBulanan = <?= json_encode($pengembalian_bulanan ?? []) ?>;
const dataStatusPeminjaman = <?= json_encode($status_peminjaman ?? ['Dipinjam' => 0, 'Dikembalikan' => 0]) ?>;
const dataTopBarang = <?= json_encode($top_barang ?? []) ?>;
const dataKategori = <?= json_encode($barang_per_kategori ?? []) ?>;
const dataKondisi = <?= json_encode($barang_per_kondisi ?? []) ?>;
const dataLokasi = <?= json_encode($barang_per_lokasi ?? []) ?>;

// Chart Default Options
Chart.defaults.font.family = "'Nunito', sans-serif";
Chart.defaults.color = '#666';

// Color Palette
const gradientColors = {
    primary: ['rgba(102, 126, 234, 0.8)', 'rgba(118, 75, 162, 0.8)'],
    success: ['rgba(17, 153, 142, 0.8)', 'rgba(56, 239, 125, 0.8)'],
    warning: ['rgba(240, 147, 251, 0.8)', 'rgba(245, 87, 108, 0.8)'],
    danger: ['rgba(235, 51, 73, 0.8)', 'rgba(244, 92, 67, 0.8)'],
    info: ['rgba(79, 172, 254, 0.8)', 'rgba(0, 242, 254, 0.8)']
};

const colorPalette = [
    'rgba(30, 60, 114, 0.8)',
    'rgba(42, 82, 152, 0.8)',
    'rgba(0, 114, 255, 0.8)',
    'rgba(0, 198, 255, 0.8)',
    'rgba(32, 58, 67, 0.8)',
    'rgba(44, 83, 100, 0.8)',
    'rgba(54, 55, 149, 0.8)',
    'rgba(0, 92, 151, 0.8)',
    'rgba(67, 100, 247, 0.8)',
    'rgba(111, 177, 252, 0.8)'
];

// 1. Chart Peminjaman & Pengembalian Bulanan
if (document.getElementById('chartPeminjamanBulanan')) {
    const ctx = document.getElementById('chartPeminjamanBulanan').getContext('2d');
    
    const gradient1 = ctx.createLinearGradient(0, 0, 0, 300);
    gradient1.addColorStop(0, 'rgba(30, 60, 114, 0.9)');
    gradient1.addColorStop(1, 'rgba(42, 82, 152, 0.3)');
    
    const gradient2 = ctx.createLinearGradient(0, 0, 0, 300);
    gradient2.addColorStop(0, 'rgba(0, 114, 255, 0.9)');
    gradient2.addColorStop(1, 'rgba(0, 198, 255, 0.3)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: dataPeminjamanBulanan.map(item => item.BULAN),
            datasets: [{
                label: 'Peminjaman',
                data: dataPeminjamanBulanan.map(item => item.TOTAL),
                backgroundColor: gradient1,
                borderRadius: 8,
                borderSkipped: false
            }, {
                label: 'Pengembalian',
                data: dataPengembalianBulanan.map(item => item.TOTAL),
                backgroundColor: gradient2,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { 
                    position: 'top',
                    labels: { usePointStyle: true, padding: 20 }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
}

// 2. Chart Status Peminjaman (Doughnut)
if (document.getElementById('chartStatusPeminjaman')) {
    new Chart(document.getElementById('chartStatusPeminjaman'), {
        type: 'doughnut',
        data: {
            labels: ['Dipinjam', 'Dikembalikan'],
            datasets: [{
                data: [dataStatusPeminjaman.Dipinjam || 0, dataStatusPeminjaman.Dikembalikan || 0],
                backgroundColor: ['rgba(0, 92, 151, 0.8)', 'rgba(0, 198, 255, 0.8)'],
                borderWidth: 0,
                cutout: '65%'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { 
                    position: 'bottom',
                    labels: { usePointStyle: true, padding: 15 }
                }
            }
        }
    });
}

// 6. Chart Barang per Lokasi (Bar)
if (document.getElementById('chartLokasi')) {
    const ctx = document.getElementById('chartLokasi').getContext('2d');
    
    const gradient = ctx.createLinearGradient(0, 0, 0, 200);
    gradient.addColorStop(0, 'rgba(0, 114, 255, 0.9)');
    gradient.addColorStop(1, 'rgba(0, 198, 255, 0.3)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: dataLokasi.map(item => item.NAMA_LOKASI),
            datasets: [{
                label: 'Jumlah Barang',
                data: dataLokasi.map(item => item.TOTAL),
                backgroundColor: gradient,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
}

<?php endif; ?>
</script>out: '70%'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { 
                    position: 'bottom',
                    labels: { usePointStyle: true, padding: 20 }
                }
            }
        }
    });
}

// 3. Chart Top 10 Barang (Horizontal Bar)
if (document.getElementById('chartTopBarang')) {
    new Chart(document.getElementById('chartTopBarang'), {
        type: 'bar',
        data: {
            labels: dataTopBarang.map(item => item.NAMA_BARANG),
            datasets: [{
                label: 'Jumlah Dipinjam',
                data: dataTopBarang.map(item => item.TOTAL_PINJAM),
                backgroundColor: colorPalette,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { 
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                y: {
                    grid: { display: false }
                }
            }
        }
    });
}

// 4. Chart Barang per Kategori (Doughnut)
if (document.getElementById('chartKategori')) {
    new Chart(document.getElementById('chartKategori'), {
        type: 'doughnut',
        data: {
            labels: dataKategori.map(item => item.NAMA_KATEGORI),
            datasets: [{
                data: dataKategori.map(item => item.TOTAL),
                backgroundColor: colorPalette,
                borderWidth: 0,
                cutout: '60%'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { 
                    position: 'right',
                    labels: { usePointStyle: true, padding: 15, font: { size: 11 } }
                }
            }
        }
    });
}

// 5. Chart Kondisi Barang (Doughnut)
if (document.getElementById('chartKondisi')) {
    new Chart(document.getElementById('chartKondisi'), {
        type: 'doughnut',
        data: {
            labels: dataKondisi.map(item => item.NAMA_KONDISI),
            datasets: [{
                data: dataKondisi.map(item => item.TOTAL),
                backgroundColor: ['rgba(30, 60, 114, 0.8)', 'rgba(42, 82, 152, 0.8)', 'rgba(0, 92, 151, 0.8)', 'rgba(0, 198, 255, 0.8)'],
                borderWidth: 0,
                cut