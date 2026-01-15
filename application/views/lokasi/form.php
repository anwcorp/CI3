<div class="content-wrapper">
    <section class="content-header">
        <h1><?= isset($lokasi) ? 'Edit' : 'Tambah' ?> Lokasi Barang</h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-body">
                <?= form_open('', ['class' => 'form-horizontal']) ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Nama Lokasi <span class="text-danger">*</span></label>
                    <div class="col-sm-6">
                        <input type="text" name="nama_lokasi" class="form-control"
                            value="<?= isset($lokasi) ? $lokasi->NAMA_LOKASI : set_value('nama_lokasi') ?>"
                            placeholder="Contoh: Ruang Server, Gudang A"
                            required>
                        <?= form_error('nama_lokasi', '<small class="text-danger">', '</small>') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Lantai <span class="text-danger">*</span></label>
                    <div class="col-sm-6">
                        <input type="number" name="lantai" class="form-control"
                            value="<?= isset($lokasi) ? $lokasi->LANTAI : set_value('lantai') ?>"
                            placeholder="Contoh: 1, 2, 3"
                            min="0"
                            required>
                        <?= form_error('lantai', '<small class="text-danger">', '</small>') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Keterangan</label>
                    <div class="col-sm-6">
                        <textarea name="keterangan" class="form-control" rows="3"
                            placeholder="Deskripsi lokasi"><?= isset($lokasi) ? $lokasi->KETERANGAN : set_value('keterangan') ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        <a href="<?= site_url('lokasi') ?>" class="btn btn-default">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </section>
</div>