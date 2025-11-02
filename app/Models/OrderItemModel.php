<?php namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'order_id',
        'product_id',
        'product_name',
        'quantity',
        'price',
    ];

    protected $useTimestamps = false;

    /**
     * Ambil items by order id (array)
     */
    public function getByOrderId($orderId)
    {
        return $this->where('order_id', $orderId)->findAll();
    }
}
