<?php

namespace App\Controllers;
use App\Models\LoginModel;

class Login extends BaseController
{
    public function index()
    {   
        $data = [
            'validation' => \Config\Services::validation(),
            'title' => 'Login'
        ];

        return view('auth/login',$data);
    }
    public function login_action()
    {
       $rules = [
            'username' => 'required',
            'password' => 'required'
       ];
       if(!$this->validate($rules)) {
            $data['validation'] = $this->validator;
            return view('auth/login',$data);
       } else {
            $session = session();
            $LoginModel = new LoginModel;

            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
            $cekUsername = $LoginModel->where('username', $username)->first();
           
            if($cekUsername) {

                $session_data = [
                    'id_user' => $cekUsername['id_user'],
                    'username' => $cekUsername['username'],
                    'logged_in' => TRUE,
                    'level' => $cekUsername['level'],
                ];
                
                $session->set($session_data);

                $password_db = $cekUsername['password'];

                $cekPassword = password_verify($password, $password_db);
                if($cekPassword) {
                    switch ($cekUsername['level']) {
                        case "admin":
                            $session->setFlashdata('sukses', 'Login berhasil');
                            return redirect()->to('admin/dashboard');
                        case "kasir":
                            $session->setFlashdata('sukses', 'Login berhasil');
                            return redirect()->to('kasir/dashboard');
                        default : 
                          $session->setFlashdata('pesan', 'Akun anda belum terdaftar');
                          return redirect()->to('/');
                    }
                } else {
                    $session->setFlashdata('pesan', 'Password salah, silahkan coba lagi');
                    return redirect()->to('/');
                }

            } else {
                $session->setFlashdata('pesan', 'Username salah, silahkan coba lagi');
                return redirect()->to('/');
            }
       }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}

