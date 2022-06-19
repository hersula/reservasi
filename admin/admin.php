<?php

include "../connection.php";
session_start();
include "../cekLogin.php";
include "../helper/base_url.php";

if (!$_SESSION['logged_on']) {
  header('location:' . BASE_URL . 'admin');
}

if($_SESSION['outletID'] == null || $_SESSION['idKaryawan'] == null) {
  header('location:'.BASE_URL . 'admin');  
}

$date = date('Y-m-d');
$page = isset($_GET['page']) ? $_GET['page'] : '';
$outletID = isset($_SESSION['outletID']) ? $_SESSION['outletID'] : '';
$select_outlet = isset($_POST['select_outlet']) ? $_POST['select_outlet'] : '';
$selected_outlet = isset($_POST['selected_outlet']) ? $_POST['selected_outlet'] : '';
// $date_report = isset($_SESSION['date_report']) ? $_SESSION['date_report'] : $date;
$date_report = isset($_POST['date_filter']) ? $_POST['date_filter'] : $date;

$date_dashboard_report  = isset($_POST['date_filter']) ? $_POST['date_filter'] : '';
$date_dashboard_report2 = isset($_POST['date_filter2']) ? $_POST['date_filter2'] : '';

if($select_outlet != '' && $selected_outlet == '') {
    $query_get_name_outlet = $conn->query("select name from master_outlet where id = '$select_outlet'") or die($conn->error);
} else if ($select_outlet == '' && $selected_outlet != '') {
    $query_get_name_outlet = $conn->query("select name from master_outlet where id = '$selected_outlet'") or die($conn->error);
} else {
    $query_get_name_outlet = $conn->query("select name from master_outlet where id = '$outletID'") or die($conn->error);
}

$fect_name_outlet      = $query_get_name_outlet->fetch_array();

if ($selected_outlet != '') {
    if($selected_outlet == '0')
    {
        $name_outlet = "Semua Outlet";
    } else {
        $name_outlet = $fect_name_outlet['name'];
    }
} else if ($select_outlet != '') {
    if($select_outlet == '0')
    {
        $name_outlet = "Semua Outlet";
    } else {
        $name_outlet = $fect_name_outlet['name'];
    }
} else {
    $name_outlet = $fect_name_outlet['name'];
}

