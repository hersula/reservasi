<?php 

include "../connection.php";
include "../../helper/base_url.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}

$passwordBaru="";
$error = 0;


if(isset($_POST["simpan"])) {
  $name          = $_SESSION["name"];
	$email         = $_SESSION["email"];
  $passwordBaru = md5($_POST["passwordBaru"]);


  if($error == 0){
    $sql2 = "update master_karyawan set password = '$passwordBaru' where email='$email'";
    mysqli_query($conn, $sql2);
    
    
    /*log file*/
    $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Ganti password karyawan yang login') ";
      mysqli_query($conn, $sql_query1);
    /*log file*/
 
      if(mysqli_error($conn) == ""){
        echo '<script>
              swal({
              title: "Sukses!",
              text: "Password baru berhasil diubah.",
              type: "success"
              }).then(function() {
              window.location = "admin.php?page=dashboard";
              });
              </script>';
          
      }else{
        echo '<script>
              swal({
                title: "Maaf!",
                text: "Password baru tidak berhasil diubah.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=dashboard";
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
          <h1 class="m-0">Ubah Password Karyawan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?=BASE_URL?>admin/admin.php">Home</a></li>
            <li class="breadcrumb-item active">Ganti Password Karyawan</li>
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
              <h3 class="card-title">Form Ganti/ Ubah Password Karyawan</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="" method="POST">
              <div class="card-body">
                <div class="row">

                <!--col-md-6 Password Baru-->
                  <div class="col-md-6">
                    <div class="form-group ">
                      <label class="text-sm">Nama Karyawan
                      <!--
                      <span class="text-warning">*</span>
                      -->
                      </label>
                      <input readonly autocomplete="off" required type="text" class="form-control" name="name" placeholder="Karyawan yang Login" id="name" value="<?php echo $_SESSION['name']; ?>" />
                    </div>
                  </div>
                  <!--end of col-md-6 Password Baru-->

                <!--col-md-6 Password Baru-->
                  <div class="col-md-6">
                    <div class="form-group ">
                      <label class="text-sm">Password Baru
                      <span class="text-warning">*</span>
                      </label>
                     <div class="input-group" id="show_hide_password">
                      <input required type="password" class="form-control" 
                      name="passwordBaru" placeholder="Password Baru" id="passwordBaru" value="<?php echo $passwordBaru; ?>" autocomplete="off" >
                      <span class="input-group-text" id="basic-addon1">
                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                      </span>
                      </div>
                    </div>
                  </div>
                  <!--end of col-md-6 Password Baru-->
                </div>
              </div>
              <!-- /.card-body -->
               <div class="card-footer">
                <button type="submit" name="simpan" class="btn btn-success btn-sm"><i class="far fa-save"> Simpan</i></button>
                <a class="btn btn-secondary btn-sm" href="admin.php?page=dashboard"><i class="fas fa-arrow-left"> Kembali</i></a>
              </div>
              </form>
             
       
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
$(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });
});
</script>