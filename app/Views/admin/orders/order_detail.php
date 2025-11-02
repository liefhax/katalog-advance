<?php
// File: app/Views/admin/orders/detail.php (Contoh nama file)
?>

<?= $this->extend('admin/layout') ?>

<?php // Bagian ini akan mengisi <title> di layout ?>
<?= $this->section('title') ?>
<?= esc($title ?? 'Detail Pesanan') ?>
<?= $this->endSection() ?>

<?php // Bagian ini akan mengisi #main-content di layout ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <div class="d-flex justify-content-between align-items-center">
        <h3><?= esc($title) ?></h3>
        <a href="/admin/orders" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<div class="page-content">
    <section class="section">

        <?php // Tampilkan notifikasi flash data ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <div class="row">
            
            <?php // --- Kolom Kiri (Detail Item & Alamat) --- ?>
            <div class="col-lg-8">
                
                <?php // Card untuk Item Pesanan ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>Items Pesanan</h5>
                        <?php foreach ($order->items as $item): ?>
                            <div class="d-flex align-items-center border-bottom py-2">
                                <img src="<?= esc($item['image_url'] ?? '') ?>" alt="" style="width:64px;height:64px;object-fit:cover" class="me-3 rounded">
                                <div class="flex-grow-1">
                                    <div><?= esc($item['product_name']) ?></div>
                                    <div class="text-muted">Rp <?= number_format($item['product_price'],0,',','.') ?> x <?= $item['quantity'] ?></div>
                                </div>
                                <div class="text-end fw-semibold">Rp <?= number_format($item['subtotal'],0,',','.') ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php // Card untuk Alamat Pengiriman ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>Alamat Pengiriman</h5>
                        <p class="mb-0"><?= nl2br(esc($order->shipping_address)) ?></p>
                    </div>
                </div>
            </div>

            <?php // --- Kolom Kanan (Update, Ringkasan, Info) --- ?>
            <div class="col-lg-4">

                <?php // Card untuk Update Status ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>Update Status</h5>
                        <form method="POST" action="/admin/orders/update-status/<?= $order->id ?>">
                            <?= csrf_field() ?>
                            <select name="status" class="form-select mb-3">
                                <option value="baru" <?= $order->status_pesanan === 'baru' ? 'selected' : '' ?>>Baru</option>
                                <option value="pending" <?= $order->status_pesanan === 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="processing" <?= $order->status_pesanan === 'processing' ? 'selected' : '' ?>>Processing</option>
                                <option value="dikirim" <?= $order->status_pesanan === 'dikirim' ? 'selected' : '' ?>>Shipped</option>
                                <option value="selesai" <?= $order->status_pesanan === 'selesai' ? 'selected' : '' ?>>Delivered</option>
                                <option value="dibatalkan" <?= $order->status_pesanan === 'dibatalkan' ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                            <button class="btn btn-primary w-100">Update Status</button>
                        </form>
                    </div>
                </div>

                <?php // Card untuk Ringkasan Pesanan ?>
                <div class="card">
                    <div class="card-body">
                        <h5>Ringkasan Pesanan</h5>
                        <div class="d-flex justify-content-between">
                            <span>Subtotal</span>
                            <span>Rp <?= number_format($order->subtotal,0,',','.') ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Diskon</span>
                            <span>- Rp <?= number_format($order->discount_amount,0,',','.') ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Ongkir</span>
                            <span>Rp <?= number_format($order->shipping_cost,0,',','.') ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Kode Unik</span>
                            <span>Rp <?= number_format($order->kode_unik,0,',','.') ?></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span>Rp <?= number_format($order->total_bayar,0,',','.') ?></span>
                        </div>
                    </div>
                </div>

                <?php // Card untuk Info Customer ?>
                <div class="card mt-3">
                    <div class="card-body">
                        <h5>Info Customer</h5>
                        <p class="mb-1"><strong>Nama:</strong> <?= esc($order->customer_name) ?></p>
                        <p class="mb-1"><strong>Email:</strong> <?= esc($order->customer_email) ?></p>
                        <p class="mb-1"><strong>Telepon:</strong> <?= esc($order->customer_phone) ?></p>
                        <p class="mb-0"><strong>Tanggal:</strong> <?= date('d M Y H:i', strtotime($order->created_at)) ?></p>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>

<?php // Bagian ini untuk script JS tambahan (jika ada) ?>
<?= $this->section('scripts') ?>
<?php // Gak ada script khusus di halaman ini, jadi biarkan kosong ?>
<?= $this->endSection() ?>