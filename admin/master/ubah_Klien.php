<?php 

include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}

$typeClientID="";
$nameClient = "";
$address    ="";
$phone      ="";


$error              = 0;
/*
$errorNameClient    = 0;
$errorAddress       =0;
$errorPhone         =0;
*/

if(isset($_GET["id"])){
  $id_client = $_GET["id"];
    $sql = "select * from master_client where id='$id_client'";
    $result = mysqli_query($conn,$sql);
    if($row = mysqli_fetch_array($result)){
      $id_client          = $row["id"];
      $typeClientID       = $row["typeClientID"];
      $nameClient         = $row["nameClient"];
      $address            = $row["address"];
      $phone              = $row["phone"];
    }else{
        echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Klien tidak berhasil diubah.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=klien-data";
                });
                </script>';    
    }
}else{
        echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Klien tidak berhasil diubah.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=klien-data";
                });
                </script>';
    
}

if(isset($_POST["simpan"])){
    $typeClientID  = $_POST["typeClientID"];
    $nameClient    = $_POST["nameClient"];
    $address       = $_POST["address"];
    $phone         = $_POST["phone"];
  
  //Pengecekan Error
  /*
  if($nameClient == ""){
    $error = 1;
    $errorNameClient = 1;
  }else{
    $sql = "select * from master_client where nameClient='$nameClient'";
    $cekData = mysqli_query($conn,$sql);
    if(mysqli_num_rows($cekData) > 0){
      $error = 1;
      $errorNameClient = 2;
    }
  }

  if($address == ""){
    $error = 1;
    $errorAddress = 1;
  }else{
    $sql = "select * from master_client where address='$address'";
    $cekData = mysqli_query($conn,$sql);
    if(mysqli_num_rows($cekData) > 0){
      $error = 1;
      $errorAddress = 2;
    }
  }

  if($phone == ""){
    $error = 1;
    $errorPhone = 1;
  }else{
    $sql = "select * from master_client where phone='$phone'";
    $cekData = mysqli_query($conn,$sql);
    if(mysqli_num_rows($cekData) > 0){
      $error = 1;
      $errorPhone = 2;
    }
  }
  */

  if($error == 0){
      $sql_query = "update master_client set typeClientID='$typeClientID', 
                    nameClient='$nameClient', address='$address', phone='$phone' 
                    where id='$id_client'";
      mysqli_query($conn, $sql_query);
      
      $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Ubah data klien') ";
      mysqli_query($conn, $sql_query1);

      if(mysqli_error($conn) == "") {
        echo '<script>
                swal({
                title: "Sukses!",
                text: "Data Klien berhasil diubah.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=klien-data";
                });
                </script>';
      }else{
          echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Klien tidak berhasil diubah.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=klien-data";
                });
                </script>';
      }
  }
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Ubah Data Klien</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/norbu-clinic/pasien/main">Home</a></li>
            <li class="breadcrumb-item active">Data Klien</li>
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
              <h3 class="card-title">Form Ubah Data Klien</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="" method="POST">
              <div class="card-body">
                <div class="row">
                 <div class="col-md-6">
                    <div class="form-group ">
                      <label class="text-sm">Nama Klien
                      <span class="text-warning">*</span>
                      </label>
                      <span class="help-block">
                      <?php
                        /*
                        if($errorNameClient == 2){
                          echo '<div class="alert alert-danger">Maaf! Nama Klien sudah ada di sistem.</div>';
                        }
                        */
                      ?>
                      </span>
                      <input required type="text" class="form-control form-control-sm" name="nameClient" placeholder="Nama Klien" id="nameClient" 
                      value="<?php echo $nameClient; ?>" autocomplete="off" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group ">
                      <label class="text-sm">Alamat 
                      <!--
                      <span class="text-warning">*</span>
                      -->
                      </label>
                      <span class="help-block">
                      <?php
                        /*
                        if($errorAddress == 2){
                          echo '<div class="alert alert-danger">Maaf! Alamat Klien sudah ada di sistem.</div>';
                        }
                        */
                      ?>
                      </span>
                      <input type="text" class="form-control form-control-sm" name="address" placeholder="Alamat Klien" id="address" value="<?php echo $address; ?>" autocomplete="off" />
                    </div>
                  </div>
                </div>
                <!--row tipe klien dan telepon klien-->
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Tipe Klien
                        <span class="text-warning">*</span>
                      </label>
                      <select id="typeClientID" name="typeClientID" class="custom-select custom-select-sm" required>
                        <option value="">--Pilih Tipe Klien--</option>
                        <?php
                          $query= "select * from master_tipe_client";
                          $resultTipeKlien = mysqli_query($conn,$query);
                            while($rowTipeKlien = mysqli_fetch_array($resultTipeKlien)){
                            ?> 
                        <option value="<?php echo $rowTipeKlien["id"]; ?>"
                            <?php
                              if($rowTipeKlien["id"] == $typeClientID){
                                echo "selected";
                              } ?>
                              ><?php echo $rowTipeKlien["nameType"]; ?></option><?php
                              }
                            ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Nomor Telepon
                       <!--
                       <span class="text-warning">*</span>
                       -->
                      </label>
                      <span class="help-block">
                      <?php
                        /*
                        if($errorPhone == 2){
                          echo '<div class="alert alert-danger">Maaf! Nomor telepon klien sudah ada di sistem.</div>';
                        }
                        */
                      ?>
                      </span>
                      <input type="text" class="form-control form-control-sm" id="phone" name="phone" placeholder="Nomor Telepon" autocomplete="off" value="<?php echo $phone; ?>"/>
                    </div>
                  </div>
                </div>
                 <!--end of row tipe klien dan telepon klien-->
              </div>
              <!-- /.card-body -->
               <div class="card-footer">
                <button type="submit" name="simpan" class="btn btn-success btn-sm"><i class="far fa-save"> Simpan</i></button>
                <a class="btn btn-secondary btn-sm" href="admin.php?page=klien-data"><i class="fas fa-arrow-left"> Kembali</i></a>
              </div>
              </form>
             
       
          </div>
        </div>
      </div>
    </div>
  </div>
