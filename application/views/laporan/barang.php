<div class="content-wrapper">
    <section class="content-header">
        <h1>Laporan Data Barang</h1>
    </section>

    <section class="content">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-cubes"></i> Stok Inventaris</h3>
                <div class="box-tools">
                    <div class="btn-group">
                        <a href="<?= site_url('laporan/print_barang') ?>" target="_blank" class="btn btn-default">
                            <i class="fa fa-print"></i> Print
                        </a>
                        <a href="<?= site_url('laporan/export_pdf_barang') ?>" class="btn btn-danger">
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                        <a href="<?= site_url('laporan/export_excel_barang') ?>" class="btn btn-success">
                            <i class="fa fa-file-excel-o"></i> Excel
                        </a>
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalEmailBarang">
                            <i class="fa fa-envelope"></i> Email
                        </button>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table-laporan">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Lokasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($barang as $b): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $b->KODE_BARANG ?></td>
                                    <td><?= htmlspecialchars($b->NAMA_BARANG) ?></td>
                                    <td><?= $b->NAMA_KATEGORI ?></td>
                                    <td><?= $b->JUMLAH ?></td>
                                    <td><?= $b->NAMA_LOKASI ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modalEmailBarang" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Kirim Laporan Stok ke Email</h4>
            </div>
            <?= form_open('laporan/kirim_email_barang') ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Email Tujuan</label>
                        <input type="email" name="email_tujuan" class="form-control" placeholder="Email bos..." required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">Kirim Sekarang</button>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>