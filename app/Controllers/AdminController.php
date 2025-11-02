<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\UserModel;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\PromoModel;

class AdminController extends BaseController
{
    protected $adminModel;
    protected $productModel;
    protected $categoryModel;
    protected $orderModel;
    protected $orderItemModel;
    protected $promoModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
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

    // --------------------------------------------------------------------
    // KELOLA PRODUK (CRUD)
    // --------------------------------------------------------------------


    public function products()
    {
        // 1. Ambil input filter & search dari URL (?keyword=...&category_id=...)
        $keyword = $this->request->getGet('keyword');
        $categoryId = $this->request->getGet('category_id');
        $perPage = 10; // Tentukan 10 produk per halaman

        // 2. Siapin query builder
        // Kita select 'products.*' dan 'categories.name'
        $builder = $this->productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left');

        // 3. Terapkan filter jika ada
        if ($keyword) {
            // Cari berdasarkan nama produk
            $builder->like('products.name', $keyword);
        }

        if ($categoryId) {
            // Filter berdasarkan ID kategori
            $builder->where('products.category_id', $categoryId);
        }

        // 4. Urutkan berdasarkan ID terbaru
        $builder->orderBy('products.id', 'DESC');

        // 5. Siapin data untuk view
        $data = [
            'title' => 'Kelola Produk',
            // Gunakan paginate() BUKAN findAll()
            // 'products' adalah nama grup pagination (penting!)
            'products' => $builder->paginate($perPage, 'products'),

            // Ambil Pager service
            'pager' => $this->productModel->pager,

            // Data untuk form filter
            'categories' => $this->categoryModel->findAll(),

            // Kirim balik nilai filter/search buat ditampilin di form
            'keyword' => $keyword,
            'current_category' => $categoryId,
            'perPage' => $perPage,

            // Pake ini buat nampilin 'Showing 1 to 10 of...'
            'currentPage' => $builder->pager->getCurrentPage('products'),
            'total' => $builder->pager->getTotal('products')
        ];

        return view('admin/products/index', $data);
    }

    /**
     * Menampilkan form tambah produk baru
     */
    public function newProduct()
    {
        $data = [
            'title' => 'Tambah Produk Baru',
            'categories' => $this->categoryModel->findAll() // Ambil data kategori
        ];
        return view('admin/products/new', $data);
    }

