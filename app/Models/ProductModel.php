<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name', 'slug', 'description', 'price', 'image_url'];

    // Dates
    protected $useTimestamps    = true;

    // Tipe data yang dikembalikan
    protected $returnType       = 'array';
}

