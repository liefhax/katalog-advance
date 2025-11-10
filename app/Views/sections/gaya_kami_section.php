<!-- Gaya Kami Section -->
<section class="py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-16">
            <!-- Left Column - Text Content -->
            <div class="lg:w-2/5">
                <div class="relative mb-6">
                    <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-12 h-px bg-black"></div>
                    <h2 class="text-4xl font-bold ml-16">Gaya Kami</h2>
                </div>
                <p class="text-base text-gray-600 mb-8 leading-relaxed">
                    Kami percaya bahwa fashion adalah ekspresi diri. Dengan koleksi yang dirancang untuk semua orang, kami hadirkan gaya yang timeless dan modern untuk setiap momen dalam hidup Anda.
                </p>
                <a href="<?= base_url('about') ?>" class="inline-block bg-black text-white px-6 py-3 text-sm font-medium hover:bg-gray-800 transition-colors">
                    Learn More
                </a>
            </div>

            <!-- Right Column - Images -->
            <div class="lg:w-3/5">
                <div class="grid grid-cols-2 gap-4">
                    <div class="aspect-[4/5]">
                        <img src="<?= base_url('assets/images/fashion-1.jpg') ?>" alt="Fashion Style 1" class="w-full h-full object-cover">
                    </div>
                    <div class="aspect-[3/4] mt-8">
                        <img src="<?= base_url('assets/images/fashion-2.jpg') ?>" alt="Fashion Style 2" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>