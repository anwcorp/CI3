<div class="content-wrapper">
    <section class="content-header">
        <h1>Data Barang</h1>
    </section>

    <section class="content">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="box">
            <div class="box-header">
                <a href="<?= site_url('barang/tambah') ?>" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Tambah Barang
                </a>
                <?php if ($this->session->userdata('role') == 1): ?>
                    <a href="<?= site_url('barang/cleanup_duplicates') ?>"
                        class="btn btn-warning"
                        onclick="return confirm('Yakin ingin menggabungkan data duplikat? Proses ini tidak bisa dibatalkan!')">
                        <i class="fa fa-broom"></i> Bersihkan Duplikat
                    </a>
                <?php endif; ?>
            </div>

            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table-barang">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Lokasi</th>
                                <th>Kondisi</th>
                                <th>Jumlah</th>
                                <th>Tanggal Perolehan</th>
                                <th>Status</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($barang) > 0): ?>
                                <?php $no = 1; foreach ($barang as $b): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($b->KODE_BARANG, ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($b->NAMA_BARANG, ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($b->NAMA_KATEGORI, ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($b->NAMA_LOKASI, ENT_QUOTES, 'UTF-8') ?> (Lt. <?= $b->LANTAI ?>)</td>
                                        <td>
                                            <span class="label label-<?= $b->NAMA_KONDISI == 'Baik' ? 'success' : ($b->NAMA_KONDISI == 'Rusak Ringan' ? 'warning' : 'danger') ?>">
                                                <?= htmlspecialchars($b->NAMA_KONDISI, ENT_QUOTES, 'UTF-8') ?>
                                            </span>
                                        </td>
                                        <td><?= $b->JUMLAH ?></td>
                                        <td><?= $b->TANGGAL_PEROLEHAN ?></td>
                                        <td>
                                            <span class="label label-<?= $b->STATUS_BARANG == 'Tersedia' ? 'success' : 'warning' ?>">
                                                <?= htmlspecialchars($b->STATUS_BARANG, ENT_QUOTES, 'UTF-8') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= site_url('barang/edit/' . $b->BARANG_ID) ?>"
                                                class="btn btn-sm btn-warning">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a href="<?= site_url('barang/hapus/' . $b->BARANG_ID) ?>"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="fa fa-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center">Tidak ada data</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        $('#table-barang').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });
</script>