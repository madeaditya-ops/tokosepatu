<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class Kategori extends BaseController
{
    public function index()
    {
        $kategoriModel = new KategoriModel();

        // Ambil semua data kategori
        $data = [
            'title' => 'Kategori Produk',
            'kategori' => $kategoriModel->findAll()
        ]; 

        // Kirim data ke view
        return view('produk/kategori', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Kategori Produk'
        ]; 
        return view('produk/tambah_kategori', $data);
    }

    public function simpan()
    {
        $kategoriModel = new KategoriModel();

        // Validasi input
        if (!$this->validate([
            'nama_kategori' => 'required|min_length[3]|max_length[50]'
        ])) {
            return redirect()->to('produk/tambah_kategori')->withInput()->with('errors', $this->validator->getErrors());
        }

        // Simpan ke database
        $kategoriModel->insert([
            'nama_kategori' => $this->request->getVar('nama_kategori'),
        ]);

        // Kirim flashdata
        session()->setFlashdata('success', 'Kategori berhasil ditambahkan!');
        return redirect()->to('produk/kategori');
    }

    public function edit($id)
    {
        $kategoriModel = new KategoriModel();
        $data = [
            'title' => 'Kategori Produk',
            'kategori' => $kategoriModel->find($id)
        ]; 

        if (!$data['kategori']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        return view('produk/edit_kategori', $data);
    }

    public function update($id)
    {
        $kategoriModel = new KategoriModel();

        // Validasi input
        if (!$this->validate([
            'nama_kategori' => 'required|min_length[3]|max_length[50]'
        ])) {
            return redirect()->to('kategori/edit/' . $id)->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update data
        $kategoriModel->update($id, [
            'nama_kategori' => $this->request->getVar('nama_kategori')
        ]);

        // Kirim flashdata
        session()->setFlashdata('success', 'Kategori berhasil diperbarui!');
        return redirect()->to('produk/kategori');
    }

    public function delete($id)
    {
        $kategoriModel = new KategoriModel();

        // Hapus data
        if (!$kategoriModel->find($id)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        $kategoriModel->delete($id);

        // Kirim flashdata
        session()->setFlashdata('success', 'Kategori berhasil dihapus!');
        return redirect()->to('produk/kategori');
    }
}
