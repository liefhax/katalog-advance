<?= $this->extend('main_layout') ?>

<?= $this->section('content') ?>

<main class="container-xl my-5 mx-auto">
    <!-- Menampilkan kata kunci yang dicari -->
    <h1 class="mb-4 fw-bold">Hasil pencarian untuk: "<?= esc($keyword) ?>"</h1>

    <!-- Cek apakah ada produk yang ditemukan -->
    <?php if (!empty($products) && is_array($products)): ?>
        <p class="text-muted mb-4">Menemukan <?= count($products) ?> produk yang cocok.</p>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
            
            <!-- Looping untuk menampilkan setiap produk -->
            <?php foreach ($products as $product): ?>
            <div class="col">
                <div class="card h-100 shadow-sm rounded-4 border-0 overflow-hidden">
                    <a href="<?= base_url('product/' . $product['slug']) ?>">
                        <img src="<?= base_url('uploads/products/' . $product['image_url']) ?>" class="card-img-top product-img" alt="<?= esc($product['name']) ?>">
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
    <?php else: ?>
        <!-- Tampilkan pesan jika tidak ada produk -->
        <div class="text-center p-5 border rounded-4">
            <i class="bi bi-search" style="font-size: 4rem; color: #6c757d;"></i>
            <h3 class="mt-3">Oops, produk tidak ditemukan</h3>
            <p class="text-muted">Coba gunakan kata kunci lain yang lebih umum, misalnya "kaos" atau "jaket".</p>
            <a href="<?= base_url('/') ?>" class="btn btn-primary mt-3">Kembali ke Beranda</a>
        </div>
    <?php endif; ?>

</main>

<?= $this->endSection() ?>

