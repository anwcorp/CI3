<div class="content-wrapper">
    <section class="content-header">
        <h1><?= isset($barang) ? 'Edit' : 'Tambah' ?> Barang</h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-body">
                <?= form_open('', ['class' => 'form-horizontal']) ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Nama Barang <span class="text-danger">*</span></label>
                    <div class="col-sm-6">
                        <input type="text" name="nama_barang" class="form-control"
                            value="<?= isset($barang) ? $barang->NAMA_BARANG : set_value('nama_barang') ?>"
                            required>
                        <?= form_error('nama_barang', '<small class="text-danger">', '</small>') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Kategori <span class="text-danger">*</span></label>
                    <div class="col-sm-6">
                        <select name="kategori_id" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($kategori as $k): ?>
                                <option value="<?= $k->KATEGORI_ID ?>"
                                    <?= (isset($barang) && $barang->KATEGORI_ID == $k->KATEGORI_ID) || set_value('kategori_id') == $k->KATEGORI_ID ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($k->NAMA_KATEGORI, ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('kategori_id', '<small class="text-danger">', '</small>') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Lokasi <span class="text-danger">*</span></label>
                    <div class="col-sm-6">
                        <select name="lokasi_id" class="form-control" required>
                            <option value="">-- Pilih Lokasi --</option>
                            <?php foreach ($lokasi as $l): ?>
                                <option value="<?= $l->LOKASI_ID ?>"
                                    <?= (isset($barang) && $barang->LOKASI_ID == $l->LOKASI_ID) || set_value('lokasi_id') == $l->LOKASI_ID ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($l->NAMA_LOKASI, ENT_QUOTES, 'UTF-8') ?> (Lantai <?= $l->LANTAI ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('lokasi_id', '<small class="text-danger">', '</small>') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Kondisi <span class="text-danger">*</span></label>
                    <div class="col-sm-6">
                        <select name="kondisi_id" class="form-control" required>
                            <option value="">-- Pilih Kondisi --</option>
                            <?php foreach ($kondisi as $ko): ?>
                                <option value="<?= $ko->KONDISI_ID ?>"
                                    <?= (isset($barang) && $barang->KONDISI_ID == $ko->KONDISI_ID) || set_value('kondisi_id') == $ko->KONDISI_ID ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($ko->NAMA_KONDISI, ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('kondisi_id', '<small class="text-danger">', '</small>') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Jumlah <span class="text-danger">*</span></label>
                    <div class="col-sm-6">
                        <input type="number" name="jumlah" class="form-control" min="0"
                            value="<?= isset($barang) ? $barang->JUMLAH : set_value('jumlah') ?>"
                            required>
                        <?= form_error('jumlah', '<small class="text-danger">', '</small>') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Tanggal Perolehan <span class="text-danger">*</span></label>
                    <div class="col-sm-6">
                        <input type="date" name="tanggal_perolehan" class="form-control"
                            value="<?= isset($barang) ? date('Y-m-d', strtotime($barang->TANGGAL_PEROLEHAN)) : set_value('tanggal_perolehan') ?>"
                            required>
                        <?= form_error('tanggal_perolehan', '<small class="text-danger">', '</small>') ?>
                    </div>
                </div>

                <?php if (isset($barang)): ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Status Barang</label>
                        <div class="col-sm-6">
                            <select name="status_barang" class="form-control">
                                <option value="Tersedia" <?= $barang->STATUS_BARANG == 'Tersedia' ? 'selected' : '' ?>>Tersedia</option>
                                <option value="Dipinjam" <?= $barang->STATUS_BARANG == 'Dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
                                <option value="Rusak" <?= $barang->STATUS_BARANG == 'Rusak' ? 'selected' : '' ?>>Rusak</option>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        <a href="<?= site_url('barang') ?>" class="btn btn-default">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </section>
</div>