<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class ApiWilayah extends ResourceController
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    // ✅ Ambil semua provinsi (kode 2 digit)
    public function provinces()
    {
        $query = $this->db->table('wilayah')
            ->select('kode, nama')
            ->where('CHAR_LENGTH(kode)', 2)
            ->orderBy('nama', 'ASC')
            ->get()
            ->getResult();

        return $this->respond($query);
    }

    // ✅ Ambil semua kota berdasarkan kode provinsi
    public function cities($provinceCode = null)
    {
        if (!$provinceCode) {
            return $this->fail('Kode provinsi wajib diisi', 400);
        }

        $query = $this->db->table('wilayah')
            ->select('kode, nama')
            ->like('kode', $provinceCode . '.', 'after')
            ->where('CHAR_LENGTH(kode)', 5)
            ->orderBy('nama', 'ASC')
            ->get()
            ->getResult();

        return $this->respond($query);
    }

    // ✅ Ambil semua kecamatan berdasarkan kode kota
    public function districts($cityCode = null)
    {
        if (!$cityCode) {
            return $this->fail('Kode kota wajib diisi', 400);
        }

        $query = $this->db->table('wilayah')
            ->select('kode, nama')
            ->like('kode', $cityCode . '.', 'after')
            ->where('CHAR_LENGTH(kode)', 8)
            ->orderBy('nama', 'ASC')
            ->get()
            ->getResult();

        return $this->respond($query);
    }
}
