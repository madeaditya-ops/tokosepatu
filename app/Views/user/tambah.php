<?= $this-> extend('template/main'); ?>
<?= $this-> section('content'); ?>

<div class="card">
  <div class="card-body">
  <div class="d-flex justify-content-between">
    <h5 class="card-title">Tambah Member</h5>   
         <a href="<?= base_url('user/data'); ?>" class="btn btn-warning my-3" style="height:40px">Kembali</a>
    </div>

    <!-- General Form Elements -->
    <form action="<?= base_url('user/simpan'); ?>"  method="POST" class="row">
    <?= csrf_field(); ?>
    <div class="row">
    <div class="col-md-6">

    <div class="mb-3">
    <label for="inputText" class="col-form-label">Nama Lengkap :</label>
    <input type="text" class="form-control  <?= ($validation->hasError('nama_lengkap')) ? 'is-invalid' : ''?>" name="nama_lengkap">
    <div class="invalid-feedback"><?= ($validation->getError('nama_lengkap'))?></div>
    </div>

    <div class="mb-3">
        <label for="inputText" class="col-form-label">Username :</label>
        <input type="text" class="form-control  <?= ($validation->hasError('username')) ? 'is-invalid' : ''?>" name="username">
        <div class="invalid-feedback"><?= ($validation->getError('username'))?></div>
    </div>
    
    <div class="mb-3">
        <label for="inputText" class="col-form-label">Password :</label>
        <input type="password" class="form-control  <?= ($validation->hasError('password')) ? 'is-invalid' : ''?>" name="password">
        <div class="invalid-feedback"><?= ($validation->getError('password'))?></div>
    </div>
    
    <div class="mb-3">
        <label class="col-form-label">Role :</label>
        <div class="col-sm-6">
            <select class="form-select" aria-label="Default select example" name="level" >
                <option value="" disabled selected>Pilih</option>
                <option value="admin">Admin</option>
                <option value="kasir">Kasir</option>
            </select>
        </div>
    </div>
</div>

   
    
<div class="col-md-6">
    <div class="mb-3">
    <label for="inputText" class="col-form-label">No Telepon :</label>
    <input type="number" class="form-control  <?= ($validation->hasError('telp')) ? 'is-invalid' : ''?>" name="telp">
        <div class="invalid-feedback"><?= ($validation->getError('telp'))?></div>
    </div>

    
    <div class="mb-3">
    <label for="inputText" class="col-form-label">Alamat :</label>
    <textarea class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : '' ?>" name="alamat" rows="3"></textarea>
    <div class="invalid-feedback"><?= ($validation->getError('alamat')) ?></div>
    </div>

</div>

</div> 
<!-- akhir row -->

      <div class="row my-3">
        <label class="col-md-11 col-9 col-form-label"></label>
        <div class="col-md-1 col-3">
        <button type="submit" class="btn btn-primary tombolSimpan">Simpan</button>
        </div>
      </div>
    
    </form>
  </div>
</div>



<?= $this-> endSection(); ?>



