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
        $categoryModel = new CategoryModel();

        $data = [
            'title'    => 'UncleStore | Jual Beli Online',
            // Ambil 8 produk terbaru saja
            'products' => $productModel->orderBy('created_at', 'DESC')->findAll(8),
            // Ambil produk baru (misalnya 4 produk terbaru lainnya)
            'newProducts' => $productModel->orderBy('created_at', 'DESC')->findAll(4, 8),
            // Ambil semua kategori
            'categories' => $categoryModel->findAll(),
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

        // Handle parameters
        $categoryId = $this->request->getGet('category');
        $page = (int) $this->request->getGet('page') ?: 1;
        $perPage = 15;
        $sort = $this->request->getGet('sort');

        // Build query based on filters
        $query = $productModel;

        // Category filter
        if ($categoryId) {
            $query = $query->where('category_id', $categoryId);
        }

        // Apply sorting
        switch ($sort) {
            case 'name-asc':
                $query = $query->orderBy('name', 'ASC');
                break;
            case 'name-desc':
                $query = $query->orderBy('name', 'DESC');
                break;
            case 'price-low':
                $query = $query->orderBy('price', 'ASC');
                break;
            case 'price-high':
                $query = $query->orderBy('price', 'DESC');
                break;
            case 'newest':
            default:
                $query = $query->orderBy('created_at', 'DESC');
                break;
        }

        // Get all products for this filter/sort combination
        $allFilteredProducts = $query->findAll();
        $totalProducts = count($allFilteredProducts);

        // Apply pagination
        $offset = ($page - 1) * $perPage;
        $displayProducts = array_slice($allFilteredProducts, $offset, $perPage);

        // Kelompokkan produk berdasarkan category_id untuk display
        $productsByCategory = [];
        foreach ($allFilteredProducts as $product) {
            if (isset($product['category_id'])) {
                $productsByCategory[$product['category_id']][] = $product;
            }
        }

        $data = [
            'title'              => 'Semua Produk | UncleStore',
            'categories'         => $categories,
            'productsByCategory' => $productsByCategory,
            'displayProducts'    => $displayProducts,
            'currentCategory'    => $categoryId,
            'currentPage'        => $page,
            'totalProducts'      => $totalProducts,
            'hasMore'            => ($offset + $perPage) < $totalProducts,
            'currentSort'        => $sort,
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

    /**
     * Menampilkan halaman About.
     */
    public function about()
    {
        $data = [
            'title' => 'Tentang UncleStore',
        ];
        return view('about', $data);
    }

    /**
     * Menampilkan halaman Contact.
     */
    public function contact()
    {
        $data = [
            'title' => 'Hubungi Kami - UncleStore',
        ];
        return view('contact', $data);
    }
}

