<div class="content-wrapper">
    <section class="content-header">
        <h1>Data Kategori</h1>
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
                <a href="<?= site_url('kategori/tambah') ?>" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Tambah Kategori
                </a>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Kategori</th>
                            <th>Keterangan</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($kategori) > 0): ?>
                            <?php $no = 1;
                            foreach ($kategori as $k): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($k->NAMA_KATEGORI, ENT_QUOTES, 'UTF-8') ?></td>
                                    
                                    <td><?= htmlspecialchars($k->KETERANGAN ?? '', ENT_QUOTES, 'UTF-8') ?></td>

                                    <td>
                                        <a href="<?= site_url('kategori/edit/' . $k->KATEGORI_ID) ?>"
                                            class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <a href="<?= site_url('kategori/hapus/' . $k->KATEGORI_ID) ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fa fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>