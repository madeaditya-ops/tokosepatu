<?= $this->extend('template/main'); ?>
<?= $this->section('content'); ?>

<div class="card card-default color-palette-box">
    <div class="card-header">
        <h3 class="card-title">
           Transaksi
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="nofaktur">Faktur</label>
                    <input type="text" class="form-control form-control-sm" style="color:red;font-weight:bold;"
                        name="nofaktur" id="nofaktur" readonly value="<?= $nofaktur?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control form-control-sm" name="tanggal" id="tanggal" readonly
                        value="<?= date('Y-m-d'); ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="nama_member">Pelanggan</label>
                    <div class="input-group mb-3">
                        <input type="text" value="-" class="form-control form-control-sm" name="nama_member" id="nama_member"
                        readonly>
                        <input type="hidden" name="id_member" id="id_member" value="1">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-primary" type="button" id="searchMember">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="tanggal">Aksi</label>
                    <div class="input-group">
                        <button class="btn btn-danger btn-sm" type="button" id="btnHapusTransaksi">
                            <i class="bi bi-trash"></i>
                        </button>&nbsp;
                        <button class="btn btn-primary" type="button" id="btnSimpanTransaksi">
                            <i class="bi bi-save"></i>
                        </button>&nbsp;
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="kodebarcode">Kode Produk</label>
                    <input type="text" class="form-control form-control-sm" name="kodebarcode" id="kodebarcode"
                        autofocus>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="">Nama Produk</label>
                    <input type="text" class="form-control form-control-sm" name="namaproduk" id="namaproduk"
                        readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="jml">Jumlah</label>
                    <input type="number" class="form-control form-control-sm" name="jumlah" id="jumlah" value="1">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="jml">Total Bayar</label>
                    <input type="text" class="form-control form-control-lg" name="totalbayar" id="totalbayar"
                        style="text-align: right; color:blue; font-weight : bold; font-size:30pt;" value="0" readonly>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 dataDetailPenjualan">
 
            </div>
        </div>
    </div>
</div>

<div class="viewmodal" style="display : none;"></div>
<div class="viewmodalmember" style="display : none;"></div>
<div class="viewmodalpembayaran" style="display : none;"></div>

<script>    
$(document).ready(function () {
    dataDetailPenjualan();

    hitungTotalBayar();

    $('#kodebarcode').keydown(function(e) {
        if(e.keyCode == 13) {
            e.preventDefault();
            cekKode();
        }
    });

    $('#btnHapusTransaksi').click(function(e) {  
        e.preventDefault();
        batalTransaksi();
    });

    $('#btnSimpanTransaksi').click(function(e) {  
        e.preventDefault();
        pembayaran();
    });

    $('#jumlah').keydown(function (e) {
        if (e.keyCode == 27){
            e.preventDefault();
            $('#kodebarcode').focus();
        }
    });

    $(this).keydown(function (e) {
        if (e.keyCode == 27){
            e.preventDefault();
            $('#kodebarcode').focus();
        }

        if (e.keyCode == 46){
            e.preventDefault();
             batalTransaksi();
        }

        if (e.keyCode == 45){
            e.preventDefault();
             pembayaran();
        }
    });

    $('#searchMember').click(function() {
    $.ajax({
        url: "<?= site_url('transaksi/viewDataMember') ?>",
        dataType: "json",
        success: function(response) {
            $('.viewmodalmember').html(response.viewmodal).show();
            $('#modalmember').modal('show');
        },
        error: function(xhr, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
});


});


function batalTransaksi() {
    Swal.fire({
    title: "Batal Transaksi?",
    text: "Yakin ingin membatalkan transaksi?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Ya, Batal!",
    cancelButtonText: "Tidak",
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            type: "post",
            url: "<?= site_url('transaksi/batalTransaksi') ?>",
            data: {
            nofaktur : $('#nofaktur').val()
            },
            dataType: "json",
            success: function(response) {
                if(response.sukses == 'berhasil') {
                    window.location.reload();
                }
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
       }
   });
}


    function pembayaran() {
        let nofaktur = $('#nofaktur').val();
        $.ajax({
        type: "post",
        url: "<?= site_url('transaksi/pembayaran') ?>",
        data: {
            nofaktur: nofaktur, 
            tglfaktur : $('#tanggal').val(),
            id_member: $('#id_member').val()
        },
        dataType: "json",
        success: function(response) {
           if (response.error) {
            Swal.fire({
                icon: "warning",
                title: "Maaf",
                text: response.error
            });
           }

           if(response.data) {
                $('.viewmodalpembayaran').html(response.data).show();
                const myModalEl = document.getElementById('modalpembayaran')
                myModalEl.addEventListener('shown.bs.modal', event => {
                    $('#jmluang').focus();
                });
                $('#modalpembayaran').modal('show');
            }
        },
        error: function(xhr, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
     });
    }

    function dataDetailPenjualan() {
        $.ajax({
        type: "post",
        url: "<?= site_url('transaksi/dataDetail') ?>",
        data: {
           nofaktur : $('#nofaktur').val()
        },
        dataType: "json",
        success: function(response) {
           if (response.data) {
                $('.dataDetailPenjualan').html(response.data);  
           }
        },
        error: function(xhr, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
    }

    function cekKode() {
        let kode = $('#kodebarcode').val();

        if(kode.length == 0) {
            $.ajax({
                url: "<?= site_url('transaksi/viewDataProduk') ?>",
                dataType: "json",
                success: function(response) {
                    $('.viewmodal').html(response.viewmodal).show();

                    $('#modalproduk').modal('show');
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        }else{
            $.ajax({
                type: "post",
                url: "<?= site_url('transaksi/simpanTemp') ?>",
                data: {
                    kodebarcode: kode,
                    namaproduk: $('#namaproduk').val(),
                    jumlah: $('#jumlah').val(),
                    nofaktur: $('#nofaktur').val(),
                },
                dataType: "json",
                success: function(response) {
                    if(response.totaldata == 'banyak'){
                        $.ajax({
                            url: "<?= site_url('transaksi/viewDataProduk') ?>",
                            dataType: "json",
                            data : {
                                keyword: kode
                            },
                            type : "post",
                            success: function(response) {
                                $('.viewmodal').html(response.viewmodal).show();

                                $('#modalproduk').modal('show');
                            },
                            error: function(xhr, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }
                        });
                    }

                    if(response.sukses == 'berhasil'){
                        dataDetailPenjualan();
                        hitungTotalBayar();
                        kosong();
                    }

                    if(response.error){
                        Swal.fire({
                            icon: "error",
                            title: "Error..",
                            html: response.error,
                        });
                    }
                    
                },
                error: function(xhr, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        }
    }

function kosong() {
    $('#kodebarcode').val('');
    $('#namaproduk').val('');
    $('#jumlah').val('1');
    $('#kodebarcode').focus();

    hitungTotalBayar();
}

function hitungTotalBayar() {
    $.ajax({
        url: "<?= site_url('transaksi/hitungTotalBayar') ?>",
        dataType: "json",
        data : {
            nofaktur : $('#nofaktur').val() 
        },
        type : "post",
        success: function(response) {
            if(response.totalbayar){
                $('#totalbayar').val(response.totalbayar);
            }
        },
        error: function(xhr, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
 }
 

</script>

<?= $this->endSection(); ?>