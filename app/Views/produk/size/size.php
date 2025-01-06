<?= $this->extend('template/main'); ?>
<?= $this->section('content'); ?>

<div class="card table-responsive">
    <div class="card-body">
        <h5 class="card-title">Size Produk</h5>
        <button class="btn btn-primary btn-md my-3 tombolTambah">
        <i class="bi bi-plus"></i> Tambah Size
        </button>

        <table class="table table-bordered" id="datatable">
            <thead>
                <tr>
                
                    <th scope="col" class="text-start">Size (EU)</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($size)): ?>
                    <?php 
                        foreach ($size as $row):
                     ?>
                        <tr>  
                            <td class="text-start"><?= esc($row['ukuran']); ?></td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" onclick="edit('<?= $row['id_size'] ?>')">
                                <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="hapus('<?= $row['id_size']?>')">
                                    <i class="bi bi-trash"></i>
                                </button>
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

<div class="viewmodal" style="display: none;"></div>

<script>
    function hapus(id) {
        Swal.fire({
            title: "Hapus Kategori?",
            text: "Yakin hapus kategori ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Hapus!",
            cancelButtonText: "Tidak!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('produk/size/hapus') ?>",
                    data: {
                        idsize: id
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {  
                            window.location.reload();
                        }
                    }
                });
            }
        });
    }



    function edit(id) {
    $.ajax({
        type: "post",
        url: "<?= site_url('produk/size/edit') ?>",
        data: {
            idsize: id
        },
        dataType: "json",
        success: function(response) {
            if (response.data) {
                $('.viewmodal').html(response.data).show();
                $('#modalformedit').on('shown.bs.modal', function(event) {
                    $('#size').focus();
                });
                $('#modalformedit').modal('show');
            }
        },
        error: function(xhr, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}

    $(document).ready(function () {
        $('.tombolTambah').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= site_url('produk/size/tambah') ?>",
                dataType: "json",
                success: function(response) {
                    if (response.data) {
                        $('.viewmodal').html(response.data).show();
                        $('#modaltambahkategori').on('shown.bs.modal', function() {
                            $('#namakategori').focus();
                        });
                        $('#modaltambahkategori').modal('show');
                    }
                },
                error: function(xhr, thrownError) {
                    console.error("AJAX Error:", xhr.status, xhr.responseText, thrownError);
                    Swal.fire("Error!", "Terjadi kesalahan pada server.", "error");
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>
