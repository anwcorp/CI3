<div class="content-wrapper">
    <section class="content-header">
        <h1><?= isset($kategori) ? 'Edit' : 'Tambah' ?> Kategori</h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-body">
                <?= form_open('', ['class' => 'form-horizontal']) ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Nama Kategori <span class="text-danger">*</span></label>
                    <div class="col-sm-6">
                        <input type="text" name="nama_kategori" class="form-control"
                            value="<?= isset($kategori) ? $kategori->NAMA_KATEGORI : set_value('nama_kategori') ?>"
                            required>
                        <?= form_error('nama_kategori', '<small class="text-danger">', '</small>') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Keterangan</label>
                    <div class="col-sm-6">
                        <textarea name="keterangan" class="form-control" rows="3"><?= isset($kategori) ? (isset($kategori->KETERANGAN) ? $kategori->KETERANGAN : '') : set_value('keterangan') ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        <a href="<?= site_url('kategori') ?>" class="btn btn-default">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </section>
</div>