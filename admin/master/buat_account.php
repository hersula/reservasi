<?php 

include_once("../connection.php");
include_once("../helper/base_url.php");

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}

$id_pasien    ="";
$nik          ="";
$name         ="";
$email        ="";
$password     ="";

if(isset($_GET["id"])){
  $id_pasien    = $_GET["id"];
    $sql = "select * from master_pasien where id='$id_pasien'";
    $result = mysqli_query($conn,$sql);
    if($row = mysqli_fetch_array($result)){
      $id_pasien    = $row["id"];
      $nik          = $row["nik"];
      $name         = $row["name"];
      $email        = $row["email"];
      $password     = $row["password"];
     
    }else{
        echo '<script>
                swal({
                title: "Maaf!",
                text: "Account Pasien tidak berhasil ditemukan.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=pasien-data";
                });
                </script>';   
    }
}

?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Ubah Account Pasien</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/norbu-clinic/pasien/main">Home</a></li>
            <li class="breadcrumb-item active">Data Pasien</li>
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
              <h3 class="card-title">Form Account Pasien</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
             <form action="<?= BASE_URL . 'admin/master/account/proses_verifikasi_email_account_pasien.php' ?>" method="POST" enctype="multipart/form-data">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <input type="hidden" class="form-control-sm" name="id_pasien" id="id_pasien" value="<?php echo $row['id']; ?>">
                    <div class="form-group ">
                      <label class="text-sm">NIK (Nomor Induk Kependudukan)</label>
                      <input type="text" class="form-control form-control-sm" name="nik" placeholder="Identity Number (KTP/Passport)" id="nik" onkeyup="isi_otomatis()" value="<?php echo $nik; ?>" readonly/>
                    </div>
                  </div>
                  <input type="hidden" name="nik" value="<?php echo $nik; ?>">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Nama 
                      <!--
                      <span class="text-warning">*</span>
                      -->
                      </label>
                      <input type="text" class="form-control form-control-sm" id="name" name="name" required placeholder="Full Name" value="<?php echo $name; ?>" readonly/>
                    </div>
                  </div>
                </div>
                <?php
                    if ($email=='null' || $email=='NULL' || $email=='' || $password=='null' || $password=='NULL' || $password=='') {
                      $readonly = '';
                      $readonly_email = 'readonly';
                      $class = 'fa-eye-slash';
                      $class_type = 'password';
                      $value_pass = '';
                    }else {
                      $readonly = 'readonly';
                      $readonly_email = 'readonly';
                      $class = 'fa-eye-slash';
                      $class_type = 'password';
                      $value_pass = $password;
                    }
                  ?>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Email
                       <span class="text-warning">*</span>
                      </label>
                      <span class="help-block">
                      <?php
                        if($errorEmail == 2){
                          echo '<div class="alert alert-danger">Maaf! Email yang dimasukkan ini sudah ada di sistem.</div>';
                        }
                      ?>
                      </span>
                         <input required type="email" class="form-control form-control-sm" name="email" placeholder="Email" id="email" value="<?php echo $email; ?>" autocomplete="off" <?php echo $readonly_email;?> >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Password <span class="text-warning">*</span></label>
                      <div class="input-group mb-3">
                        <input type="<?=$class_type?>" name="password" class="form-control" placeholder="Password" id="form-password" required oninvalid="this.setCustomValidity('Password wajib diisi!')" oninput="setCustomValidity('')" autocomplete="off" value="<?php echo $value_pass;?>" <?php echo $readonly; ?> >
                        <span class="input-group-text" id="basic-addon1">
                          <span toggle="#password-field" class="fa fa-fw <?=$class?> field_icon toggle-password2">
                          </span>
                        </span>
                      </div>
                    </div>

                  </div>
                </div>
              
              </div>

              <!-- /.card-body -->

              <div class="card-footer">
                <?php
                  if ($email=='null' || $email=='NULL' || $email=='' || $password=='null' || $password=='NULL' || $password=='') {
                ?>
                  <button type="submit" name="update" class="btn btn-primary btn-sm"><i class="far fa-save"> Update</i></button>
                <?php
                  }else{
                ?>
                  <!-- <button type="submit" name="update" class="btn btn-primary btn-sm"><i class="far fa-save" disabled="disabled"> Update</i></button> -->
                <?php
                  }
                ?>
                <a class="btn btn-secondary btn-sm" href="admin.php?page=master-pasien-data"><i class="fas fa-arrow-left"> Kembali</i></a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>