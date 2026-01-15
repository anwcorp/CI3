<div class="content-wrapper">
    <section class="content-header">
        <h1>Data Peminjaman</h1>
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
                <a href="<?= site_url('peminjaman/tambah') ?>" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Tambah Peminjaman
                </a>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table-peminjaman">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <?php if (in_array(get_role_name(), ['Admin', 'Petugas Inventaris', 'Kepala Bagian'])): ?>
                                    <th>Peminjam</th>
                                    <th>Email</th>
                                <?php endif; ?>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($peminjaman) > 0): ?>
                                <?php $no = 1;
                                foreach ($peminjaman as $p): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <?php if (in_array(get_role_name(), ['Admin', 'Petugas Inventaris', 'Kepala Bagian'])): ?>
                                            <td><?= htmlspecialchars($p->NAMA_PEMINJAM, ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= htmlspecialchars($p->EMAIL, ENT_QUOTES, 'UTF-8') ?></td>
                                        <?php endif; ?>
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
                                                class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i> Detail
                                            </a>
                                            <?php if ($p->STATUS_PEMINJAMAN == 'Dipinjam' && in_array(get_role_name(), ['Administrator', 'Admin', 'Petugas Inventaris'])): ?>
                                                <a href="<?= site_url('pengembalian/proses/' . $p->PEMINJAMAN_ID) ?>"
                                                    class="btn btn-sm btn-success">
                                                    <i class="fa fa-check"></i> Kembalikan
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data</td>
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
        $('#table-peminjaman').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });
</script>