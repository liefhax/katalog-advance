<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rute Halaman Utama
$routes->get('/', 'Landing::index');

// Rute untuk Halaman Semua Produk
$routes->get('products', 'Landing::products');

// Rute untuk About dan Contact
$routes->get('about', 'Landing::about');
$routes->get('contact', 'Landing::contact');

// Rute untuk Pencarian
$routes->get('search', 'Landing::search');

// Rute untuk Autentikasi
$routes->get('login', 'AuthController::login');
$routes->post('login/process', 'AuthController::processLogin');
$routes->get('register', 'AuthController::register');
$routes->post('register/process', 'AuthController::processRegister');
$routes->get('logout', 'AuthController::logout');

// Rute untuk Produk & Keranjang
$routes->get('product/(:segment)', 'ProductController::detail/$1');
$routes->post('cart/add', 'ProductController::addToCart');
$routes->get('cart', 'ProductController::showCart');
$routes->post('cart/update', 'ProductController::updateCart');
$routes->get('cart/remove/(:num)', 'ProductController::removeFromCart/$1');

// Rute untuk Profile User
$routes->get('profile', 'UserController::profile', ['filter' => 'auth']);
$routes->post('profile/update', 'UserController::updateProfile', ['filter' => 'auth']);

// Rute untuk manajemen alamat
$routes->group('profile', ['filter' => 'auth'], static function ($routes) {
    $routes->get('addresses', 'UserController::addresses');
    $routes->get('addresses/new', 'UserController::newAddress');
    $routes->post('addresses/store', 'UserController::storeAddress');
    $routes->get('addresses/set-default/(:num)', 'UserController::setDefaultAddress/$1');
    $routes->post('addresses/delete/(:num)', 'UserController::deleteAddress/$1');
    $routes->get('addresses/edit/(:num)', 'UserController::editAddress/$1');
    $routes->post('addresses/update/(:num)', 'UserController::updateAddress/$1');
});

// API untuk ambil data ongkir
$routes->post('/api/shipping/cost', 'ApiShipping::getCost', ['filter' => 'auth']);
$routes->post('/api/promo/apply', 'ApiPromo::apply', ['filter' => 'auth']);
// API untuk ambil data wilayah (JSON)
// ✅ API Wilayah (harus di luar grup lain)
$routes->get('api/wilayah/provinces', 'ApiWilayah::provinces');
$routes->get('api/wilayah/cities/(:segment)', 'ApiWilayah::cities/$1');
$routes->get('api/wilayah/districts/(:segment)', 'ApiWilayah::districts/$1');

// qris generator
$routes->post('/api/qris/generate', 'Api\QrisController::generate');

// Rute untuk Checkout
$routes->group('checkout', ['filter' => 'auth'], static function ($routes) {

    // Rute buat nampilin halaman checkout (GET /checkout)
    $routes->get('/', 'Checkout::index');

    // Rute buat nampilin halaman bayar (GET /checkout/pembayaran/...)
    $routes->get('pembayaran/(:segment)', 'Checkout::pembayaran/$1');

    // Rute buat proses order (POST /checkout/place-order)
    $routes->post('place-order', 'Checkout::placeOrder');
});

$routes->get('order/success', 'OrderController::success');



// ===========================
// ADMIN ROUTES
// ===========================
$routes->group('admin', ['filter' => 'auth'], function ($routes) {

    $routes->get('dashboard', 'AdminController::dashboard');

    // =====================
    // ORDER MANAGEMENT
    // =====================
    $routes->get('orders', 'AdminController::orders');
    $routes->get('orders/detail/(:num)', 'AdminController::orderDetail/$1');
    $routes->get('orders/json/(:num)', 'AdminController::getOrderDetailJson/$1');
    $routes->post('orders/update/(:num)', 'AdminController::updateOrderStatus/$1');
    $routes->post('orders/update-status/(:num)', 'AdminController::updateOrderStatus/$1');
    $routes->get('orders/delete/(:num)', 'AdminController::deleteOrder/$1'); // 🆕 baru


    // Redirect legacy link /admin/orders/{id} → /admin/orders/detail/{id}
    $routes->get('orders/(:num)', 'AdminController::orderDetail/$1');

    // =====================
    // PRODUCT MANAGEMENT
    // =====================
    $routes->get('products', 'AdminController::products');
    $routes->get('products/new', 'AdminController::newProduct');
    $routes->get('products/edit/(:num)', 'AdminController::editProduct/$1');
    $routes->post('products/create', 'AdminController::createProduct');
    $routes->post('products/update', 'AdminController::updateProduct');
    $routes->post('products/delete', 'AdminController::deleteProduct');
    $routes->get('products/delete/(:num)', 'AdminController::deleteProduct/$1');

    // =====================
    // PROMO MANAGEMENT
    // =====================
    $routes->get('promos', 'AdminController::promos');
    $routes->post('promos/add', 'AdminController::addPromo');
    $routes->post('promos/edit/(:num)', 'AdminController::editPromo/$1');
    $routes->get('promos/delete/(:num)', 'AdminController::deletePromo/$1');

    // =====================
    // STOCK MANAGEMENT
    // =====================
    $routes->get('stock', 'AdminController::stockManagement');
    $routes->post('stock/update/(:num)', 'AdminController::updateStock/$1');

    // =====================
    // CATEGORY MANAGEMENT
    // =====================
    $routes->get('categories', 'AdminController::categories');
    $routes->post('categories/create', 'AdminController::createCategory');
    $routes->post('categories/update', 'AdminController::updateCategory');
    $routes->post('categories/delete', 'AdminController::deleteCategory');

    // USER MANAGEMENT
    $routes->get('users', 'UserController::index');
    $routes->post('users/store', 'UserController::store');
    $routes->post('users/update', 'UserController::update');
    $routes->post('users/delete', 'UserController::delete');
    $routes->get('users/detail/(:num)', 'UserController::detail/$1');
});
