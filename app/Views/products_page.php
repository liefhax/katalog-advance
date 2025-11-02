<?= $this->extend('main_layout') ?>

<?= $this->section('content') ?>

<main class="container-xl my-5 mx-auto">
    <h1 class="mb-5 fw-bold text-center">Semua Koleksi Produk</h1>

    <?php if (!empty($categories) && !empty($productsByCategory)): ?>
        <!-- Looping untuk setiap kategori -->
        <?php foreach ($categories as $category): ?>
            <?php if (isset($productsByCategory[$category['id']])): ?>
                <section class="mb-5">
                    <h2 class="mb-4 border-bottom pb-2 fw-bold"><?= esc($category['name']) ?></h2>
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                        <!-- Looping untuk produk di dalam kategori ini -->
                        <?php foreach ($productsByCategory[$category['id']] as $product): ?>
                        <div class="col">
                            <div class="card h-100 shadow-sm rounded-4 border-0 overflow-hidden">
                                <a href="<?= base_url('product/' . $product['slug']) ?>">
<<<<<<< HEAD
                                    <img src="<?= base_url('uploads/products/' . $product['image_url']) ?>" class="card-img-top product-img" alt="<?= esc($product['name']) ?>">
=======
                                    <img src="<?= esc($product['image_url']) ?>" class="card-img-top product-img" alt="<?= esc($product['name']) ?>">
>>>>>>> 3f36f2c33831e6bfbf5d2bedd649fd897e4a7795
                                </a>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold">
                                        <a href="<?= base_url('product/' . $product['slug']) ?>" class="text-decoration-none text-body">
                                            <?= esc($product['name']) ?>
                                        </a>
                                    </h5>
                                    <p class="card-text text-success fw-bold fs-5 mt-auto">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                                    <a href="<?= base_url('product/' . $product['slug']) ?>" class="btn btn-outline-primary w-100 mt-2">
                                        <i class="bi bi-eye-fill me-1"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center p-5 border rounded-4">
            <h3 class="mt-3">Belum ada produk yang tersedia</h3>
            <p class="text-muted">Silakan cek kembali nanti.</p>
        </div>
    <?php endif; ?>

</main>

<?= $this->endSection() ?>

