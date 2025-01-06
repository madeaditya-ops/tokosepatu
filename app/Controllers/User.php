<?php

namespace App\Controllers;
use App\Models\LoginModel;

class User extends BaseController
{
    public function index()
    {   
        $userModel = new LoginModel();
        
        $data = [
            'title' => 'User',
            'user' => $userModel->findall()
        ];

        return view('user/data',$data);
    }

    public function tambah()
    {
        $userModel = new LoginModel();

        $data = [
            'title' => 'Tambah User',
            'validation' => \Config\Services::validation(),
            'user' => $userModel->findAll(),
        ]; 

            
        // Kirim data ke view
        return view('user/tambah', $data);
    }

    public function simpan()
    {
        $userModel = new LoginModel();

        $rules = [
            'nama_lengkap' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama wajib diisi.'
                ],
            ],
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Username wajib diisi.'
                ],
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password wajib diisi.'
                ],
            ],
            'level' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Role wajib diisi.'
                ],
            ],
            'telp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No Telepon wajib diisi.'
                ],
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat wajib diisi.'
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            $data = [
                'title' => 'User',
                'validation' => \Config\Services::validation(),
                'user' => $userModel->findAll(),
            ]; 
            return view('user/tambah', $data);
        } else {
            $userModel->insert([
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'username' => $this->request->getPost('username'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'level' => $this->request->getPost('level'),
                'telp' => $this->request->getPost('telp'),
                'alamat' => $this->request->getPost('alamat'), 
            ]);

            session()->setFlashdata('success', 'User berhasil ditambahkan!');

            return redirect()->to(base_url('user/data'));
        }
    }

    public function hapus($id)
    {
        $userModel = new LoginModel();
        $UserId = session()->get('id_user'); // Ambil ID user yang sedang login
        $UserLevel = session()->get('level'); // Ambil role user yang sedang login
    

        // Cek apakah ID yang akan dihapus adalah ID admin yang sedang login
        if ($id == $UserId && $UserLevel == 'admin') {
            // Jika admin mencoba menghapus dirinya sendiri
            session()->setFlashdata('error', 'Admin tidak dapat menghapus dirinya sendiri!');
            return redirect()->to('user/data'); // Redirect ke halaman data user
        }

        if (!$userModel->find($id)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User tidak ditemukan');
        }
 
        $userModel->delete($id);

        // Kirim flashdata
        session()->setFlashdata('success', 'User berhasil dihapus!');
        return redirect()->to('user/data');
    }
   
    public function edit($id)
    {
        $userModel = new LoginModel();
        $data = [
            'title' => 'User',
            'validation' => \Config\Services::validation(),
            'user' => $userModel->find($id)
        ]; 

        if (!$data['user']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User tidak ditemukan');
        }

        return view('user/edit', $data);
    }

    public function update($id)
    {
        $userModel = new LoginModel();

        $rules = [
            'nama_lengkap' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama wajib diisi.'
                ],
            ],
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Username wajib diisi.'
                ],
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password wajib diisi.'
                ],
            ],
            'level' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Role wajib diisi.'
                ],
            ],
            'telp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No Telepon wajib diisi.'
                ],
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat wajib diisi.'
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            $data = [
                'title' => 'User',
                'validation' => \Config\Services::validation(),
                'user' => $userModel->findAll(),
            ]; 
            return view('user/edit', $data);
        } else {
            $userModel->update($id, [
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'username' => $this->request->getPost('username'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'level' => $this->request->getPost('level'),
                'telp' => $this->request->getPost('telp'),
                'alamat' => $this->request->getPost('alamat'), 
            ]);
            session()->setFlashdata('success', 'User berhasil diperbarui!');
            return redirect()->to(base_url('user/data'));
        }
    }

}

