<?= $this->extend('template/main'); ?>
<?= $this->section('content'); ?>

<div class="card table-responsive">
    <div class="card-body">
        <h5 class="card-title">Member</h5>
        <a href="<?= base_url('member/tambah'); ?>" class="btn btn-primary btn-md my-3"><i class="bi bi-plus"></i> Tambah Member</a>
        <table class="table table-bordered" id="datatable">
            <thead>
                <tr>
                    <th scope="col" class="text-start">No</th>
                    <th scope="col" class="text-start">Kode</th>
                    <th scope="col" >Nama</th>
                    <th scope="col" class="text-start">No Telepon</th>
                    <th scope="col" >Alamat</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($member)): ?>
                    <?php $no = 1; foreach ($member as $row): ?>
                        <tr>
                            <td class="text-start"><?= $no++; ?></td>
                            <td><?= esc($row['kode_member']); ?></td>
                            <td><?= esc($row['nama_member']); ?></td>
                            <td class="text-start"><?= esc($row['telp']); ?></td>
                            <td><?= esc($row['alamat']); ?></td>
                            <td>
                                <a href="<?= base_url('member/edit/' . $row['id_member']); ?>" class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i></a>
                                <a href="<?= base_url('member/hapus/' . $row['id_member']); ?>" class="btn btn-danger btn-sm" id="hapus"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data member</td>
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
        title: "Hapus Member?",
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
