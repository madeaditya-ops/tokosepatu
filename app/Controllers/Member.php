<?php

namespace App\Controllers;

use App\Models\MemberModel;

class Member extends BaseController
{
    public function index()
    {
        $memberModel = new MemberModel();

        // Ambil semua data kategori
        $data = [
            'title' => 'Member',
            'member' => $memberModel->findAll()
        ]; 

        // Kirim data ke view
        return view('member/data', $data);
    }

    public function generateKodeMember()
    {
        $lastMember = $this->db->table('member')
            ->select('kode_member')
            ->orderBy('kode_member', 'DESC')
            ->get(1)
            ->getRow();

        if ($lastMember) {
            $lastCode = (int)substr($lastMember->kode_member, -4); // Ambil angka terakhir
            $newCode = sprintf("M%04d", $lastCode + 1); // Tambahkan 1 dan format jadi 4 digit
        } else {
            $newCode = "M0001"; // Jika belum ada data, mulai dari 0001
        }

        return $newCode;
    }


    public function tambah()
    {
        $memberModel = new memberModel();

        $data = [
            'title' => 'Member',
            'validation' => \Config\Services::validation(),
            'member' => $memberModel->findAll(),
            'kode_member' => $this->generateKodeMember()
        ]; 

            
        // Kirim data ke view
        return view('member/tambah', $data);
    }

    public function simpan()
    {
        $memberModel = new MemberModel();

        $rules = [
            'nama_member' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama wajib diisi.'
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
                'title' => 'Member',
                'validation' => \Config\Services::validation(),
                'member' => $memberModel->findAll(),
                'kode_member' => $this->generateKodeMember()
            ]; 
            return view('member/tambah', $data);
        } else {
            $memberModel->insert([
                'kode_member' => $this->request->getPost('kode_member'),
                'nama_member' => $this->request->getPost('nama_member'),
                'telp' => $this->request->getPost('telp'),
                'alamat' => $this->request->getPost('alamat'), 
            ]);

            session()->setFlashdata('success', 'Member berhasil ditambahkan!');

            return redirect()->to(base_url('member/data'));
        }
    }

    public function edit($id)
    {
        $memberModel = new MemberModel();
        $data = [
            'title' => 'Member',
            'validation' => \Config\Services::validation(),
            'member' => $memberModel->find($id)
        ]; 

        if (!$data['member']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Member tidak ditemukan');
        }

        return view('member/edit', $data);
    }

    public function update($id)
    {
        $memberModel = new MemberModel();

        $rules = [
            'nama_member' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama wajib diisi.'
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

        // Validasi input
        if (!$this->validate($rules)) {
            $data = [
                'title' => 'Member',
                'validation' => \Config\Services::validation(),
                'member' => $memberModel->find($id),
            ]; 

            return view('member/edit', $data);
        } else {
            $memberModel->update($id, [
                'kode_member' => $this->request->getPost('kode_member'),
                'nama_member' => $this->request->getPost('nama_member'),
                'telp' => $this->request->getPost('telp'),
                'alamat' => $this->request->getPost('alamat'), 
            ]);

            session()->setFlashdata('success', 'Member berhasil diperbarui!');
            return redirect()->to(base_url('member/data'));
        }
    }

    public function hapus($id)
    {
        $memberModel = new MemberModel();

        // Hapus data
        if (!$memberModel->find($id)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Member tidak ditemukan');
        }

        $memberModel->delete($id);

        // Kirim flashdata
        session()->setFlashdata('success', 'Member berhasil dihapus!');
        return redirect()->to('member/data');
    }
}
