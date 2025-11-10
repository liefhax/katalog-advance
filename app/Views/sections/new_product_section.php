<!-- New Product Section -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold mb-4">New Products</h2>
            <p class="text-base text-gray-600">Koleksi terbaru untuk minggu ini</p>
        </div>

        <?php if (!empty($newProducts) && is_array($newProducts)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach (array_slice($newProducts, 0, 4) as $product): ?>
                <div class="bg-white border border-gray-300 hover:border-gray-400 transition-colors group">
                    <a href="<?= base_url('product/' . $product['slug']) ?>">
                        <img src="<?= base_url('uploads/products/' . $product['image_url']) ?>" class="w-full h-64 object-cover group-hover:-translate-y-1 transition-transform duration-300" alt="<?= esc($product['name']) ?>">
                    </a>
                    <div class="p-5">
                        <h3 class="text-lg font-semibold mb-2">
                            <a href="<?= base_url('product/' . $product['slug']) ?>" class="text-black hover:text-gray-600 transition-colors">
                                <?= esc($product['name']) ?>
                            </a>
                        </h3>
                        <p class="text-xl font-semibold text-black mb-3">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                        <a href="<?= base_url('product/' . $product['slug']) ?>" class="text-sm text-gray-600 hover:text-black transition-colors">
                            View →
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">Belum ada produk baru</p>
            </div>
        <?php endif; ?>
    </div>
</section>