function titleDocument($page, $name, $date_report, $date_dashboard_report, $date_dashboard_report2, $date) {
    if($page == 'report-dashboard') {
        $title = 'Norbu Medika ' . $name . ' [' . $date_report . ']';
    } else if ($page == '' || $page == NULL) {
        if ($date_dashboard_report == '' && $date_dashboard_report2 =='') {
            $title = 'Norbu Medika ' . $name . ' [' . $date . ']';
        } else {
            $title = 'Norbu Medika ' . $name . ' [' . $date_dashboard_report . ' s/d ' . $date_dashboard_report2 .']';
        }
        
    } else {
        $title = ucwords($page);
    }
    
    return $title;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= titleDocument($page, $name_outlet, $date_report, $date_dashboard_report, $date_dashboard_report2, $date) ?> | Norbu Medika</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!--Datatable/Grid View-->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="icon" href="<?= BASE_URL  . 'images/LogoNorbuMedika.png'?>" type="image/png">
  <!--end of DataTable -->
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!--Sweet Alert -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
  <!--end of Sweet Alert-->
   <!--Sweet Alert untuk master-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
  <!--end of Sweet Alert untuk master-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>
<style>
  #getTindakanTes {
    width: 455px;

  }


  @media print {
    .nonprintable {
      display: none;
    }

    .printable {
      display: block;
    }
  }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <!--
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>
-->

    <?php

    include_once("partials/navbar.php");

    include_once("partials/sidebar.php");

    ?>

    <!-- Content Wrapper. Contains page content -->

    <!-- Main content -->
    <?php
    if (isset($_GET['page'])) {
      $page = $_GET['page'];

      switch ($page) {
        case 'dashboard':
          include "dashboard/dashboard.php";
          break;
        case 'roles-data':
          include "master/Roles.php";
          break;
        case 'tambah-roles-data':
          include "master/tambah_Roles.php";
          break;
        case 'ubah-roles-data':
          include "master/ubah_Roles.php";
          break;
        case 'hapus-roles-data':
          include "master/hapus_Roles.php";
          break;
        case 'lihat-roles-data':
          include "master/lihat_Roles.php";
          break;
        case 'outlet-data':
          include "master/Outlet.php";
          break;
        case 'tambah-outlet-data':
          include "master/tambah_Outlet.php";
          break;
        case 'ubah-outlet-data':
          include "master/ubah_Outlet.php";
          break;
        case 'hapus-outlet-data':
          include "master/hapus_Outlet.php";
          break;
        case 'lihat-outlet-data':
          include "master/lihat_Outlet.php";
          break;
        case 'tindakan-data':
          include "master/Tindakan.php";
          break;
        case 'tambah-tindakan-data':
          include "master/tambah_Tindakan.php";
          break;
        case 'ubah-tindakan-data':
          include "master/ubah_Tindakan.php";
          break;
        case 'hapus-tindakan-data':
          include "master/hapus_Tindakan.php";
          break;
        case 'lihat-tindakan-data':
          include "master/lihat_Tindakan.php";
          break;
        case 'kategori-data':
          include "master/Katpemeriksaan.php";
          break;
        case 'tambah-kategori-data':
          include "master/tambah_Katpemeriksaan.php";
          break;
        case 'ubah-kategori-data':
          include "master/ubah_Katpemeriksaan.php";
          break;
        case 'hapus-kategori-data':
          include "master/hapus_Katpemeriksaan.php";
          break;
        case 'lihat-kategori-data':
          include "master/lihat_Katpemeriksaan.php";
          break;
        case 'pemeriksaan-data':
          include "master/Pemeriksaan.php";
          break;
        case 'tambah-pemeriksaan-data':
          include "master/tambah_Pemeriksaan.php";
          break;
        case 'ubah-pemeriksaan-data':
          include "master/ubah_Pemeriksaan.php";
          break;
        case 'hapus-pemeriksaan-data':
          include "master/hapus_Pemeriksaan.php";
          break;
        case 'lihat-pemeriksaan-data':
          include "master/lihat_Pemeriksaan.php";
          break;
        case 'master-pasien-data':
          include "master/Pasien.php";
          break;
        case 'ubah-pasien-data':
          include "master/ubah_Pasien.php";
          break;
        case 'hapus-pasien-data':
          include "master/hapus_Pasien.php";
          break;
        case 'lihat-pasien-data':
          include "master/lihat_Pasien.php";
          break;
        case 'karyawan-data':
          include "master/Karyawan.php";
          break;
        case 'tambah-karyawan-data':
          include "master/tambah_Karyawan.php";
          break;
        case 'ubah-karyawan-data':
          include "master/ubah_Karyawan.php";
          break;
        case 'hapus-karyawan-data':
          include "master/hapus_Karyawan.php";
          break;
        case 'lihat-karyawan-data':
          include "master/lihat_Karyawan.php";
          break;
        case 'target-gen-data':
          include "master/Target_Gen.php";
          break;
        case 'tambah-target-gen-data':
          include "master/tambah_Target_Gen.php";
          break;
        case 'ubah-target-gen-data':
          include "master/ubah_Target_Gen.php";
          break;
        case 'hapus-target-gen-data':
          include "master/hapus_Target_Gen.php";
          break;
        case 'lihat-target-gen-data':
          include "master/lihat_Target_Gen.php";
          break;
        case 'reagen-data':
          include "master/Reagen.php";
          break;
        case 'tambah-reagen-data':
          include "master/tambah_Reagen.php";
          break;
        case 'ubah-reagen-data':
          include "master/ubah_Reagen.php";
          break;
        case 'hapus-reagen-data':
          include "master/hapus_Reagen.php";
          break;
        case 'lihat-reagen-data':
          include "master/lihat_Reagen.php";
          break;
        case 'master-hasil-tes-data':
          include "master/Hasil_Tes.php";
          break;
        case 'ubah-hasil-tes-data':
          include "master/ubah_Hasil_Tes.php";
          break;
        case 'lihat-hasil-tes-data':
          include "master/lihat_Hasil_Tes.php";
          break;
        case 'tipe-klien-data':
          include "master/Tipe_Klien.php";
          break;
        case 'tambah-tipe-klien-data':
          include "master/tambah_Tipe_Klien.php";
          break;
        case 'ubah-tipe-klien-data':
          include "master/ubah_Tipe_Klien.php";
          break;
        case 'hapus-tipe-klien-data':
          include "master/hapus_Tipe_Klien.php";
          break;
        case 'lihat-tipe-klien-data':
          include "master/lihat_Tipe_Klien.php";
          break;
        case 'klien-data':
          include "master/Klien.php";
          break;
        case 'tambah-klien-data':
          include "master/tambah_Klien.php";
          break;
        case 'ubah-klien-data':
          include "master/ubah_Klien.php";
          break;
        case 'hapus-klien-data':
          include "master/hapus_Klien.php";
          break;
        case 'lihat-klien-data':
          include "master/lihat_Klien.php";
          break;
        case 'tipe-pembayaran-data':
          include "master/Tipe_Pembayaran.php";
          break;
        case 'tambah-tipe-pembayaran-data':
          include "master/tambah_Tipe_Pembayaran.php";
          break;
        case 'lihat-tipe-pembayaran-data':
          include "master/lihat_Tipe_Pembayaran.php";
          break;
        case 'report-dashboard':
          include "dashboard/report_dashboard.php";
          break;
        case 'report-faskes-dashboard':
          include "dashboard/report_faskes_dashboard.php";
          break;
        case 'pasien-data':
          include "reservasi/Pendaftaran_Tes.php";
          break;
        case 'reservation':
          include "reservasi/tambah_Pendaftaran_Tes.php";
          break;
        case 'sample-lab':
          include "laboratorium/sample_lab.php";
          break;
        case 'hasil-lab-pcr':
          include "laboratorium/hasil-lab-pcr/hasil_lab_pcr.php";
          break;
        case 'hasil-lab-antigen':
          include "laboratorium/hasil-lab-antigen/hasil_lab_antigen.php";
          break;
        case 'input-hasil-pcr':
          include "laboratorium/hasil-lab-pcr/input_hasil_pcr.php";
          break;
         case 'input-hasil-antigen':
          include "laboratorium/hasil-lab-antigen/input_hasil_antigen.php";
          break;
        case 'history-tindakan':
          include "reservasi/riwayat_tindakan_outlet.php";
          break;
        case 'reservation-faskes':
          include "faskes/pendaftaran_faskes.php";
          break;
        case 'hasil-pcr-faskes':
          include "faskes/hasil_pcr_faskes.php";
          break;
        case 'hasil-antigen-faskes':
          include "faskes/hasil_antigen_faskes.php";
          break;
        case 'input-hasil-antigen-faskes':
          include "faskes/input_antigen_faskes.php";
          break;
        case 'account-pasien-data':
          include "master/buat_account.php";
          break;
        case 'errorURL':
          include "page/error_url_midtrans.php";
          break;
        case 'ganti-password':
          include "utility/Ganti_Password.php";
          break;
        case 'pemeriksaan-kategori':
          include "master/Tindakan.php";
          break;
        default:
          echo "<center><h3>Maaf. Halaman tidak di temukan !</h3></center>";
          break;
      }
    } else {
      include "dashboard/dashboard.php";
    }

    ?>
    <!-- /.content -->
  </div>
  </div>
  <!-- /.wrapper -->
  <br /><br />

  <!-- /.content-wrapper -->
  <footer class="main-footer nonprintable">
    <strong>Copyright &copy; 2021 <a href="<?=BASE_URL?>admin">Norbu Medika</a>.</strong>
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
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <!-- <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script> -->
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Select 2 -->
  <script src="plugins/select2/js/select2.full.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
  <!--Datatable -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="plugins/jszip/jszip.min.js"></script>
  <script src="plugins/pdfmake/pdfmake.min.js"></script>
  <script src="plugins/pdfmake/vfs_fonts.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $("body").on('click', '.toggle-password', function() {
      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $("#InputPassword");
      if (input.attr("type") === "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });
    $("body").on('click', '.toggle-password2', function() {
      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $("#form-password");
      if (input.attr("type") === "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });
  </script>
  <script>
    $(function() {
      $("#dataRiwayatTindakan").DataTable({
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "pageLength": 20,
        "scrollX": true,
        "order": [
          [1, "desc"],
        ],
      }).buttons().container().appendTo('#dataRiwayatTindakan_wrapper .col-md-6:eq(0)');
      
      $("#dataRiwayatTindakanPeriode").DataTable({
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "pageLength": 20,
        "order": [
          [1, "desc"],
        ],
      }).buttons().container().appendTo('#dataRiwayatTindakanPeriode_wrapper .col-md-6:eq(0)');
      
      $("#dataHasilTesAntigen").DataTable({
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "pageLength": 20,
        "order": [
          [0, "desc"],
        ],
      }).buttons().container().appendTo('#dataHasilTesAntigen_wrapper .col-md-6:eq(0)');
      
      $("#dataSampleLab").DataTable({
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "pageLength": 20,
        "order": [
          [1, "asc"],
        ],
      }).buttons().container().appendTo('#dataSampleLab_wrapper .col-md-6:eq(0)');
      $('#dataSampleLab_filter label input').focus();
      
      $("#dataReportDashboard").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "pageLength": 20,
        buttons: [
          'excel'
        ]
      }).buttons().container().appendTo('#dataReportDashboard_wrapper .col-md-6:eq(0)');
      
      
      $('.select2bs4').select2({
        theme: 'bootstrap4',
        width: 'null',
      });

      $('#tableSampleBarcode').DataTable({
        "responsive": true,
        "autoWidth": false,
        "lengthChange": false,
        "pageLength": 10,
        "order": [
          [0, "asc"],
        ],
        buttons: [
          'excel', 'pdf'
        ]
      }).buttons().container().appendTo('#tableSampleBarcode_wrapper .col-md-6:eq(0)');
      
        
      $('#dataLaporanTindakanNew').DataTable({
        "responsive": true,
        "autoWidth": false,
        "lengthChange": false,
        "pageLength": 10,
      }).buttons().container().appendTo('#dataLaporanTindakanNew_wrapper .col-md-6:eq(0)');
        
      
      $('#dataLaporanTindakan').DataTable({
        "responsive": true,
        "autoWidth": false,
        "lengthChange": false,
        "pageLength": 10,
        "order": [
          [0, "asc"],
        ],
        buttons: [
          { extend: 'excel',footer: true,},
          { extend: 'pdf',footer: true, }
         
        ]
      }).buttons().container().appendTo('#dataLaporanTindakan_wrapper .col-md-6:eq(0)'); 
      
      $('#dataLaporanPembayaran').DataTable({
        "responsive": true,
        "autoWidth": false,
        "lengthChange": false,
        "pageLength": 10
      }).buttons().container().appendTo('#dataLaporanPembayaran_wrapper .col-md-6:eq(0)'); 
      
      $('#dataLaporanStatus').DataTable({
        "responsive": true,
        "autoWidth": false,
        "lengthChange": false,
        "pageLength": 10
      }).buttons().container().appendTo('#dataLaporanStatus_wrapper .col-md-6:eq(0)'); 
        
        
      $('#tableSamplePeriodeFaskes').DataTable({
        "responsive": true,
        "autoWidth": false,
        "lengthChange": false,
        "pageLength": 10,
        "order": [
          [0, "asc"],
        ],
        buttons: [
          'excel', 'pdf'
        ]
      }).buttons().container().appendTo('#tableSamplePeriodeFaskes_wrapper .col-md-6:eq(0)');

      $('#tableBarcodePeriode').DataTable({
        "responsive": true,
        "autoWidth": false,
        "lengthChange": false,
        "pageLength": 20,
        "order": [
          [0, "asc"],
        ],
      }).buttons().container().appendTo('#tableBarcodePeriode_wrapper .col-md-6:eq(0)');
      
      $('#tableSamplePCRfaskes').DataTable({
        "responsive": true,
        "autoWidth": false,
        "lengthChange": false,
        "pageLength": 10,
        "order": [
          [0, "asc"],
        ],
      }).buttons().container().appendTo('#tableSamplePCRfaskes_wrapper .col-md-6:eq(0)');

      $('#myTab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
      });

      // store the currently selected tab in the hash value
      $("ul.nav-pills > li > a").on("shown.bs.tab", function(e) {
        var id = $(e.target).attr("href").substr(1);
        window.location.hash = id;
      });

      // on load of the page: switch to the currently selected tab
      var hash = window.location.hash;
      $('#myTab a[href="' + hash + '"]').tab('show');
    });
  </script>

  <script>
    function confirmDelete() {
      var x = confirm("Anda yakin akan menghapus data ini?")
      if (x) {
        return true;
      } else {
        return false;
      }
    }
    
    function testPrice() {
      var valOutletID = $(".outletID option:selected").val();
      var valIdTindakan = document.getElementById('tindakanID').value;
      var valueTextPrice = document.getElementById('textprice');
      var valueLabPrice = document.getElementById('labprice');
      var el1 = document.getElementById("textdiskon");
      var val = $("input[id='tax']").val() 
      var el2 = document.getElementById("diskon").val == '' ? '0' : document.getElementById("diskon");
      el1.innerHTML = new Intl.NumberFormat('id-ID').format(el2.value);
      var textHasil = document.getElementById('texthasil');
      $.ajax({
        type: "POST",
        url: "reservasi/get_total_price.php",
        data: {
          tindakanID: valIdTindakan,
          outletID: valOutletID
        }
      }).done(function(data) {
        valueTextPrice.innerHTML = new Intl.NumberFormat('id-ID').format(data);
        var val2 = document.getElementById("textTax");
        var price = data;
        var lab = valueLabPrice.value == '' ? '0' : valueLabPrice.value;
        var diskon = el2.value == '' ? '0' : el2.value;
        var tax = val == '' ? 0 : parseInt(val)/100;
        var subtotal = parseInt(price) + parseInt(lab);
        var hasil = subtotal + parseInt(price * tax) - parseInt(diskon);
        
        val2.innerHTML = !isNaN(parseInt(price * tax)) ? Intl.NumberFormat('id-ID').format(parseInt(price * tax)) : 0;
        
        textHasil.innerHTML = !isNaN(hasil) ? new Intl.NumberFormat('id-ID').format(parseInt(hasil)) : new Intl.NumberFormat('id-ID').format(parseInt(data));
      });

    }

    function getPrice() {
      var valOutletID = $(".outletID option:selected").val();
      var valIdTindakan = document.getElementById('targetGenID').value;
      var valueTextPrice = document.getElementById('textprice').innerText;
      var valPrice = valueTextPrice.replace(".", ""); 
      var valueLabPrice = document.getElementById("labprice");
      var valLab = valueLabPrice.innerText.replace(".", "");
      var el1 = document.getElementById("textdiskon");
      var val = $("input[id='tax']").val() ;
      var el2 = document.getElementById("diskon").val == '' ? '0' : document.getElementById("diskon");
      el1.innerHTML = new Intl.NumberFormat('id-ID').format(el2.value);
      var textHasil = document.getElementById('texthasil');
      $.ajax({
        type: "POST",
        url: "reservasi/get_total_price1.php",
        data: {
          tindakanID: valIdTindakan,
          outletID: valOutletID
        }
      }).done(function(data) {
        
        var val2 = document.getElementById("textTax");
        var price = data;
        var tPrice = valPrice;
        // var tLab = valLab;
        var tLab = valLab == '' ? '0' : valLab;
        var covid = new Intl.NumberFormat('id-ID').format(tPrice);
        var lab = new Intl.NumberFormat('id-ID').format(tLab);
        var diskon = el2.value == '' ? '0' : el2.value;
        var tax = val == '' ? 0 : parseInt(val)/100;
        var nPrice = parseInt(price) + parseInt(tLab);
        var kumpul = parseInt(tPrice) + parseInt(price) + parseInt(tLab); 
        var subtotal = parseInt(kumpul);
        var hasil = subtotal + parseInt(price * tax) - parseInt(diskon);
        
        val2.innerHTML = !isNaN(parseInt(price * tax)) ? Intl.NumberFormat('id-ID').format(parseInt(price * tax)) : 0;
        valueLabPrice.innerHTML = !isNaN(nPrice) ? new Intl.NumberFormat('id-ID').format(parseInt(nPrice)) : new Intl.NumberFormat('id-ID').format(parseInt(data));
        textHasil.innerHTML = !isNaN(hasil) ? new Intl.NumberFormat('id-ID').format(parseInt(hasil)) : new Intl.NumberFormat('id-ID').format(parseInt(data));
      });

    }
  </script>
  <script>
    //$(function() {
    function isi_otomatis() {
      $("#nik").change(function() {
        var nik = $("#nik").val();
        if(nik.length == 16) {
         $.ajax({
          url: 'dist/js/proses-ajax-nik.php',
          type: 'GET',
          dataType: 'json',
          data: {
            'nik': nik
          },
          success: function(pasien) {
              if(pasien['name'] != null || pasien['gender'] != null || pasien['passport'] != null) {
                    
                  //$("#nik").prop("readonly", true);
                $("#name").val(pasien['name']);
                $("#name").prop("readonly", true);
                $("#gender").val(pasien['gender']);
                $("#gender").css("background-color","#e6e6e6");
                $("#gender").select2({disabled:'readonly'}, true);
                $("#placeOfBirth").val(pasien['placeOfBirth']);
                $("#placeOfBirth").prop("readonly", true);
                $("#passport").val(pasien['passport']);
                $("#passport").prop("readonly", true);
                $("#phone").val(pasien['phone']);
                $("#phone").prop("readonly", true);
                $("#country").val(pasien['country']).trigger('change');
                $("#country").select2({disabled:'readonly'});
                $("#address").val(pasien['address']);
                $("#address").prop("readonly", true);
                $("#dateOfBirth").val(pasien['dateOfBirth']);
                $("#dateOfBirth").prop("readonly", true);
                $("#isWNA").val(pasien['isWNA']);
                $("#isWNA").css("background-color","#e6e6e6");
                $("#isWNA").select2({disabled:'readonly'});
                //$("#isWNA").prop("readonly", true);
               
                // Swal.fire({
                //   icon: 'success',
                //   title: 'Data Pasien Ditemukan',
                //   showConfirmButton: false,
                //   timer: 1000,
                // }); 
                
                $('#alertdatapasien').removeClass('d-none').addClass('show');
                
                return false;
             
              } 
            //   else {
            //     $("#name").val('');
            //     $("#name").prop("readonly", false);
            //     $("#gender").val('').trigger('change');
            //     $("#gender").removeAttr('disabled');
            //     $("#placeOfBirth").val('');
            //     $("#placeOfBirth").prop("readonly", false);
            //     $("#passport").val('');
            //     $("#passport").prop("readonly", false);
            //     $("#phone").val('');
            //     $("#phone").prop("readonly", false);
            //     $("#country").val();
            //     $("#country").removeAttr('disabled');
            //     $("#address").val();
            //     $("#address").prop("readonly", false);
            //     $("#dateOfBirth").val();
            //     $("#dateOfBirth").prop("readonly", false);
            //     $("#isWNA").val();
            //     $("#isWNA").removeAttr('disabled');
            //   }
          }, 
        })
        }
      });
    }
  </script>
  
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
    
    function getTargetField() {
      $('#hasil_pemeriksaan').change(function() {
        var selected = $(this).val();
        if (selected == 'Positif') {
          $("#valueTarget").prop("required", true);
          $("#detailGen").removeClass('d-none');
          $("#detailGen").show();
        } else {
          $("#valueTarget").prop("required", false);
          $("#detailGen").addClass('d-none');
          $("#detailGen").hide();
        }
      });
    }
  </script>
  <script type="text/javascript">
    $(document).ready(function () {
      $("#isWNA").change(function() {
        var determineCountry = $("#isWNA").val();
        var country = $("#country").val("Indonesia");
        if (determineCountry == "0") {
             country.trigger('change');
            // $('select[name="country"] option[value=Indonesia]').prop("selected",true);
            //$('select[id="country"] option[value="Indonesia"]').attr("selected","selected");
            // $("#country").select2({disabled:'readonly'});
        } 
        if (determineCountry == "1") {
          $("#country").val("").trigger('change');
          $("#country").prop("disabled", false); 
        }       
      });
    });

    $(document).ready(function(){
      $("#paymentType").change(function() {
        var selectedPayment= $(this).val();
        if($(this).val() == "5"){
            $("#penjelasanBillTo").show();
        }else {
            $("#penjelasanBillTo").hide();
        }
      });
    });
    
    $(document).ready(function(){
        $("select.outletID").change(function(){
            var selectedOutletID = $(".outletID option:selected").val();
            console.log(selectedOutletID);
            $.ajax({
                type: "POST",
                url: "reservasi/get_list_tindakan.php",
                data: { outletID : selectedOutletID } 
            }).done(function(data){
                $("#tindakanID").html(data);
            });
        });
    });
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
        $('#role').select2({
        placeholder: "Pilih Role",
        allowClear: true,
        language: "id"
        });
    });
     $(document).ready(function() {
        $('#targetGenID').select2({
        placeholder: "Pilih Target Gen",
        allowClear: true,
        language: "id"
        });
    });
    /*
    $(document).ready(function() {
        $('#outlet').select2({
        placeholder: "Pilih Outlet",
        allowClear: true,
        language: "id"
        });
    });
    */
  </script>
  <script language='javascript'>
        function isNumberKeyTrue(evt) {
          var charCode = (evt.which) ? evt.which : event.keyCode
              if (charCode > 65) {
                  return false;        
              }else {
                  return true;
              }
        }
    </script>
</body>

</html>