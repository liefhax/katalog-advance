<?= $this->extend('main_layout') ?>

<?= $this->section('content') ?>
<main class="container-xl my-5 mx-auto text-center" style="max-width: 600px;">
    <div class="card shadow-sm border-0 rounded-4 p-4 p-md-5">
        <i class="bi bi-check-circle-fill text-success mb-3" style="font-size: 4rem;"></i>

        <h2 class="fw-bold mb-3"><?= esc($title) ?></h2>

        <p class="text-muted">
            Terima kasih telah berbelanja! Pesanan Anda dengan nomor
            <strong><?= esc($orderData['order_code']) ?></strong> telah kami terima.
        </p>

        <hr class="my-4">

        <h4 class="fw-bold mb-3">Instruksi Pembayaran</h4>

        <?php if (strpos($orderData['payment_method'], 'qris') !== false && !empty($orderData['qris_image_url'])): ?>
            <p>Silakan lakukan pembayaran dengan men-scan kode QRIS di bawah ini:</p>
            <img src="<?= esc($orderData['qris_image_url']) ?>" alt="QRIS Code" class="img-fluid mb-3" style="max-width: 250px;">
            <p class="fw-bold fs-5">Jumlah yang harus dibayar:</p>
            <h3 class="fw-bold text-primary mb-3">
                Rp <?= number_format($orderData['total_to_pay'], 0, ',', '.') ?>
            </h3>
            <p class="text-muted small">(Jumlah sudah termasuk kode unik untuk verifikasi)</p>
            <a href="#" class="btn btn-warning mt-2">Konfirmasi Pembayaran</a>

        <?php elseif (strpos($orderData['payment_method'], 'manual') !== false): ?>
            <p>Silakan lakukan transfer ke salah satu rekening berikut:</p>

            <?php if ($orderData['payment_method'] === 'bca_manual'): ?>
                <p><strong>Bank BCA:</strong> 1234567890 a/n Toko Kamu</p>
            <?php elseif ($orderData['payment_method'] === 'mandiri_manual'): ?>
                <p><strong>Bank Mandiri:</strong> 0987654321 a/n Toko Kamu</p>
            <?php endif; ?>

            <p class="fw-bold fs-5">Jumlah yang harus dibayar:</p>
            <h3 class="fw-bold text-primary mb-3">
                Rp <?= number_format($orderData['total_to_pay'], 0, ',', '.') ?>
            </h3>
            <p class="text-muted small">(Jumlah sudah termasuk kode unik untuk verifikasi)</p>

            <a href="#" class="btn btn-warning mt-2">Konfirmasi Pembayaran</a>

        <?php else: ?>
            <p class="text-danger">Metode pembayaran tidak dikenal.</p>
        <?php endif; ?>

        <hr class="my-4">
        <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary">Kembali ke Beranda</a>
    </div>
</main>
<?= $this->endSection() ?>
