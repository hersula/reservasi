<?php 

include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}

$typeClientID="";
$nameClient = "";
$address    ="";
$phone      ="";


/*
$error              = 0;
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
                text: "Data Klien tidak berhasil dilihat.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=klien-data";
                });
                </script>';    
    }
    
    $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Lihat data klien') ";
    mysqli_query($conn, $sql_query1);
}else{
        echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Klien tidak berhasil dilihat.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=klien-data";
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
          <h1 class="m-0">Lihat Data Klien</h1>
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
              <h3 class="card-title">Form Lihat Data Klien</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="" method="POST">
              <div class="card-body">
                <div class="row">
                 <div class="col-md-6">
                    <div class="form-group ">
                      <label class="text-sm">Nama Klien
                      <!--
                      <span class="text-warning">*</span>
                      -->
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
                      <input readonly required type="text" class="form-control form-control-sm" name="nameClient" placeholder="Nama Klien" id="nameClient" 
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
                      <input readonly type="text" class="form-control form-control-sm" name="address" placeholder="Alamat Klien" id="address" value="<?php echo $address; ?>" autocomplete="off" />
                    </div>
                  </div>
                </div>
                <!--row tipe klien dan telepon klien-->
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Tipe Klien
                        <!--
                        <span class="text-warning">*</span>
                      -->
                      </label>
                      <select disabled id="typeClientID" name="typeClientID" class="custom-select custom-select-sm" required>
                        <option value="">--Pilih Tipe Klien--</option>
                        <?php
                          $query= "select * from master_tipe_client where status='Aktif'";
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
                      <input readonly type="text" class="form-control form-control-sm" id="phone" name="phone" placeholder="Nomor Telepon" autocomplete="off" value="<?php echo $phone; ?>"/>
                    </div>
                  </div>
                </div>
                 <!--end of row tipe klien dan telepon klien-->
              </div>
              <!-- /.card-body -->
               <div class="card-footer">
                <a class="btn btn-secondary btn-sm" href="admin.php?page=klien-data"><i class="fas fa-arrow-left"> Kembali</i></a>
              </div>
              </form>
             
       
          </div>
        </div>
      </div>
    </div>
  </div>
