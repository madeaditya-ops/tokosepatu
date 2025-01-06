<?php
namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table  = 'produk'; 
    protected $primaryKey = 'id_produk'; 
    protected $allowedFields = ['id_kategori', 'nama_produk', 'harga', 'barcode', 'gambar_produk', 'created_at', 'updated_at', 'size', 'stok']; 
    protected $useTimestamps = true; 
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at'; 


    public function getProdukWithKategori()
    {
        return $this->select('produk.*, kategori.nama_kategori')
                    ->join('kategori', 'kategori.id_kategori = produk.id_kategori')
                    ->findAll();
    }
    
        public function getProdukById($id)
        {
            return $this->db->table('produk')
                            ->select('produk.*, kategori.nama_kategori')
                            ->join('kategori', 'produk.id_kategori = kategori.id_kategori')
                            ->where('produk.id_produk', $id)
                            ->get()
                            ->getRowArray();
        }
    

}


    