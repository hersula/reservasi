<?php 

include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}

$idTindakan = "";
$satuan     ="";
$nilai_min  = 0;
$nilai_max  = 0;
$kelamin    = "";
$isFaskes   ="1";

$error              =0;
$errorEmail         =0;
$errorPhone         =0;

$idParameter = $_GET["id"];
$Params = $_GET["params"];
echo $idParameter. ' dan ' .$Params;


?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Ubah Data Karyawan dan Tambah Role Karyawan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/norbu-clinic/pasien/main">Home</a></li>
            <li class="breadcrumb-item active">Data Karyawan</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Form Ubah Data Karyawan dan Tambah Role Karyawan</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            
          </div>
        </div>
      </div>
    </div>
  </div>
