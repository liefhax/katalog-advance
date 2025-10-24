<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // Menentukan tabel mana yang akan digunakan oleh model ini.
    protected $table            = 'users';
    
    // Menentukan kolom mana yang menjadi Primary Key.
    protected $primaryKey       = 'id';

    // Daftar kolom yang diizinkan untuk diisi melalui form (demi keamanan).
    protected $allowedFields    = ['name', 'email', 'password_hash'];

    // CodeIgniter akan otomatis mengisi kolom 'created_at' dan 'updated_at'.
    protected $useTimestamps    = true;

    // Tipe data yang dikembalikan (bisa 'object' atau 'array')
    protected $returnType       = 'array';
}
