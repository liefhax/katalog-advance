<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
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

