<?php

namespace App\Models;

use CodeIgniter\Model;

class PromoModel extends Model
{
    protected $table            = 'promos';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'name', 'code', 'description', 'discount_type', 'discount_value',
        'min_purchase', 'max_discount', 'usage_limit', 'used_count',
        'start_date', 'end_date', 'is_active'
    ];
    protected $useTimestamps    = true;

    /**
     * Cek apakah kode promo valid untuk subtotal tertentu.
     * Mengembalikan data promo jika valid, atau string error jika tidak.
     */
    public function checkPromo($code, $subtotal)
    {
        $promo = $this->where('code', $code)->first();

        // 1. Cek ada kodenya?
        if (!$promo) {
            return "Kode promo tidak ditemukan.";
        }

        // 2. Cek masih aktif?
        if ($promo['is_active'] != 1) {
            return "Kode promo sudah tidak aktif.";
        }

        // 3. Cek tanggal berlakunya
        $now = date('Y-m-d H:i:s');
        if ($now < $promo['start_date']) {
            return "Kode promo belum berlaku.";
        }
        if ($now > $promo['end_date']) {
            return "Kode promo sudah kedaluwarsa.";
        }

        // 4. Cek batas penggunaan
        if ($promo['usage_limit'] !== null && $promo['used_count'] >= $promo['usage_limit']) {
            return "Batas penggunaan promo sudah habis.";
        }

        // 5. Cek minimum pembelian
        if ($subtotal < $promo['min_purchase']) {
            return "Belanja minimal " . number_format($promo['min_purchase'], 0, ',', '.') . " untuk pakai promo ini.";
        }

        // 6. Lolos semua, kembalikan data promo
        return $promo;
    }
}