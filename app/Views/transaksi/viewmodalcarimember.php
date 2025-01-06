<!-- Modal -->
<div class="modal fade" id="modalmember" tabindex="-1" aria-labelledby="modalmemberLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalmemberLabel">Data Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="datamember" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Pelanggan</th>
                            <th>No Telepon</th>
                            <th>Alamat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#modalmember').on('shown.bs.modal', function () {
        $('#datamember').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= site_url('transaksi/listDataMember') ?>",
                type: "POST",
                error: function(xhr, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
            },
            columns: [
                { data: 0, orderable: false },
                { data: 1 },
                { data: 2 },
                { data: 3 },
                { data: 4 },
                { data: 5, orderable: false }
            ]
        });
    });
});

function pilihitem(id, nama) {
    $('#id_member').val(id);
    $('#nama_member').val(nama);
    $('#modalmember').modal('hide');
}
</script>
