<?php
namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'order_code', 'user_id', 'total_amount', 'status', 'shipping_address',
        'customer_name', 'customer_email', 'customer_phone', 'promo_id',
        'discount_amount', 'final_amount', 'notes'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    public function getOrdersWithDetails($limit = null)
    {
        $builder = $this->db->table('orders');
        $builder->select('orders.*, users.name as user_name, promos.name as promo_name');
        $builder->join('users', 'users.id = orders.user_id', 'left');
        $builder->join('promos', 'promos.id = orders.promo_id', 'left');
        $builder->orderBy('orders.created_at', 'DESC');
        
        if ($limit) {
            $builder->limit($limit);
        }
        
        return $builder->get()->getResult();
    }
    
    public function getOrderWithItems($orderId)
    {
        $order = $this->find($orderId);
        if (!$order) return null;
        
        $builder = $this->db->table('order_items');
        $builder->select('order_items.*, products.image_url');
        $builder->join('products', 'products.id = order_items.product_id');
        $builder->where('order_items.order_id', $orderId);
        
        $order->items = $builder->get()->getResult();
        
        return $order;
    }
    
    public function updateOrderStatus($orderId, $status)
    {
        return $this->update($orderId, ['status' => $status]);
    }
    
    public function getSalesStats($period = 'monthly')
    {
        $builder = $this->db->table('orders');
        $builder->select("
            DATE_FORMAT(created_at, '%Y-%m') as period,
            COUNT(*) as total_orders,
            SUM(final_amount) as total_revenue,
            AVG(final_amount) as avg_order_value
        ");
        $builder->where('status', 'delivered');
        $builder->groupBy("DATE_FORMAT(created_at, '%Y-%m')");
        $builder->orderBy('period', 'DESC');
        $builder->limit(12);
        
        return $builder->get()->getResult();
    }
}