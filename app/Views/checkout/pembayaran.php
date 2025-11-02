<?= $this->extend('main_layout') ?>

<?= $this->section('content') ?>

<main class="container-xl my-5 mx-auto" style="max-width: 600px;">
    
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4 p-md-5 text-center">
            
            <h2 class="fw-bold">Pesanan Dibuat!</h2>
            <p class="text-muted">Segera selesaikan pembayaran untuk pesanan:</p>
            
            <h3 class="fw-bold my-3" style="color: #007bff;"><?= esc($order['order_id']) ?></h3>
            
            <hr class="my-4">

            <p class="fs-5">Total yang harus dibayar:</p>
            
            <div class="display-6 fw-bold text-danger mb-4">
                Rp <?= number_format($order['total_bayar'], 0, ',', '.') ?>
            </div>
            
            <div class="alert alert-warning">
                <strong>Penting!</strong> Harap transfer tepat sesuai nominal di atas (termasuk kode unik) agar pesananmu bisa diproses.
            </div>

            <hr>

            <?php if ($order['payment_method'] == 'bca_manual'): ?>
                
                <h4 class="fw-bold">Bank Transfer BCA</h4>
                <p>Silakan transfer ke rekening di bawah ini:</p>
                <h3 class="fw-bold">1234567890</h3>
                <p>a.n. Toko Kamu</p>
                
            <?php elseif ($order['payment_method'] == 'mandiri_manual'): ?>
                
                <h4 class="fw-bold">Bank Transfer Mandiri</h4>
                <p>Silakan transfer ke rekening di bawah ini:</p>
                <h3 class="fw-bold">0987654321</h3>
                <p>a.n. Toko Kamu</p>

            <?php elseif ($order['payment_method'] == 'qris_manual'): ?>

                <h4 class="fw-bold">Pembayaran QRIS</h4>
                
                <?php if ($qr_image): // Cek kalo $qr_image-nya sukses di-generate ?>
                    <p>Scan QR Code di bawah ini dengan e-wallet kamu. Nominal akan terisi otomatis.</p>
                    <img src="<?= $qr_image ?>" alt="Scan QRIS" class="img-fluid rounded border p-2" style="max-width: 300px;">
                <?php else: // Kalo $qr_image-nya null (gagal generate) ?>
                    <p class="text-danger"><strong>Error:</strong> Gagal memuat gambar QRIS.</p>
                    <p>Silakan hubungi admin untuk pembayaran manual.</p>
                <?php endif; ?>
            
            <?php endif; ?>
            <div class="d-grid mt-4">
                <a href="<?= base_url('/akun/pesanan') // Arahin ke halaman riwayat pesanan ?>" class="btn btn-outline-primary">Lihat Daftar Pesanan Saya</a>
            </div>

        </div>
    </div>
</main>

<?= $this->endSection() ?>