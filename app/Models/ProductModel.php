<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array'; // Ubah ke array biar gampang di view
    protected $useSoftDeletes   = false;

    // ✨ INI YANG PENTING
    protected $allowedFields    = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'is_active',
        'category_id',
        'image_url' // Kita akan isi ini dengan nama file
    ];

    // ... (protected $createdField, $updatedField, dll.)

    // Helper function buat join dengan kategori (Opsional tapi ngebantu)
    public function getProductsWithCategory()
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->orderBy('products.id', 'DESC')
            ->findAll();
    }
}