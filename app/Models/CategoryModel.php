<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array'; // Pake array aja biar gampang
    protected $useSoftDeletes   = false;

    // ✨ INI YANG PENTING
    protected $allowedFields    = ['name', 'slug'];

    // (Opsional) Kalo lo pake created_at/updated_at
    // protected $useTimestamps = true; 
}