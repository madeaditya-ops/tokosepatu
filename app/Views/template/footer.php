  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>TokoSepatu</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?= base_url('assets');?>/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="<?= base_url('assets');?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url('assets');?>/vendor/chart.js/chart.umd.js"></script>
  <script src="<?= base_url('assets');?>/vendor/echarts/echarts.min.js"></script>
  <script src="<?= base_url('assets');?>/vendor/quill/quill.js"></script>
  <script src="<?= base_url('assets');?>/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="<?= base_url('assets');?>/vendor/tinymce/tinymce.min.js"></script>
  <script src="<?= base_url('assets');?>/vendor/php-email-form/validate.js"></script>


  <!-- Template Main JS File -->
  <script src="<?= base_url('assets');?>/js/main.js"></script>


  <!-- datatable -->
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>

 <!-- SweetAlert2 JS -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $(document).ready( function () {
    $('#datatable').DataTable();
    } );

    $(function() {
      <?php if(session()->has('success')) {?>
      Swal.fire({
        title: "Berhasil",
        text: "<?= $_SESSION['success']?>",
        icon: "success"
      });
      <?php }?>


      <?php if(session()->has('sukses')) {?>
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.onmouseenter = Swal.stopTimer;
              toast.onmouseleave = Swal.resumeTimer;
            }
          });
          Toast.fire({
            icon: "success",
            title: "<?= $_SESSION['sukses']?>"
          });
      <?php }?>
    });


    

  </script>

</body>

</html>