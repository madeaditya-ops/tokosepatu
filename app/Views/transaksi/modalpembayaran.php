<div class="modal fade" id="modalpembayaran" tabindex="-1" aria-labelledby="modalpembayaranLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalpembayaranLabel">Pembayaran</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= form_open('transaksi/simpanPembayaran', ['class'=> 'formpembayaran']); ?>
      <div class="modal-body">
        <input type="hidden" name="nofaktur" value="<?= $nofaktur?>">
        <input type="hidden" name="idmember" value="<?= $idmember?>">
        <input type="hidden" name="totalkotor" id="totalkotor" value="<?= $totalbayar?>">

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="">Disc(%)</label>
                    <input type="text" name="dispersen" id="dispersen" class="form-control">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">Disc(Rp)</label>
                    <input type="text" name="disuang" id="disuang" class="form-control">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="">Total Pembayaran</label>
            <input type="text" name="totalbersih" id="totalbersih" class="form-control form-control-lg" value="<?= $totalbayar;?>" style="font-weight: bold; text-align: right; color: blue; font-size: 24pt;" readonly>
        </div>
        <div class="form-group">
            <label for="">Jumlah Uang</label>
            <input type="text" name="jmluang" id="jmluang" class="form-control form-control-lg" style="font-weight: bold; text-align: right; color: red; font-size: 24pt;" autocomplete="off">
        </div>
        <div class="form-group">
            <label for="">Sisa Uang</label>
            <input type="text" name="sisauang" id="sisauang" class="form-control form-control-lg" style="font-weight: bold; text-align: right; color: blue; font-size: 24pt;" readonly>
        </div>
      </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-primary tombolSimpan">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
     <?= form_close()?>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.6.0/autoNumeric.min.js"></script>
<script>
    
$(document).ready(function () {

    let anDispersen, anDisuang, anTotalBersih, anJumlahUang, anSisaUang;

    $('#modalpembayaran').on('shown.bs.modal', function () {
    anDispersen = new AutoNumeric('#dispersen', { digitGroupSeparator: '.', decimalCharacter: ',', decimalPlaces: 0 });
    anDisuang = new AutoNumeric('#disuang', { digitGroupSeparator: '.', decimalCharacter: ',', decimalPlaces: 0 });
    anTotalBersih = new AutoNumeric('#totalbersih', { digitGroupSeparator: '.', decimalCharacter: ',', decimalPlaces: 0, readOnly: true });
    anJumlahUang = new AutoNumeric('#jmluang', { digitGroupSeparator: '.', decimalCharacter: ',', decimalPlaces: 0 });
    anSisaUang = new AutoNumeric('#sisauang', { digitGroupSeparator: '.', decimalCharacter: ',', decimalPlaces: 0, readOnly: true });
});

    function hitungDiskon() {
        let totalkotor = parseFloat($('#totalkotor').val()) || 0;
        let dispersen = anDispersen.getNumber() || 0;
        let disuang = anDisuang.getNumber() || 0;

        let hasil = totalkotor - (totalkotor * dispersen / 100) - disuang;
        anTotalBersih.set(hasil);
    }

    function hitungSisaUang() {
        let totalbersih = anTotalBersih.getNumber() || 0;
        let jumlahuang = anJumlahUang.getNumber() || 0;

        let sisauang = jumlahuang - totalbersih;
        anSisaUang.set(sisauang);
    }

    $('#dispersen, #disuang').keyup(hitungDiskon);
    $('#jmluang').keyup(hitungSisaUang);
    $('.formpembayaran').submit(function (e) {
    e.preventDefault();

    let jmluang = anJumlahUang.getNumber();
    let totalbersih = anTotalBersih.getNumber();

    if (jmluang === 0 || jmluang === "") {
        alert('Jumlah uang tidak boleh kosong!');
    } else if (jmluang < totalbersih) {
        alert('Jumlah uang tidak mencukupi!');
    } else {
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            success: function (response) {
                if (response.sukses == 'berhasil') {
                    Swal.fire({
                        title: "Cetak Struk?",
                        text: "Mau cetak struk?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Cetak!",
                        cancelButtonText: "Tidak",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "post",
                                url: "<?= site_url('transaksi/cetakstruk') ?>",
                                data: {
                                    nofaktur: response.nofaktur
                                },
                                success: function (cetakResponse) {
                                    alert('Struk berhasil dicetak: ');
                                    window.location.reload();
                                },
                                error: function (xhr, thrownError) {
                                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                                }
                            });
                        } else {
                            window.location.reload();
                        }
                    });
                }
            },
            error: function (xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
});

});

</script>