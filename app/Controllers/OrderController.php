<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OrderModel;

class OrderController extends BaseController
{
    public function success()
    {
        $session = session();
        $orderData = $session->getFlashdata('order_success_data');

        if (!$orderData) {
            // Kalau diakses langsung tanpa proses checkout sebelumnya
            return redirect()->to('/')->with('warning', 'Tidak ada data pesanan untuk ditampilkan.');
        }

        // Pastikan format data cocok dengan order_success.php
        $data = [
            'title' => 'Pesanan Berhasil Dibuat',
            'orderData' => [
                'order_code'     => $orderData['order_id'] ?? 'INV-TIDAK-DIKETAHUI',
                'payment_method' => $orderData['payment_method'] ?? 'manual',
                'total_to_pay'   => $orderData['total_bayar'] ?? 0,
                'qris_image_url' => $orderData['qris_image_url'] ?? null
            ]
        ];

        return view('order_success', $data);
    }
}
