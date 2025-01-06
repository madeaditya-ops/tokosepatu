<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if(!session()->get('logged_in')) {
            session()->setFlashdata('pesan', 'Anda belum login');
            return redirect()->to('/');
        }

        if(session()->get('level') != 'admin') {
            session()->setFlashdata('pesan', 'Anda tidak memiliki akses, login terlebih dahulu');
            return redirect()->to('/');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}