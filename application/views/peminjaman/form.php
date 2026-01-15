<div class="content-wrapper">
    <section class="content-header">
        <h1>Tambah Peminjaman</h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-body">
                <?= form_open('', ['id' => 'form-peminjaman']) ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Pinjam <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pinjam" class="form-control"
                                value="<?= date('Y-m-d') ?>" required>
                            <?= form_error('tanggal_pinjam', '<small class="text-danger">', '</small>') ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Kembali <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_kembali" class="form-control"
                                value="<?= set_value('tanggal_kembali') ?>" required>
                            <?= form_error('tanggal_kembali', '<small class="text-danger">', '</small>') ?>
                        </div>
                    </div>
                </div>

                <hr>
                <h4>Pilih Barang</h4>

                <div id="barang-container">
                    <div class="row barang-item" style="margin-bottom: 10px;">
                        <div class="col-md-6">
                            <select name="barang_id[]" class="form-control barang-select" required>
                                <option value="">-- Pilih Barang --</option>
                                <?php foreach ($barang as $b): ?>
                                    <option value="<?= $b->BARANG_ID ?>" data-stok="<?= $b->JUMLAH ?>">
                                        <?= htmlspecialchars($b->NAMA_BARANG, ENT_QUOTES, 'UTF-8') ?>
                                        (Stok: <?= $b->JUMLAH ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="jumlah_pinjam[]" class="form-control"
                                placeholder="Jumlah" min="1" required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-remove-barang" disabled>
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-success" id="btn-tambah-barang">
                    <i class="fa fa-plus"></i> Tambah Barang
                </button>

                <hr>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan Peminjaman
                    </button>
                    <a href="<?= site_url('peminjaman') ?>" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        // Template untuk item barang baru
        var barangTemplate = `
        <div class="row barang-item" style="margin-bottom: 10px;">
            <div class="col-md-6">
                <select name="barang_id[]" class="form-control barang-select" required>
                    <option value="">-- Pilih Barang --</option>
                    <?php foreach ($barang as $b): ?>
                        <option value="<?= $b->BARANG_ID ?>" data-stok="<?= $b->JUMLAH ?>">
                            <?= htmlspecialchars($b->NAMA_BARANG, ENT_QUOTES, 'UTF-8') ?> 
                            (Stok: <?= $b->JUMLAH ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <input type="number" name="jumlah_pinjam[]" class="form-control" 
                       placeholder="Jumlah" min="1" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-remove-barang">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
    `;

        // Tambah barang
        $('#btn-tambah-barang').click(function() {
            $('#barang-container').append(barangTemplate);
            updateRemoveButtons();
        });

        // Hapus barang
        $(document).on('click', '.btn-remove-barang', function() {
            $(this).closest('.barang-item').remove();
            updateRemoveButtons();
        });

        // Update status tombol hapus
        function updateRemoveButtons() {
            var items = $('.barang-item').length;
            if (items > 1) {
                $('.btn-remove-barang').prop('disabled', false);
            } else {
                $('.btn-remove-barang').prop('disabled', true);
            }
        }

        // Validasi stok saat submit
        $('#form-peminjaman').submit(function(e) {
            var valid = true;
            $('.barang-item').each(function() {
                var select = $(this).find('.barang-select');
                var input = $(this).find('input[name="jumlah_pinjam[]"]');
                var stok = select.find(':selected').data('stok');
                var jumlah = parseInt(input.val());

                if (jumlah > stok) {
                    alert('Jumlah pinjam melebihi stok tersedia!');
                    input.focus();
                    valid = false;
                    return false;
                }
            });

            if (!valid) {
                e.preventDefault();
            }
        });
    });
</script>