    /**
     * Memproses data dari form tambah produk
     */
    public function createProduct()
    {
        // 1. Aturan Validasi
        $rules = [
            'name' => 'required|min_length[3]|is_unique[products.name]',
            'category_id' => 'required|numeric',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image_url' => [
                'rules' => 'uploaded[image_url]|max_size[image_url,2048]|is_image[image_url]|mime_in[image_url,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Harus ada file gambar yang diupload',
                    'max_size' => 'Ukuran gambar terlalu besar (Max 2MB)',
                    'is_image' => 'File yang diupload bukan gambar',
                    'mime_in' => 'Format file harus jpg, jpeg, atau png'
                ]
            ]
        ];

        // 2. Cek Validasi
        if (!$this->validate($rules)) {
            // Kirim pesan error dan data input lama ke form
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 3. Proses Upload Gambar
        $imgFile = $this->request->getFile('image_url');
        $imgName = $imgFile->getRandomName(); // Bikin nama random
        $imgFile->move(FCPATH . 'uploads/products/', $imgName);; // Pindahin ke folder public/uploads/products/

        // 4. Siapin Data ke Database
        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => url_title($this->request->getPost('name'), '-', true), // Bikin slug
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'category_id' => $this->request->getPost('category_id'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'image_url' => $imgName // Simpan nama filenya ke DB
        ];

        // 5. Simpan ke DB
        $this->productModel->save($data);

        return redirect()->to('/admin/products')->with('success', 'Produk baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit produk
     */
    public function editProduct($id)
    {
        $data = [
            'title' => 'Edit Produk',
            'categories' => $this->categoryModel->findAll(),
            'product' => $this->productModel->find($id)
        ];

        if (empty($data['product'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk tidak ditemukan: ' . $id);
        }

        return view('admin/products/edit', $data);
    }

    /**
     * Memproses data dari form edit produk
     */
    public function updateProduct() // Hapus ($id) dari sini
    {
        // Ambil id dari hidden input di form
        $id = $this->request->getPost('id');

        // 1. Ambil data produk lama
        $oldProduct = $this->productModel->find($id);

        // 2. Aturan Validasi
        $nameRule = "required|min_length[3]|is_unique[products.name,id,{$id}]";
        $rules = [
            'name' => $nameRule,
            'category_id' => 'required|numeric',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image_url' => [ // Gambar gak wajib diupdate
                'rules' => 'max_size[image_url,2048]|is_image[image_url]|mime_in[image_url,image/jpg,image/jpeg,image/png]',
            ]
        ];

        // 3. Cek Validasi
        if (!$this->validate($rules)) {
            // Kalo gagal, redirect balik. Nanti notif error-nya muncul di atas tabel
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 4. Siapin data (sama kayak sebelumnya)
        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => url_title($this->request->getPost('name'), '-', true),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'category_id' => $this->request->getPost('category_id'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ];

        // 5. Cek & Proses Upload Gambar Baru (sama kayak sebelumnya)
        $imgFile = $this->request->getFile('image_url');
        if ($imgFile && $imgFile->isValid() && !$imgFile->hasMoved()) {
            $imgName = $imgFile->getRandomName();
            $imgFile->move(FCPATH . 'uploads/products/', $imgName);
            if ($oldProduct['image_url'] && file_exists(FCPATH .'uploads/products/' . $oldProduct['image_url'])) {
                unlink('uploads/products/' . $oldProduct['image_url']);
            }
            $data['image_url'] = $imgName;
        }

        // 6. Update ke DB
        $this->productModel->update($id, $data);
        return redirect()->to('/admin/products')->with('success', 'Produk berhasil diperbarui.');
    }


    /**
     * Menghapus produk (dari modal)
     */
    public function deleteProduct() // Hapus ($id) dari sini
    {
        // Ambil id dari hidden input di form
        $id = $this->request->getPost('id');

        // 1. Cari data produk (buat ngambil nama file gambar)
        $product = $this->productModel->find($id);

        if ($product) {
            // 2. Hapus file gambar dari server
            if ($product['image_url'] && file_exists(FCPATH .'uploads/products/' . $product['image_url'])) {
                unlink('uploads/products/' . $product['image_url']);
            }
            // 3. Hapus data dari database
            $this->productModel->delete($id);
            return redirect()->to('/admin/products')->with('success', 'Produk berhasil dihapus.');
        }

        return redirect()->to('/admin/products')->with('error', 'Produk gagal dihapus atau tidak ditemukan.');
    }

    // PROMO & VOUCHER MANAGEMENT

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


    public function categories()
    {
        $data = [
            'title' => 'Kelola Kategori',
            'categories' => $this->categoryModel->findAll()
        ];
        return view('admin/categories/index', $data);
    }

    /**
     * PROSES: Buat kategori baru
     */
    public function createCategory()
    {
        // 1. Validasi
        $rules = ['name' => 'required|is_unique[categories.name]'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Siapin data
        $name = $this->request->getPost('name');
        $data = [
            'name' => $name,
            'slug' => url_title($name, '-', true) // Bikin slug otomatis
        ];

        // 3. Simpan
        $this->categoryModel->save($data);
        return redirect()->to('/admin/categories')->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    /**
     * PROSES: Update kategori
     */
    public function updateCategory()
    {
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');

        // 1. Validasi (unik, tapi abaikan id dia sendiri)
        $rules = ['name' => "required|is_unique[categories.name,id,{$id}]"];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Siapin data
        $data = [
            'id'   => $id, // Penting buat update
            'name' => $name,
            'slug' => url_title($name, '-', true) // Bikin slug otomatis
        ];

        // 3. Update
        $this->categoryModel->save($data);
        return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil diupdate.');
    }

    /**
     * PROSES: Hapus kategori
     */
    public function deleteCategory()
    {
        $id = $this->request->getPost('id');
        $this->categoryModel->delete($id);

        return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil dihapus.');
    }

    // ORDER MANAGEMENT
    /**
     * Halaman daftar pesanan (admin)
     */
    public function orders()
    {
        $data = [
            'title'  => 'Kelola Pesanan',
            'orders' => $this->orderModel->getOrdersWithDetails()
        ];

        return view('admin/orders/orders', $data);
    }

    /**
     * Halaman detail order (opsional view terpisah)
     */
    public function orderDetail($id)
    {
        $order = $this->orderModel->getOrderWithItems($id);
        if (!$order) {
            return redirect()->to('/admin/orders')->with('warning', 'Pesanan tidak ditemukan.');
        }

        $data = [
            'title' => 'Detail Pesanan',
            'order' => $order
        ];

        return view('admin/orders/order_detail', $data);
    }

    /**
     * Endpoint JSON untuk modal detail (dipanggil AJAX)
     * Route: GET /admin/orders/json/{id}
     */
    public function getOrderDetailJson($id)
    {
        $order = $this->orderModel->getOrderWithItems($id);
        if (!$order) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Order not found']);
        }

        $items = [];
        foreach ($order->items as $it) {
            $items[] = [
                'product_name'  => $it['product_name'],
                'product_price' => (float) $it['product_price'],
                'quantity'      => (int) $it['quantity'],
                'subtotal'      => (float) $it['subtotal'],
            ];
        }

        $payload = [
            'id'               => (int) $order->id,
            'order_code'       => $order->order_id,
            'customer_name'    => $order->customer_name,
            'customer_email'   => $order->customer_email,
            'customer_phone'   => $order->customer_phone,
            'shipping_address' => $order->shipping_address,
            'status'           => $order->status_pesanan,
            'total_amount'     => (float) $order->subtotal,
            'discount_amount'  => (float) $order->discount_amount,
            'shipping_cost'    => (float) $order->shipping_cost,
            'kode_unik'        => (int) $order->kode_unik,
            'final_amount'     => (float) $order->total_bayar,
            'items'            => $items,
        ];

        return $this->response->setJSON($payload);
    }

    /**
     * Update status (dipanggil dari modal form)
     * Route: POST /admin/orders/update/{id}
     */
    public function updateOrderStatus($id)
    {
        $newStatus = $this->request->getPost('status');

        if (!$newStatus) {
            return redirect()->back()->with('warning', 'Status tidak valid.');
        }

        $order = $this->orderModel->find($id);
        if (!$order) {
            return redirect()->back()->with('warning', 'Pesanan tidak ditemukan.');
        }

        $this->orderModel->updateStatus($id, $newStatus);
        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function deleteOrder($id)
    {
        $order = $this->orderModel->find($id);
        if (!$order) {
            return redirect()->back()->with('warning', 'Pesanan tidak ditemukan.');
        }

        // Hapus dulu item order (biar tidak orphan)
        $this->orderItemModel->where('order_id', $id)->delete();

        // Hapus order
        $this->orderModel->delete($id);

        return redirect()->back()->with('success', 'Pesanan berhasil dihapus.');
    }
}
