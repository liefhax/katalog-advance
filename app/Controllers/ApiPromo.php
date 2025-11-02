<?php

namespace App\Controllers;

use App\Models\PromoModel;

class ApiPromo extends BaseController
{
    public function apply()
    {
        // Ambil data dari JavaScript
        $code = $this->request->getPost('promo_code');
        $subtotal = (float) $this->request->getPost('subtotal');

        if (empty($code) || empty($subtotal)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data tidak lengkap.'
            ]);
        }

        $promoModel = new PromoModel();
        $promo = $promoModel->checkPromo($code, $subtotal);

        // Cek kalo hasilnya string, berarti error
        if (is_string($promo)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $promo // "Kode promo tidak ditemukan", dll
            ]);
        }

        // Kalo lolos, hitung diskonnya
        $discountAmount = 0;

        if ($promo['discount_type'] == 'fixed') {
            $discountAmount = (float) $promo['discount_value'];
        } 
        elseif ($promo['discount_type'] == 'percentage') {
            $discountAmount = $subtotal * ((float) $promo['discount_value'] / 100);
            
            // Cek diskon maksimal
            if ($promo['max_discount'] !== null && $discountAmount > $promo['max_discount']) {
                $discountAmount = (float) $promo['max_discount'];
            }
        }

        // Pastikan diskon gak lebih besar dari subtotal
        if ($discountAmount > $subtotal) {
            $discountAmount = $subtotal;
        }

        return $this->response->setJSON([
            'success'       => true,
            'message'       => 'Promo "' . $promo['name'] . '" berhasil dipakai!',
            'discount_amount' => $discountAmount,
            'promo_id'      => $promo['id'] // Kirim ID-nya buat disimpen di order
        ]);
    }
}