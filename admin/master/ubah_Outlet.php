<?php 

include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}

$id       ="";
$name     = "";
$address  ="";
$phone    ="";
$isFaskes ="1";

$error       = 0;
$errorName   = 0;
$errorAddress=0;


if(isset($_GET["id"])){
  $id    = $_GET["id"];
    $sql = "select * from master_outlet where id='$id'";
    $result = mysqli_query($conn,$sql);
    if($row = mysqli_fetch_array($result)){
      $id           = $row["id"];
      $name         = $row["name"];
      $address      = $row["address"];
      $phone        = $row["phone"];
      $isFaskes     = $row["isFaskes"];
    }else{
       echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Outlet tidak berhasil diubah.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=outlet-data";
                });
                </script>';  
    }
}else{
        echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Outlet tidak berhasil diubah.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=outlet-data";
                });
                </script>'; 
    
}

if(isset($_POST["simpan"])){
    $name     = $_POST["name"];
    $address  = $_POST["address"];
    $phone    = $_POST["phone"];
    $isFaskes = $_POST["isFaskes"];
  
   //Pengecekan Error
  if($name == ""){
    $error = 1;
    $errorName = 1;
  }else{
    $sql = "select * from master_outlet where name='$name' and id<>'$id'";
    $cekData = mysqli_query($conn,$sql);
    if(mysqli_num_rows($cekData) > 0){
      $error = 1;
      $errorName = 2;
    }
  }

  if($address == ""){
    $error = 1;
    $errorAddress = 1;
  }else{
    $sql = "select * from master_outlet where address='$address' and id<>'$id'";
    $cekData = mysqli_query($conn,$sql);
    if(mysqli_num_rows($cekData) > 0){
      $error = 1;
      $errorAddress = 2;
    }
  }



  if($error == 0){
      $sql2 = "update master_outlet set name='$name', address='$address', phone='$phone', 
              isFaskes='$isFaskes' where id='$id'";
      mysqli_query($conn, $sql2);
      
      $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Ubah data outlet') ";
      mysqli_query($conn, $sql_query1);

      if(mysqli_error($conn) == "") {
          echo '<script>
                swal({
                title: "Sukses!",
                text: "Data Outlet berhasil diubah.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=outlet-data";
                });
                </script>'; 
      }
      else{
          echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Outlet tidak berhasil diubah.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=outlet-data";
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
          <h1 class="m-0">Ubah Data Outlet</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/norbu-clinic/pasien/main">Home</a></li>
            <li class="breadcrumb-item active">Data Outlet</li>
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
              <h3 class="card-title">Form Ubah Data Outlet</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="" method="POST">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                        
                    <input type="hidden" class="form-control-sm" name="id" id="id" value="<?php echo $row['id']; ?>">

                    <div class="form-group ">
                      <label class="text-sm">Nama Outlet
                      <span class="text-warning">*</span>
                      </label>
                      <span class="help-block">
                      <?php                    
                        if($errorName == 2){
                          echo '<div class="alert alert-danger">Maaf! Nama Outlet sudah ada di sistem.</div>';
                        }                    
                      ?>
                      </span>
                      <input required type="text" class="form-control form-control-sm" name="name" placeholder="Nama Outlet" id="name" value="<?php echo $name; ?>" autocomplete="off"/>
                    </div>
                  </div>
                  
                   <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Nomor Telepon
                       <span class="text-warning">*</span>
                      </label>
                      <input type="text" class="form-control form-control-sm" id="phone" name="phone" placeholder="Nomor Telepon" value="<?php echo $phone; ?>" autocomplete="off"/>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group ">
                      <label class="text-sm">Alamat Outlet
                      <span class="text-warning">*</span>
                      </label>
                      <span class="help-block">
                      <?php
                    
                        if($errorAddress == 2){
                          echo '<div class="alert alert-danger">Maaf! Alamat Outlet sudah ada di sistem.</div>';
                        }
                   
                      ?>
                      </span>
                      <input required type="text" class="form-control form-control-sm" name="address" placeholder="Alamat Outlet" id="address" value="<?php echo $address; ?>" autocomplete="off" />
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div  class="form-group" >
                      <label class="text-sm">
                        Termasuk Faskes?
                      <span class="text-warning">*</span>
                      </label>
                      <div class="col-sm-6">
                        <div class="form-check-inline">
                          <label class="form-check-label" for="rbYa">
                          <input type="radio" class="form-check-input" id="isFaskes" name="isFaskes" <?php if($isFaskes == "1") { echo "checked"; } ?> value="1">Ya
                          </label>
                        </div>
                        <div class="form-check-inline">
                          <label class="form-check-label" for="rbTidak">
                          <input type="radio" class="form-check-input" id="radio2" name="isFaskes"
                          <?php if($isFaskes == "0") { echo "checked"; } ?> value="0">Tidak
                          </label>
                        </div>
                      </div>
                    </div>
                    <!--Akhir form group Radio Button isFaskes-->
                  </div>

                </div>
                 <!--end of row alamat dan isFaskes-->
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" name="simpan" class="btn btn-success btn-sm"><i class="far fa-save"> Simpan</i></button>
                <a class="btn btn-secondary btn-sm" href="admin.php?page=outlet-data"><i class="fas fa-arrow-left"> Kembali</i></a>
              </div>
            </form> 
          </div>
        </div>
      </div>
    </div>
  </div>