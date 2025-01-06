<?php 
namespace App\Controllers;

use Dompdf\Dompdf;

class PdfController extends BaseController
{
    public function cetak()
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

    
        // Render tampilan HTML sebagai PDF
        $dompdf = new Dompdf();
        $html = view('pdf_template', $data); // View CI4 sebagai template PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Kirim file PDF ke browser
        $dompdf->stream('laporan-transaksi.pdf', ['Attachment' => false]);
    }
}
