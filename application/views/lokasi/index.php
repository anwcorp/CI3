<div class="content-wrapper">
    <section class="content-header">
        <h1>Data Lokasi Barang</h1>
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
                <a href="<?= site_url('lokasi/tambah') ?>" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Tambah Lokasi
                </a>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped" id="table-lokasi">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Lokasi</th>
                            <th>Lantai</th>
                            <th>Keterangan</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($lokasi) > 0): ?>
                            <?php $no = 1;
                            foreach ($lokasi as $l): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <i class="fa fa-map-marker text-danger"></i>
                                        <?= htmlspecialchars($l->NAMA_LOKASI, ENT_QUOTES, 'UTF-8') ?>
                                    </td>
                                    <td>
                                        <span class="label label-info">Lantai <?= $l->LANTAI ?></span>
                                    </td>
                                    <td><?= htmlspecialchars($l->KETERANGAN, ENT_QUOTES, 'UTF-8') ?></td>
                                    <td>
                                        <a href="<?= site_url('lokasi/edit/' . $l->LOKASI_ID) ?>"
                                            class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <a href="<?= site_url('lokasi/hapus/' . $l->LOKASI_ID) ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fa fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        $('#table-lokasi').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });
</script>