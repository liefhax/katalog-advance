<?= $this->extend('main_layout') ?>

<?= $this->section('content') ?>

<div class="py-8 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto space-y-8 animate-fade-in">

        <!-- Header Section -->
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 tracking-tight">
                Pesanan Berhasil Dibuat!
            </h1>
            <p class="mt-2 text-lg text-gray-600">
                Terima kasih telah berbelanja di UncleStore
            </p>
        </div>

        <!-- Success Card -->
        <div class="max-w-2xl mx-auto">
            <div class="bg-white p-8 shadow-lg border border-gray-200 text-center">

                <!-- Success Icon -->
                <div class="inline-block p-4 bg-green-100 rounded-full mb-6">
                    <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <!-- Order Details -->
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    Pesanan Diterima
                </h2>

                <p class="text-gray-600 mb-6">
                    Terima kasih telah berbelanja! Pesanan Anda dengan nomor
                    <span class="font-semibold text-gray-900 bg-gray-100 px-2 py-1 rounded">
                        <?= esc($orderData['order_code']) ?>
                    </span>
                    telah kami terima.
                </p>

                <hr class="border-gray-200 mb-6">

                <!-- Payment Instructions -->
                <div class="text-left">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">
                        Instruksi Pembayaran
                    </h3>

                    <?php if (strpos($orderData['payment_method'], 'qris') !== false && !empty($orderData['qris_image_url'])): ?>
                        <p class="text-gray-600 mb-4">Silakan lakukan pembayaran dengan men-scan kode QRIS di bawah ini:</p>

                        <div class="flex justify-center mb-4">
                            <img src="<?= esc($orderData['qris_image_url']) ?>"
                                 alt="QRIS Code"
                                 class="w-full max-w-xs rounded-lg border border-gray-200 shadow-sm">
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg mb-4">
                            <p class="text-sm text-gray-600 mb-2">Jumlah yang harus dibayar:</p>
                            <p class="text-2xl font-bold text-gray-900">
                                Rp <?= number_format($orderData['total_to_pay'], 0, ',', '.') ?>
                            </p>
                            <p class="text-xs text-gray-500 mt-1">(Jumlah sudah termasuk kode unik untuk verifikasi)</p>
                        </div>

                        <button class="w-full bg-yellow-500 text-white py-3 px-4 text-lg font-semibold hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg">
                            Konfirmasi Pembayaran
                        </button>

                    <?php elseif (strpos($orderData['payment_method'], 'manual') !== false): ?>
                        <p class="text-gray-600 mb-4">Silakan lakukan transfer ke salah satu rekening berikut:</p>

                        <div class="bg-gray-50 p-4 rounded-lg mb-4">
                            <?php if ($orderData['payment_method'] === 'bca_manual'): ?>
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold text-gray-900">Bank BCA:</span>
                                    <span class="font-mono text-gray-800">1234567890</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">a/n Toko Kamu</p>
                            <?php elseif ($orderData['payment_method'] === 'mandiri_manual'): ?>
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold text-gray-900">Bank Mandiri:</span>
                                    <span class="font-mono text-gray-800">0987654321</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">a/n Toko Kamu</p>
                            <?php endif; ?>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg mb-4">
                            <p class="text-sm text-gray-600 mb-2">Jumlah yang harus dibayar:</p>
                            <p class="text-2xl font-bold text-gray-900">
                                Rp <?= number_format($orderData['total_to_pay'], 0, ',', '.') ?>
                            </p>
                            <p class="text-xs text-gray-500 mt-1">(Jumlah sudah termasuk kode unik untuk verifikasi)</p>
                        </div>

                        <button class="w-full bg-yellow-500 text-white py-3 px-4 text-lg font-semibold hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg">
                            Konfirmasi Pembayaran
                        </button>

                    <?php else: ?>
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                            Metode pembayaran tidak dikenal.
                        </div>
                    <?php endif; ?>
                </div>

                <hr class="border-gray-200 my-6">

                <!-- Back to Home Button -->
                <a href="<?= base_url('/') ?>"
                   class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Beranda
                </a>

            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
