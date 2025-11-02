<?php
namespace App\Models;

use CodeIgniter\Model;

class UserAddressModel extends Model
{
    protected $table            = 'user_addresses';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'user_id',
        'label',
        'recipient_name',
        'recipient_phone',
        'street_address',
        'province_kode',
        'province_name',
        'city_kode',
        'city_name',
        'subdistrict_kode',
        'subdistrict_name',
        'postal_code',
        'is_default'
    ];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    public function setDefault($addressId, $userId)
    {
        // Set semua alamat user ini jadi is_default = 0
        $this->where('user_id', $userId)
             ->set(['is_default' => 0])
             ->update();

        // Set alamat yang dipilih jadi is_default = 1
        $this->where('id', $addressId)
             ->where('user_id', $userId)
             ->set(['is_default' => 1])
             ->update();
    }
}
