<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table            = 'cart_items';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['user_id', 'product_id', 'quantity'];
    protected $useTimestamps    = true;

    /**
     * Mengambil semua item di keranjang milik seorang user,
     * lengkap dengan detail produknya (nama, harga, gambar).
     */
    public function getCartItemsByUserId($userId)
    {
        return $this->select('cart_items.id as cart_item_id, cart_items.quantity, products.id as product_id, products.name, products.price, products.image_url')
            ->join('products', 'products.id = cart_items.product_id')
            ->where('cart_items.user_id', $userId)
            ->findAll();
    }
}
