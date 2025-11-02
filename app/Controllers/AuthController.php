<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    /**
     * Menampilkan halaman login.
     */
    public function login()
    {
        // Jika sudah login, redirect berdasarkan role
        if (session()->get('isLoggedIn')) {
            $user = session()->get('user');

            // DEBUG: Cek session
            // echo "<pre>Session User: "; print_r($user); echo "</pre>"; die();

            if ($user && $user['is_admin'] == 1) {
                $namaUser = session()->get('user')['name'] ?? 'Admin';
                session()->setFlashdata('login_success', 'Login berhasil! Selamat datang, ' . $namaUser);
                // Jika admin, redirect ke admin dashboard
                return redirect()->to('/admin/dashboard');
            } else {
                // Jika user biasa, redirect ke home
                return redirect()->to('/');
            }
        }

        $data = ['title' => 'Login ke Akun Anda'];
        return view('login', $data);
    }


    /**
     * Memproses data dari form login.
     */
    public function processLogin()
    {
        $session = session();
        $userModel = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password_hash'])) {
            $sessionData = [
                'id'       => $user['id'],
                'name'     => $user['name'],
                'email'    => $user['email'],
                'is_admin' => $user['is_admin']
            ];

            $session->set('isLoggedIn', true);
            $session->set('user', $sessionData);

            // Redirect berdasarkan role
            if ($user['is_admin'] == 1) {
                return redirect()->to('/admin/dashboard')->with('success', 'Selamat datang, Admin!');
            }

            return redirect()->to('/')->with('success', 'Login berhasil!');
        } else {
            $session->setFlashdata('error', 'Email atau password salah.');
            return redirect()->to('/login');
        }
    }


    /**
     * Menampilkan halaman registrasi.
     */
    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $data = [
            'title' => 'Buat Akun Baru',
            'validation' => \Config\Services::validation()
        ];
        return view('register', $data);
    }

    /**
     * Memproses data dari form registrasi.
     */
    public function processRegister()
    {
        $rules = [
            'name'      => 'required|min_length[3]',
            'email'     => 'required|valid_email|is_unique[users.email]',
            'password'  => 'required|min_length[8]',
            'passconf'  => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $userModel->save([
            'name'          => $this->request->getPost('name'),
            'email'         => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'is_admin'      => 0, // Default user biasa
            'created_at'    => date('Y-m-d H:i:s')
        ]);

        session()->setFlashdata('success', 'Registrasi berhasil! Silakan login.');
        return redirect()->to('/login');
    }

    /**
     * Menghapus session dan logout user.
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
