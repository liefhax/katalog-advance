<?php
namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\UserModel;
use App\Models\OrderModel;
use App\Models\PromoModel;

class AdminController extends BaseController
{
    protected $adminModel;
    protected $productModel;
    protected $categoryModel;
    protected $orderModel;
    protected $promoModel;
    
    public function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->orderModel = new OrderModel();
        $this->promoModel = new PromoModel();
        
        // Middleware untuk cek admin

    }
    
    public function dashboard()
    {
        $salesStats = $this->orderModel->getSalesStats();
        
        $data = [
            'title' => 'Admin Dashboard',
            'total_products' => $this->productModel->countAll(),
            'total_categories' => $this->categoryModel->countAll(),
            'total_users' => model(UserModel::class)->countAll(),
            'total_orders' => $this->orderModel->countAll(),
            'recent_products' => $this->productModel->orderBy('created_at', 'DESC')->limit(5)->find(),
            'recent_orders' => $this->orderModel->getOrdersWithDetails(5),
            'sales_stats' => $salesStats
        ];
        
        return view('admin/dashboard', $data);
    }
    
    // ... [method products, addProduct, editProduct, deleteProduct tetap sama]
    
    public function orders()
    {
        $data = [
            'title' => 'Kelola Pesanan',
            'orders' => $this->orderModel->getOrdersWithDetails()
        ];
        
        return view('admin/orders', $data);
    }
    
    public function orderDetail($id)
    {
        $order = $this->orderModel->getOrderWithItems($id);
        
        if (!$order) {
            return redirect()->to('/admin/orders')->with('error', 'Pesanan tidak ditemukan');
        }
        
        $data = [
            'title' => 'Detail Pesanan #' . $order->order_code,
            'order' => $order
        ];
        
        return view('admin/order_detail', $data);
    }
    
    public function updateOrderStatus($id)
    {
        $status = $this->request->getPost('status');
        $validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        
        if (!in_array($status, $validStatuses)) {
            return redirect()->back()->with('error', 'Status tidak valid');
        }
        
        if ($this->orderModel->updateOrderStatus($id, $status)) {
            return redirect()->back()->with('success', 'Status pesanan berhasil diupdate');
        }
        
        return redirect()->back()->with('error', 'Gagal mengupdate status pesanan');
    }
    
    public function promos()
    {
        $data = [
            'title' => 'Kelola Promo & Voucher',
            'promos' => $this->promoModel->findAll()
        ];
        
        return view('admin/promos', $data);
    }
    
    public function addPromo()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required',
                'code' => 'required|is_unique[promos.code]',
                'discount_value' => 'required|numeric',
                'start_date' => 'required',
                'end_date' => 'required'
            ];
            
            if ($this->validate($rules)) {
                $promoData = [
                    'name' => $this->request->getPost('name'),
                    'code' => strtoupper($this->request->getPost('code')),
                    'description' => $this->request->getPost('description'),
                    'discount_type' => $this->request->getPost('discount_type'),
                    'discount_value' => $this->request->getPost('discount_value'),
                    'min_purchase' => $this->request->getPost('min_purchase') ?? 0,
                    'max_discount' => $this->request->getPost('max_discount'),
                    'usage_limit' => $this->request->getPost('usage_limit'),
                    'start_date' => $this->request->getPost('start_date'),
                    'end_date' => $this->request->getPost('end_date'),
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0
                ];
                
                if ($this->promoModel->save($promoData)) {
                    return redirect()->to('/admin/promos')->with('success', 'Promo berhasil ditambahkan');
                }
            }
        }
        
        return redirect()->back()->with('errors', $this->validator->getErrors());
    }
    
    public function editPromo($id)
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required',
                'code' => "required|is_unique[promos.code,id,{$id}]",
                'discount_value' => 'required|numeric',
                'start_date' => 'required',
                'end_date' => 'required'
            ];
            
            if ($this->validate($rules)) {
                $promoData = [
                    'id' => $id,
                    'name' => $this->request->getPost('name'),
                    'code' => strtoupper($this->request->getPost('code')),
                    'description' => $this->request->getPost('description'),
                    'discount_type' => $this->request->getPost('discount_type'),
                    'discount_value' => $this->request->getPost('discount_value'),
                    'min_purchase' => $this->request->getPost('min_purchase') ?? 0,
                    'max_discount' => $this->request->getPost('max_discount'),
                    'usage_limit' => $this->request->getPost('usage_limit'),
                    'start_date' => $this->request->getPost('start_date'),
                    'end_date' => $this->request->getPost('end_date'),
                    'is_active' => $this->request->getPost('is_active') ? 1 : 0
                ];
                
                if ($this->promoModel->save($promoData)) {
                    return redirect()->to('/admin/promos')->with('success', 'Promo berhasil diupdate');
                }
            }
        }
        
        return redirect()->back()->with('errors', $this->validator->getErrors());
    }
    
    public function deletePromo($id)
    {
        if ($this->promoModel->delete($id)) {
            return redirect()->back()->with('success', 'Promo berhasil dihapus');
        }
        
        return redirect()->back()->with('error', 'Gagal menghapus promo');
    }
    
    public function stockManagement()
    {
        $data = [
            'title' => 'Manajemen Stok',
            'products' => $this->productModel->select('products.*, categories.name as category_name')
                ->join('categories', 'categories.id = products.category_id', 'left')
                ->findAll()
        ];
        
        return view('admin/stock', $data);
    }
    
    public function updateStock($id)
    {
        $stock = $this->request->getPost('stock');
        
        if (!is_numeric($stock) || $stock < 0) {
            return redirect()->back()->with('error', 'Stok harus berupa angka positif');
        }
        
        if ($this->productModel->update($id, ['stock' => $stock])) {
            return redirect()->back()->with('success', 'Stok berhasil diupdate');
        }
        
        return redirect()->back()->with('error', 'Gagal mengupdate stok');
    }
}