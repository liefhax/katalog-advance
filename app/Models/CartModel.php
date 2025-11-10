<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table            = 'cart_items';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['user_id', 'product_id', 'quantity'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    /**
     * Ambil semua item keranjang milik user, digabung dengan data produk.
     */
    public function getCartItems($userId)
    {
        return $this->select('cart_items.id as cart_item_id, cart_items.quantity, products.id as product_id, products.name, products.price, products.image_url, products.stock, products.category_id')
                    ->join('products', 'products.id = cart_items.product_id')
                    ->where('cart_items.user_id', $userId)
                    ->orderBy('cart_items.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Ambil item keranjang SPESIFIK (berdasarkan array ID) milik user.
     * Digunakan untuk halaman checkout.
     */
    public function getSpecificCartItems($userId, array $cartItemIds)
    {
        if (empty($cartItemIds)) {
            return [];
        }

        return $this->select('cart_items.id as cart_item_id, cart_items.quantity, products.id as product_id, products.name, products.price, products.image_url, products.stock, products.category_id')
                    ->join('products', 'products.id = cart_items.product_id')
                    ->where('cart_items.user_id', $userId)
                    ->whereIn('cart_items.id', $cartItemIds) // Hanya ambil yg ID-nya ada di array
                    ->findAll();
    }
}