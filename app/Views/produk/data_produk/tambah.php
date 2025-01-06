<?= $this-> extend('template/main'); ?>
<?= $this-> section('content'); ?>

<div class="card">
  <div class="card-body">
  <div class="d-flex justify-content-between">
    <h5 class="card-title">Tambah Produk</h5>   
         <a href="<?= base_url('produk/data_produk/data_produk'); ?>" class="btn btn-warning my-3" style="height:40px">Kembali</a>
    </div>

    <!-- General Form Elements -->
    <form action="<?= base_url('produk/data_produk/simpan'); ?>"  method="POST" enctype="multipart/form-data">
    <?= csrf_field(); ?>
      <div class="row mb-3">
        <label for="inputText" class="col-sm-2 col-form-label">Nama Produk</label>
        <div class="col-sm-10">
          <input type="text" class="form-control  <?= ($validation->hasError('nama_produk')) ? 'is-invalid' : ''?>" name="nama_produk"  value="<?= old('nama_produk'); ?>">
          <div class="invalid-feedback"><?= ($validation->getError('nama_produk'))?></div>
        </div>
      </div>

      <div class="row mb-3">
        <label for="inputEmail" class="col-sm-2 col-form-label">Barcode</label>
        <div class="col-sm-10">
          <input type="text" class="form-control <?= ($validation->hasError('barcode')) ? 'is-invalid' : ''?>" name="barcode"  value="<?= old('barcode'); ?>">
          <div class="invalid-feedback"><?= ($validation->getError('barcode'))?></div>
        </div>
      </div>
      
      <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Kategori</label>
        <div class="col-sm-3">
          <select class="form-select" aria-label="Default select example" name="id_kategori">
            <option value="" disabled selected>Pilih Kategori</option> 
            <?php foreach ($kategori as $k): ?>
              <option value="<?= $k['id_kategori']; ?>"><?= esc($k['nama_kategori']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Size</label>
          <div class="col-sm-3">
              <select class="form-select" aria-label="Default select example" name="size" >
                  <option value="" disabled selected>Pilih Size</option>
                  <option value="38">38</option>
                  <option value="39">39</option>
                  <option value="40">40</option>
                  <option value="41">41</option>
                  <option value="42">42</option>
              </select>
          </div>
        </div>

        <div class="row mb-3">
          <label for="inputEmail" class="col-sm-2 col-form-label">Harga</label>
          <div class="col-sm-10">
            <input type="number" class="form-control <?= ($validation->hasError('harga')) ? 'is-invalid' : ''?>" name="harga"  value="<?= old('harga'); ?>">
            <div class="invalid-feedback"><?= ($validation->getError('harga'))?></div>
          </div>
        </div>

        <div class="row mb-3">
          <label for="inputEmail" class="col-sm-2 col-form-label">Stok</label>
          <div class="col-sm-10">
            <input type="number" class="form-control <?= ($validation->hasError('stok')) ? 'is-invalid' : ''?>" name="stok"  value="<?= old('stok'); ?>">
            <div class="invalid-feedback"><?= ($validation->getError('stok'))?></div>
          </div>
        </div>

      <!-- <div class="row mb-3">
        <label for="inputNumber" class="col-sm-2 col-form-label">Gambar</label>
        <div class="col-sm-10">
          <input class="form-control" type="file" id="formFile" name="gambar_produk">
        </div>
      </div> -->
   
      <div class="row mb-3">
        <label class="col-sm-2 col-form-label"></label>
        <div class="col-sm-10">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>

    </form><!-- End General Form Elements -->

  </div>
</div>



<?= $this-> endSection(); ?>



