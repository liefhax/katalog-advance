<?= $this->extend('main_layout') ?>

<?= $this->section('content') ?>

<!-- 1. Header Section (Catalog Hero) -->
<section class="relative h-[540px] overflow-hidden">
    <img src="<?= base_url('assets/images/clotes 1.png') ?>" alt="Fashion" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-black bg-opacity-30"></div>
    <div class="absolute inset-0 flex items-center justify-center">
        <div class="text-center text-white max-w-4xl mx-auto px-6 z-10">
            <h1 class="text-6xl font-bold uppercase tracking-wider mb-6">CATALOG</h1>
            <p class="text-xl text-gray-200 leading-relaxed max-w-2xl mx-auto">
                Discover our complete collection of premium fashion pieces. From casual essentials to statement pieces, find everything you need for your wardrobe.
            </p>
        </div>
    </div>
</section>

<!-- 2. Categories Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Column - Categories Card -->
            <div class="lg:w-1/4">
                <div class="bg-black text-white p-8">
                    <h2 class="text-2xl font-bold uppercase mb-4">Categories</h2>
                    <p class="text-gray-300 leading-relaxed">
                        Explore our curated collections organized by style and occasion. From everyday essentials to special occasion pieces, find exactly what you're looking for.
                    </p>
                </div>
            </div>

            <!-- Right Column - Category Image Cards -->
            <div class="lg:w-3/4">
                <?php if (!empty($categories) && count($categories) > 3): ?>
                <!-- Infinite Carousel for more than 3 categories -->
                <div class="relative">
                    <div class="overflow-hidden">
                        <div id="category-carousel" class="flex transition-transform duration-300 ease-in-out">
                            <?php
                            // Create seamless rotation array: for 4 categories, create {1,2,3,4,1,2,3} so we can rotate smoothly
                            // This allows: {1,2,3,1} -> {2,3,1,2} -> {3,1,2,3} -> {1,2,3,1} (back to start seamlessly)
                            $rotationItems = array_merge($categories, array_slice($categories, 0, 3));
                            foreach ($rotationItems as $index => $category):
                            ?>
                            <div class="flex-shrink-0 w-full md:w-1/3 px-3">
                                <a href="<?= base_url('products?category=' . $category['id']) ?>" class="block">
                                    <div class="relative group cursor-pointer overflow-hidden">
                                        <img src="https://source.unsplash.com/random/400x60<?= $index % count($categories) ?>/?<?= strtolower(str_replace(' ', '-', $category['name'])) ?>-fashion" alt="<?= esc($category['name']) ?> Collection" class="w-full h-80 object-cover transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-60"></div>
                                        <div class="absolute bottom-6 left-6 text-white">
                                            <h3 class="text-xl font-bold"><?= esc($category['name']) ?></h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <button id="prev-category" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-80 hover:bg-opacity-100 text-black p-3 shadow-lg transition-all duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button id="next-category" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white bg-opacity-80 hover:bg-opacity-100 text-black p-3 shadow-lg transition-all duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
                <?php else: ?>
                <!-- Grid layout for 3 or fewer categories -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $index => $category): ?>
                        <a href="<?= base_url('products?category=' . $category['id']) ?>" class="block">
                            <div class="relative group cursor-pointer overflow-hidden">
                                <img src="https://source.unsplash.com/random/400x60<?= $index ?>/?<?= strtolower(str_replace(' ', '-', $category['name'])) ?>-fashion" alt="<?= esc($category['name']) ?> Collection" class="w-full h-80 object-cover transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-60"></div>
                                <div class="absolute bottom-6 left-6 text-white">
                                    <h3 class="text-xl font-bold"><?= esc($category['name']) ?></h3>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Fallback if no categories -->
                        <div class="relative group cursor-pointer overflow-hidden">
                            <img src="https://source.unsplash.com/random/400x600/?fashion" alt="Fashion Collection" class="w-full h-80 object-cover transition-transform duration-300 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-60"></div>
                            <div class="absolute bottom-6 left-6 text-white">
                                <h3 class="text-xl font-bold">Fashion</h3>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- 3. Product Grid Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Filter and Sort Controls -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-12">
            <div class="text-sm text-gray-600 mb-4 sm:mb-0">
                <?php
                $start = (($currentPage - 1) * 15) + 1;
                $end = min($start + count($displayProducts) - 1, $totalProducts);
                ?>
                Showing <?= $start ?>–<?= $end ?> of <?= $totalProducts ?> results
                <?php if ($currentCategory): ?>
                    <span class="ml-2">(filtered by category)</span>
                    <a href="<?= base_url('products') ?>" class="ml-2 text-blue-600 hover:text-blue-800">Clear filter</a>
                <?php endif; ?>
            </div>
            <div class="flex gap-4">
                <select id="sort-select" class="border border-gray-300 px-4 py-2 text-sm bg-white">
                    <option value="">Sort by</option>
                    <option value="name-asc" <?= ($currentSort === 'name-asc') ? 'selected' : '' ?>>Name A-Z</option>
                    <option value="name-desc" <?= ($currentSort === 'name-desc') ? 'selected' : '' ?>>Name Z-A</option>
                    <option value="price-low" <?= ($currentSort === 'price-low') ? 'selected' : '' ?>>Price Low-High</option>
                    <option value="price-high" <?= ($currentSort === 'price-high') ? 'selected' : '' ?>>Price High-Low</option>
                    <option value="newest" <?= ($currentSort === 'newest') ? 'selected' : '' ?>>Newest</option>
                </select>
            </div>
        </div>

        <!-- Product Grid -->
        <?php if (!empty($displayProducts)): ?>
            <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <?php foreach ($displayProducts as $product): ?>
                <div class="bg-white border border-gray-300 group">
                    <a href="<?= base_url('product/' . $product['slug']) ?>">
                        <img src="<?= base_url('uploads/products/' . $product['image_url']) ?>" class="w-full aspect-square object-cover transition-transform duration-300 group-hover:-translate-y-1" alt="<?= esc($product['name']) ?>">
                    </a>
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">
                            <a href="<?= base_url('product/' . $product['slug']) ?>" class="text-black hover:text-gray-600 transition-colors">
                                <?= esc($product['name']) ?>
                            </a>
                        </h3>
                        <p class="text-sm text-gray-600 mb-3">SKU: <?= esc($product['id'] ?? 'N/A') ?></p>
                        <p class="text-xl font-semibold text-black">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Load More Button -->
            <?php if ($hasMore): ?>
            <div class="text-center">
                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $currentPage + 1])) ?>" class="inline-block bg-black text-white px-8 py-3 text-sm font-medium hover:bg-white hover:text-black hover:border hover:border-black transition-colors">
                    Load More
                </a>
            </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="text-center py-20">
                <p class="text-gray-500 text-lg">
                    <?php if ($currentCategory): ?>
                        No products found in this category.
                        <a href="<?= base_url('products') ?>" class="text-blue-600 hover:text-blue-800 ml-2">View all products</a>
                    <?php else: ?>
                        Belum ada produk yang tersedia
                    <?php endif; ?>
                </p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- 4. Promotional Banner Section -->
