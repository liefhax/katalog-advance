<?php
namespace App\Models;

use CodeIgniter\Model;

class PromoModel extends Model
{
    protected $table = 'promos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'code', 'description', 'discount_type', 'discount_value',
        'min_purchase', 'max_discount', 'usage_limit', 'used_count',
        'start_date', 'end_date', 'is_active'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    public function getActivePromos()
    {
        $now = date('Y-m-d H:i:s');
        return $this->where('is_active', 1)
            ->where('start_date <=', $now)
            ->where('end_date >=', $now)
            ->findAll();
    }
    
    public function validatePromo($code, $totalAmount)
    {
        $now = date('Y-m-d H:i:s');
        $promo = $this->where('code', $code)
            ->where('is_active', 1)
            ->where('start_date <=', $now)
            ->where('end_date >=', $now)
            ->first();
        
        if (!$promo) {
            return ['valid' => false, 'message' => 'Kode promo tidak valid atau sudah kadaluarsa'];
        }
        
        if ($promo->usage_limit && $promo->used_count >= $promo->usage_limit) {
            return ['valid' => false, 'message' => 'Kuota promo sudah habis'];
        }
        
        if ($totalAmount < $promo->min_purchase) {
            return ['valid' => false, 'message' => 'Minimum pembelian Rp ' . number_format($promo->min_purchase, 0, ',', '.')];
        }
        
        return ['valid' => true, 'promo' => $promo];
    }
}