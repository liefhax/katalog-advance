<?= $this->extend('main_layout') ?>

<?= $this->section('content') ?>

    <!-- 1. Hero Section -->
    <section class="p-5 p-md-5 text-center bg-primary bg-opacity-10 text-primary-emphasis rounded-3 my-4 mx-3 mx-lg-5">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold mb-3">Temukan Gaya & Pakaian Terbaikmu</h1>
            <p class="fs-4 mb-4">Dari kaos oversized ternyaman hingga jaket paling stylish, semua ada di sini!</p>
            <a href="<?= base_url('products') ?>" class="btn btn-primary btn-lg rounded-pill px-5 shadow-lg" role="button">
                Lihat Semua Koleksi <i class="bi bi-arrow-right-short"></i>
            </a>
        </div>
    </section>

    <!-- 2. Daftar Produk Unggulan -->
    <section class="container-xl my-5 mx-auto">
        <h2 class="text-center mb-5 fw-bold">Produk Terbaru</h2>
        <?php if (!empty($products) && is_array($products)): ?>
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php foreach ($products as $product): ?>
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
            <!-- Tombol Lihat Semua -->
            <div class="text-center mt-5">
                <a href="<?= base_url('products') ?>" class="btn btn-outline-primary btn-lg rounded-pill px-5">Lihat Semua Produk</a>
            </div>
        <?php else: ?>
            <div class="text-center"><p>Belum ada produk.</p></div>
        <?php endif; ?>
    </section>

<?= $this->endSection() ?>

