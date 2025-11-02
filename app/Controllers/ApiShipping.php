<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CartModel;

class ApiShipping extends Controller
{
    public function getCost()
    {
        $request = service('request');
        $session = service('session');
        $db = db_connect();

        // Pastikan user login
        if (!$session->get('isLoggedIn')) {
            return service('response')->setStatusCode(403)->setJSON(['error' => 'Access denied']);
        }

        // Ambil data user dan kurir
        $user = $session->get('user');
        $userId = $user['id'] ?? null;
        $courier = $request->getPost('courier');

        if (empty($courier)) {
            return service('response')->setJSON(['error' => 'Kurir wajib diisi.']);
        }

        // Ambil alamat utama user
        $address = $db->table('user_addresses')
            ->where('user_id', $userId)
            ->where('is_default', 1)
            ->get()
            ->getRow();

        if (!$address) {
            return service('response')->setJSON(['error' => 'Alamat utama pengguna belum diatur.']);
        }

        $cityKode = $address->city_kode;
        if (empty($cityKode)) {
            return service('response')->setJSON(['error' => 'Alamat pengguna belum memiliki kode kota.']);
        }

        // Ambil nama kota untuk tampilan
        $city = $db->table('wilayah')->select('nama')->where('kode', $cityKode)->get()->getRow();
        $cityName = $city->nama ?? 'Kota Tidak Dikenal';

        // Hitung berat keranjang
        $cartModel = model(CartModel::class);
        $cartItems = $cartModel->getCartItems($userId);

        if (empty($cartItems)) {
            return service('response')->setJSON(['error' => 'Keranjang kosong.']);
        }

        $totalWeight = 0;
        foreach ($cartItems as $item) {
            $productWeight = $db->table('products')->select('weight')->where('id', $item['product_id'])->get()->getRow('weight') ?? 100;
            $totalWeight += $productWeight * $item['quantity'];
        }

        // === SIMULASI ONGKIR LOKAL ===
        // Logika sederhana: Rp10.000 per 1kg + tambahan per km berdasarkan kode wilayah
        $baseRate = 10000; // ongkir dasar
        $extraRate = (float) substr($cityKode, -2); // simulasi jarak berdasarkan 2 digit akhir kode
        $estCost = $baseRate + ($extraRate * 300); // variasi dikit
        $estDay = rand(1, 4); // estimasi 1–4 hari

        $response = [
            'info' => 'Ongkir simulasi lokal (RajaOngkir dimatikan)',
            'courier' => strtoupper($courier),
            'destination' => $cityName,
            'weight' => $totalWeight . ' gram',
            'costs' => [
                [
                    'service' => strtoupper($courier) . ' - REG',
                    'description' => 'Layanan Reguler (simulasi)',
                    'cost' => [
                        ['value' => $estCost, 'etd' => "{$estDay}-" . ($estDay + 1), 'note' => '']
                    ]
                ],
                [
                    'service' => strtoupper($courier) . ' - YES',
                    'description' => 'Yakin Esok Sampai (simulasi)',
                    'cost' => [
                        ['value' => $estCost + 10000, 'etd' => '1', 'note' => '']
                    ]
                ]
            ]
        ];

        return service('response')->setJSON($response);
    }
}
