<?php
namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'slug', 'description', 'price', 'category_id', 'image_url', 'stock', 'is_active'];
    
    // Untuk laporan penjualan (jika ada tabel orders nanti)
    public function getSalesReport($startDate = null, $endDate = null)
    {
        $builder = $this->db->table('orders');
        $builder->select('COUNT(*) as total_orders, SUM(total_amount) as total_revenue');
        
        if ($startDate && $endDate) {
            $builder->where('created_at >=', $startDate);
            $builder->where('created_at <=', $endDate);
        }
        
        return $builder->get()->getRow();
    }
    
    // Untuk mendapatkan produk terpopuler
    public function getPopularProducts($limit = 5)
    {
        $builder = $this->db->table('order_items');
        $builder->select('products.name, SUM(order_items.quantity) as total_sold');
        $builder->join('products', 'products.id = order_items.product_id');
        $builder->groupBy('order_items.product_id');
        $builder->orderBy('total_sold', 'DESC');
        $builder->limit($limit);
        
        return $builder->get()->getResult();
    }
}