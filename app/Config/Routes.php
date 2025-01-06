<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// login
$routes->get('/', 'Login::index');
$routes->post('login', 'Login::login_action');
$routes->get('logout', 'Login::logout');

// admin
$routes->get('admin/dashboard', 'Admin::index', ['filter' => 'adminFilter']);

// routes kategori
$routes->get('produk/kategori', 'Kategori::index',['filter' => 'adminFilter']);
$routes->get('produk/tambah_kategori', 'Kategori::tambah',['filter' => 'adminFilter']);
$routes->post('produk/simpan_kategori', 'Kategori::simpan',['filter' => 'adminFilter']);
$routes->get('kategori/edit/(:num)', 'Kategori::edit/$1',['filter' => 'adminFilter']);
$routes->post('kategori/update/(:num)', 'Kategori::update/$1',['filter' => 'adminFilter']);
$routes->get('kategori/delete/(:num)', 'Kategori::delete/$1',['filter' => 'adminFilter']);

// produk
$routes->get('produk/data_produk/data_produk', 'Produk::index',['filter' => 'adminFilter']);
$routes->get('produk/data_produk/tambah', 'Produk::tambah',['filter' => 'adminFilter']);
$routes->post('produk/data_produk/simpan', 'Produk::simpan',['filter' => 'adminFilter']);
$routes->get('produk/data_produk/edit/(:num)', 'Produk::edit/$1',['filter' => 'adminFilter']);
$routes->post('produk/data_produk/update/(:num)', 'Produk::update/$1',['filter' => 'adminFilter']);
$routes->get('produk/data_produk/delete/(:num)', 'Produk::delete/$1',['filter' => 'adminFilter']);

// size
// $routes->get('produk/size', 'Size::index',['filter' => 'adminFilter']);
// $routes->get('produk/size/tambah', 'Size::tambah',['filter' => 'adminFilter']);
// $routes->post('produk/size/simpandata', 'Size::simpandata',['filter' => 'adminFilter']);
// $routes->post('produk/size/hapus', 'Size::hapus',['filter' => 'adminFilter']);
// $routes->post('produk/size/edit', 'Size::edit',['filter' => 'adminFilter']);
// $routes->post('produk/size/updatedata', 'Size::updatedata',['filter' => 'adminFilter']);

// transaksi
$routes->get('transaksi/input', 'Transaksi::index',['filter' => 'adminFilter']);
$routes->post('transaksi/buatFaktur', 'Transaksi::buatFaktur',['filter' => 'adminFilter']);
$routes->post('transaksi/dataDetail', 'Transaksi::dataDetail',['filter' => 'adminFilter']);
$routes->post('transaksi/listDataProduk', 'Transaksi::listDataProduk',['filter' => 'adminFilter']);
$routes->get('transaksi/viewDataProduk', 'Transaksi::viewDataProduk',['filter' => 'adminFilter']);
$routes->post('transaksi/simpanTemp', 'Transaksi::simpanTemp',['filter' => 'adminFilter']);
$routes->post('transaksi/viewDataProduk', 'Transaksi::viewDataProduk',['filter' => 'adminFilter']);
$routes->post('transaksi/hitungTotalBayar', 'Transaksi::hitungTotalBayar',['filter' => 'adminFilter']);
$routes->post('transaksi/hapusItem', 'Transaksi::hapusItem',['filter' => 'adminFilter']);
$routes->post('transaksi/batalTransaksi', 'Transaksi::batalTransaksi',['filter' => 'adminFilter']);
$routes->post('transaksi/pembayaran', 'Transaksi::pembayaran',['filter' => 'adminFilter']);
$routes->post('transaksi/simpanPembayaran', 'Transaksi::simpanPembayaran',['filter' => 'adminFilter']);
$routes->get('transaksi/viewDataMember', 'Transaksi::viewDataMember',['filter' => 'adminFilter']);
$routes->post('transaksi/listDataMember', 'Transaksi::listDataMember',['filter' => 'adminFilter']);

$routes->get('transaksi/riwayat', 'Transaksi::riwayatTransaksi',['filter' => 'adminFilter']);
$routes->get('transaksi/hpsRiwayat/(:any)', 'Transaksi::hapusRiwayat/$1',['filter' => 'adminFilter']);


// member
$routes->get('member/data', 'Member::index',['filter' => 'adminFilter']);
$routes->get('member/tambah', 'Member::tambah',['filter' => 'adminFilter']);
$routes->post('member/simpan', 'Member::simpan',['filter' => 'adminFilter']);
$routes->get('member/hapus/(:num)', 'Member::hapus/$1',['filter' => 'adminFilter']);
$routes->get('member/edit/(:num)', 'Member::edit/$1',['filter' => 'adminFilter']);
$routes->post('member/update/(:num)', 'Member::update/$1',['filter' => 'adminFilter']);


$routes->get('user/data', 'User::index',['filter' => 'adminFilter']);
$routes->get('user/tambah', 'User::tambah',['filter' => 'adminFilter']);
$routes->post('user/simpan', 'User::simpan',['filter' => 'adminFilter']);
$routes->get('user/hapus/(:num)', 'User::hapus/$1',['filter' => 'adminFilter']);
$routes->get('user/edit/(:num)', 'User::edit/$1',['filter' => 'adminFilter']);
$routes->post('user/update/(:num)', 'User::update/$1',['filter' => 'adminFilter']);


$routes->get('laporan', 'Laporan::index',['filter' => 'adminFilter']);

// kasir
$routes->get('kasir/dashboard', 'Kasir::index', ['filter' => 'kasirFilter']);





