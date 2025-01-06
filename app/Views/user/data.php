<?= $this->extend('template/main'); ?>
<?= $this->section('content'); ?>

<div class="card table-responsive">
    <div class="card-body">
        <h5 class="card-title">User</h5>
        <a href="<?= base_url('user/tambah'); ?>" class="btn btn-primary btn-md my-3"><i class="bi bi-plus"></i> Tambah User</a>
        <table class="table table-bordered" id="datatable">
            <thead>
                <tr>
                    <th scope="col" class="text-start">No</th>
                    <th scope="col" >Nama</th>
                    <th scope="col" class="text-start">No Telepon</th>
                    <th scope="col" >Alamat</th>
                    <th scope="col" >Role</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($user)): ?>
                    <?php $no = 1; foreach ($user as $row): ?>
                        <tr>
                            <td class="text-start"><?= $no++; ?></td>
                            <td><?= esc($row['nama_lengkap']); ?></td>
                            <td class="text-start"><?= esc($row['telp']); ?></td>
                            <td><?= esc($row['alamat']); ?></td>
                            <td style="text-transform: capitalize;"><?= esc($row['level']); ?></td>
                            <td>
                                <a href="<?= base_url('user/edit/' . $row['id_user']); ?>" class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i></a>
                                <a href="<?= base_url('user/hapus/' . $row['id_user']); ?>" class="btn btn-danger btn-sm" id="hapus"><i class="bi bi-trash"></i></a>
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
        title: "Hapus User?",
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

$(function() {
      <?php if(session()->has('error')) {?>
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "<?= session()->get('error')?>"
      });
      <?php }?>
    });
</script>


<?= $this->endSection(); ?>
