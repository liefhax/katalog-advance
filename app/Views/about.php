<!-- Menggunakan kerangka utama -->
<?= $this->extend('main_layout') ?>

<!-- Mendefinisikan isi konten untuk bagian 'content' -->
<?= $this->section('content') ?>

<div class="py-8 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto space-y-8 animate-fade-in">

        <!-- Header Section -->
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 tracking-tight">
                Tentang UncleStore
            </h1>
            <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                Kami adalah toko furniture modern yang berkomitmen untuk menghadirkan produk berkualitas tinggi
                dengan desain yang stylish dan fungsional untuk rumah dan ruang kerja Anda.
            </p>
        </div>

        <!-- Mission & Vision -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Mission -->
            <div class="bg-white p-8 shadow-lg border border-gray-200">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-gray-900">Misi Kami</h3>
                    </div>
                </div>
                <p class="text-gray-600 leading-relaxed">
                    Menyediakan furniture berkualitas tinggi dengan desain modern yang dapat diakses oleh semua kalangan.
                    Kami berkomitmen untuk memberikan pelayanan terbaik dan produk yang tahan lama untuk kebutuhan rumah tangga dan bisnis Anda.
                </p>
            </div>

            <!-- Vision -->
            <div class="bg-white p-8 shadow-lg border border-gray-200">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-gray-900">Visi Kami</h3>
                    </div>
                </div>
                <p class="text-gray-600 leading-relaxed">
                    Menjadi brand furniture terdepan di Indonesia yang dikenal karena inovasi desain, kualitas produk,
                    dan kepuasan pelanggan yang luar biasa. Kami ingin menciptakan ruang yang indah dan fungsional untuk setiap rumah.
                </p>
            </div>
        </div>

        <!-- Why Choose Us -->
        <div class="bg-white p-8 shadow-lg border border-gray-200">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Mengapa Memilih UncleStore?</h2>
                <p class="mt-2 text-gray-600">Keunggulan yang membuat kami berbeda dari yang lain</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Quality -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Kualitas Terjamin</h3>
                    <p class="text-gray-600 text-sm">Semua produk kami melalui proses quality control yang ketat untuk memastikan durability dan keamanan.</p>
                </div>

                <!-- Design -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Desain Modern</h3>
                    <p class="text-gray-600 text-sm">Koleksi furniture dengan desain contemporary yang mengikuti tren terkini dan cocok untuk berbagai gaya rumah.</p>
                </div>

                <!-- Service -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Pelayanan Prima</h3>
                    <p class="text-gray-600 text-sm">Tim customer service kami siap membantu Anda 24/7 dengan konsultasi dan dukungan penuh.</p>
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="bg-white p-8 shadow-lg border border-gray-200">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Hubungi Kami</h2>
                <p class="mt-2 text-gray-600">Kami siap membantu Anda dengan pertanyaan atau kebutuhan furniture</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Address -->
                <div class="text-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Alamat</h3>
                    <p class="text-gray-600 text-sm">Jl. Furniture No. 123<br>Jakarta Selatan, DKI Jakarta<br>Indonesia 12345</p>
                </div>

                <!-- Phone -->
                <div class="text-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Telepon</h3>
                    <p class="text-gray-600 text-sm">+62 21 1234 5678<br>+62 812 3456 7890</p>
                </div>

                <!-- Email -->
                <div class="text-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Email</h3>
                    <p class="text-gray-600 text-sm">info@unclestore.com<br>support@unclestore.com</p>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>