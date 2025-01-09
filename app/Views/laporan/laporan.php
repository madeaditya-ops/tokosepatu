<?= $this->extend('template/main'); ?>
<?= $this->section('content'); ?>

<div class="pagetitle">
      <h1><b>Laporan Penjualan</b></h1>
      <nav>
        <ol class="breadcrumb mt-1">
          <li class="breadcrumb-item"><a href="index.html"><i class="bi bi-house-door"></i></a></li>
          <li class="breadcrumb-item">Laporan Penjualan</li>
        </ol>
      </nav>
    </div>
            
         
<div class="card table-responsive">
 <div class="card-body pt-1">
    <div class="card-title d-flex justify-content-between">
        <a href="<?= base_url('cetakpdf?bulan=' . $bulan); ?>" class="btn btn-danger btn-sm">Cetak PDF</a>

        <form method="get" action="" class="row g-3 align-items-center">
        <div class="col-auto">
            <label for="bulan" class="form-label fw-bold">Pilih Bulan:</label>
        </div>
        <div class="col-auto">
            <select name="bulan" id="bulan" class="form-select">
                <option value="">-- Semua Bulan --</option>
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?= $i ?>" <?= ($bulan == $i) ? 'selected' : '' ?>>
                        <?= date('F', mktime(0, 0, 0, $i, 1)); ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    </div>

        <table class="table  table-responsive ">
            <thead>
                <tr class="table-secondary">
                    <th scope="col" class="text-start">No Faktur</th>
                    <th scope="col" >Tanggal</th>
                    <th scope="col" >Nama Pelanggan</th>
                    <th scope="col" >Nama Produk</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Diskon</th>
                    <th scope="col">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($laporan)): ?>
                    <?php foreach ($laporan as $row): ?>
                        <tr>
                            <td><?= esc($row['faktur']); ?></td>
                            <td><?= esc($row['tanggal']); ?></td>
                            <td><?= esc($row['namaMember']); ?></td>
                            <td><?= esc($row['namaProduk']); ?></td>
                            <td><?= esc($row['jml']); ?></td>
                            <td><?='Rp  '.esc(number_format($row['harga'], 0, ',', '.')); ?></td>
                            <td><?= esc($row['diskon']); ?></td>
                            <td><?='Rp  '.esc(number_format($row['totalharga'], 0, ',', '.')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="table-secondary">
                         <td colspan="4" class="text-center"><b>Total :</b></td>
                         <td><b><?=$totalJumlah; ?></b></td>
                         <td colspan="2"></td>
                         <td><b><?='Rp '.number_format($totalHarga, 0, ',', '.');  ?></b></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data untuk bulan ini</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).on('click', '#hapus', function(e) {
    e.preventDefault(); // Mencegah link langsung dieksekusi
    var getLink = $(this).attr('href');

    Swal.fire({
        title: "Hapus Transaksi?",
        text: "Data yang sudah dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya",
        cancelButtonText : "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = getLink; // Eksekusi penghapusan jika dikonfirmasi
        }
    }); 
});
</script>


<?= $this->endSection(); ?>
