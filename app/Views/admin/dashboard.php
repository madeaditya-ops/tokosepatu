<?= $this-> extend('template/main'); ?>
<?= $this-> section('content'); ?>

<section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <!-- <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div> -->

                <div class="card-body">
                  <h5 class="card-title">Total Transaksi</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?= $totalTrPerhari; ?></h6>
                      <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                <!-- <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div> -->

                <div class="card-body">
                  <h5 class="card-title">Total Pendapatan</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?= "Rp ". number_format($jmlTrPerhari); ?></h6>
                      <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                <!-- <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div> -->

                <div class="card-body">
                  <h5 class="card-title">Total Users</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-person"></i>
                    </div>
                    <div class="ps-3">
                      <h6>0</h6>
                      <!-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> -->

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->


              <!-- awal bar chart -->
                <div class="col-md-12">
                  <div class="card responsive">
                  <div class="card-body">
                    <h5 class="card-title">Pendapatan Mingguan</h5>

                    <!-- Bar Chart -->
                    <div id="barChart" style="min-height: 400px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);" class="echart" _echarts_instance_="ec_1736083855394"><div style="position: relative; width: 693px; height: 400px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;"><canvas data-zr-dom-id="zr_0" width="866" height="500" style="position: absolute; left: 0px; top: 0px; width: 693px; height: 400px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div></div>

                    <script>
                      document.addEventListener("DOMContentLoaded", () => {
                          // Ambil data yang sudah dikirimkan dari controller
                          const dataLabels = JSON.parse('<?= $datachart['labels'] ?>');
                          const dataValues = JSON.parse('<?= $datachart['values'] ?>');

                          var chart = echarts.init(document.getElementById('barChart'));
                          chart.setOption({
                              tooltip: {
                                  trigger: 'item',  // Menampilkan tooltip saat item dipilih
                                  formatter: function (params) {
                                      var value = Number(params.value);
                                      // Format value with thousands separator
                                      if (!isNaN(value)) {
                                          var formattedValue = value.toLocaleString();
                                          return params.name + ': Rp ' + formattedValue;
                                      }
                                      return params.name + ': Rp ' + params.value;
                                  }
                              },
                              xAxis: {
                                  type: 'category',
                                  data: dataLabels
                              },
                              yAxis: {
                                  type: 'value'
                              },
                              series: [{
                                  data: dataValues,
                                  type: 'bar'
                              }]
                          });
                      });
                  </script>
                    <!-- End Bar Chart -->

                  </div>
                  </div>
                  </div>
                  <!-- akhir bar chart -->
  
            
            <div class="col-lg-7">
                        
                <div class="card table-responsive">
                    <div class="card-body pt-1">
                      <h5 class="card-title">Produk Terlaris</h5>
                        <table class="table table-responsive ">
                            <thead>
                                <tr>
                                    <th scope="col" class="w-50">Nama Produk</th>
                                    <th scope="col" class="text-center">Terjual</th>
                                    <th scope="col" class="text-end">Total Penjualan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($topProduk)): ?>
                                    <?php foreach ($topProduk as $row): ?>
                                        <tr>
                                            <td><?= esc($row['nama_produk']); ?></td>
                                            <td class="text-center"><?= esc($row['total_terjual']); ?></td>
                                            <td class="text-end"><?='Rp  '.esc(number_format($row['total_penjualan'], 0, ',', '.')); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>



            <!-- awal pie chart -->
            <div class="col-lg-5">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Produk Terlaris</h5>

              <!-- Pie Chart -->
              <div id="pieChart" style="min-height: 400px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); position: relative;" class="echart" _echarts_instance_="ec_1736092169591"><div style="position: relative; width: 693px; height: 400px; padding: 0px; margin: 0px; border-width: 0px;"><canvas data-zr-dom-id="zr_0" width="1386" height="800" style="position: absolute; left: 0px; top: 0px; width: 693px; height: 400px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas></div><div class=""></div></div>

              <script>
                  document.addEventListener("DOMContentLoaded", () => {
                      var chartDom = document.getElementById('pieChart');
                      var myChart = echarts.init(chartDom);

                      // Data dari server
                      var labels = <?= $piechart['labels']; ?>;
                      var values = <?= $piechart['values']; ?>;

                      // Konfigurasi Pie Chart
                      var option = {
                          title: {
                              text: 'Produk Terlaris',
                              subtext: 'Berdasarkan Penjualan',
                              left: 'center'
                          },
                          tooltip: {
                              trigger: 'item'
                          },
                          legend: {
                              orient: 'vertical',
                              left: 'left'
                          },
                          series: [
                              {
                                  name: 'Jumlah Terjual',
                                  type: 'pie',
                                  radius: '50%',
                                  data: labels.map((label, index) => ({
                                      value: values[index],
                                      name: label
                                  })),
                                  emphasis: {
                                      itemStyle: {
                                          shadowBlur: 10,
                                          shadowOffsetX: 0,
                                          shadowColor: 'rgba(0, 0, 0, 0.5)'
                                      }
                                  }
                              }
                          ]
                      };

                      // Render chart
                      myChart.setOption(option);
                  });
              </script>
              <!-- End Pie Chart -->

            </div>
          </div>
        </div>
             <!-- akhir pie chart -->

<div class="col-md-12">
      
      <div class="card table-responsive">
          <div class="card-body pt-1">
            <h5 class="card-title">Stok Alert</h5>
              <table class="table table-responsive ">
                  <thead>
                      <tr>
                          <th scope="col" class="">Barcode</th>
                          <th scope="col" class="">Nama Produk</th>
                          <th scope="col" class="">Kategori</th>
                          <th scope="col" class="">Size</th>
                          <th scope="col" class="">Stok</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php if (!empty($stokAlert)): ?>
                          <?php foreach ($stokAlert as $row): ?>
                              <tr>
                                  <td class=""><?= esc($row['barcode']); ?></td>
                                  <td class=""><?= esc($row['nama_produk']); ?></td>
                                  <td class=""><?= esc($row['kategori']); ?></td>
                                  <td class=""><?= esc($row['size']); ?></td>
                                  <td class=""><?= esc($row['stok']); ?></td>
                              </tr>
                          <?php endforeach; ?>
                      <?php else: ?>
                          <tr>
                              <td colspan="4" class="text-center">Tidak ada data</td>
                          </tr>
                      <?php endif; ?>
                  </tbody>
              </table>
          </div>
      </div>

  </div>


</div>
<?= $this-> endSection(); ?>