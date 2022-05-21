<?php 

include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}

$name     = "";
$address  ="";
$phone    ="";
$isFaskes ="1";

$error       = 0;
$errorName   = 0;
$errorAddress=0;

if(isset($_POST["simpan"])){
    $name     = $_POST["namaOutlet"];
    $address  = $_POST["alamatOutlet"];
    $phone    = $_POST["telp"];
    $isFaskes =$_POST["isFaskes"];
    
    
  
  //Pengecekan Error
  if($name == ""){
    $error = 1;
    $errorName = 1;
  }else{
    $sql = "select * from master_outlet where name='$name'";
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
    $sql = "select * from master_outlet where address='$address'";
    $cekData = mysqli_query($conn,$sql);
    if(mysqli_num_rows($cekData) > 0){
      $error = 1;
      $errorAddress = 2;
    }
  }


  if($error == 0){
      $query = "insert into master_outlet (marketingID, name, address, phone, isFaskes, status,
                createdAt)
                values ('0', '$name', '$address', '$phone', '$isFaskes', 'Aktif', NOW())";
      mysqli_query($conn, $query);
      
      $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Tambah data outlet') ";
      mysqli_query($conn, $sql_query1);

      if(mysqli_error($conn) == "") {
        echo '<script>
                swal({
                title: "Sukses!",
                text: "Data Outlet baru berhasil ditambahkan ke dalam sistem.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=outlet-data";
                });
                </script>';
      }else{
          echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Outlet baru tidak berhasil ditambahkan ke dalam sistem.",
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
          <h1 class="m-0">Tambah Data Outlet</h1>
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
              <h3 class="card-title">Form Tambah Data Outlet</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="" method="POST">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
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
                      <input required type="text" class="form-control form-control-sm" name="namaOutlet" placeholder="Nama Outlet" id="namaOutlet" value="<?php echo $name; ?>" autocomplete="off" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Nomor Telepon
                       <span class="text-warning">*</span>
                      </label>
                      <input type="text" class="form-control form-control-sm" id="telp" name="telp" placeholder="Nomor Telepon" autocomplete="off" />
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
                      <input required type="text" class="form-control form-control-sm" name="alamatOutlet" placeholder="Alamat Outlet" id="alamatOutlet" value="<?php echo $address; ?>" autocomplete="off" />
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
                          <input type="radio" class="form-check-input" id="isFaskes" name="isFaskes"
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
