<?= $this->extend('main_layout') ?>

<?= $this->section('content') ?>

<main class="container-xl my-5 mx-auto">
    <h1 class="mb-4 fw-bold">Keranjang Belanja Anda</h1>

    <?php if (empty($cartItems)): ?>
        
        <div class="text-center p-5 border rounded-4">
            <i class="bi bi-cart-x" style="font-size: 4rem; color: #6c757d;"></i>
            <h3 class="mt-3">Keranjang Anda masih kosong</h3>
            <p class="text-muted">Yuk, cari produk keren dan tambahkan ke sini!</p>
            <a href="<?= base_url('/') ?>" class="btn btn-primary mt-3">Mulai Belanja</a>
        </div>

    <?php else: ?>
        
        <div class="row g-5">
            <div class="col-lg-8">

                <?php foreach ($cartItems as $item): ?>
                <div class="card mb-3 shadow-sm border-0">
                    <div class="row g-0">
                        <div class="col-md-3">
                            <img src="<?= base_url('uploads/products/' . $item['image_url']) ?>" class="img-fluid rounded-start" alt="<?= esc($item['name']) ?>" style="height: 100%; object-fit: cover;">
                        </div>
                        <div class="col">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title fw-bold"><?= esc($item['name']) ?></h5>
                                    <a href="<?= base_url('cart/remove/' . $item['cart_item_id']) ?>" class="btn-close" aria-label="Close"></a>
                                </div>
                                <p class="card-text text-success fw-bold">Rp <?= number_format($item['price'], 0, ',', '.') ?></p>
                                
                                <form action="<?= base_url('cart/update') ?>" method="post" class="d-flex align-items-center">
                                     <?= csrf_field() ?>
                                     <input type="hidden" name="cart_item_id" value="<?= $item['cart_item_id'] ?>">
                                     <label for="quantity-<?= $item['cart_item_id'] ?>" class="me-2">Jumlah:</label>
                                     <input type="number" name="quantity" id="quantity-<?= $item['cart_item_id'] ?>" class="form-control" value="<?= $item['quantity'] ?>" min="1" style="width: 70px;">
                                     <button type="submit" class="btn btn-sm btn-outline-secondary ms-2">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 2rem;">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Ringkasan Belanja</h5>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal</span>
                            <span class="fw-bold fs-5">Rp <?= number_format($total, 0, ',', '.') ?></span>
                        </div>
                        <div class="d-grid">
                            <a href="<?= base_url('checkout') ?>" class="btn btn-primary btn-lg">
                                Lanjut ke Checkout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

</main>

<?= $this->endSection() ?>