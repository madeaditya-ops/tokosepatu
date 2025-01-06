<!-- Modal -->
<div class="modal fade" id="modaltambahkategori" tabindex="-1" aria-labelledby="modaltambahkategoriLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modaltambahkategoriLabel">Tambah Size Chart</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('produk/size/simpandata', ['class'=> 'formsimpan']) ?>
      <div class="modal-body">
         <div class="form-group">
            <label for="" class="mb-3">Size</label>
            <input type="text" name="size" id="size" class="form-control">
         </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary tombolSimpan">Simpan</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
      <?= form_close();?>
    </div>
  </div>
</div>

<script>
    $(document).ready(function () {
        $('.formsimpan').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if(response.sukses){
                        Swal.fire(
                        "Berhasil",
                        response.sukses,
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload(); 
                        }
                    });
                    }
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        }); 
    });
</script>