<?= $this-> extend('template/main'); ?>
<?= $this-> section('content'); ?>

<div class="card">
  <div class="card-body">
  <div class="d-flex justify-content-between">
    <h5 class="card-title">Tambah Produk</h5>   
         <a href="<?= base_url('member/data'); ?>" class="btn btn-warning my-3" style="height:40px">Kembali</a>
    </div>

    <!-- General Form Elements -->
    <form action="<?= base_url('member/update/') .$member['id_member']; ?>"  method="POST">
    <?= csrf_field(); ?>
    <div class="row mb-3">
    <label for="inputText" class="col-sm-2 col-form-label">Kode</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" value="<?= old('kode_member', $member['kode_member']); ?>" name="kode_member" readonly>
    </div>
    </div>
    
    <div class="row mb-3">
    <label for="inputText" class="col-sm-2 col-form-label">Nama</label>
    <div class="col-sm-10">
        <input type="text" class="form-control  <?= ($validation->hasError('nama_member')) ? 'is-invalid' : ''?>"  value="<?= old('nama_member', $member['nama_member']); ?>"  name="nama_member" >
        <div class="invalid-feedback"><?= ($validation->getError('nama_member'))?></div>
    </div>
    </div>
    
    <div class="row mb-3">
    <label for="inputText" class="col-sm-2 col-form-label">No Telepon</label>
    <div class="col-sm-10">
        <input type="number" class="form-control  <?= ($validation->hasError('telp')) ? 'is-invalid' : ''?>"  value="<?= old('telp', $member['telp']); ?>" name="telp">
        <div class="invalid-feedback"><?= ($validation->getError('telp'))?></div>
    </div>
    </div>

    <div class="row mb-3">
    <label for="inputText" class="col-sm-2 col-form-label">Alamat</label>
    <div class="col-sm-10">
        <input type="text" class="form-control  <?= ($validation->hasError('alamat')) ? 'is-invalid' : ''?>"  value="<?= old('alamat', $member['alamat']); ?>" name="alamat">
        <div class="invalid-feedback"><?= ($validation->getError('alamat'))?></div>
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



