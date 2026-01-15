<div class="content-wrapper">
    <section class="content-header">
        <h1>Data Pengembalian Barang</h1>
    </section>

    <section class="content">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="icon fa fa-check"></i> <?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="icon fa fa-ban"></i> <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-list"></i> Daftar Pengembalian
                </h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table-pengembalian">
                        <thead>
                            <tr>
                                <th width="50" class="text-center">No</th>
                                <th>ID Transaksi</th>
                                <th>Nama Peminjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Catatan</th>
                                <th width="100" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pengembalian)): ?>
                                <?php $no = 1; foreach ($pengembalian as $p): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td>
                                            <span class="label label-primary">
                                                #<?= $p->PENGEMBALIAN_ID ?>
                                            </span>
                                        </td>
                                        <td>
                                            <strong><i class="fa fa-user text-muted"></i> <?= htmlspecialchars($p->NAMA_PEMINJAM ?? 'User Tidak Dikenal', ENT_QUOTES, 'UTF-8') ?></strong>
                                        </td>
                                        <td>
                                            <i class="fa fa-calendar text-primary"></i> 
                                            <?= date('d/m/Y', strtotime($p->TANGGAL_DIKEMBALIKAN)) ?>
                                        </td>
                                        <td>
                                            <small><?= htmlspecialchars($p->CATATAN ?? '-', ENT_QUOTES, 'UTF-8') ?></small>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= site_url('pengembalian/detail/' . $p->PENGEMBALIAN_ID) ?>"
                                               class="btn btn-xs btn-info" title="Lihat Detail">
                                                <i class="fa fa-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada data pengembalian</td>
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
        $('#table-pengembalian').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "order": [[0, "desc"]] // Urutkan dari yang terbaru
        });
    });
</script>