<?php 

include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}

$roleName = "";

$error = 0;
$errorRoleName= 0;


if(isset($_GET["id"])){
  $id_role = $_GET["id"];
    $sql = "select * from master_roles where id='$id_role'";
    $result = mysqli_query($conn,$sql);
    if($row = mysqli_fetch_array($result)){
      $id_role      = $row["id"];
      $roleName     = $row["roleName"];
    }else{
        echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Role tidak berhasil diubah.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=roles-data";
                });
                </script>';    
    }
}else{
        echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Role tidak berhasil diubah.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=roles-data";
                });
                </script>';
    
}

if(isset($_POST["simpan"])){
    $roleName = $_POST["roleName"];
  
  //Pengecekan Error
  if($roleName == ""){
    $error = 1;
    $errorRoleName = 1;
  }else{
    $sql = "select * from master_roles where roleName='$roleName'";
    $cekData = mysqli_query($conn,$sql);
    if(mysqli_num_rows($cekData) > 0){
      $error = 1;
      $errorRoleName = 2;
    }
  }


  if($error == 0){
      $sql2 = "update master_roles set roleName='$roleName' where id='$id_role'";
      mysqli_query($conn, $sql2);
      
      $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Ubah data roles') ";
      mysqli_query($conn, $sql_query1);


      if(mysqli_error($conn) == "") {
          echo '<script>
                swal({
                title: "Sukses!",
                text: "Data Role berhasil diubah.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=roles-data";
                });
                </script>';
      }
      else{
          echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Role tidak berhasil diubah.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=roles-data";
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
          <h1 class="m-0">Ubah Data Roles</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/norbu-clinic/pasien/main">Home</a></li>
            <li class="breadcrumb-item active">Data Roles</li>
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
              <h3 class="card-title">Form Ubah Data Roles</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="" method="POST">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group ">
                      <label class="text-sm">Nama Role
                      <span class="text-warning">*</span></label>
                      <input required type="text" class="form-control form-control-sm" name="roleName" placeholder="Nama Role" id="roleName" value="<?php echo $roleName; ?>" autocomplete="off" />
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            
              <div class="card-footer">
                 <button type="submit" name="simpan" class="btn btn-success btn-sm"><i class="far fa-save"> Simpan</i></button>
                <a class="btn btn-secondary btn-sm" href="admin.php?page=roles-data"><i class="fas fa-arrow-left"> Kembali</i></a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>