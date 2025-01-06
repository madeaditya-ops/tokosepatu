<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\KategoriModel;

class Produk extends BaseController
{
    public function index()
    {
        $produkModel = new ProdukModel();

        $data = [
            'title' => 'Data Produk',
            'produk' => $produkModel->getProdukWithKategori()
        ]; 

        // Kirim data ke view
        return view('produk/data_produk/data_produk', $data);
    }

    public function tambah()
    {
        $kategoriModel = new KategoriModel();

        $data = [
            'title' => 'Data Produk',
            'validation' => \Config\Services::validation(),
            'kategori' => $kategoriModel->findAll()
        ]; 

        // Kirim data ke view
        return view('produk/data_produk/tambah', $data);
    }

    public function simpan()
    {
        $produkModel = new ProdukModel();
        $kategoriModel = new KategoriModel();

        $rules = [
            'nama_produk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama produk wajib diisi.'
                ],
            ],
            'barcode' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Barcode wajib diisi.'
                ],
            ],
            'harga' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harga wajib diisi.'
                ],
            ],
            'id_kategori' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kategori wajib dipilih.'
                ],
            ],
            'size' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'size wajib dipilih.'
                ],
            ],
            'stok' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'stok wajib diisi.'
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            $data = [
                'title' => 'Data Produk',
                'validation' => \Config\Services::validation(),
                'kategori' => $kategoriModel->findAll()
            ]; 
            return redirect()->to('produk/data_produk/tambah', $data);
        } else {
            $produkModel->insert([
                'nama_produk' => $this->request->getVar('nama_produk'),
                'barcode' => $this->request->getVar('barcode'),
                'id_kategori' => $this->request->getVar('id_kategori'), 
                'harga' => $this->request->getVar('harga'), 
                'size' => $this->request->getVar('size'),
                'stok' => $this->request->getVar('stok'),
                'gambar_produk' => $this->request->getFile('gambar_produk'),
            ]);

            session()->setFlashdata('success', 'Produk berhasil ditambahkan!');

            return redirect()->to(base_url('produk/data_produk/data_produk'));
        }
    }

    public function edit($id)
    {
        $produkModel = new ProdukModel();
        $kategoriModel = new KategoriModel();

        $data = [
            'title' => 'Edit Data Produk',
            'validation' => \Config\Services::validation(),
            'produk' => $produkModel->getProdukById($id),
            'kategori' => $kategoriModel->findAll()
        ]; 

        // Kirim data ke view
        return view('produk/data_produk/edit', $data);
    }

    public function update($id)
    {
        $produkModel = new ProdukModel();
        $kategoriModel = new KategoriModel();

        $rules = [
            'nama_produk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama produk wajib diisi.'
                ],
            ],
            'barcode' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Barcode wajib diisi.'
                ],
            ],
            'harga' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Harga wajib diisi.'
                ],
            ],
            'id_kategori' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kategori wajib dipilih.'
                ],
            ],
            'size' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'size wajib dipilih.'
                ],
            ],
            'stok' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'stok wajib diisi.'
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            $data = [
                'title' => 'Edit Data Produk',
                'validation' => \Config\Services::validation(),
                'produk' => $produkModel->getProdukById($id),
                'kategori' => $kategoriModel->findAll(),
            ]; 

            return view('produk/data_produk/edit', $data);
        } else {
            $produkModel->update($id, [
                'nama_produk' => $this->request->getVar('nama_produk'),
                'barcode' => $this->request->getVar('barcode'),
                'id_kategori' => $this->request->getVar('id_kategori'), 
                'harga' => $this->request->getVar('harga'),
                'size' => $this->request->getVar('size'),
                'stok' => $this->request->getVar('stok'),
                'gambar_produk' => $this->request->getFile('gambar_produk'),
            ]);

            session()->setFlashdata('success', 'Produk berhasil diperbarui!');
            return redirect()->to(base_url('produk/data_produk/data_produk'));
        }
    }   

    public function delete($id)
    {
        $produkModel = new ProdukModel();

        $produk = $produkModel->find($id);
        if ($produk) {
            $produkModel->delete($id);
            session()->setFlashdata('success', 'Produk berhasil dihapus!');
        }

        return redirect()->to(base_url('produk/data_produk/data_produk'));
    }
}
