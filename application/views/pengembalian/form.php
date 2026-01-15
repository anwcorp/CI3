<div class="content-wrapper">
    <section class="content-header">
        <h1>Proses Pengembalian Barang</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Informasi Peminjaman</h3>
                    </div>
                    <div class="box-body">
                        <table class="table">
                            <tr>
                                <th width="40%">Peminjam</th>
                                <td><?= htmlspecialchars($peminjaman->NAMA_PEMINJAM, ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Pinjam</th>
                                <td><?= $peminjaman->TGL_PINJAM ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Kembali</th>
                                <td><?= $peminjaman->TGL_KEMBALI ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-body">
                <?= form_open('') ?>

                <div class="form-group">
                    <label>Tanggal Dikembalikan <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_dikembalikan" class="form-control"
                        value="<?= date('Y-m-d') ?>" required style="max-width: 300px;">
                    <?= form_error('tanggal_dikembalikan', '<small class="text-danger">', '</small>') ?>
                </div>
                <h4>Detail Barang Dikembalikan</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Jumlah Pinjam</th>
                            <th>Jumlah Kembali <span class="text-danger">*</span></th>
                            <th>Kondisi Setelah <span class="text-danger">*</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detail as $d): ?>
                            <tr>
                                <td>
                                    <?= htmlspecialchars($d->NAMA_BARANG, ENT_QUOTES, 'UTF-8') ?>
                                    <input type="hidden" name="detail_peminjaman_id[]" value="<?= $d->DETAIL_PEMINJAMAN_ID ?>">
                                    <input type="hidden" name="barang_id[]" value="<?= $d->BARANG_ID ?>">
                                </td>
                                <td><?= $d->JUMLAH_PINJAM ?></td>
                                <td>
                                    <input type="number" name="jumlah_kembali[]" class="form-control"
                                        min="1" max="<?= $d->JUMLAH_PINJAM ?>"
                                        value="<?= $d->JUMLAH_PINJAM ?>" required>
                                </td>
                                <td>
                                    <select name="kondisi_setelah[]" class="form-control" required>
                                        <option value="">-- Pilih Kondisi --</option>
                                        <?php foreach ($kondisi as $k): ?>
                                            <option value="<?= $k->KONDISI_ID ?>">
                                                <?= htmlspecialchars($k->NAMA_KONDISI, ENT_QUOTES, 'UTF-8') ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="form-group">
                    <label>Catatan</label>
                    <textarea name="catatan" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i> Proses Pengembalian
                    </button>
                    <a href="<?= site_url('peminjaman') ?>" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> Batal
                    </a>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </section>
</div>