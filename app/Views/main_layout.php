<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'UncleStore') ?></title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
    // Delegate to page's remove-selected handler so the cart page's JS handles UI updates
    window.handleRemoveSelected = function() {
        try {
            const removeBtn = document.getElementById('remove-selected');
            if (removeBtn) {
                removeBtn.click();
                return;
            }
            alert('Tombol tidak ditemukan pada halaman ini. Silakan refresh.');
        } catch (err) {
            console.error('handleRemoveSelected error:', err);
            alert('Terjadi kesalahan. Silakan refresh halaman.');
        }
    };
    </script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Akshar:wght@300..700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Akshar', sans-serif;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-50 text-gray-900">

<?php
    $isLoggedIn = session()->get('isLoggedIn');
    $user = session()->get('user');
    $current_page = current_url(true)->getSegment(1);
    $cartItemCount = 0;

    if ($isLoggedIn) {
        $cartModel = new \App\Models\CartModel();
        $userId = $user['id'];
        $cartItemCount = $cartModel->where('user_id', $userId)->countAllResults();
    }
?>

<header class="sticky top-0 z-50 bg-white shadow-sm">
    <nav class="max-w-7xl mx-auto py-4">
        <div class="flex justify-between items-end">
            <!-- Navbar Brand -->
            <a class="flex items-end" href="<?= base_url('/') ?>">
                <img id="navbar-logo" src="<?= base_url('assets/images/icons/logo.png') ?>" alt="UncleStore" class="h-28 w-auto transition-all duration-300">
            </a>

            <!-- Links -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="<?= base_url('/') ?>" class="text-gray-700 hover:text-blue-600 uppercase font-medium">HOME</a>
                <a href="<?= base_url('products') ?>" class="text-gray-700 hover:text-blue-600 uppercase font-medium">PRODUCTS</a>
                <a href="<?= base_url('about') ?>" class="text-gray-700 hover:text-blue-600 uppercase font-medium">ABOUT</a>
                <a href="<?= base_url('contact') ?>" class="text-gray-700 hover:text-blue-600 uppercase font-medium">CONTACT</a>
            </div>

            <!-- Icons -->
            <div class="flex items-center space-x-4">
                <a href="<?= base_url('cart') ?>" class="relative text-gray-700 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="m2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
                    </svg>
                    <?php if ($cartItemCount > 0): ?>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full px-1 py-0.5">
                            <?= $cartItemCount ?>
                        </span>
                    <?php endif; ?>
                </a>
                <button class="text-gray-700 hover:text-blue-600" id="search-toggle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                    </svg>
                </button>
                <?php if ($isLoggedIn && $user): ?>
                    <div class="relative">
                        <button class="flex items-center text-gray-700 hover:text-blue-600" id="user-menu-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                            </svg>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden" id="user-menu">
                            <a href="<?= base_url('profile') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                            <a href="<?= base_url('logout') ?>" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= base_url('login') ?>" class="text-gray-700 hover:text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Mobile menu button -->
            <button class="md:hidden text-gray-700" id="mobile-menu-button">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden hidden mt-4" id="mobile-menu">
            <div class="flex flex-col space-y-2">
                <a href="<?= base_url('/') ?>" class="text-gray-700 hover:text-blue-600 uppercase font-medium">HOME</a>
                <a href="<?= base_url('products') ?>" class="text-gray-700 hover:text-blue-600 uppercase font-medium">PRODUCTS</a>
                <a href="<?= base_url('about') ?>" class="text-gray-700 hover:text-blue-600 uppercase font-medium">ABOUT</a>
                <a href="<?= base_url('contact') ?>" class="text-gray-700 hover:text-blue-600 uppercase font-medium">CONTACT</a>
            </div>
            <div class="flex space-x-4 mt-4">
                <a href="<?= base_url('cart') ?>" class="text-gray-700 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="m2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
                    </svg>
                </a>
                <a href="#" class="text-gray-700 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                    </svg>
                </a>
                <?php if ($isLoggedIn && $user): ?>
                    <a href="#" class="text-gray-700 hover:text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('login') ?>" class="text-gray-700 hover:text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Search Form -->
        <div class="hidden mt-4" id="search-form">
            <form action="<?= base_url('search') ?>" method="get" class="w-full">
                <div class="flex">
                    <input type="search" name="q" class="flex-1 px-4 py-2 border-0 focus:outline-none focus:ring-0" placeholder="Cari produk..." required>
                    <button class="px-4 py-2" type="submit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </nav>
