<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel; // Panggil CategoryModel

class Landing extends BaseController
{
    /**
     * Menampilkan halaman utama (homepage) dengan produk terbatas.
     */
    public function index()
    {
        $productModel = new ProductModel();
        $data = [
            'title'    => 'UncleStore | Jual Beli Online',
            // Ambil 8 produk terbaru saja
            'products' => $productModel->orderBy('created_at', 'DESC')->findAll(8),
        ];
        return view('landing_page', $data);
    }

    /**
     * [INI DIA METHOD YANG HILANG]
     * Menampilkan halaman "Semua Produk" dengan kategori.
     */
    public function products()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        $categories = $categoryModel->findAll();
        $products = $productModel->findAll();
        
        // Kelompokkan produk berdasarkan category_id
        $productsByCategory = [];
        foreach ($products as $product) {
            // Cek dulu apakah category_id ada dan tidak null
            if (isset($product['category_id'])) {
                $productsByCategory[$product['category_id']][] = $product;
            }
        }

        $data = [
            'title'              => 'Semua Produk | UncleStore',
            'categories'         => $categories,
            'productsByCategory' => $productsByCategory,
        ];

        return view('products_page', $data);
    }

    /**
     * Method untuk menangani pencarian produk.
     */
    public function search()
    {
        $productModel = new ProductModel();
        $keyword = $this->request->getGet('q');
        $products = [];
        if ($keyword) {
            $products = $productModel->like('name', $keyword)
                                     ->orLike('description', $keyword)
                                     ->findAll();
        }
        $data = [
            'title'    => 'Hasil Pencarian untuk "' . esc($keyword) . '"',
            'keyword'  => $keyword,
            'products' => $products,
        ];
        return view('search_results', $data);
    }
}

