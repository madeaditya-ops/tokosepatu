<?= $this-> extend('template/main'); ?>
<?= $this-> section('content'); ?>

<div class="card">
  <div class="card-body">
  <div class="d-flex justify-content-between">
    <h5 class="card-title">Tambah Member</h5>   
         <a href="<?= base_url('member/data'); ?>" class="btn btn-warning my-3" style="height:40px">Kembali</a>
    </div>

    <!-- General Form Elements -->
    <form action="<?= base_url('member/simpan'); ?>"  method="POST">
    <?= csrf_field(); ?>
    <div class="row mb-3">
    <label for="inputText" class="col-sm-2 col-form-label">Kode</label>
    <div class="col-sm-2">
        <input type="text" class="form-control" value="<?= esc($kode_member) ?>" name="kode_member" readonly>
    </div>
    </div>
    
    <div class="row mb-3">
    <label for="inputText" class="col-sm-2 col-form-label">Nama</label>
    <div class="col-sm-10">
        <input type="text" class="form-control  <?= ($validation->hasError('nama_member')) ? 'is-invalid' : ''?>" name="nama_member">
        <div class="invalid-feedback"><?= ($validation->getError('nama_member'))?></div>
    </div>
    </div>
    
    <div class="row mb-3">
    <label for="inputText" class="col-sm-2 col-form-label">No Telepon</label>
    <div class="col-sm-5">
        <input type="number" class="form-control  <?= ($validation->hasError('telp')) ? 'is-invalid' : ''?>" name="telp">
        <div class="invalid-feedback"><?= ($validation->getError('telp'))?></div>
    </div>
    </div>

    <div class="row mb-3">
    <label for="inputText" class="col-sm-2 col-form-label">Alamat</label>
    <div class="col-sm-10">
    <textarea class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : '' ?>" name="alamat" rows="3"></textarea>
    <div class="invalid-feedback"><?= ($validation->getError('alamat')) ?></div>
    </div>
    </div>
      <div class="row mb-3">
        <label class="col-sm-2 col-form-label"></label>
        <div class="col-sm-10">
        <button type="submit" class="btn btn-primary tombolSimpan">Simpan</button>
        </div>
      </div>
    
    </form>
  </div>
</div>



<?= $this-> endSection(); ?>



