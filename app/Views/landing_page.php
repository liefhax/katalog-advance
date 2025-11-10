<?= $this->extend('main_layout') ?>

<?= $this->section('content') ?>

<?= $this->extend('main_layout') ?>

<?= $this->section('content') ?>

    <!-- 1. Hero Section -->
    <section class="relative h-[540px]">
        <img src="<?= base_url('assets/images/clotes 1.png') ?>" alt="Fashion" class="w-full h-full object-cover">
        <div class="absolute inset-0 flex items-center">
            <div class="max-w-7xl mx-auto px-4 w-full flex justify-end">
                <div class="bg-black/40 backdrop-blur-md border border-white/20 p-8 max-w-md text-white">
                    <h1 class="text-4xl mb-4">Temukan Gaya Terbaikmu di NU Uncle</h1>
                    <p class="text-lg mb-6">Katalog online modern dari NU Uncle Factory Outlet hadir untuk kamu yang ingin tampil stylish setiap hari. Jelajahi koleksi pakaian terbaik, dari kasual hingga formal, lengkap dengan fitur pencarian, filter, dan pembelian online yang praktis.</p>
                    <a href="<?= base_url('products') ?>" class="inline-block bg-white text-black px-6 py-3 font-medium hover:bg-gray-100 transition-colors">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Include all sections -->
    <?= $this->include('sections/product_section') ?>

    <div class="border-t border-gray-200"></div>

    <?= $this->include('sections/gaya_kami_section') ?>

    <div class="border-t border-gray-200"></div>

    <?= $this->include('sections/desain_ekslusif_section') ?>

    <div class="border-t border-gray-200"></div>

    <?= $this->include('sections/new_product_section') ?>

    <div class="border-t border-gray-200"></div>

    <?= $this->include('sections/collections_section') ?>

    <div class="border-t border-gray-200"></div>

    <?= $this->include('sections/discount_section') ?>

<?= $this->endSection() ?>

<?= $this->endSection() ?>

