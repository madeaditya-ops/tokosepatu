<?= $this->extend('template/main'); ?>
<?= $this->section('content'); ?>

<div class="card">
  <div class="card-body">
  <div class="d-flex justify-content-between">
    <h5 class="card-title">Edit Member</h5>   
    <a href="<?= base_url('user/data'); ?>" class="btn btn-warning my-3" style="height:40px">Kembali</a>
  </div>

  <!-- General Form Elements -->
  <form action="<?= base_url('user/update/' . $user['id_user']); ?>" method="POST" class="row">
    <?= csrf_field(); ?>
    <div class="row">
      <div class="col-md-6">

        <div class="mb-3">
          <label for="inputText" class="col-form-label">Nama Lengkap :</label>
          <input 
            type="text" 
            class="form-control <?= ($validation->hasError('nama_lengkap')) ? 'is-invalid' : '' ?>" 
            name="nama_lengkap" 
            value="<?= old('nama_lengkap', $user['nama_lengkap']) ?>"
          >
          <div class="invalid-feedback"><?= ($validation->getError('nama_lengkap')) ?></div>
        </div>

        <div class="mb-3">
          <label for="inputText" class="col-form-label">Username :</label>
          <input 
            type="text" 
            class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>" 
            name="username" 
            value="<?= old('username', $user['username']) ?>"
          >
          <div class="invalid-feedback"><?= ($validation->getError('username')) ?></div>
        </div>

        <div class="mb-3">
          <label for="inputText" class="col-form-label">Password :</label>
          <input 
            type="password" 
            class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>" 
            name="password"
          >
          <div class="invalid-feedback"><?= ($validation->getError('password')) ?></div>
          <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti password</small>
        </div>

        <div class="mb-3">
          <label class="col-form-label">Role :</label>
          <div class="col-sm-6">
            <select 
              class="form-select <?= ($validation->hasError('level')) ? 'is-invalid' : '' ?>" 
              name="level"
            >
              <option value="" disabled>Pilih</option>
              <option value="admin" <?= old('level', $user['level']) == 'admin' ? 'selected' : '' ?>>Admin</option>
              <option value="kasir" <?= old('level', $user['level']) == 'kasir' ? 'selected' : '' ?>>Kasir</option>
            </select>
            <div class="invalid-feedback"><?= ($validation->getError('level')) ?></div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="mb-3">
          <label for="inputText" class="col-form-label">No Telepon :</label>
          <input 
            type="number" 
            class="form-control <?= ($validation->hasError('telp')) ? 'is-invalid' : '' ?>" 
            name="telp" 
            value="<?= old('telp', $user['telp']) ?>"
          >
          <div class="invalid-feedback"><?= ($validation->getError('telp')) ?></div>
        </div>

        <div class="mb-3">
          <label for="inputText" class="col-form-label">Alamat :</label>
          <textarea 
            class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : '' ?>" 
            name="alamat" 
            rows="3"><?= old('alamat', $user['alamat']) ?></textarea>
          <div class="invalid-feedback"><?= ($validation->getError('alamat')) ?></div>
        </div>
      </div>
    </div> 
    <!-- Akhir row -->

    <div class="row my-3">
      <label class="col-md-11 col-9 col-form-label"></label>
      <div class="col-md-1 col-3">
        <button type="submit" class="btn btn-primary tombolSimpan">Simpan</button>
      </div>
    </div>
  </form>
  </div>
</div>



<?= $this->endSection(); ?>

