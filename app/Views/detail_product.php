<?= $this->extend('main_layout') ?>

<?= $this->section('content') ?>

<main class="flex-grow-1">
    <div class="container-xl my-5 mx-auto">
        <div class="card p-4 p-lg-5 shadow-lg border-0 rounded-4">
            <div class="row g-5">
                <!-- Kolom Gambar Produk -->
                <div class="col-lg-6">
                    <img src="<?= base_url('uploads/products/' . $product['image_url']) ?>" class="card-img-top product-img" alt="<?= esc($product['name']) ?>">
                </div>

                <!-- Kolom Detail Produk -->
                <div class="col-lg-6 d-flex flex-column">
                    <h1 class="fw-bold mb-3 display-5"><?= esc($product['name']) ?></h1>
                    
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge text-bg-warning me-2 fs-6"><i class="bi bi-star-fill"></i> 4.8</span>
                        <span class="text-muted">| Terjual 1.2rb+</span>
                    </div>

                    <p class="fs-4 text-success fw-bold mb-4">
                        Rp <?= number_format($product['price'], 0, ',', '.') ?>
                    </p>
                    
                    <h5 class="fw-bold">Deskripsi Produk:</h5>
                    <p class="text-muted mb-4">
                        <?= esc($product['description']) ?>
                    </p>

                    <!-- Tombol Aksi -->
                    <div class="mt-auto">
                         <div class="d-grid gap-2 d-sm-flex">
<form action="<?= base_url('cart/add') ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
    <button class="btn btn-primary btn-lg flex-grow-1" type="submit">
        <i class="bi bi-cart-plus-fill me-2"></i>Tambah ke Keranjang
    </button>
    </form>
                            <button class="btn btn-outline-secondary btn-lg" type="button" title="Tambahkan ke Wishlist">
                                <i class="bi bi-heart-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?= $this->endSection() ?>
