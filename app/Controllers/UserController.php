<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\UserAddressModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $addressModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->addressModel = new UserAddressModel();
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
}
