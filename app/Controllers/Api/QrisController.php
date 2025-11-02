<?php namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use chillerlan\QRCode\QRCode; // Pastikan sudah install

class QrisController extends ResourceController
{
    /**
     * @var \CodeIgniter\HTTP\IncomingRequest
     */
    protected $request; // Ini buat ngilangin merah di VSCode

    // ==========================================================
    // INI BAGIAN PALING PENTING
    // Pastikan fungsi __construct() ini ADA
    // ==========================================================
    public function __construct()
    {
        // Baris ini PENTING!
        // Ini yang ngasih tau CI4 buat nge-load file qris_helper.php
        helper('qris');
    }

    public function generate()
    {
        // 1. Ambil total dari request AJAX
        // Kita pakai $this->request->getPost() karena udah declare $request di atas
        $total = $this->request->getPost('total_amount'); 
        
        // Alternatif (kalo $this->request masih error):
        // $total = service('request')->getPost('total_amount');

        if (empty($total) || !is_numeric($total)) {
            return $this->fail('Total amount tidak valid', 400);
        }

        // 2. Ambil string qris statis dari .env
        $qrisStatis = getenv('QRIS_STATIC_STRING');
        if (empty($qrisStatis)) {
            return $this->fail('QRIS statis belum di-setting di .env', 500);
        }

        try {
            // 3. Panggil helper buat generate string dinamis
            // (Error kamu ada di baris ini, line 35)
            $stringQrisDinamis = generate_dynamic_qris($qrisStatis, $total);

            // 4. Generate gambar QR-nya jadi base64
            $qrImageBase64 = (new QRCode)->render($stringQrisDinamis);

            // 5. Kirim balik sebagai JSON
            return $this->respond([
                'success' => true,
                'qr_image_base64' => $qrImageBase64
            ]);

        } catch (\Exception $e) {
            return $this->fail('Gagal generate QRIS: ' . $e->getMessage(), 500);
        }
    }
}