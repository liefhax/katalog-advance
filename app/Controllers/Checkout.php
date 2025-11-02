<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\UserAddressModel;
use App\Models\ProductModel;
use App\Models\CartModel;
use App\Models\UserModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Checkout extends BaseController
{
    protected $cartModel;
    protected $userModel;
    protected $userAddressModel;
    protected $productModel;
    protected $session;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->userModel = new UserModel();
        $this->userAddressModel = new UserAddressModel();
        $this->productModel = new ProductModel();
        $this->session = session();

        helper(['text', 'form', 'number', 'qris']);

    }

    /**
     * Halaman checkout utama
     */
    public function index()
    {
        $userData = $this->session->get('user');
        if (!$userData || !isset($userData['id'])) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $userId = $userData['id'];

        $db = db_connect();
        $addresses = $db->table('user_addresses')
            ->select('user_addresses.*, prov.nama AS province_name, city.nama AS city_name, sub.nama AS subdistrict_name')
            ->join('wilayah AS prov', 'prov.kode = user_addresses.province_kode', 'left')
            ->join('wilayah AS city', 'city.kode = user_addresses.city_kode', 'left')
            ->join('wilayah AS sub', 'sub.kode = user_addresses.subdistrict_kode', 'left')
            ->where('user_addresses.user_id', $userId)
            ->orderBy('user_addresses.is_default', 'DESC')
            ->get()
            ->getResultArray();

        if (empty($addresses)) {
            $this->session->set('redirect_url', base_url('checkout'));
            return redirect()->to('profile/addresses/new')
                ->with('info', 'Anda harus menambahkan alamat pengiriman terlebih dahulu.');
        }

        $cartItems = $this->cartModel->getCartItems($userId);
        if (empty($cartItems)) {
            return redirect()->to('/cart')->with('warning', 'Keranjang Anda kosong.');
        }

        $itemsForView = [];
        $total = 0;

        foreach ($cartItems as $item) {
            $product = $this->productModel->select('image_url')->find($item['product_id']);
            $item['image_url'] = $product['image_url'] ?? base_url('assets/img/default-product.png');

            $price = (float)($item['price'] ?? 0);
            $quantity = (int)($item['quantity'] ?? 0);
            $total += $price * $quantity;

            $itemsForView[] = $item;
        }

        return view('checkout', [
            'cartItems' => $itemsForView,
            'total' => $total,
            'addresses' => $addresses,
            'user' => $this->userModel->find($userId),
        ]);
    }

    /**
     * Simpan pesanan baru ke database
     */
    public function placeOrder()
    {
        $postData = $this->request->getPost();
        $userData = $this->session->get('user');

        if (!$userData || !isset($userData['id'])) {
            return redirect()->to('/login')->with('error', 'Sesi Anda telah berakhir, silakan login lagi.');
        }
        $userId = $userData['id'];

        $cartItems = $this->cartModel->getCartItems($userId);
        if (empty($cartItems)) {
            return redirect()->to('/cart')->with('error', 'Keranjang kamu kosong.');
        }

        $address = $this->userAddressModel->where([
            'id' => $postData['user_address_id'] ?? 0,
            'user_id' => $userId
        ])->first();

        if (!$address) {
            return redirect()->back()->with('error', 'Alamat pengiriman tidak valid.');
        }

        $addressString = "{$address['recipient_name']} ({$address['recipient_phone']})\n"
            . "{$address['street_address']}\n"
            . "{$postData['selected_subdistrict_name']}, {$postData['selected_city_name']}\n"
            . "{$postData['selected_province_name']}, {$address['postal_code']}";

        // Generate invoice unik
        $orderIdString = 'INV-' . date('Ymd') . '-' . strtoupper(random_string('alnum', 6));

        // Siapkan data pesanan utama
        $orderData = [
            'order_id' => $orderIdString,
            'user_id' => $userId,
            'status_pembayaran' => 'pending',
            'status_pesanan' => 'baru',
            'subtotal' => (float)$postData['subtotal'],
            'shipping_cost' => (float)$postData['shipping_cost'],
            'discount_amount' => (float)$postData['discount_amount'],
            'kode_unik' => (int)$postData['unique_code'],
            'total_bayar' => (float)$postData['total_amount'],
            'payment_method' => $postData['payment_method'] ?? 'bca_manual',
            'shipping_service' => $postData['shipping_service_name'] ?: 'Unknown',
            'shipping_address' => $addressString,
        ];

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $orderModel = new OrderModel();
            $orderItemModel = new OrderItemModel();

            // Simpan order utama
            $orderModel->insert($orderData);
            $newOrderId = $orderModel->getInsertID();

            // Siapkan data item
            $itemsToSave = [];
            foreach ($cartItems as $item) {
                $itemsToSave[] = [
                    'order_id' => $newOrderId,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ];
            }

            $orderItemModel->insertBatch($itemsToSave);

            // Kosongkan keranjang
            $this->cartModel->where('user_id', $userId)->delete();

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new DatabaseException('Transaksi gagal disimpan.');
            }

            // Simpan data ke session flash
            session()->setFlashdata('order_success_data', [
                'order_id' => $orderIdString,
                'total_bayar' => $orderData['total_bayar'],
                'payment_method' => $orderData['payment_method'],
            ]);

            session()->setFlashdata('order_success_data', $orderData);
return redirect()->to('/order/success');


        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', '[Checkout Error] ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Halaman pembayaran (QRIS / Transfer)
     */
    public function pembayaran($orderIdString = null)
    {
        if (!$orderIdString) {
            return redirect()->to('/')->with('error', 'Pesanan tidak ditemukan.');
        }

        $orderModel = new OrderModel();
        $order = $orderModel->where('order_id', $orderIdString)->first();

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $userData = $this->session->get('user');
        if (!$userData || !isset($userData['id']) || $order['user_id'] != $userData['id']) {
            return redirect()->to('/akun/pesanan')->with('error', 'Anda tidak memiliki akses ke pesanan ini.');
        }

        $data = [
            'order' => $order,
            'qr_image' => null,
        ];

        if ($order['payment_method'] == 'qris_manual') {
            try {
                $qrisStatis = getenv('QRIS_STATIC_STRING');
                if (empty($qrisStatis)) {
                    throw new \Exception('QRIS_STATIC_STRING belum di-set di .env');
                }
                $stringDinamis = generate_dynamic_qris($qrisStatis, $order['total_bayar']);
                $data['qr_image'] = (new \chillerlan\QRCode\QRCode)->render($stringDinamis);
            } catch (\Exception $e) {
                log_message('error', 'Gagal generate QRIS: ' . $e->getMessage());
            }
        }

        return view('checkout/pembayaran', $data);
    }
}
