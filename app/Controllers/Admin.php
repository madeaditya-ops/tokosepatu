<?php

namespace App\Controllers;
use App\Models\ProdukModel;
use App\Models\TransaksiModel;
use App\Models\LoginModel;


class Admin extends BaseController
{
    public function index()
    {
        $transaksiModel = new TransaksiModel();
        $userModel = new LoginModel();

        // Menghitung jumlah transaksi berdasarkan hari ini
        $jumlahHari = $transaksiModel
            ->where('DATE(tanggal)', date('Y-m-d')) // Transaksi hari ini
            ->countAllResults();


        $transaksiHariIni = $transaksiModel
            ->select("SUM(total_bersih) as totalTransaksi")
            ->where("DATE(tanggal)", date('Y-m-d')) // Menambahkan kondisi untuk tanggal hari ini
            ->get()
            ->getRow();
        // Jika transaksi ditemukan, tampilkan total transaksi hari ini
        $totalTransaksiHariIni = $transaksiHariIni->totalTransaksi ?? 0;


        $totalUser = $userModel
            ->select("COUNT(*) AS totalUser")
            ->get()
            ->getRow();


        // Mendapatkan data chart
        $dataChart = $this->getChartData();
        $pieChart = $this->topProductsChart();
        $topProduk = $this->getTopProducts();
        $stokAlert = $this->stokAlert();

        $data = [
            'title' => 'Dashboard',
            'totalTrPerhari' => $jumlahHari,
            'jmlTrPerhari' => $totalTransaksiHariIni,
            'datachart' => $dataChart,
            'piechart' => $pieChart,
            'topProduk' => $topProduk,
            'stokAlert' => $stokAlert,
            'totalUser' => $totalUser->totalUser,
        ];
        return view('admin/dashboard', $data);
    }
    
    function getChartData()
    {
        $transaksiModel = new TransaksiModel();
    
        // Ambil data transaksi untuk chart
        $dataPenjualan = $transaksiModel->select('tanggal, SUM(total_bersih) as total_penjualan')
                                        ->groupBy('tanggal')
                                        ->orderBy('tanggal', 'ASC')
                                        ->findAll();
    
        // Siapkan data untuk view
        $labels = [];
        $values = [];
        
        foreach ($dataPenjualan as $row) {
            // Menambahkan tanggal langsung ke labels
            $labels[] = $row['tanggal']; // Format tanggal langsung dari database
            $values[] = $row['total_penjualan'];
        }
    
        return [
            'labels' => json_encode($labels),
            'values' => json_encode($values)
        ];
    }
    
    function getTopProducts()
{
    $builder = $this->db->table('detail_transaksi');

    // Join tabel produk dengan detail_transaksi berdasarkan barcode
    $builder->select('produk.nama_produk, SUM(detail_transaksi.jumlah) as total_terjual, SUM(detail_transaksi.subtotal) as total_penjualan' )
            ->join('produk', 'detail_transaksi.barcode = produk.barcode')
            ->groupBy('produk.nama_produk')
            ->orderBy('total_terjual', 'DESC')
            ->limit(5); // Ambil 5 produk terlaris

    $query = $builder->get();

    return $query->getResultArray();
}

public function topProductsChart()
{
    $topProducts = $this->getTopProducts();

    $labels = [];
    $values = [];

    // Format data untuk digunakan di Pie Chart
    foreach ($topProducts as $product) {
        $labels[] = $product['nama_produk'];
        $values[] = $product['total_terjual'];
    }

    // Data untuk dikirim ke view
    return [
        'labels' => json_encode($labels),
        'values' => json_encode($values)
    ];

}

 public function stokAlert()
 {
    
        $produkModel = new ProdukModel();

        $stokAlert = $produkModel->select('produk.barcode, produk.nama_produk, kategori.nama_kategori as kategori, produk.size, produk.stok')
                                 ->join('kategori', 'kategori.id_kategori = produk.id_kategori')
                                 ->where('produk.stok < 10')
                                 ->findAll();
    
        return $stokAlert;

    
 }
}
