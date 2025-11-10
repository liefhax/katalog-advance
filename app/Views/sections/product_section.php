<!-- Our Products Section -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold uppercase mb-4">Our Products</h2>
            <p class="text-base text-gray-600 max-w-2xl mx-auto">Discover our curated collection of premium fashion pieces, designed for the modern lifestyle.</p>
        </div>

        <?php if (!empty($products) && is_array($products)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                <?php foreach ($products as $product): ?>
                <div class="bg-white border border-gray-200">
                    <a href="<?= base_url('product/' . $product['slug']) ?>">
                        <img src="<?= base_url('uploads/products/' . $product['image_url']) ?>" class="w-full h-80 object-cover" alt="<?= esc($product['name']) ?>">
                    </a>
                    <div class="p-6">
                        <h3 class="text-lg font-bold mb-2">
                            <a href="<?= base_url('product/' . $product['slug']) ?>" class="text-black hover:text-gray-600 transition-colors">
                                <?= esc($product['name']) ?>
                            </a>
                        </h3>
                        <p class="text-xl font-semibold text-black mb-4">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                        <a href="<?= base_url('product/' . $product['slug']) ?>" class="text-sm text-gray-600 hover:text-black transition-colors">
                            View Details →
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center">
                <a href="<?= base_url('products') ?>" class="inline-block bg-black text-white px-8 py-3 text-sm font-medium hover:bg-gray-800 transition-colors">
                    View All Products
                </a>
            </div>
        <?php else: ?>
            <div class="text-center text-gray-500">
                <p>No products available at the moment.</p>
            </div>
        <?php endif; ?>
    </div>
</section>