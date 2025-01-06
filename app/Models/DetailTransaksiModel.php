<?php
namespace App\Models;

use CodeIgniter\Model;

class DetailTransaksiModel extends Model
{
    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id_detail';
    protected $allowedFields = ['id_transaksi', 'id_produk', 'id_size', 'jumlah', 'harga'];
    protected $useTimestamps = false;

    public function getDetailsByTransaksiId($id_transaksi)
    {
        return $this->where('id_transaksi', $id_transaksi)->findAll();
    }
}
