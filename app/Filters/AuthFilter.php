<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Jika mengakses admin route, cek apakah user adalah admin
        if (strpos($request->getUri()->getPath(), 'admin') !== false) {
            $user = session()->get('user');
            if (!$user || $user['is_admin'] != 1) {
                return redirect()->to('/')->with('error', 'Anda tidak memiliki akses ke halaman admin');
            }
        }

        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here if needed
        return $response;
    }
}