<?php 

include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}

$name       = "";
$email      = "";
$phone      ="";
$password   ="";
$outlet     ="";
$role       ="";
$karyawanID ="";

$error              =0;
$errorEmail         =0;
$errorPhone         =0;

if(isset($_POST["simpan"])){
    $name         = $_POST["name"];
    $email        = $_POST["email"];
    $phone        = $_POST["phone"];
    $password     = md5($_POST["password"]);
    $outlet       = $_POST["outlet"];
    $role         = $_POST["role"];
   
  
  //Pengecekan Error
  if($phone == ""){
    $error = 1;
    $errorPhone = 1;
  }else{
    $sql = "select * from master_karyawan where phone='$phone' and id<>'$idKaryawan' and status='Aktif'";
    $cekData = mysqli_query($conn,$sql);
    if(mysqli_num_rows($cekData) > 0){
      $error = 1;
      $errorPhone = 2;
    }
  }
  

  if($email == ""){
    $error = 1;
    $errorEmail = 1;
  }else{
    $sql = "select * from master_karyawan where email='$email' and email !='null' 
            and email !='' and email !='NULL' and id<>'$idKaryawan' and status='Aktif'";
    $cekData = mysqli_query($conn,$sql);
    if(mysqli_num_rows($cekData) > 0){
      $error = 1;
      $errorEmail = 2;
    }
  }


  if($error == 0){
      $sql1 = "insert into master_karyawan (outletID, name, email, phone, password, 
               status, createdAt)
               values ('$outlet', '$name', '$email', '$phone', '$password','Aktif', NOW())";
      mysqli_query($conn, $sql1);

      // query untuk get last id dari tabel master_karyawan
      $result = mysqli_query($conn, "select id from master_karyawan order by id desc LIMIT 1");
 
      // tampilkan last id dari tabel master_karyawan
      while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
        echo $row['id'];
        $karyawanID=$row["id"];
      }

      //perulangan data array dari inputan combobox
      foreach ($_POST['role'] as $value) {
          $sql3= "insert into karyawan_role_list (karyawanID, rolesID, status) 
                  values ('$karyawanID', '".$value."', 'Aktif')";
          mysqli_query($conn, $sql3);
      }
      $sql4 = "update master_outlet set marketingID='$karyawanID' 
               where id='$outlet'";
      mysqli_query($conn, $sql4);
      
      $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Tambah data karyawan') ";
      mysqli_query($conn, $sql_query1);
   
      if(mysqli_error($conn) == "") {
        echo '<script>
                swal({
                title: "Sukses!",
                text: "Data Karyawan baru berhasil ditambahkan ke dalam sistem.",
                type: "success"
                }).then(function() {
                window.location="admin.php?page=karyawan-data";
                });
                </script>';
      }else{
          echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Karyawan baru tidak berhasil ditambahkan ke dalam sistem.",
                type: "error"
                }).then(function() {
                window.location="admin.php?page=karyawan-data";
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
          <h1 class="m-0">Tambah Data Karyawan</h1>
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
              <h3 class="card-title">Form Tambah Data Karyawan</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="" method="POST" enctype="multipart/form-data">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group ">
                      <label class="text-sm">Nama Karyawan
                      <span class="text-warning">*</span>
                      </label>
                      <input required type="text" class="form-control" name="name" placeholder="Nama Karyawan" id="name" value="<?php echo $name; ?>" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group ">         
                      <label class="text-sm">Password
                      <span class="text-warning">*</span>
                      </label>
                      <div class="input-group" id="show_hide_password">
                      <input required type="password" class="form-control" 
                      name="password" placeholder="Password" id="password" 
                      value="<?php echo $password; ?>" autocomplete="off" >
                      <span class="input-group-text" id="basic-addon1">
                        <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                      </span>
                      </div>
                    </div>
                  </div>   
                  <!--end of cold-md-6-->

                </div>
                <!--end of row Nama Karyawan dan Password -->

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
                         <input required type="email" class="form-control form-control-sm" name="email" placeholder="Email" id="email" value="<?php echo $email; ?>" autocomplete="off" >
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Outlet <span class="text-warning">*</span></label>
                      <select type="text" class="custom-select custom-select-sm"  name="outlet" required>
                        <option value="">--Pilih Outlet--</option>
                        <?php
                          $query= "select * from master_outlet where status='Aktif'";
                          $resultOutlet = mysqli_query($conn,$query);
                            while($rowOutlet = mysqli_fetch_array($resultOutlet)){
                            ?> 
                        <option value="<?php echo $rowOutlet["id"]; ?>"
                            <?php
                              if($rowOutlet["id"] == $outlet){
                                echo "selected";
                              } ?>
                              ><?php echo $rowOutlet["name"]; ?></option><?php
                              }
                            ?>
                      </select>
                    </div>
                  </div>
                  <!--end of col-md-6-->
                </div>
                 <!--end of row Email dan Outlet-->

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group ">
                      <label class="text-sm">Nomor Handphone
                      <span class="text-warning">*</span>
                      </label>
                      <span class="help-block">
                      <?php
                        if($errorPhone == 2){
                          echo '<div class="alert alert-danger">Maaf! Nomor handphone  yang dimasukkan ini sudah ada di sistem.</div>';
                        }
                      ?>
                      </span>
                      <input required type="text" class="form-control" name="phone" placeholder="Nomor Handphone" id="phone" value="<?php echo $phone; ?>" autocomplete="off" >
                    </div>
                  </div> 
                  <!--end of col-md-6--> 

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Role <span class="text-warning">*</span></label>
                      <select multiple="multiple" class="custom-select custom-select-sm" id="role" name="role[]" required>
                        <option value="">--Pilih Role--</option>
                        <?php
                          $DB= "select * from master_roles where status='Aktif'";
                          $resultRole = mysqli_query($conn,$DB);
                            while($rowRole = mysqli_fetch_array($resultRole)){
                            ?> 
                        <option value="<?php echo $rowRole["id"]; ?>"
                            <?php
                              if($rowRole["id"] == $role){
                                echo "selected";
                              } ?>
                              ><?php echo $rowRole["roleName"]; ?></option><?php
                              }
                            ?>
                      </select>
                    </div>
                  </div>
                  <!--end of col-md-6-->

             
                </div>
                <!--end of row Nomor Handphone and Role-->
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" name="simpan" class="btn btn-success btn-sm"><i class="far fa-save"> Simpan</i></button>
                <a class="btn btn-secondary btn-sm" href="admin.php?page=karyawan-data"><i class="fas fa-arrow-left"> Kembali</i></a>
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
