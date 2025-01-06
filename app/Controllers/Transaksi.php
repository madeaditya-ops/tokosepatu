<?php

namespace App\Controllers;

use App\Models\DetailTransaksiModel;
use App\Models\ProdukModel;
use App\Models\TransaksiModel;
use PHPUnit\Util\Json;
use App\Models\Modeldataproduk;
use App\Models\Modeldatamember;
use Config\Services;
use Escpos\PrintConnectors\WindowsPrintConnectors;
use Escpos\CapabilityProfile;
use Escpos\Printer;


class Transaksi extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home',
            'nofaktur' => $this->buatFaktur()
        ];
        return view('transaksi/input', $data);
    }

    public function buatFaktur()
    {
        $tgl = date('Y-m-d');
        $query = $this->db->query("SELECT MAX(no_faktur) AS nofaktur FROM transaksi WHERE DATE_FORMAT(tanggal, '%Y-%m-%d') = '$tgl'");
        $hasil = $query->getRowArray();
        $data = $hasil['nofaktur'];

        $lastNoUrut = substr($data, -4);

        // nomor urut ditambah 1
        $nextNoUrut = intval($lastNoUrut) + 1;

        // membuat format nomor transaksi berikutnya
        $fakturPenjualan = 'T' . date('dmy', strtotime($tgl)) . sprintf('%04s', $nextNoUrut);
        
        return $fakturPenjualan;
    }

    public function dataDetail() {
        $nofaktur = $this->request->getPost('nofaktur');

        $tempPenjualan = $this->db->table('temp_transaksi');
        $queryTampil = $tempPenjualan->select('id_temp as id, temp_barcode as kode, nama_produk, temp_harga as harga , temp_jumlah as qty, temp_subtotal as subtotal')->join('produk', 'temp_barcode=barcode')->where('no_faktur',
        $nofaktur)->orderBy('id_temp', 'asc');

        $data = [
            'datadetail' => $queryTampil->get()
        ];

        $msg = [
             'data' => view('transaksi/viewdetail', $data)
        ];

        echo json_encode($msg);
    }

    public function viewDataProduk() 
    {
        if ($this->request->isAJAX()) {
            $keyword = $this->request->getPost('keyword');
            $data = [
                'keyword' => $keyword
            ];
            $msg = [
                'viewmodal' => view('transaksi/viewmodalcariproduk', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function listDataProduk()
    {
        if ($this->request->isAJAX()) {
            $keywordkode = $this->request->getPost('keywordkode');
            $request = Services::request();
            $modelproduk = new Modeldataproduk($request);
            if ($request->getMethod(true) == 'POST') {
                $lists = $modelproduk->get_datatables($keywordkode);
                $data = [];
                $no = $request->getPost("start");
                foreach ($lists as $list) {
                    $no++;
                    $row = [];
                    $row[] = $no;
                    $row[] = $list->barcode;
                    $row[] = $list->nama_produk;
                    $row[] = $list->nama_kategori;
                    $row[] = $list->size;
                    $row[] = number_format($list->stok, 0,",",".");
                    $row[] = number_format($list->harga, 0,",",".");
                    $row[] = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"pilihitem('".$list->barcode."', '".$list->nama_produk."')\" >Pilih</button>";
                    $data[] = $row;
                }
                $output = [
                    "draw" => $request->getPost('draw'),
                    "recordsTotal" => $modelproduk->count_all($keywordkode),
                    "recordsFiltered" => $modelproduk->count_filtered($keywordkode),
                    "data" => $data
                ];
            echo json_encode($output);
            }
        }
    }

    public function simpanTemp() 
    {
        if ($this->request->isAJAX()) {
            $kodebarcode = $this->request->getPost('kodebarcode');
            $namaproduk = $this->request->getPost('namaproduk');
            $jumlah = $this->request->getPost('jumlah');
            $nofaktur = $this->request->getPost('nofaktur');

            if(strlen($namaproduk) > 0){
                $queryCekProduk = $this->db->table('produk')->where('barcode', $kodebarcode)->where('nama_produk', $namaproduk)->get();
            }else{
                $queryCekProduk = $this->db->table('produk')->like('barcode', $kodebarcode)->orlike('nama_produk', $kodebarcode)->get();
            }

            $totalData = $queryCekProduk->getNumRows();

            if ($totalData > 1) {
                $msg = [
                    'totaldata'=> 'banyak',
                ];
            }else{
                // insert ke temp transaksi
                $tblTempTransaksi = $this->db->table('temp_transaksi');
                $rowProduk = $queryCekProduk->getRowArray();

                $stokProduk = $rowProduk['stok'];

                if (intval($stokProduk) == 0){
                    $msg = [
                        'error' => 'maaf stok habis'
                    ];
                } else if($jumlah > intval($stokProduk)){
                    $msg = [
                        'error' => 'maaf stok tidak mencukupi'
                    ];
                }else {
                    $insertData = [
                        'no_faktur' => $nofaktur,
                        'temp_barcode' => $rowProduk['barcode'],
                        'temp_harga' => $rowProduk['harga'],
                        'temp_jumlah' => $jumlah,
                        'temp_subtotal' => intval($rowProduk['harga']) * $jumlah
                    ];
                    $tblTempTransaksi->insert($insertData);
    
                    $msg = ['sukses' => 'berhasil'];
                }    
            }
            echo json_encode($msg);
        }
    }

    public function hitungTotalBayar() 
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
        
            $tblTempTransaksi = $this->db->table('temp_transaksi');

            $queryTotal = $tblTempTransaksi->select ('SUM(temp_subtotal) as totalbayar')->where('no_faktur', $nofaktur)->get();
            $rowTotal = $queryTotal->getRowArray();

            $msg = [
                'totalbayar' => number_format($rowTotal['totalbayar'], 0, ",", ".")
            ];
            echo json_encode($msg);
        }
    }

    public function hapusItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost("id");
            $tblTempTranksaksi = $this->db->table("temp_transaksi");
            $queryhapus = $tblTempTranksaksi->delete(['id_temp' => $id]);

            if($queryhapus) {
                $msg = [
                    'sukses' => 'berhasil'
                ];
                echo json_encode($msg);
            }
        }

    }

    public function batalTransaksi() 
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');

            $tblTempTranksaksi = $this->db->table('temp_transaksi');
            $hapusData = $tblTempTranksaksi->emptyTable();

            if($hapusData) {
                $msg = [
                    'sukses' => 'berhasil'
                ];
            }
            echo json_encode($msg);
        }
    }

    public function pembayaran() 
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $tglfaktur = $this->request->getPost('tglfaktur');
            $idmember = $this->request->getPost('id_member');

            $tblTempTransaksi = $this->db->table('temp_transaksi');
            $cekDataTransaksi = $tblTempTransaksi->getWhere(['no_faktur' => $nofaktur]);

            $queryTotal = $tblTempTransaksi->select ('SUM(temp_subtotal) as totalbayar')->where('no_faktur', $nofaktur)->get();
            $rowTotal = $queryTotal->getRowArray();

            if($cekDataTransaksi->getNumRows() > 0) {
                $data = [
                    'nofaktur' => $nofaktur,
                    'idmember' => $idmember,
                    'totalbayar' => $rowTotal['totalbayar']
                ];

                $msg =[
                    'data' => view('transaksi/modalpembayaran', $data)
                ];
            }else{
                $msg = [
                    'error' => 'Maaf belum ada item yang dipilih'
                ];
            }
            echo json_encode($msg);
        }   
    }

    public function simpanPembayaran() 
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $idmember = $this->request->getPost('idmember');
            $totalkotor = $this->request->getPost('totalkotor');
            $totalbersih = str_replace( [",","."], "",$this->request->getPost('totalbersih'));
            $dispersen = str_replace( [",","."], "",$this->request->getPost('dispersen'));
            $disuang = str_replace( [",","."], "",$this->request->getPost('disuang'));
            $jmluang = str_replace( [",","."], "",$this->request->getPost('jmluang'));
            $sisauang = str_replace( [",","."] , "",$this->request->getPost('sisauang'));

            $tblTransaksi = $this->db->table('transaksi');
            $tblTempTransaksi = $this->db->table('temp_transaksi');
            $tblDetailTransaksi = $this->db->table('detail_transaksi');

            $insertDataTransaksi = [
                'id_member' => $idmember,
                'no_faktur' => $nofaktur,
                'tanggal' => date(' Y-m-d H:i:s'),
                'diskon_persen' => $dispersen,
                'diskon_uang' => $disuang,
                'total_kotor' => $totalkotor,
                'total_bersih' => $totalbersih,
                'jumlah_uang' => $jmluang,
                'sisa_uang' => $sisauang,
            ];

            $tblTransaksi->insert($insertDataTransaksi);

            $ambilDataTemp = $tblTempTransaksi->getWhere(['no_faktur'=> $nofaktur]);

            $fieldDetailTransaksi = [];
            foreach ($ambilDataTemp->getResultArray() as $row) {
                $fieldDetailTransaksi[] = [
                    'no_faktur' => $row['no_faktur'],
                    'barcode' => $row['temp_barcode'],
                    'harga' => $row['temp_harga'],
                    'jumlah' => $row['temp_jumlah'],
                    'subtotal' => $row['temp_subtotal']
                ];
            }
            $tblDetailTransaksi->insertBatch($fieldDetailTransaksi);

            $tblTempTransaksi->emptyTable();       

            $msg = [
                'sukses' => 'berhasil',
            ];

            echo json_encode($msg);
         }
    }

    public function cetakStruk()
    {
        function buatBaris1Kolom($kolom1)
        {
            // Mengatur lebar setiap kolom (dalam satuan karakter)
            $lebar_kolom_1 = 33;

            // Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
            $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);

            // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
            $kolom1Array = explode("\n", $kolom1);

            // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
            $jmlBarisTerbanyak = count($kolom1Array);

            // Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
            $hasilBaris = array();

            // Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
            for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

                // memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
                $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");

                // Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
                $hasilBaris[] = $hasilKolom1;
            }

            // Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
            return implode($hasilBaris, "\n") . "\n";
        }

        function buatBaris3Kolom($kolom1, $kolom2, $kolom3)
        {
            // Mengatur lebar setiap kolom (dalam satuan karakter)
            $lebar_kolom_1 = 11;
            $lebar_kolom_2 = 11;
            $lebar_kolom_3 = 11;

            // Melakukan wordwrap(), jadi jika karakter teks melebihi lebar kolom, ditambahkan \n 
            $kolom1 = wordwrap($kolom1, $lebar_kolom_1, "\n", true);
            $kolom2 = wordwrap($kolom2, $lebar_kolom_2, "\n", true);
            $kolom3 = wordwrap($kolom3, $lebar_kolom_3, "\n", true);

            // Merubah hasil wordwrap menjadi array, kolom yang memiliki 2 index array berarti memiliki 2 baris (kena wordwrap)
            $kolom1Array = explode("\n", $kolom1);
            $kolom2Array = explode("\n", $kolom2);
            $kolom3Array = explode("\n", $kolom3);

            // Mengambil jumlah baris terbanyak dari kolom-kolom untuk dijadikan titik akhir perulangan
            $jmlBarisTerbanyak = max(count($kolom1Array), count($kolom2Array), count($kolom3Array));

            // Mendeklarasikan variabel untuk menampung kolom yang sudah di edit
            $hasilBaris = array();

            // Melakukan perulangan setiap baris (yang dibentuk wordwrap), untuk menggabungkan setiap kolom menjadi 1 baris 
            for ($i = 0; $i < $jmlBarisTerbanyak; $i++) {

                // memberikan spasi di setiap cell berdasarkan lebar kolom yang ditentukan, 
                $hasilKolom1 = str_pad((isset($kolom1Array[$i]) ? $kolom1Array[$i] : ""), $lebar_kolom_1, " ");
                // memberikan rata kanan pada kolom 3 dan 4 karena akan kita gunakan untuk harga dan total harga
                $hasilKolom2 = str_pad((isset($kolom2Array[$i]) ? $kolom2Array[$i] : ""), $lebar_kolom_2, " ", STR_PAD_LEFT);

                $hasilKolom3 = str_pad((isset($kolom3Array[$i]) ? $kolom3Array[$i] : ""), $lebar_kolom_3, " ", STR_PAD_LEFT);

                // Menggabungkan kolom tersebut menjadi 1 baris dan ditampung ke variabel hasil (ada 1 spasi disetiap kolom)
                $hasilBaris[] = $hasilKolom1 . " " . $hasilKolom2 . " " . $hasilKolom3;
            }

            // Hasil yang berupa array, disatukan kembali menjadi string dan tambahkan \n disetiap barisnya.
            return implode($hasilBaris, "\n") . "\n";
        }


        $profile = CapabilityProfile::load("simple");
        $connector = new WindowsPrintConnector("printer_made");
        $printer = new Printer($connector, $profile);

        $nofaktur = $this->request->getPost("nofaktur");
        $tblTransaksi = $this->db->table('transaksi');
        $tblDetailTransaksi = $this->db->table('detail_transaksi');

        $queryTransaksi = $tblTransaksi->getWhere(['no_faktur' => $nofaktur]);
        $rowTransaksi = $queryTransaksi->getRowArray();

        $printer->initialize();
        $printer->selectPrintMode(Printer::MODE_FONT_A);    
        $printer->text(buatBaris1Kolom("Made Shoes"));
        $printer->text(buatBaris1Kolom("Klungkung, Telp 087861134692"));
        $printer->text(buatBaris1Kolom("Faktur : $nofaktur"));
        $printer->text(buatBaris1Kolom("Tanggal : $rowTransaksi[tanggal]"));

        $printer->text("---------------------------------");

        $queryDetailTransaksi = $tblDetailTransaksi->select('nama_produk, detail_transaksi.jumlah AS jml, detail_transaksi.harga AS harga, subtotal, diskon_persen AS diskon, diskon_uang AS potongan, total_bersih AS totalbersih, total_kotor AS totalkotor, jumlah_uang AS bayar, sisa_uang AS sisa')
                                                   ->join('produk','produk.barcode','=','detail_transaksi.barcode')
                                                   ->join('transaksi','transaksi.no_faktur','=','detail_transaksi.no_faktur')
                                                   ->where('no_faktur', $nofaktur)
                                                   ->get();

        foreach($queryDetailTransaksi->getResultArray() as $d){
            $printer->text(buatBaris1Kolom("$d[nama_produk]"));
            $printer->text(buatBaris3Kolom(number_format($d['jml'],0).' x' , number_format($d['harga'],0), number_format($d['subtotal'],0)));


        }

        $printer->text("---------------------------------");
        $printer->text(buatBaris3Kolom("Total :", "", number_format($d['totalkotor'],0)));
        $printer->text(buatBaris3Kolom( "Diskon :", "", number_format($d['diskon'],0)));
        $printer->text("---------------------------------");
        $printer->text(buatBaris3Kolom( "Sub Total :", "", number_format($d['totalbersih'],0)));
        $printer->text(buatBaris3Kolom( "Bayar :", "", number_format($d['bayar'],0)));
        $printer->text(buatBaris3Kolom( "Kembali :", "", number_format($d['sisa'],0)));
        $printer->text("\n");
        $printer->text(buatBaris1Kolom("Terima kasih telah berkunjung"));


        $printer->feed(4);   
        $printer->cut();   
        $printer->close();   
    }

    public function viewDataMember()
    {
        // Fungsi ini digunakan untuk menampilkan modal
        if ($this->request->isAJAX()) {
            $msg = [
                'viewmodal' => view('transaksi/viewmodalcarimember') // Gantilah dengan path view yang sesuai
            ];
            echo json_encode($msg);
        }
    }

    public function listDataMember()
    {
        if ($this->request->isAJAX()) {
            $request = Services::request();
            $modelmember = new Modeldatamember($request);
            if ($request->getMethod(true) == 'POST') {
                $lists = $modelmember->get_datatables();
                $data = [];
                $no = $request->getPost("start");
                foreach ($lists as $list) {
                    $no++;
                    $row = [];
                    $row[] = $no;
                    $row[] = $list->kode_member;
                    $row[] = $list->nama_member;
                    $row[] = $list->telp;
                    $row[] = $list->alamat;
                    $row[] = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"pilihitem('".$list->id_member."', '".$list->nama_member."')\" >Pilih</button>";
                    $data[] = $row;
                }
                $output = [
                    "draw" => $request->getPost('draw'),
                    "recordsTotal" => $modelmember->count_all(),
                    "recordsFiltered" => $modelmember->count_filtered(),
                    "data" => $data
                ];
            echo json_encode($output);
            }
        }
    }


    public function riwayatTransaksi()
    {
        // Mengambil tabel detail_transaksi
        $tblDetailTransaksi = $this->db->table('detail_transaksi');

        // Menjalankan query untuk semua riwayat transaksi
        $queryRiwayat = $tblDetailTransaksi->select('
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
            'title' => 'Transaksi',
            'riwayat' => $queryRiwayat->getResultArray()
        ];

        return view('transaksi/riwayat', $data);
    }

public function hapusRiwayat($faktur)
{

    $this->db->table('detail_transaksi')->delete(['no_faktur' => $faktur]);
    $this->db->table('transaksi')->delete(['no_faktur' => $faktur]);

    return redirect()->to('transaksi/riwayat');

}
    
    
}