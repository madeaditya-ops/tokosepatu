<?php
namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table  = 'transaksi'; 
    protected $primaryKey = 'id_transaksi'; 
    protected $allowedFields = ['id_member', 'no_faktur', 'tanggal', 'diskon_persen', 'diskon_uang', 'total_kotor', 'total bersih', 'jumlah_uang', 'sisa_uang']; 

}


    