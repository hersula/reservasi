<?php 

include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}

$nameType = "";

/*
$error = 0;
$errorNameType= 0;
*/

if(isset($_GET["id"])){
  $id_tipe_client = $_GET["id"];
    $sql = "select * from master_tipe_client where id='$id_tipe_client'";
    $result = mysqli_query($conn,$sql);
    if($row = mysqli_fetch_array($result)){
      $id_tipe_client     = $row["id"];
      $nameType           = $row["nameType"];
    }else{
        echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Tipe Klien tidak berhasil dilihat.",
                type: "error"
                }).then(function() {
                window.location="admin.php?page=tipe-klien-data";
                });
                </script>';    
    }
    
     $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Lihat data tipe klien') ";
     mysqli_query($conn, $sql_query1);
}else{
        echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Tipe Klien tidak berhasil dilihat.",
                type: "error"
                }).then(function() {
                window.location="admin.php?page=tipe-klien-data";
                });
                </script>';
    
}

?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Lihat Data Tipe Klien</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/norbu-clinic/pasien/main">Home</a></li>
            <li class="breadcrumb-item active">Data Tipe Klien</li>
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
              <h3 class="card-title">Form Lihat Data Tipe Klien</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="" method="POST">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group ">
                      <label class="text-sm">Nama Tipe Klien
                      <!--
                      <span class="text-warning">*</span>
                      -->
                      </label>
                      <span class="help-block">
                      <?php
                        /*
                        if($errorNameType == 2){
                          echo '<div class="alert alert-danger">Maaf! Nama Tipe Klien sudah ada di sistem.</div>';
                        }
                        */
                      ?>
                      </span>
                      <input readonly required type="text" class="form-control form-control-sm" name="nameType" placeholder="Nama Tipe Klien" id="nameType" value="<?php echo $nameType; ?>"  />
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
               <div class="card-footer">
                <a class="btn btn-secondary btn-sm" href="admin.php?page=tipe-klien-data"><i class="fas fa-arrow-left"> Kembali</i></a>
              </div>
              </form>
             
       
          </div>
        </div>
      </div>
    </div>
  </div>