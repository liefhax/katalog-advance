<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>
<?= $title ?? 'Tambah Produk' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="page-heading">
    <h3><?= $title ?></h3>
</div>
<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-body">

                <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="alert alert-danger">
                        <h4 class="alert-heading">Gagal menyimpan data!</h4>
                        <p>Pastikan semua inputan sudah benar:</p>
                        <ul>
                            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="/admin/products/create" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= old('name') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="description" name="description" rows="5"><?= old('description') ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategori</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php foreach ($categories as $category) : ?>
                                        <option value="<?= $category['id'] ?>" <?= (old('category_id') == $category['id']) ? 'selected' : '' ?>>
                                            <?= esc($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="price" name="price" value="<?= old('price') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stok</label>
                                <input type="number" class="form-control" id="stock" name="stock" value="<?= old('stock', 0) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="image_url" class="form-label">Gambar Produk</label>
                                <input class="form-control" type="file" id="image_url" name="image_url" required>
                                <small class="text-muted">Max 2MB. (JPG, PNG, JPEG)</small>
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                    <label class="form-check-label" for="is_active">Aktifkan Produk</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Simpan Produk</button>
                        <a href="/admin/products" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>