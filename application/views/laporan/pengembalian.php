<div class="content-wrapper">
    <section class="content-header">
        <h1>Laporan Pengembalian Barang</h1>
    </section>

    <section class="content">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible"><?= $this->session->flashdata('success'); ?></div>
        <?php endif; ?>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-filter"></i> Filter Periode</h3>
            </div>
            <div class="box-body">
                <?= form_open('laporan/pengembalian', ['class' => 'form-inline', 'style' => 'display:inline-block']) ?>
                    <input type="date" name="tanggal_dari" class="form-control" value="<?= isset($tanggal_dari) ? $tanggal_dari : '' ?>" required>
                    <input type="date" name="tanggal_sampai" class="form-control" value="<?= isset($tanggal_sampai) ? $tanggal_sampai : '' ?>" required>
                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                <?= form_close() ?>

                <div class="pull-right">
                    <?php if (isset($tanggal_dari) && isset($tanggal_sampai)): ?>
                        <div class="btn-group">
                            <a href="<?= site_url('laporan/print_pengembalian?dari='.$tanggal_dari.'&sampai='.$tanggal_sampai) ?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i></a>
                            <a href="<?= site_url('laporan/export_pdf_pengembalian?dari='.$tanggal_dari.'&sampai='.$tanggal_sampai) ?>" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> PDF</a>
                            <a href="<?= site_url('laporan/export_excel_pengembalian?dari='.$tanggal_dari.'&sampai='.$tanggal_sampai) ?>" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Excel</a>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalEmail"><i class="fa fa-envelope"></i> Email</button>
                        </div>
                    <?php endif; ?>
                    <a href="<?= site_url('laporan') ?>" class="btn btn-default">Kembali</a>
                </div>
            </div>
        </div>

        <?php if (!empty($pengembalian)): ?>
            <div class="box box-success">
                <div class="box-body">
                    <table class="table table-bordered table-striped" id="table-laporan">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Pengembalian</th>
                                <th>Nama Peminjam</th>
                                <th>Tanggal Dikembalikan</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($pengembalian as $p): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><span class="label label-success">#<?= $p->PENGEMBALIAN_ID ?></span></td>
                                    <td><?= htmlspecialchars($p->NAMA_PEMINJAM) ?></td>
                                    <td><?= $p->TANGGAL_DIKEMBALIKAN ?></td>
                                    <td><?= htmlspecialchars($p->CATATAN) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </section>
</div>

<div class="modal fade" id="modalEmail" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Kirim Laporan via Email</h4></div>
            <?= form_open('laporan/kirim_email_pengembalian') ?>
                <div class="modal-body">
                    <input type="hidden" name="tgl_dari" value="<?= $tanggal_dari ?>">
                    <input type="hidden" name="tgl_sampai" value="<?= $tanggal_sampai ?>">
                    <div class="form-group">
                        <label>Email Tujuan</label>
                        <input type="email" name="email_tujuan" class="form-control" placeholder="Email bos..." required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">Kirim</button>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>