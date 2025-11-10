<!-- Menggunakan kerangka utama -->
<?= $this->extend('main_layout') ?>

<!-- Mendefinisikan isi konten untuk bagian 'content' -->
<?= $this->section('content') ?>

<div class="py-8 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto space-y-8 animate-fade-in">

        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 tracking-tight">
                    Kelola Alamat
                </h1>
                <a href="<?= base_url('profile') ?>"
                   class="inline-flex items-center mt-2 text-base text-gray-600 hover:text-gray-900 hover:underline transition-colors duration-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Profil
                </a>
            </div>
            <a href="<?= base_url('profile/addresses/new') ?>"
               class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium text-white bg-black hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Alamat
            </a>
        </div>

        <!-- Notification Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-4 shadow-sm animate-slide-down max-w-4xl mx-auto" role="alert">
                <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-6 py-4 shadow-sm animate-slide-down max-w-4xl mx-auto" role="alert">
                <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <!-- Addresses List -->
        <?php if (empty($addresses)): ?>
            <!-- Empty State -->
            <div class="bg-white shadow-sm border-t-4 border-black overflow-hidden">
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada alamat</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai tambahkan alamat pengiriman Anda.</p>
                    <div class="mt-6">
                        <a href="<?= base_url('profile/addresses/new') ?>"
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Alamat Baru
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Addresses Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($addresses as $address): ?>
                    <div class="bg-white shadow-sm border-t-4 border-black overflow-hidden relative">
                        <?php if ($address['is_default']): ?>
                            <div class="absolute top-0 right-0 bg-green-500 text-white text-xs px-2 py-1 font-medium">
                                Utama
                            </div>
                        <?php endif; ?>

                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <?= esc($address['label'] ?? 'Alamat') ?>
                                </h3>
                                <div class="flex space-x-2">
                                    <?php if (!$address['is_default']): ?>
                                        <form action="<?= base_url('profile/addresses/set-default/' . $address['id']) ?>" method="post" class="inline">
                                            <?= csrf_field() ?>
                                            <button type="submit"
                                                    class="text-xs text-blue-600 hover:text-blue-800 font-medium"
                                                    onclick="return confirm('Jadikan alamat ini sebagai alamat utama?')">
                                                Jadikan Utama
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="space-y-2 text-sm text-gray-600">
                                <p class="font-medium text-gray-900">
                                    <?= esc($address['recipient_name'] ?? '') ?>
                                </p>
                                <p>
                                    <?= esc($address['recipient_phone'] ?? '') ?>
                                </p>
                                <p>
                                    <?= esc($address['street_address'] ?? '') ?>
                                </p>
                                <p>
                                    <?= esc($address['subdistrict_name'] ?? '') ?>, <?= esc($address['city_name'] ?? '') ?>
                                </p>
                                <p>
                                    <?= esc($address['province_name'] ?? '') ?> <?= esc($address['postal_code'] ?? '') ?>
                                </p>
                            </div>

                            <div class="mt-6 flex space-x-3">
                                <a href="<?= base_url('profile/addresses/edit/' . $address['id']) ?>"
                                   class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit
                                </a>
                                <form action="<?= base_url('profile/addresses/delete/' . $address['id']) ?>" method="post" class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus alamat ini?')">
                                    <?= csrf_field() ?>
                                    <button type="submit"
                                            class="w-full inline-flex justify-center items-center px-3 py-2 border border-red-300 shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slide-down {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fade-in 0.6s ease-out;
}

.animate-slide-down {
    animation: slide-down 0.4s ease-out;
}
</style>

<?= $this->endSection() ?>