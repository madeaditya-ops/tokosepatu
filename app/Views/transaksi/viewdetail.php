<table class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th class="text-start" scope="col">No</th>
            <th scope="col" class="text-start">Barcode</th>
            <th scope="col">Nama Produk</th>
            <th scope="col">Jumlah</th>
            <th class="text-start" scope="col">Harga</th>
            <th scope="col">Subtotal</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>    
    <tbody>
        <?php if (!empty($datadetail)): ?>
            <?php $no = 1; foreach ($datadetail->getResultArray() as $r): ?>
                <tr>
                    <td class="text-start"><?= $no++; ?></td>
                    <td class="text-start"><?= esc($r['kode']); ?></td>
                    <td><?= esc($r['nama_produk']); ?></td>                       
                    <td><?= esc($r['qty']); ?></td>
                    <td><?='Rp  '.esc(number_format($r['harga'], 0, ',', '.')); ?></td>
                    <td><?='Rp  '.esc(number_format($r['subtotal'], 0, ',', '.')); ?></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger" onclick="hapusitem('<?= $r['id']?>','<?= $r['nama_produk']?>')">
                            <i class="bi bi-trash"></i>
                        </button>
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

<script>
    function hapusitem(id, nama) {
        Swal.fire({
        title: "Hapus Item?",
        text: "Yakin ingin menghapus item "+ nama +"!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batal"
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "<?= site_url('transaksi/hapusItem') ?>",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                if (response.sukses == 'berhasil') {
                    dataDetailPenjualan();
                    hitungTotalBayar();
                    kososng();
                }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        }
        });
    }
</script>