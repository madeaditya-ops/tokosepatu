<link href="<?= base_url('assets')?>/vendor/simple-datatables/style.css" rel="stylesheet">
<script src="<?= base_url('assets')?>/vendor/simple-datatables/simple-datatables.js"></script>
<!-- Modal -->
<div class="modal fade" id="modalproduk" tabindex="-1" aria-labelledby="modalprodukLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalprodukLabel">Data Produk</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <input type="hidden" name="keywordkode" id="keywordkode" value="<?= $keyword;?>">
      <table id="dataproduk" class="table table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Barcode</th>
              <th>Nama Produk</th>
              <th>Kategori</th>
              <th>Size(EU)</th>
              <th>Stok</th>
              <th>Harga</th>
              <th></th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

$(document).ready(function() {
  var table = $('#dataproduk').DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax": {
        "url": "<?php echo site_url('transaksi/listDataProduk') ?>",
        "type": "POST",
        "data": {
            keywordkode: $('#keywordkode').val()
        }
    },
    "columnDefs": [{
        "targets": [0],
        "orderable": false,
    }, ],
  });
});

function pilihitem(kode, nama){
      $('#kodebarcode').val(kode);
      $('#namaproduk').val(nama);
      $('#modalproduk').on('hidden.bs.modal', function(event) {
          $('#kodebarcode').focus();
      });

      $('#modalproduk').modal('hide');
  }

</script>