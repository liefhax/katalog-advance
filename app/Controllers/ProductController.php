<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CartModel; // Panggil CartModel
use CodeIgniter\Exceptions\PageNotFoundException;

class ProductController extends BaseController
{
    protected $session;
    protected $cartModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->cartModel = new CartModel(); // Buat instance CartModel
    }

    public function detail($slug)
    {
        $productModel = new ProductModel();
        $product = $productModel->where('slug', $slug)->first();
        if (!$product) {
            throw PageNotFoundException::forPageNotFound('Maaf, produk tidak ditemukan.');
        }
        $data = ['title' => $product['name'], 'product' => $product];
        return view('detail_product', $data);
    }

    public function addToCart()
    {
        // Cek dulu apakah user sudah login
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('login')->with('error', 'Silakan login untuk menambahkan produk ke keranjang.');
        }

        $userId = $this->session->get('user')['id'];
        $productId = $this->request->getPost('product_id');
        $quantity = 1;

        // Cek apakah produk sudah ada di keranjang user ini
        $existingItem = $this->cartModel->where(['user_id' => $userId, 'product_id' => $productId])->first();

        if ($existingItem) {
            // Jika sudah ada, update quantity-nya
            $newQuantity = $existingItem['quantity'] + $quantity;
            $this->cartModel->update($existingItem['id'], ['quantity' => $newQuantity]);
        } else {
            // Jika belum ada, insert data baru
            $this->cartModel->insert([
                'user_id'    => $userId,
                'product_id' => $productId,
                'quantity'   => $quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function showCart()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $userId = $this->session->get('user')['id'];
        $cartItems = $this->cartModel->getCartItemsByUserId($userId);
        
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $data = [
            'title'     => 'Keranjang Belanja',
            'cartItems' => $cartItems,
            'total'     => $total,
        ];

        return view('cart', $data);
    }

    public function updateCart()
    {
        $cartItemId = $this->request->getPost('cart_item_id');
        $quantity = $this->request->getPost('quantity');

        // Update kuantitas di database
        $this->cartModel->update($cartItemId, ['quantity' => $quantity]);
        
        return redirect()->to('cart')->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    public function removeFromCart($cartItemId)
    {
        // Hapus item dari database
        $this->cartModel->delete($cartItemId);
        
        return redirect()->to('cart')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}