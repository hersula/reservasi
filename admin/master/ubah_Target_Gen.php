<?php 

include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}


$nameTargetGen= "";

$error = 0;
$errorNameTargetGen= 0;


if(isset($_GET["id"])){
  $id_target_gen = $_GET["id"];
    $sql = "select * from master_target_gen where id='$id_target_gen'";
    $result = mysqli_query($conn,$sql);
    if($row = mysqli_fetch_array($result)){
      $id_target_gen        = $row["id"];
      $nameTargetGen       = $row["nameTargetGen"];
    }else{
        echo '<script>
              swal({
              title: "Maaf!",
              text: "Data Target Gen tidak berhasil diubah.",
              type: "error"
              }).then(function() {
              window.location = "admin.php?page=target-gen-data";
              });
              </script>';    
    }
}else{
         echo '<script>
              swal({
              title: "Maaf!",
              text: "Data Target Gen tidak berhasil diubah.",
              type: "error"
              }).then(function() {
              window.location = "admin.php?page=target-gen-data";
              });
              </script>';   
    
}

if(isset($_POST["simpan"])){
    $nameTargetGen = $_POST["nameTargetGen"];
  
  //Pengecekan Error
  if($nameTargetGen   == ""){
    $error = 1;
    $errorNameTargetGen = 1;
  }else{
    $sql = "select * from master_target_gen where nameTargetGen='$nameTargetGen'";
    $cekData = mysqli_query($conn,$sql);
    if(mysqli_num_rows($cekData) > 0){
      $error = 1;
      $errorNameTargetGen = 2;
    }
  }

  if($error == 0){
      $sql2 = "update master_target_gen set nameTargetGen='$nameTargetGen' where id='$id_target_gen'";
      mysqli_query($conn, $sql2);
      
      $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Ubah data target gen') ";
      mysqli_query($conn, $sql_query1);

      if(mysqli_error($conn) == "") { 
        echo '<script>
                swal({
                title: "Sukses!",
                text: "Data Target Gen baru berhasil diubah.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=target-gen-data";
                });
                </script>'; 
      }else{
        echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Target Gen baru tidak berhasil diubah.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=target-gen-data";
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
          <h1 class="m-0">Ubah Data Target Gen</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/norbu-clinic/pasien/main">Home</a></li>
            <li class="breadcrumb-item active">Data Target Gen</li>
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
              <h3 class="card-title">Form Ubah Data Target Gen</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="" method="POST">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group ">
                      <label class="text-sm">Nama Target Gen
                      <span class="text-warning">*</span>
                      </label>
                      <span class="help-block">
                      <?php
                        if($errorNameTargetGen == 2){
                          echo '<div class="alert alert-danger">Maaf! Nama Target Gen sudah ada di sistem.</div>';
                        }
                      ?>
                      </span>
                      <input required type="text" class="form-control form-control-sm" name="nameTargetGen" placeholder="Nama Target Gen" id="nameTargetGen" value="<?php echo $nameTargetGen; ?>" autocomplete="off" />
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
               <div class="card-footer">
                <button type="submit" name="simpan" class="btn btn-success btn-sm"><i class="far fa-save"> Simpan</i></button>
                <a class="btn btn-secondary btn-sm" href="admin.php?page=target-gen-data"><i class="fas fa-arrow-left"> Kembali</i></a>
              </div>
              </form>
             
       
          </div>
        </div>
      </div>
    </div>
  </div>