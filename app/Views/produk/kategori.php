<?= $this->extend('template/main'); ?>
<?= $this->section('content'); ?>

<div class="pagetitle">
      <h1><b>Kategori Produk</b></h1>
      <nav>
        <ol class="breadcrumb mt-1">
          <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard')?>"><i class="bi bi-house-door"></i></a></li>
          <li class="breadcrumb-item">Produk</li>
          <li class="breadcrumb-item active">Kategori Peoduk</li>
        </ol>
      </nav>
    </div>

<div class="card table-responsive">
    <div class="card-body">
        <a href="<?= base_url('produk/tambah_kategori'); ?>" class="btn btn-primary btn-md my-3"><i class="bi bi-plus"></i> Tambah Kategori</a>
        <table class="table table-bordered" id="datatable">
            <thead>
                <tr>
                    <th scope="col" class="text-start">No</th>
                    <th scope="col" class="w-75">Nama Kategori</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($kategori)): ?>
                    <?php $no = 1; foreach ($kategori as $row): ?>
                        <tr>
                            <td class="text-start"><?= $no++; ?></td>
                            <td><?= esc($row['nama_kategori']); ?></td>
                            <td>
                                <a href="<?= base_url('kategori/edit/' . $row['id_kategori']); ?>" class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i></a>
                                <a href="<?= base_url('kategori/delete/' . $row['id_kategori']); ?>" class="btn btn-danger btn-sm" id="hapus"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data kategori</td>
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
        title: "Hapus Kategori?",
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
