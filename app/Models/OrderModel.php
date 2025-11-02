<?php
namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'order_id',
        'status_pembayaran',
        'status_pesanan',
        'subtotal',
        'shipping_cost',
        'discount_amount',
        'kode_unik',
        'total_bayar',
        'payment_method',
        'shipping_service',
        'shipping_address',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ambil daftar pesanan (ringkas) untuk halaman admin.
     * Mengembalikan array objek dengan field yang dibutuhkan views/admin/orders.php
     */

        public function getSalesStats()
    {
        $builder = $this->db->table($this->table); 
        $builder->select("COUNT(id) as total_orders");
        $builder->select("SUM(CASE WHEN status_pembayaran = 'paid' THEN total_bayar ELSE 0 END) as total_revenue");
        $builder->select("COUNT(CASE WHEN status_pembayaran = 'pending' THEN 1 END) as total_pending");

        $stats = $builder->get()->getRowArray();
        return [
            'total_orders'  => $stats['total_orders'] ?? 0,
            'total_revenue' => $stats['total_revenue'] ?? 0,
            'total_pending' => $stats['total_pending'] ?? 0
        ];
    }
    
    public function getOrdersWithDetails()
    {
        $builder = $this->db->table($this->table);

        $builder->select('orders.id');
        $builder->select('orders.order_id AS order_code');
        $builder->select('orders.total_bayar AS final_amount');
        $builder->select('orders.status_pesanan AS status');
        $builder->select('orders.created_at');
        $builder->select('users.name AS customer_name');
        $builder->select('users.email AS customer_email');

        $builder->join('users', 'users.id = orders.user_id', 'left');
        $builder->orderBy('orders.created_at', 'DESC');

        return $builder->get()->getResultObject();
    }

    /**
     * Ambil detail 1 order beserta item-itemnya.
     * Mengembalikan object order dengan properti items (array)
     */
    public function getOrderWithItems($id)
    {
        // Ambil order
        $order = $this->where('orders.id', $id)
                      ->select('orders.*')
                      ->first();

        if (!$order) {
            return null;
        }

        // Ambil user (customer) kalau ada
        $user = $this->db->table('users')->select('name,email')->where('id', $order['user_id'])->get()->getRowArray();

        // Ambil alamat user default bila ada (opsional)
        $address = $this->db->table('user_addresses')
                            ->where('user_id', $order['user_id'])
                            ->where('is_default', 1)
                            ->get()
                            ->getRowArray();

        // Ambil item
        $items = $this->db->table('order_items')
                          ->where('order_id', $order['id'])
                          ->get()
                          ->getResultArray();

        // Hitung subtotal tiap item dan juga total subtotal (sanity check)
        $calculatedSubtotal = 0;
        foreach ($items as &$it) {
            $it['product_price'] = (float) $it['price'];
            $it['quantity'] = (int) $it['quantity'];
            $it['subtotal'] = $it['product_price'] * $it['quantity'];
            $calculatedSubtotal += $it['subtotal'];
        }
        unset($it);

        // Jika di DB ada field subtotal, shipping_cost, discount_amount, kode_unik, total_bayar
        $orderObj = (object) $order;
        $orderObj->items = $items;
        $orderObj->customer_name = $user['name'] ?? null;
        $orderObj->customer_email = $user['email'] ?? null;
        $orderObj->customer_phone = $address['recipient_phone'] ?? null;
        // bentuk alamat rapi
        if (!empty($address)) {
            $fullAddr = $address['recipient_name'] . "\n" . $address['street_address'] . "\n" . ($address['postal_code'] ?? '');
            $orderObj->shipping_address = $fullAddr;
        } else {
            // fallback ke kolom shipping_address di orders (jika diisi manual)
            $orderObj->shipping_address = $orderObj->shipping_address ?? '';
        }

        // Pastikan tipe numeric
        $orderObj->subtotal = (float) ($orderObj->subtotal ?? $calculatedSubtotal);
        $orderObj->shipping_cost = (float) ($orderObj->shipping_cost ?? 0);
        $orderObj->discount_amount = (float) ($orderObj->discount_amount ?? 0);
        $orderObj->kode_unik = (int) ($orderObj->kode_unik ?? 0);
        $orderObj->total_bayar = (float) ($orderObj->total_bayar ?? ($orderObj->subtotal + $orderObj->shipping_cost - $orderObj->discount_amount + $orderObj->kode_unik));

        return $orderObj;
    }

    /**
     * Update status_pesanan
     */
    public function updateStatus($id, $newStatus)
    {
        return $this->update($id, ['status_pesanan' => $newStatus]);
    }
}
