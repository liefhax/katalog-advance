<?= $this->extend('main_layout') ?>

<?= $this->section('content') ?>

<!-- 1. Page Header / Breadcrumb -->
<section class="bg-gray-800 text-white py-4">
    <div class="max-w-7xl mx-auto px-4">
        <nav class="text-sm">
            <a href="<?= base_url() ?>" class="text-gray-300 hover:text-white">Home</a>
            <span class="mx-2 text-gray-500">></span>
            <a href="<?= base_url('products') ?>" class="text-gray-300 hover:text-white">Products</a>
            <span class="mx-2 text-gray-500">></span>
            <span class="text-white"><?= esc($product['name']) ?></span>
        </nav>
    </div>
</section>

<!-- 2. Main Product Area -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Left Column - Product Gallery -->
            <div class="lg:w-2/5">
                <!-- Main Product Image -->
                <div class="mb-6">
                    <img id="main-product-image" src="<?= base_url('uploads/products/' . $product['image_url']) ?>" alt="<?= esc($product['name']) ?>" class="w-full aspect-square object-cover border border-gray-200">
                </div>
            </div>

            <!-- Right Column - Product Info -->
            <div class="lg:w-3/5">
                <h1 class="text-3xl font-bold text-gray-900 mb-4"><?= esc($product['name']) ?></h1>

                <div class="text-2xl font-semibold text-gray-900 mb-6">
                    Rp <?= number_format($product['price'], 0, ',', '.') ?>
                </div>

                <div class="text-gray-600 leading-relaxed mb-8">
                    <?= esc($product['description'] ?? 'Premium quality fashion piece designed for the modern lifestyle. Crafted with attention to detail and made to last.') ?>
                </div>

                <!-- Quantity Selector and Add to Cart -->
                <div class="flex items-center gap-4 mb-8">
                    <div class="flex items-center border border-gray-300">
                        <button class="px-4 py-3 border-r border-gray-300 hover:bg-gray-50" onclick="updateQuantity(-1)">-</button>
                        <input type="text" id="quantity" value="1" class="w-16 text-center py-3 border-0" readonly>
                        <button class="px-4 py-3 border-l border-gray-300 hover:bg-gray-50" onclick="updateQuantity(1)">+</button>
                    </div>

                    <form action="<?= base_url('cart/add') ?>" method="post" class="flex-1">
                        <?= csrf_field() ?>
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="hidden" name="quantity" id="cart-quantity" value="1">
                        <button type="submit" class="w-full bg-black text-white py-3 text-sm font-medium hover:bg-gray-800 transition-colors">
                            Add to Cart
                        </button>
                    </form>
                </div>

                <!-- Product Features -->
                <ul class="space-y-3 text-gray-600">
                    <li class="flex items-start">
                        <span class="text-black mr-3">•</span>
                        Premium quality materials and craftsmanship
                    </li>
                    <li class="flex items-start">
                        <span class="text-black mr-3">•</span>
                        Designed for comfort and style
                    </li>
                    <li class="flex items-start">
                        <span class="text-black mr-3">•</span>
                        Available in multiple sizes and colors
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- 3. Tabs Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Tab Navigation -->
        <div class="border-b border-gray-200 mb-8">
            <nav class="flex space-x-8">
                <button class="tab-button active py-4 px-2 border-b-2 border-black text-black font-medium" data-tab="description">
                    Description
                </button>
                <button class="tab-button py-4 px-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium" data-tab="details">
                    Details
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="tab-content">
            <div id="description" class="tab-pane active">
                <div class="prose max-w-none text-gray-600 leading-relaxed">
                    <?= nl2br(esc($product['description'] ?? 'No description available.')) ?>
                </div>
            </div>

            <div id="details" class="tab-pane hidden">
                <div class="prose max-w-none text-gray-600 leading-relaxed">
                    <h4 class="font-semibold text-gray-900 mb-3">Product Details</h4>
                    <ul class="space-y-2">
                        <li><strong>Stock:</strong> <?= esc($product['stock'] ?? 0) ?> items available</li>
                        <li><strong>Weight:</strong> <?= esc($product['weight'] ?? 0) ?> grams</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4. Related Products Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-bold text-gray-900 mb-12">Related Products</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
            // Get related products (you can implement this logic in the controller)
            $relatedProducts = array_slice($relatedProducts ?? [], 0, 4);
            foreach ($relatedProducts as $related):
            ?>
            <div class="bg-white border border-gray-200 group">
                <a href="<?= base_url('product/' . $related['slug']) ?>">
                    <img src="<?= base_url('uploads/products/' . $related['image_url']) ?>" class="w-full aspect-square object-cover transition-transform duration-300 group-hover:-translate-y-1" alt="<?= esc($related['name']) ?>">
                </a>
                <div class="p-4">
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">
                        <a href="<?= base_url('product/' . $related['slug']) ?>" class="text-black hover:text-gray-600 transition-colors">
                            <?= esc($related['name']) ?>
                        </a>
                    </h3>
                    <p class="text-xs text-gray-500 mb-2">SKU: <?= esc($related['id'] ?? 'N/A') ?></p>
                    <p class="text-lg font-semibold text-black">Rp <?= number_format($related['price'], 0, ',', '.') ?></p>
                </div>
            </div>
            <?php endforeach; ?>

            <?php if (empty($relatedProducts)): ?>
                <!-- Placeholder products if no related products -->
                <?php for ($i = 0; $i < 4; $i++): ?>
                <div class="bg-white border border-gray-200">
                    <img src="https://source.unsplash.com/random/300x30<?= $i ?>/?fashion-related" class="w-full aspect-square object-cover" alt="Related Product">
                    <div class="p-4">
                        <h3 class="text-sm font-semibold text-gray-900 mb-1">Related Product <?= $i + 1 ?></h3>
                        <p class="text-xs text-gray-500 mb-2">SKU: RP<?= $i + 1 ?>00</p>
                        <p class="text-lg font-semibold text-black">Rp 299,000</p>
                    </div>
                </div>
                <?php endfor; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
// Quantity selector functionality
function updateQuantity(change) {
    const quantityInput = document.getElementById('quantity');
    const cartQuantityInput = document.getElementById('cart-quantity');
    let currentQuantity = parseInt(quantityInput.value);

    currentQuantity += change;
    if (currentQuantity < 1) currentQuantity = 1;

    quantityInput.value = currentQuantity;
    cartQuantityInput.value = currentQuantity;
}

// Tab functionality
document.addEventListener('DOMContentLoaded', function() {

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all tabs
            tabButtons.forEach(btn => {
                btn.classList.remove('active', 'border-black', 'text-black');
                btn.classList.add('border-transparent', 'text-gray-500');
            });

            // Hide all tab panes
            tabPanes.forEach(pane => pane.classList.add('hidden'));

            // Add active class to clicked tab
            this.classList.add('active', 'border-black', 'text-black');
            this.classList.remove('border-transparent', 'text-gray-500');

            // Show corresponding tab pane
            const tabId = this.dataset.tab;
            document.getElementById(tabId).classList.remove('hidden');
        });
    });
});
</script>

<?= $this->endSection() ?>
