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

        // Get related products from the same category (excluding current product)
        $relatedProducts = [];
        if (!empty($product['category_id'])) {
            $relatedProducts = $productModel
                ->where('category_id', $product['category_id'])
                ->where('id !=', $product['id'])
                ->orderBy('created_at', 'DESC')
                ->findAll(4); // Get up to 4 related products
        }

        $data = [
            'title' => $product['name'],
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ];
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
        $quantity = $this->request->getPost('quantity') ?? 1; // Ambil quantity dari POST, default 1 jika tidak ada

        // Validasi quantity
        $quantity = max(1, intval($quantity));

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
        $cartItems = $this->cartModel->getCartItems($userId);

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Get related products based on cart items categories
        $relatedProducts = [];
        if (!empty($cartItems)) {
            // Get unique category IDs from cart items
            $categoryIds = array_unique(array_column($cartItems, 'category_id'));
            $cartProductIds = array_column($cartItems, 'product_id');

            // Filter out null/empty values
            $categoryIds = array_filter($categoryIds, function($id) {
                return !empty($id) && is_numeric($id);
            });
            $cartProductIds = array_filter($cartProductIds, function($id) {
                return !empty($id) && is_numeric($id);
            });

            // Only proceed if we have valid category IDs
            if (!empty($categoryIds)) {
                // Get products from same categories, excluding products already in cart
                $productModel = new ProductModel();
                $query = $productModel->select('products.*, categories.name as category_name')
                    ->join('categories', 'categories.id = products.category_id', 'left')
                    ->whereIn('products.category_id', $categoryIds)
                    ->where('products.is_active', 1)
                    ->orderBy('products.created_at', 'DESC');

                // Only exclude products already in cart if we have cart product IDs
                if (!empty($cartProductIds)) {
                    $query->whereNotIn('products.id', $cartProductIds);
                }

                $relatedProducts = $query->limit(4)->findAll();
            }
        }

        $data = [
            'title'           => 'Keranjang Belanja',
            'cartItems'       => $cartItems,
            'total'           => $total,
            'relatedProducts' => $relatedProducts,
        ];

        return view('cart', $data);
    }

    public function updateCart()
    {
        $cartItemId = $this->request->getPost('cart_item_id');
        $quantity = $this->request->getPost('quantity');

        // Update kuantitas di database
        $result = $this->cartModel->update($cartItemId, ['quantity' => $quantity]);

        if ($this->request->isAJAX()) {
            // Return JSON response for AJAX requests
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Jumlah produk berhasil diperbarui.'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal memperbarui jumlah produk.'
                ]);
            }
        } else {
            // Return redirect for regular form submissions
            return redirect()->to('cart')->with('success', 'Jumlah produk berhasil diperbarui.');
        }
    }

    public function removeFromCart($cartItemId)
    {
        // Check if this is an AJAX request
        $isAjax = $this->request->isAJAX() ||
                  $this->request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest' ||
                  $this->request->getHeaderLine('Accept') === 'application/json';

        // Hapus item dari database
        $result = $this->cartModel->delete($cartItemId);

        if ($isAjax) {
            // Always return JSON for AJAX requests
            $this->response->setContentType('application/json');
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Produk berhasil dihapus dari keranjang.'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus produk dari keranjang.'
                ]);
            }
        } else {
            // Return redirect for regular requests
            return redirect()->to('cart')->with('success', 'Produk berhasil dihapus dari keranjang.');
        }
    }
}