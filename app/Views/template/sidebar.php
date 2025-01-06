 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link collapsed" href="<?= base_url('admin/dashboard'); ?>">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->

  <li class="nav-heading">Main Menu</li>


  <?php if (session()->get('level') === 'admin'): ?>
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#produk" data-bs-toggle="collapse" href="#">
      <i class="bi bi-box"></i><span>Produk</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="produk" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="<?= base_url('produk/data_produk/data_produk'); ?>">
          <i class="bi bi-circle"></i><span>Data Produk</span>
        </a>
      </li>
      <li>
        <a href="<?= base_url('produk/kategori'); ?>">
          <i class="bi bi-circle"></i><span>Kategori Produk</span>
        </a>
      </li>
    </ul>
  </li><!-- End Components Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="<?= base_url('member/data'); ?>">
      <i class="bi bi-people"></i>
      <span>Customers</span>
    </a>
   </li>
  <li class="nav-item">
    <a class="nav-link collapsed" href="<?= base_url('user/data'); ?>">
      <i class="bi bi-person"></i>
      <span>Users</span>
    </a>
   </li>
 <?php endif?>

 <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#transaksi" data-bs-toggle="collapse" href="#">
      <i class="bi bi-cart2"></i><span>Transaksi    </span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="transaksi" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
      <a href="<?= base_url('transaksi/input'); ?>">
      <i class="bi bi-circle"></i><span>Transaksi</span>
        </a>
      </li>
      <li>
        <a href="<?= base_url('transaksi/riwayat'); ?>">
          <i class="bi bi-circle"></i><span>Riwayat Transaksi</span>
        </a>
      </li>
    </ul>
  </li>


   <?php if (session()->get('level') === 'admin'): ?>
   <li class="nav-item">
    <a class="nav-link collapsed" href="<?= base_url('laporan'); ?>">
      <i class="bi bi-bar-chart"></i>
      <span>Laporan Penjualan</span>
    </a>
   </li>
   <?php endif?>
</ul>

</aside>
<!-- End Sidebar -->
