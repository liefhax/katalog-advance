<!-- Collections Section -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Men's Collection -->
            <div class="relative min-h-64 border border-gray-200 group">
                <img src="https://source.unsplash.com/random/400x500/?men-fashion" alt="Men's Collection" class="w-full h-full object-cover">
                <div class="absolute bottom-6 left-6 text-white">
                    <h3 class="text-2xl font-bold mb-2">Men</h3>
                    <a href="<?= base_url('products?category=men') ?>" class="text-sm hover:underline">
                        Shop this collection →
                    </a>
                </div>
            </div>

            <!-- Women's Collection -->
            <div class="relative min-h-64 border border-gray-200 group">
                <img src="https://source.unsplash.com/random/400x501/?women-fashion" alt="Women's Collection" class="w-full h-full object-cover">
                <div class="absolute bottom-6 left-6 text-white">
                    <h3 class="text-2xl font-bold mb-2">Women</h3>
                    <a href="<?= base_url('products?category=women') ?>" class="text-sm hover:underline">
                        Shop this collection →
                    </a>
                </div>
            </div>

            <!-- Accessories Collection -->
            <div class="relative min-h-64 border border-gray-200 group">
                <img src="https://source.unsplash.com/random/400x502/?fashion-accessories" alt="Accessories" class="w-full h-full object-cover">
                <div class="absolute bottom-6 left-6 text-white">
                    <h3 class="text-2xl font-bold mb-2">Accessories</h3>
                    <a href="<?= base_url('products?category=accessories') ?>" class="text-sm hover:underline">
                        Shop this collection →
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>