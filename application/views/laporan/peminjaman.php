<div class="content-wrapper">
    <section class="content-header">
        <h1>Laporan Peminjaman Barang</h1>
    </section>

    <section class="content">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-filter"></i> Filter & Aksi</h3>
            </div>
            <div class="box-body">
                <?= form_open('laporan/peminjaman', ['class' => 'form-inline', 'style' => 'display:inline-block']) ?>
                    <div class="form-group">
                        <label>Dari:</label>
                        <input type="date" name="tanggal_dari" class="form-control" value="<?= isset($tanggal_dari) ? $tanggal_dari : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Sampai:</label>
                        <input type="date" name="tanggal_sampai" class="form-control" value="<?= isset($tanggal_sampai) ? $tanggal_sampai : '' ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search"></i> Tampilkan
                    </button>
                <?= form_close() ?>

                <div class="pull-right">
                    <?php if (isset($tanggal_dari) && isset($tanggal_sampai)): ?>
                        <a href="<?= site_url('laporan/print_peminjaman?dari=' . $tanggal_dari . '&sampai=' . $tanggal_sampai) ?>" target="_blank" class="btn btn-default">
                            <i class="fa fa-print"></i> Print
                        </a>
                        
                        <a href="<?= site_url('laporan/export_pdf_peminjaman?dari=' . $tanggal_dari . '&sampai=' . $tanggal_sampai) ?>" class="btn btn-danger">
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>

                        <a href="<?= site_url('laporan/export_excel_peminjaman?dari=' . $tanggal_dari . '&sampai=' . $tanggal_sampai) ?>" class="btn btn-success">
                            <i class="fa fa-file-excel-o"></i> Excel
                        </a>

                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalEmail">
                            <i class="fa fa-envelope"></i> Kirim Email
                        </button>
                    <?php endif; ?>
                    <a href="<?= site_url('laporan') ?>" class="btn btn-danger">Kembali</a>
                </div>
            </div>
        </div>

        <?php if (isset($peminjaman) && count($peminjaman) > 0): ?>
            <div class="box box-primary">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="table-laporan">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Peminjaman</th>
                                    <th>Nama Peminjam</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($peminjaman as $p): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>#<?= $p->PEMINJAMAN_ID ?></td>
                                        <td><?= htmlspecialchars($p->NAMA_PEMINJAM) ?></td>
                                        <td><?= $p->TANGGAL_PINJAM ?></td>
                                        <td><?= $p->TANGGAL_KEMBALI ?></td>
                                        <td>
                                            <span class="label label-<?= $p->STATUS_PEMINJAMAN == 'Dipinjam' ? 'warning' : 'success' ?>">
                                                <?= $p->STATUS_PEMINJAMAN ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>
</div>

<div class="modal fade" id="modalEmail" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Kirim Laporan via Email</h4>
            </div>
            <?= form_open('laporan/kirim_email_peminjaman') ?>
                <div class="modal-body">
                    <input type="hidden" name="tgl_dari" value="<?= isset($tanggal_dari) ? $tanggal_dari : '' ?>">
                    <input type="hidden" name="tgl_sampai" value="<?= isset($tanggal_sampai) ? $tanggal_sampai : '' ?>">
                    <div class="form-group">
                        <label>Email Tujuan</label>
                        <input type="email" name="email_tujuan" class="form-control" placeholder="Masukkan email bos lu..." required>
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