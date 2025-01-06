<?php

namespace App\Controllers;


class Laporan extends BaseController
{
    public function index()
    {
        $tbLaporan = $this->db->table('detail_transaksi');

        // Menjalankan query untuk semua riwayat transaksi
        $queryLaporan = $tbLaporan->select('
            transaksi.no_faktur AS faktur,
            produk.nama_produk AS namaProduk,
            detail_transaksi.jumlah AS jml,
            detail_transaksi.harga AS harga,
            detail_transaksi.subtotal AS totalharga,
            transaksi.tanggal AS tanggal,
            transaksi.diskon_persen AS diskon,
            transaksi.diskon_uang AS potongan,
            member.nama_member AS namaMember,

        ')
        ->join('produk', 'produk.barcode = detail_transaksi.barcode')
        ->join('transaksi', 'transaksi.no_faktur = detail_transaksi.no_faktur')
        ->join('member', 'member.id_member = transaksi.id_member')
        ->get();

        // Mengembalikan hasil sebagai array

        $data = [
            'title' => 'Laporan',
            'laporan' => $queryLaporan->getResultArray()
        ];

        return view('laporan/laporan', $data);
    }
}