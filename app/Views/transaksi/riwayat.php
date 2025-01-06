<?= $this->extend('template/main'); ?>
<?= $this->section('content'); ?>

<div class="pagetitle">
      <h1><b>Riwayat Transaksi</b></h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html"><i class="bi bi-house-door"></i></a></li>
          <li class="breadcrumb-item">Transaksi</li>
          <li class="breadcrumb-item active">Riwayat Transaksi</li>
        </ol>
      </nav>
</div>
            
         
<div class="card table-responsive">
    <div class="card-body pt-1">
        <table class="table table-bordered table-responsive table-striped" id="datatable">
            <thead>
                <tr>
                    <th scope="col" class="text-start">No Faktur</th>
                    <th scope="col" >Tanggal</th>
                    <th scope="col" >Nama Pelanggan</th>
                    <th scope="col" >Nama Produk</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Diskon</th>
                    <th scope="col">Total Harga</th>
                    <th scope="col">#</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($riwayat)): ?>
                    <?php foreach ($riwayat as $row): ?>
                        <tr>
                            <td><?= esc($row['faktur']); ?></td>
                            <td><?= esc($row['tanggal']); ?></td>
                            <td><?= esc($row['namaMember']); ?></td>
                            <td><?= esc($row['namaProduk']); ?></td>
                            <td><?= esc($row['jml']); ?></td>
                            <td><?='Rp  '.esc(number_format($row['harga'], 0, ',', '.')); ?></td>
                            <td><?= esc($row['diskon']); ?></td>
                            <td><?='Rp  '.esc(number_format($row['totalharga'], 0, ',', '.')); ?></td>
                            <td>
                                <a href="<?= base_url('transaksi/hpsRiwayat/' . $row['faktur']); ?>" class="btn btn-danger btn-sm" id="hapus"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data user</td>
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