<section class="py-20 bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Left Column - Text Block -->
            <div class="lg:w-2/5">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Promotional Banner</h2>
                <p class="text-gray-600 leading-relaxed mb-8">
                    Take advantage of our seasonal promotions and special offers. Discover exclusive deals on selected items and enjoy savings on your favorite pieces.
                </p>
                <a href="<?= base_url('promotions') ?>" class="inline-block bg-black text-white px-6 py-3 text-sm font-medium hover:bg-white hover:text-black hover:border hover:border-black transition-colors">
                    Learn More
                </a>
            </div>

            <!-- Right Column - Image -->
            <div class="lg:w-3/5">
                <img src="https://source.unsplash.com/random/800x400/?jeans-store-aisle" alt="Jeans Store Aisle" class="w-full h-80 object-cover">
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sortSelect = document.getElementById('sort-select');

    function updateURL() {
        const url = new URL(window.location);
        const sortValue = sortSelect.value;

        // Remove existing sort params
        url.searchParams.delete('sort');
        url.searchParams.delete('page'); // Reset to page 1 when sorting

        // Add new params if selected
        if (sortValue) {
            url.searchParams.set('sort', sortValue);
        }

        // Navigate to new URL
        window.location.href = url.toString();
    }

    sortSelect.addEventListener('change', updateURL);

    // Category Carousel Functionality - Seamless one-direction rotation
    const categoryCarousel = document.getElementById('category-carousel');
    const prevButton = document.getElementById('prev-category');
    const nextButton = document.getElementById('next-category');

    if (categoryCarousel && prevButton && nextButton) {
        let currentPosition = 0;
        const maxPosition = 4; // 4 positions for seamless rotation through all categories

        function updateCarousel() {
            // Move by exactly one category position (33.33% of container width for 3 items)
            const translateX = -currentPosition * (100 / 3);
            categoryCarousel.style.transform = `translateX(${translateX}%)`;
        }

        function nextSlide() {
            currentPosition++;
            updateCarousel();

            // When reaching the end, seamlessly jump back to start
            if (currentPosition >= maxPosition) {
                setTimeout(() => {
                    categoryCarousel.style.transition = 'none';
                    currentPosition = 0;
                    updateCarousel();
                    setTimeout(() => {
                        categoryCarousel.style.transition = 'transform 0.3s ease-in-out';
                    }, 50);
                }, 300);
            }
        }

        function prevSlide() {
            if (currentPosition <= 0) {
                // When at start, jump to end seamlessly
                categoryCarousel.style.transition = 'none';
                currentPosition = maxPosition;
                updateCarousel();
                setTimeout(() => {
                    categoryCarousel.style.transition = 'transform 0.3s ease-in-out';
                    currentPosition = maxPosition - 1;
                    updateCarousel();
                }, 50);
            } else {
                currentPosition--;
                updateCarousel();
            }
        }

        // Event listeners
        nextButton.addEventListener('click', nextSlide);
        prevButton.addEventListener('click', prevSlide);
    }
});
</script>

<?= $this->endSection() ?>

