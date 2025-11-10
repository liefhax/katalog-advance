<!-- Menggunakan kerangka utama -->
<?= $this->extend('main_layout') ?>

<!-- Mendefinisikan isi konten untuk bagian 'content' -->
<?= $this->section('content') ?>

<div class="flex items-center justify-center  py-8 px-4 sm:px-6">
    <div class="max-w-sm w-full space-y-6 animate-fade-in">
        <!-- Header with floating animation -->
        <div class="text-center transform hover:scale-105 transition-transform duration-300">
            <div class="inline-block p-4 bg-white shadow-lg">
                <img class="h-12 w-auto mx-auto" src="<?= base_url('assets/images/icons/logo.png') ?>" alt="UncleStore">
            </div>
            <h2 class="mt-4 text-2xl font-bold text-gray-900 tracking-tight">
                Masuk ke Akun Anda
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Belum punya akun?
                <a href="<?= base_url('register') ?>" class="font-medium text-blue-600 hover:text-blue-500 transition-colors">
                    Daftar sekarang
                </a>
            </p>
        </div>

        <!-- Notification Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 shadow-sm animate-slide-down" role="alert">
                <span class="block sm:inline"><?= session()->getFlashdata('success') ?></span>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 shadow-sm animate-slide-down" role="alert">
                <span class="block sm:inline"><?= session()->getFlashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form class="space-y-4 bg-white p-6 shadow-lg border-t-4 border-black" action="<?= base_url('/login/process') ?>" method="post">
            <?= csrf_field() ?>

            <div class="space-y-3">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Alamat Email
                    </label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                           class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                           placeholder="Masukkan email Anda">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Password
                    </label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                           class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                           placeholder="Masukkan password Anda">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold text-white bg-black hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                    </span>
                    Masuk
                </button>
            </div>

            <!-- Demo Info with subtle animation -->
            <div class="bg-gray-50 border border-gray-200 p-3 mt-4 hover:bg-gray-100 transition-colors duration-200">
                <div class="text-xs text-gray-700">
                    <strong class="font-medium text-gray-900">Demo Admin:</strong>
                    <div class="mt-1 font-mono">
                        Email: budi@bud.com<br>
                        Password: 123456
                    </div>
                </div>
            </div>
        </form>

        <!-- Floating particles effect -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-blue-200 opacity-60 animate-float"></div>
            <div class="absolute top-3/4 right-1/4 w-1 h-1 bg-gray-300 opacity-40 animate-float-delayed"></div>
            <div class="absolute top-1/2 left-3/4 w-1.5 h-1.5 bg-gray-400 opacity-50 animate-float"></div>
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

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-10px) rotate(180deg); }
}

@keyframes float-delayed {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-15px) rotate(180deg); }
}

.animate-fade-in {
    animation: fade-in 0.6s ease-out;
}

.animate-slide-down {
    animation: slide-down 0.4s ease-out;
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
    animation: float-delayed 8s ease-in-out infinite;
    animation-delay: 2s;
}
</style>

<?= $this->endSection() ?>