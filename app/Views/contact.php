<!-- Menggunakan kerangka utama -->
<?= $this->extend('main_layout') ?>

<!-- Mendefinisikan isi konten untuk bagian 'content' -->
<?= $this->section('content') ?>

<div class="py-8 px-4 sm:px-6">
    <div class="max-w-7xl mx-auto space-y-8 animate-fade-in">

        <!-- Header Section -->
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 tracking-tight">
                Hubungi Kami
            </h1>
            <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                Ada pertanyaan tentang produk kami atau butuh bantuan? Jangan ragu untuk menghubungi tim kami.
                Kami siap membantu Anda dengan pelayanan terbaik.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Contact Form -->
            <div class="bg-white p-8 shadow-lg border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h2>

                <form action="#" method="post" class="space-y-6">
                    <?= csrf_field() ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" id="name" name="name" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" id="email" name="email" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                        <input type="tel" id="phone" name="phone"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subjek</label>
                        <select id="subject" name="subject" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Subjek</option>
                            <option value="inquiry">Pertanyaan Produk</option>
                            <option value="support">Dukungan Teknis</option>
                            <option value="complaint">Keluhan</option>
                            <option value="partnership">Kemitraan</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                        <textarea id="message" name="message" rows="5" required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                  placeholder="Tuliskan pesan Anda di sini..."></textarea>
                    </div>

                    <button type="submit"
                            class="w-full bg-black text-white py-3 px-4 text-lg font-semibold hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg">
                        Kirim Pesan
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-6">

                <!-- Contact Details -->
                <div class="bg-white p-8 shadow-lg border border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Informasi Kontak</h3>

                    <div class="space-y-6">
                        <!-- Address -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Alamat</h4>
                                <p class="text-gray-600 mt-1">
                                    Jl. Furniture No. 123<br>
                                    Jakarta Selatan, DKI Jakarta<br>
                                    Indonesia 12345
                                </p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Telepon</h4>
                                <p class="text-gray-600 mt-1">
                                    +62 21 1234 5678<br>
                                    +62 812 3456 7890
                                </p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Email</h4>
                                <p class="text-gray-600 mt-1">
                                    info@unclestore.com<br>
                                    support@unclestore.com
                                </p>
                            </div>
                        </div>

                        <!-- Business Hours -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Jam Operasional</h4>
                                <div class="text-gray-600 mt-1">
                                    <p>Senin - Jumat: 09:00 - 18:00</p>
                                    <p>Sabtu: 09:00 - 16:00</p>
                                    <p>Minggu: Tutup</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map Placeholder -->
                <div class="bg-white p-8 shadow-lg border border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Lokasi Kami</h3>
                    <div class="aspect-w-16 aspect-h-9 bg-gray-200 rounded-lg flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                            <p class="text-gray-500">Peta lokasi akan ditampilkan di sini</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- FAQ Section -->
        <div class="bg-white p-8 shadow-lg border border-gray-200">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Pertanyaan Umum</h2>
                <p class="mt-2 text-gray-600">Jawaban untuk pertanyaan yang sering ditanyakan</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">Berapa lama waktu pengiriman?</h3>
                    <p class="text-gray-600 text-sm">Waktu pengiriman tergantung lokasi Anda. Untuk area Jakarta biasanya 2-3 hari kerja, luar Jakarta 3-7 hari kerja.</p>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">Apakah ada garansi produk?</h3>
                    <p class="text-gray-600 text-sm">Ya, semua produk kami memiliki garansi minimal 1 tahun untuk cacat pabrik dan material.</p>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">Bisakah saya request custom design?</h3>
                    <p class="text-gray-600 text-sm">Tentu! Kami menyediakan layanan custom furniture. Silakan hubungi tim kami untuk konsultasi lebih lanjut.</p>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900 mb-2">Bagaimana cara mengembalikan produk?</h3>
                    <p class="text-gray-600 text-sm">Produk dapat dikembalikan dalam 7 hari dengan kondisi masih baru dan dalam kemasan asli.</p>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>