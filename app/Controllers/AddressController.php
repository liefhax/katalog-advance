<?php

namespace App\Controllers;

use App\Models\UserAddressModel;

class AddressController extends BaseController
{
    protected $userAddressModel;
    protected $session;
    protected $userId;

    public function __construct()
    {
        $this->userAddressModel = new UserAddressModel();
        $this->session = session();
        $user = $this->session->get('user');
        $this->userId = $user['id'] ?? null;
    }

    public function index()
    {
        $data = [
            'title'     => 'Buku Alamat',
            'addresses' => $this->userAddressModel->where('user_id', $this->userId)->orderBy('is_default','DESC')->findAll()
        ];
        return view('addresses/index', $data);
    }

    public function new()
    {
        // Batasi 5 alamat
        $addressCount = $this->userAddressModel->where('user_id', $this->userId)->countAllResults();
        if ($addressCount >= 5) {
            return redirect()->to('profile/addresses')->with('error', 'Anda sudah mencapai batas maksimum 5 alamat.');
        }

        $data = [
            'title' => 'Tambah Alamat Baru'
            // NOTE: kita tidak kirim provinces ke view karena view akan fetch ke /api/wilayah/provinces
        ];
        return view('addresses/new', $data);
    }

    public function create()
    {
        $rules = [
            'label'           => 'required|string|max_length[100]',
            'recipient_name'  => 'required|string|max_length[150]',
            'recipient_phone' => 'required|string|max_length[30]',
            'street_address'  => 'required|string',
            'province_kode'   => 'required|string|max_length[20]',
            'city_kode'       => 'required|string|max_length[20]',
            'subdistrict_kode'=> 'required|string|max_length[20]',
            'postal_code'     => 'required|string|max_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil nama provinsi/kota/kecamatan juga supaya gampang ditampilkan nantinya
        $provinceName = $this->request->getPost('province_name') ?? null;
        $cityName = $this->request->getPost('city_name') ?? null;
        $subdistrictName = $this->request->getPost('subdistrict_name') ?? null;

        $data = [
            'user_id'         => $this->userId,
            'label'           => $this->request->getPost('label'),
            'recipient_name'  => $this->request->getPost('recipient_name'),
            'recipient_phone' => $this->request->getPost('recipient_phone'),
            'street_address'  => $this->request->getPost('street_address'),
            'province_kode'   => $this->request->getPost('province_kode'),
            'province_name'   => $provinceName,
            'city_kode'       => $this->request->getPost('city_kode'),
            'city_name'       => $cityName,
            'subdistrict_kode'=> $this->request->getPost('subdistrict_kode'),
            'subdistrict_name'=> $subdistrictName,
            'postal_code'     => $this->request->getPost('postal_code'),
            'is_default'      => $this->request->getPost('is_default') ? 1 : 0
        ];

        // Jika ini alamat pertama, jadikan default
        $addressCount = $this->userAddressModel->where('user_id', $this->userId)->countAllResults();
        if ($addressCount == 0) {
            $data['is_default'] = 1;
        }

        if ($this->userAddressModel->save($data)) {
            $newAddressId = $this->userAddressModel->getInsertID();

            if ($data['is_default'] == 1 && $addressCount > 0) {
                $this->userAddressModel->setDefault($newAddressId, $this->userId);
            }

            if ($this->session->get('redirect_url')) {
                $redirectUrl = $this->session->get('redirect_url');
                $this->session->remove('redirect_url');
                return redirect()->to($redirectUrl)->with('success', 'Alamat berhasil ditambahkan.');
            }

            return redirect()->to('profile/addresses')->with('success', 'Alamat berhasil ditambahkan.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan alamat ke database.');
        }
    }

    public function delete($id)
    {
        $this->userAddressModel->where('id', $id)
                               ->where('user_id', $this->userId)
                               ->delete();
        return redirect()->to('profile/addresses')->with('success', 'Alamat berhasil dihapus.');
    }

    public function setDefault($id)
    {
        $this->userAddressModel->setDefault($id, $this->userId);
        return redirect()->to('profile/addresses')->with('success', 'Alamat utama berhasil diperbarui.');
    }
}
