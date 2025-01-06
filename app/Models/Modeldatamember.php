<?php
namespace App\Models;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class Modeldatamember extends Model {

protected $table = "member";
protected $column_order = array(null,'id_member','kode_member', 'nama_member', 'telp', 'alamat');
protected $column_search = array('id_member','kode_member', 'nama_member', 'telp', 'alamat');
protected $order = array('nama_member' => 'desc');
protected $request;
protected $db;
protected $dt;

public function __construct(RequestInterface $request) {
    parent::__construct();
    $this->request = $request;
    $this->db = \Config\Database::connect();
    $this->dt = $this->db->table($this->table);
}

private function _get_datatables_query() {
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
        $columnIndex = $this->request->getPost('order')['0']['column'];
        $direction = $this->request->getPost('order')['0']['dir'];
    
        // Validasi apakah index kolom ada di $this->column_order
        if (isset($this->column_order[$columnIndex]) && in_array($direction, ['asc', 'desc'])) {
            $this->dt->orderBy($this->column_order[$columnIndex], $direction);
        }
    }  else if (isset($this->order)) {
        $order = $this->order;
        $key = key($order);
        $direction = $order[$key];
    
        // Validasi apakah $key dan $direction valid
        if (!empty($key) && in_array($direction, ['asc', 'desc'])) {
            $this->dt->orderBy($key, $direction);
        }
    }
}

public function get_datatables() {
    $this->_get_datatables_query();
    if ($this->request->getPost('length') != -1) {
        $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
    }
    return $this->dt->get()->getResult();
}

public function count_filtered() {
    $this->_get_datatables_query();
    return $this->dt->countAllResults();
}

public function count_all() {
   $tbl_storage = $this->db->table($this->table);
    return $tbl_storage->countAllResults();
}

}