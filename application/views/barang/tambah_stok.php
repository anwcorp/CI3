<h3><?= $title ?></h3>

<form method="post">
    <div class="form-group">
        <label>Nama Barang</label>
        <input type="text" class="form-control" value="<?= $barang->NAMA_BARANG ?>" readonly>
    </div>

    <div class="form-group">
        <label>Jumlah Tambahan</label>
        <input type="number" name="jumlah" class="form-control" required min="1">
    </div>

    <button type="submit" class="btn btn-primary">Tambah Stok</button>
    <a href="<?= base_url('barang') ?>" class="btn btn-secondary">Kembali</a>
</form>