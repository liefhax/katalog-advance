<!-- Menggunakan kerangka utama -->
<?= $this->extend('main_layout') ?>

<!-- Mendefinisikan isi konten untuk bagian 'content' -->
<?= $this->section('content') ?>

<div class="py-8 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto space-y-8 animate-fade-in">

        <!-- Header Section -->
        <div>
            <h1 class="text-4xl font-bold text-gray-900 tracking-tight">
                Profil Saya
            </h1>
            <a href="<?= base_url('/') ?>"
               class="inline-flex items-center mt-2 text-base text-gray-600 hover:text-gray-900 hover:underline transition-colors duration-200">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>

        <!-- Notification Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-4 shadow-sm animate-slide-down max-w-4xl mx-auto" role="alert">
                <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-6 py-4 shadow-sm animate-slide-down max-w-4xl mx-auto" role="alert">
                <ul class="list-disc list-inside">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Profile Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Profile Information -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow-sm border-t-4 border-black overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">Informasi Profil</h2>
                    </div>

                    <form action="<?= base_url('profile/update') ?>" method="post" class="p-6 space-y-6">
                        <?= csrf_field() ?>

                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap
                            </label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="<?= esc($user['name'] ?? '') ?>"
                                   class="w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   required>
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   value="<?= esc($user['email'] ?? '') ?>"
                                   class="w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   required>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Kata Sandi Baru (Opsional)
                            </label>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   class="w-full px-3 py-2 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Kosongkan jika tidak ingin mengubah">
                            <p class="mt-1 text-sm text-gray-500">Biarkan kosong jika tidak ingin mengubah kata sandi</p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium text-white bg-black hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">

                <!-- Account Actions -->
                <div class="bg-white shadow-sm border-t-4 border-black overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Pengaturan Akun</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <a href="<?= base_url('profile/addresses') ?>"
                           class="flex items-center w-full px-4 py-3 text-left text-gray-700 bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Kelola Alamat
                        </a>

                        <a href="<?= base_url('cart') ?>"
                           class="flex items-center w-full px-4 py-3 text-left text-gray-700 bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="m1 1 4 4h15l-1 9H6"></path>
                            </svg>
                            Keranjang Belanja
                        </a>
                    </div>
                </div>

                <!-- Account Info -->
                <div class="bg-white shadow-sm border-t-4 border-black overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Info Akun</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Bergabung sejak:</span>
                            <span class="text-sm font-medium text-gray-900">
                                <?= date('d M Y', strtotime($user['created_at'] ?? 'now')) ?>
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Status:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium bg-green-100 text-green-800">
                                Aktif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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