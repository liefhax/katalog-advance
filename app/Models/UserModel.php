<?php
<<<<<<< HEAD
=======

>>>>>>> 3f36f2c33831e6bfbf5d2bedd649fd897e4a7795
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
<<<<<<< HEAD
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'password_hash', 'is_admin'];
    protected $useTimestamps = true;
    protected $returnType = 'array';
}

class UserAddressModel extends Model
{
    protected $table = 'user_addresses';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id','label','recipient_name','recipient_phone',
        'street_address','province_kode','city_kode','subdistrict_kode',
        'postal_code','is_default'
    ];
    protected $useTimestamps = true;
    protected $returnType = 'array';
}

=======
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
>>>>>>> 3f36f2c33831e6bfbf5d2bedd649fd897e4a7795
