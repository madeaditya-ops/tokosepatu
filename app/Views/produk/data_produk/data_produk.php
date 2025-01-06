<?= $this->extend('template/main'); ?>
<?= $this->section('content'); ?>

<div class="card table-responsive">
    <div class="card-body">
        <h5 class="card-title">Data Produk</h5>
        <a href="<?= base_url('produk/data_produk/tambah'); ?>" class="btn btn-primary btn-md my-3"><i class="bi bi-plus"></i> Tambah Produk</a>
        <table class="table table-responsive table-bordered" id="datatable">
            <thead>
                <tr>
                    <th class="text-start" scope="col">No</th>
                    <th scope="col" class="text-start">Barcode</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Kategori</th>
                    <th class="text-start" scope="col">Size (EU)</th>
                    <th scope="col">Harga</th>
                    <th class="text-start" scope="col">Stok</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>    
            <tbody>
                <?php if (!empty($produk)): ?>
                    <?php $no = 1; foreach ($produk as $row): ?>
                        <tr>
                            <td class="text-start"><?= $no++; ?></td>
                            <td class="text-start"><?= esc($row['barcode']); ?></td>
                            <td><?= esc($row['nama_produk']); ?></td>                       
                            <td><?= esc($row['nama_kategori']); ?></td>
                            <td class="text-center"><?= esc($row['size']); ?></td>
                            <td><?='Rp  '.esc(number_format($row['harga'], 0, ',', '.')); ?></td>
                            <td class="text-center"><?= esc($row['stok']); ?></td>
                            <td>
                                <a href="<?= base_url('produk/data_produk/edit/' . $row['id_produk']); ?>" class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i></a>
                                <a href="<?= base_url('produk/data_produk/delete/' . $row['id_produk']); ?>" class="btn btn-danger btn-sm" id="tombol_hapus"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data kategori</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
        $(document).on('click', '#tombol_hapus', function(e) {
    e.preventDefault(); // Mencegah link langsung dieksekusi
    var getLink = $(this).attr('href');

    Swal.fire({
        title: "Hapus Produk?",
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
