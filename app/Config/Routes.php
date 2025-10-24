<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rute Halaman Utama
$routes->get('/', 'Landing::index');

// Rute untuk Halaman Semua Produk
$routes->get('products', 'Landing::products');

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

// Route untuk Admin
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'AdminController::dashboard');
    $routes->get('products', 'AdminController::products');
    $routes->post('products/add', 'AdminController::addProduct');
    $routes->post('products/edit/(:num)', 'AdminController::editProduct/$1');
    $routes->get('products/delete/(:num)', 'AdminController::deleteProduct/$1');
    $routes->get('categories', 'AdminController::categories');
    $routes->get('orders', 'AdminController::orders');
        // Orders
    $routes->get('orders', 'AdminController::orders');
    $routes->get('orders/(:num)', 'AdminController::orderDetail/$1');
    $routes->post('orders/update-status/(:num)', 'AdminController::updateOrderStatus/$1');
    
    // Promos
    $routes->get('promos', 'AdminController::promos');
    $routes->post('promos/add', 'AdminController::addPromo');
    $routes->post('promos/edit/(:num)', 'AdminController::editPromo/$1');
    $routes->get('promos/delete/(:num)', 'AdminController::deletePromo/$1');
    
    // Stock Management
    $routes->get('stock', 'AdminController::stockManagement');
    $routes->post('stock/update/(:num)', 'AdminController::updateStock/$1');
});

