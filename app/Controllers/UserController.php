<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\UserAddressModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $addressModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->addressModel = new UserAddressModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $users = $this->userModel->orderBy('created_at','DESC')->findAll();
        return view('admin/users/index', ['users'=>$users, 'title'=>'Kelola User']);
    }

    public function store()
    {
        $this->userModel->save([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'is_admin' => $this->request->getPost('is_admin') ? 1 : 0,
        ]);
        return redirect()->to('/admin/users')->with('success','User berhasil ditambahkan!');
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'is_admin' => $this->request->getPost('is_admin') ? 1 : 0
        ];
        if($this->request->getPost('password')){
            $data['password_hash'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }
        $this->userModel->update($id, $data);
        return redirect()->to('/admin/users')->with('success','User berhasil diperbarui!');
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $this->addressModel->where('user_id',$id)->delete();
        $this->userModel->delete($id);
        return redirect()->to('/admin/users')->with('success','User dan alamat terkait berhasil dihapus!');
    }

    public function detail($id)
    {
        $user = $this->userModel->find($id);
        $addresses = $this->addressModel->where('user_id',$id)->findAll();
        return view('admin/users/detail', ['user'=>$user,'addresses'=>$addresses]);
    }

    // User Profile Methods
    public function profile()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $userId = $this->session->get('user')['id'];
        $user = $this->userModel->find($userId);
        $addresses = $this->addressModel->where('user_id', $userId)->findAll();

        $data = [
            'title' => 'Profil Saya',
            'user' => $user,
            'addresses' => $addresses,
        ];

        return view('profile', $data);
    }

    public function updateProfile()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $userId = $this->session->get('user')['id'];

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email|is_unique[users.email,id,' . $userId . ']',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ];

        // Update password if provided
        if ($this->request->getPost('password')) {
            $data['password_hash'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($userId, $data);

        // Update session data
        $updatedUser = $this->userModel->find($userId);
        $this->session->set('user', $updatedUser);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    // Address Management Methods
    public function addresses()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $userId = $this->session->get('user')['id'];
        $addresses = $this->addressModel->where('user_id', $userId)->findAll();

        $data = [
            'title' => 'Kelola Alamat',
            'addresses' => $addresses,
        ];

        return view('addresses', $data);
    }

    public function newAddress()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $data = [
            'title' => 'Tambah Alamat Baru',
        ];

        return view('new_address', $data);
    }

    public function storeAddress()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $userId = $this->session->get('user')['id'];

        $rules = [
            'label' => 'required|min_length[3]|max_length[50]',
            'recipient_name' => 'required|min_length[3]|max_length[100]',
            'recipient_phone' => 'required|min_length[10]|max_length[15]',
            'street_address' => 'required|min_length[10]|max_length[255]',
            'province_kode' => 'required',
            'province_name' => 'required',
            'city_kode' => 'required',
            'city_name' => 'required',
            'subdistrict_kode' => 'required',
            'subdistrict_name' => 'required',
            'postal_code' => 'required|min_length[5]|max_length[5]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $addressData = [
            'user_id' => $userId,
            'label' => $this->request->getPost('label'),
            'recipient_name' => $this->request->getPost('recipient_name'),
            'recipient_phone' => $this->request->getPost('recipient_phone'),
            'street_address' => $this->request->getPost('street_address'),
            'province_kode' => $this->request->getPost('province_kode'),
            'province_name' => $this->request->getPost('province_name'),
            'city_kode' => $this->request->getPost('city_kode'),
            'city_name' => $this->request->getPost('city_name'),
            'subdistrict_kode' => $this->request->getPost('subdistrict_kode'),
            'subdistrict_name' => $this->request->getPost('subdistrict_name'),
            'postal_code' => $this->request->getPost('postal_code'),
            'is_default' => $this->request->getPost('is_default') ? 1 : 0,
        ];

        // If this is set as default, unset other defaults
        if ($addressData['is_default']) {
            $this->addressModel->where('user_id', $userId)->set(['is_default' => 0])->update();
        }

        $this->addressModel->save($addressData);

        return redirect()->to('profile/addresses')->with('success', 'Alamat berhasil ditambahkan!');
    }

    public function setDefaultAddress($addressId)
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $userId = $this->session->get('user')['id'];

        // Verify address belongs to user
        $address = $this->addressModel->where('id', $addressId)->where('user_id', $userId)->first();
        if (!$address) {
            return redirect()->to('profile/addresses')->with('error', 'Alamat tidak ditemukan!');
        }

        $this->addressModel->setDefault($addressId, $userId);

        return redirect()->to('profile/addresses')->with('success', 'Alamat utama berhasil diubah!');
    }

    public function deleteAddress($addressId)
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $userId = $this->session->get('user')['id'];

        // Verify address belongs to user
        $address = $this->addressModel->where('id', $addressId)->where('user_id', $userId)->first();
        if (!$address) {
            return redirect()->to('profile/addresses')->with('error', 'Alamat tidak ditemukan!');
        }

        // Attempt to delete the address
        $deleted = $this->addressModel->delete($addressId);
        if ($deleted === false) {
            return redirect()->to('profile/addresses')->with('error', 'Gagal menghapus alamat!');
        }

        // Clear any existing error messages and set success message
        $this->session->remove('error');
        return redirect()->to('profile/addresses')->with('success', 'Alamat berhasil dihapus!');
    }

    public function editAddress($addressId)
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $userId = $this->session->get('user')['id'];

        // Verify address belongs to user
        $address = $this->addressModel->where('id', $addressId)->where('user_id', $userId)->first();
        if (!$address) {
            return redirect()->to('profile/addresses')->with('error', 'Alamat tidak ditemukan!');
        }

        $data = [
            'title' => 'Edit Alamat',
            'address' => $address,
        ];

        return view('edit_address', $data);
    }

    public function updateAddress($addressId)
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $userId = $this->session->get('user')['id'];

        // Verify address belongs to user
        $address = $this->addressModel->where('id', $addressId)->where('user_id', $userId)->first();
        if (!$address) {
            return redirect()->to('profile/addresses')->with('error', 'Alamat tidak ditemukan!');
        }

        $rules = [
            'label' => 'required|min_length[3]|max_length[50]',
            'recipient_name' => 'required|min_length[3]|max_length[100]',
            'recipient_phone' => 'required|min_length[10]|max_length[15]',
            'street_address' => 'required|min_length[10]|max_length[255]',
            'province_kode' => 'required',
            'province_name' => 'required',
            'city_kode' => 'required',
            'city_name' => 'required',
            'subdistrict_kode' => 'required',
            'subdistrict_name' => 'required',
            'postal_code' => 'required|min_length[5]|max_length[5]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $addressData = [
            'label' => $this->request->getPost('label'),
            'recipient_name' => $this->request->getPost('recipient_name'),
            'recipient_phone' => $this->request->getPost('recipient_phone'),
            'street_address' => $this->request->getPost('street_address'),
            'province_kode' => $this->request->getPost('province_kode'),
            'province_name' => $this->request->getPost('province_name'),
            'city_kode' => $this->request->getPost('city_kode'),
            'city_name' => $this->request->getPost('city_name'),
            'subdistrict_kode' => $this->request->getPost('subdistrict_kode'),
            'subdistrict_name' => $this->request->getPost('subdistrict_name'),
            'postal_code' => $this->request->getPost('postal_code'),
            'is_default' => $this->request->getPost('is_default') ? 1 : 0,
        ];

        // If this is set as default, unset other defaults
        if ($addressData['is_default']) {
            $this->addressModel->where('user_id', $userId)->set(['is_default' => 0])->update();
        }

        $this->addressModel->update($addressId, $addressData);

        return redirect()->to('profile/addresses')->with('success', 'Alamat berhasil diperbarui!');
    }
}
