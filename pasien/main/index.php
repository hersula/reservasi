<?php session_start();

include('../../connection.php');
include('../../helper/base_url.php');

$nik = isset($_SESSION['nik']) ? $_SESSION['nik'] : null;

if (!$_SESSION['logged_on']) {
  # code...
  header('location:../index.php');
} else if ($nik == null) {
  session_destroy();
  header('location: ' . BASE_URL);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pasien <?= $_SESSION['name'] ?> | Norbu Medika</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../../admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../../admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../../admin/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../admin/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../../admin/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../../admin/plugins/summernote/summernote-bs4.min.css">
  <!--Datatable/Grid View-->
  <link rel="stylesheet" href="../../admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!--end of DataTable -->

  <!-- BizLand -->
  <link rel="stylesheet" href="../../bootstrap/css/template/navbar_pasien.css">
  <link rel="icon" href="../../images/LogoNorbuMedika.png" type="image/png">
  
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader 
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="../../admin/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>-->

    <?php

    include("partials/navbar.php");

    include("partials/sidebar.php");

    ?>



    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <?php
        if (isset($_GET['page'])) {
          $page = $_GET['page'];

          switch ($page) {
            case 'package':
              include "page/package_tes.php";
              break;
            case 'reservation':
              include "../transaction/reservation.php";
              break;
            case 'location':
              include "../transaction/location_outlet.php";
              break;
            case 'epidemiologi':
              include "../transaction/form_epidemiologi.php";
              break;
            case 'type-register':
              include "../transaction/type_registration.php";
              break;
            case 'cart':
              include "../transaction/cart_page.php";
              break;
            case 'invoice':
              include "page/invoice.php";
              break;
            case 'history':
              include "page/riwayat_transaction.php";
              break;
             case 'finishURL':
              include "page/finish_url_midtrans.php";
              break;
            case 'unFinishURL':
              include "page/unfinish_url_midtrans.php";
              break;
            case 'errorURL':
              include "page/error_url_midtrans.php";
              break;
            default:
              echo "<center><h3>Maaf. Halaman tidak di temukan !</h3></center>";
              break;
          }
        } else {
          include "../transaction/location_outlet.php";
        }

        ?>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2021 <a href="https://adminlte.io">Norbu Medika</a>.</strong>
    All rights reserved.
    <!--
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0-rc
    </div>
-->
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="../../admin/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="../../admin/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="../../admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="../../admin/plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="../../admin/plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="../../admin/plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="../../admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="../../admin/plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="../../admin/plugins/moment/moment.min.js"></script>
  <script src="../../admin/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="../../admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="../../admin/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="../../admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../admin/dist/js/adminlte.js"></script>
  <!--Datatable -->
    <script src="../../admin/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../../admin/plugins/jszip/jszip.min.js"></script>
    <script src="../../admin/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../../admin/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../../admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../../admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../../admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    
    <!-- Midtrans Snap -->
    <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js" data-client-key="Mid-client-h3lXG45aXwGWX3fP"></script>
  
<script>
  $('select').change(function() {
    var selected = $(this).val();
    if (selected == 'Iya') {
        $("#tulisanGejala").prop("required", true);
        $("#penjelasanGejala").show();
    }
    if (selected == 'Tidak') {
        $("#tulisanGejala").prop("required", false);
        $("#penjelasanGejala").hide();
    }
});
</script>
 <script>
  $(function () {
    $("#datatablepasien").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    }).buttons().container().appendTo('#datatablepasien_wrapper .col-md-6:eq(0)');
  });
</script>

  <!-- AdminLTE for demo purposes -->
  <!-- <script src="../../admin/dist/js/demo.js"></script> -->
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <!-- <script src="../../admin/dist/js/pages/dashboard.js"></script> -->

</body>

</html>