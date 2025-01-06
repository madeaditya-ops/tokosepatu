<?php

namespace App\Controllers;

use App\Models\SizeModel;

class Size extends BaseController
{

    public function __construct()
    {
        $this->size = new SizeModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Size Produk',
            'size' => $this->size->findAll()
        ]; 

        // Kirim data ke view
        return view('produk/size/size', $data);
    }

    function tambah() {
        if($this->request->isAJAX()){
            $msg = [
                'data' => view('produk/size/modalformtambah')
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak ada halaman yang bisa ditampilkan');
        }
    }

    public function simpandata() 
    {
        if($this->request->isAJAX()){
            $size = $this->request->getVar('size');
            $this->size->insert([
                'ukuran' => $size
            ]);
    
            $msg = [
                'sukses' => 'Kategori berhasil ditambahkan'
            ];
            echo json_encode($msg);
        }
       
    }

    function hapus() {
        if($this->request->isAJAX()){
            $idSize = $this -> request -> getVar('idsize');

            $this->size->delete($idSize);

            $msg = [
                'sukses' => 'Kategori berhasil dihapus'
            ];
           echo json_encode($msg);
        }
    }

    function edit()
    {
        if ($this->request->isAJAX()) {
            $idSize =  $this->request->getVar('idsize');

            $ambildatasize = $this->size->find($idSize);
            $data = [
                'idsize' => $idSize,
                'size' => $ambildatasize['ukuran']
            ];

            $msg = [
                'data' => view('produk/size/modalformedit', $data)
            ];
            echo json_encode($msg);
        }
    }

    function updatedata()
    {
        if ($this->request->isAJAX()) {
            $idSize = $this->request->getVar('idsize');
            $size = $this->request->getVar('size');

            $this->size->update($idSize, [
                'ukuran' => $size
            ]);

            $msg = [
                'sukses' =>  'Data kategori berhasil diupdate'
            ];
            echo json_encode($msg);
        }
    }



}
