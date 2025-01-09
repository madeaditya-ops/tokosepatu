<?php

namespace App\Controllers;

class Laporan extends BaseController
{
    public function index()
    {
        $bulan = $this->request->getVar('bulan'); // Tangkap input bulan dari request (GET atau POST)

        $tbLaporan = $this->db->table('detail_transaksi');

        // Menjalankan query untuk semua riwayat transaksi dengan filter bulan
        $queryLaporan = $tbLaporan->select('
            transaksi.no_faktur AS faktur,
            produk.nama_produk AS namaProduk,
            detail_transaksi.jumlah AS jml,
            detail_transaksi.harga AS harga,
            detail_transaksi.subtotal AS totalharga,
            transaksi.tanggal AS tanggal,
            transaksi.diskon_persen AS diskon,
            transaksi.diskon_uang AS potongan,
            member.nama_member AS namaMember
        ')
        ->join('produk', 'produk.barcode = detail_transaksi.barcode')
        ->join('transaksi', 'transaksi.no_faktur = detail_transaksi.no_faktur')
        ->join('member', 'member.id_member = transaksi.id_member')
        ->orderBy('transaksi.tanggal', 'ASC');

        // Jika bulan diinputkan, tambahkan filter WHERE
        if ($bulan) {
            $queryLaporan->where('MONTH(transaksi.tanggal)', $bulan);
        }

        $queryLaporan = $queryLaporan->get();

        // Hitung total jumlah dan total harga
        $totals = $tbLaporan->select('
            SUM(detail_transaksi.jumlah) AS totalJumlah,
            SUM(detail_transaksi.subtotal) AS totalHarga
        ')
        ->join('transaksi', 'transaksi.no_faktur = detail_transaksi.no_faktur');

        if ($bulan) {
            $totals->where('MONTH(transaksi.tanggal)', $bulan);
        }

        $totals = $totals->get()->getRowArray();

        $data = [
            'title' => 'Laporan',
            'laporan' => $queryLaporan->getResultArray(),
            'bulan' => $bulan, // Kirimkan bulan terpilih ke view
            'totalJumlah' => $totals['totalJumlah'] ?? 0, // Total jumlah barang
            'totalHarga' => $totals['totalHarga'] ?? 0 // Total harga
        ];

        return view('laporan/laporan', $data);
    }
}
