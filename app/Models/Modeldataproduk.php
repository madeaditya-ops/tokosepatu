<?php
namespace App\Models;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class Modeldataproduk extends Model {

protected $table = "produk";
protected $column_order = array(null, 'barcode', 'nama_produk');
protected $column_search = array('barcode', 'nama_produk');
protected $order = array('nama_produk' => 'desc');
protected $request;
protected $db;
protected $dt;

public function __construct(RequestInterface $request) {
    parent::__construct();
    $this->request = $request;
    $this->db = \Config\Database::connect();
}

private function _get_datatables_query($keywordkode) {
    if(strlen($keywordkode) == 0){
        $this->dt = $this->db->table($this->table)
                             ->join('kategori', 'kategori.id_kategori = produk.id_kategori');
    }else{
        $this->dt = $this->db->table($this->table)
                             ->join('kategori', 'kategori.id_kategori = produk.id_kategori')
                             ->like('barcode', $keywordkode)
                             ->orlike('nama_produk', $keywordkode);
    }
    $i = 0;
    foreach ($this->column_search as $item) {
        if ($this->request->getPost('search')['value']) {
            if ($i === 0) {
                $this->dt->groupStart();
                $this->dt->like($item, $this->request->getPost('search')['value']);
            } else {
                $this->dt->orLike($item, $this->request->getPost('search')['value']);
            }
            if (count($this->column_search) - 1 == $i) {
                $this->dt->groupEnd();
            }
        }
        $i++;
    }
    if ($this->request->getPost('order')) {
        $this->dt->orderBy(
            $this->column_order[$this->request->getPost('order')['0']['column']],
            $this->request->getPost('order')['0']['dir']
        );
    } else if (isset($this->order)) {
        $order = $this->order;
        $this->dt->orderBy(key($order), $order[key($order)]);
    }
}

public function get_datatables($keywordkode) {
    $this->_get_datatables_query($keywordkode);
    if ($this->request->getPost('length') != -1) {
        $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
    }
    return $this->dt->get()->getResult();
}

public function count_filtered($keywordkode) {
    $this->_get_datatables_query($keywordkode);
    return $this->dt->countAllResults();
}

public function count_all($keywordkode) {
    if(strlen($keywordkode) == 0){
        $tbl_storage = $this->db->table($this->table)
                                ->join('kategori', 'kategori.id_kategori = produk.id_kategori');
    }else{
        $tbl_storage = $this->db->table($this->table)
                                ->join('kategori', 'kategori.id_kategori = produk.id_kategori')
                                ->like('barcode', $keywordkode)
                                ->orlike('nama_produk', $keywordkode);
    }
    return $tbl_storage->countAllResults();
}

}