<?= $this->extend('template/main'); ?>
<?= $this->section('content'); ?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Tambah Kategori</h5>

        <form action="<?= base_url('produk/simpan_kategori'); ?>" method="post">
            <?= csrf_field(); ?>
            <div class="mb-3">
                <label for="nama_kategori" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control <?= (isset($errors['nama_kategori'])) ? 'is-invalid' : ''; ?>" id="nama_kategori" name="nama_kategori" value="<?= old('nama_kategori'); ?>">
                <?php if (isset($errors['nama_kategori'])): ?>
                    <div class="invalid-feedback"><?= $errors['nama_kategori']; ?></div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?= base_url('produk/kategori'); ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>