</header>

<main class="flex-1">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</main>

<footer class="bg-[#111010] text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col space-y-8">
            <!-- Child 1: flex row -->
            <div class="flex flex-row justify-between items-start space-x-8">
                <!-- Logo and Social Icons -->
                <div class="flex flex-col items-center">
                    <div class="bg-white p-4 rounded">
                        <img src="<?= base_url('assets/images/icons/logo.png') ?>" alt="UncleStore" class="h-12 w-auto">
                    </div>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-white hover:text-gray-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-white hover:text-gray-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-white hover:text-gray-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.097.118.112.221.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.746-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.987C24.007 5.367 18.641.001 12.017.001z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Products -->
                <div class="flex flex-col">
                    <h3 class="font-bold mb-4">Products</h3>
                    <?php
                    $categoryModel = new \App\Models\CategoryModel();
                    $categories = $categoryModel->findAll();
                    $displayCategories = array_slice($categories, 0, 4);
                    foreach ($displayCategories as $category):
                    ?>
                    <a href="<?= base_url('products?category=' . $category['id']) ?>" class="text-gray-300 hover:text-white mb-2">
                        <?= esc($category['name']) ?>
                    </a>
                    <?php endforeach; ?>
                    <?php if (count($categories) > 4): ?>
                    <a href="<?= base_url('products') ?>" class="text-blue-400 hover:text-blue-300 font-medium">
                        More →
                    </a>
                    <?php endif; ?>
                </div>

                <!-- Contact Information -->
                <div class="flex flex-col">
                    <h3 class="font-bold mb-4">Contact Information</h3>
                    <p class="text-gray-300">Email: info@uncle.com</p>
                    <p class="text-gray-300">Phone: +123 456 7890</p>
                    <p class="text-gray-300">Address: 123 Fashion Street, City</p>
                </div>
            </div>

            <!-- Child 2: flex row justify between -->
            <div class="flex flex-row justify-between items-center border-t border-gray-700 pt-8">
                <p>&copy; 2024 UncleStore. All rights reserved.</p>
                <p>Created by NU Uncle</p>
            </div>
        </div>
    </div>
</footer>

<!-- Theme Toggle Script (removed for light mode only) -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const logo = document.getElementById('navbar-logo');
        const searchToggle = document.getElementById('search-toggle');
        const searchForm = document.getElementById('search-form');

        // Scroll event for logo shrink
        window.addEventListener('scroll', () => {
            if (window.scrollY > 0) {
                logo.classList.remove('h-28');
                logo.classList.add('h-12');
            } else {
                logo.classList.remove('h-12');
                logo.classList.add('h-28');
            }
        });

        // Toggle search form
        if (searchToggle && searchForm) {
            searchToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                searchForm.classList.toggle('hidden');
            });

            // Collapse on click outside
            document.addEventListener('click', (e) => {
                if (!searchForm.contains(e.target) && !searchToggle.contains(e.target)) {
                    searchForm.classList.add('hidden');
                }
            });
        }

        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // User menu toggle
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');
        if (userMenuButton && userMenu) {
            userMenuButton.addEventListener('click', () => {
                userMenu.classList.toggle('hidden');
            });
        }
    });
</script>
<?= $this->renderSection('scripts') ?>

</body>
</html>
