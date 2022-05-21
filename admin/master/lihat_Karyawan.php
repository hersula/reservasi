<?php 

include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}

$idKaryawan ="";
$name       ="";
$email      ="";
$phone      ="";
$password   ="";
$outlet     ="";
$roleID     ="";
$karyawanID ="";

$error                =0;
//$errorEmail         =0;
//$errorPhone         =0;

if(isset($_GET["id"])){
    $idKaryawan = $_GET["id"];

    $cekRoleKaryawanList= "select * from karyawan_role_list where karyawanID='$idKaryawan'";
    $cekHasilRKL = mysqli_query($conn,$cekRoleKaryawanList);

    if(mysqli_num_rows($cekHasilRKL) > 0) {
        $sql = "select k.id,k.outletID, k.name, k.email, k.phone, k.password, 
                krl.rolesID as 'rolesID', r.roleName 
                from master_karyawan k join karyawan_role_list krl
                on k.id=krl.karyawanID join master_roles r on r.id=krl.rolesID 
                where k.id='$idKaryawan'";
        $result = mysqli_query($conn,$sql);
        if($row = mysqli_fetch_array($result)){
          $idKaryawan   = $row["id"];
          $outlet       = $row["outletID"];
          $name         = $row["name"];
          $email        = $row["email"];
          $phone        = $row["phone"];
          $password     = $row["password"];
          $roleID       = $row["rolesID"];

        }else{
           echo '<script>
                    swal({
                    title: "Maaf!",
                    text: "Data Karyawan tidak berhasil diubah.",
                    type: "error"
                    }).then(function() {
                    window.location = "admin.php?page=karyawan-data";
                    });
                    </script>';  
        }
    }else{
        $query1 = "select * from master_karyawan where id='$idKaryawan'";
        $result1 = mysqli_query($conn,$query1);
        if($row = mysqli_fetch_array($result1)){
          $idKaryawan   = $row["id"];
          $outlet       = $row["outletID"];
          $name         = $row["name"];
          $email        = $row["email"];
          $phone        = $row["phone"];
          $password     = $row["password"];

        }else{
            echo '<script>
                  swal({
                  title: "Maaf!",
                  text: "Data Karyawan tidak berhasil diubah.",
                  type: "error"
                  }).then(function() {
                  window.location = "admin.php?page=karyawan-data";
                  });
                  </script>';    
        }

    }
    
    $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Lihat data karyawan') ";
     mysqli_query($conn, $sql_query1);
}else{
        echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Karyawan tidak berhasil diubah.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=karyawan-data";
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
          <h1 class="m-0">Lihat Data Karyawan</h1>
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
              <h3 class="card-title">Form Lihat Data Karyawan</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="" method="POST" enctype="multipart/form-data">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group ">
                      <label class="text-sm">Nama Karyawan
                      <!--
                      <span class="text-warning">*</span>
                       -->
                      </label>
                      <input readonly required type="text" class="form-control" name="name" placeholder="Nama Karyawan" id="name" value="<?php echo $name; ?>" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group ">
                      <label class="text-sm">Password
                      <!--
                      <span class="text-warning">*</span>
                      -->
                      </label>
                      <input readonly required type="password" class="form-control" name="password" placeholder="Password" id="password" value="<?php echo $password; ?>" autocomplete="off" >
                    </div>
                  </div>              
                </div>
                <!--end of row Nama Karyawan dan Password -->

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Email
                        <!--
                       <span class="text-warning">*</span>
                        -->
                      </label>
                      <span class="help-block">
                      <?php
                      /*
                        if($errorEmail == 2){
                          echo '<div class="alert alert-danger">Maaf! Email yang dimasukkan ini sudah ada di sistem.</div>';
                        }
                        */
                      ?>
                      </span>
                         <input readonly required type="email" class="form-control form-control-sm" name="email" placeholder="Email" id="email" value="<?php echo $email; ?>" autocomplete="off" >
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Outlet 
                        <!--
                        <span class="text-warning">*</span>
                        -->
                      </label>
                      <select disabled type="text" class="custom-select custom-select-sm"
                       name="outlet" required>
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
                      <!--
                      <span class="text-warning">*</span>
                      -->
                      </label>
                      <span class="help-block">
                      <?php
                      /*
                        if($errorPhone == 2){
                          echo '<div class="alert alert-danger">Maaf! Nomor handphone  yang dimasukkan ini sudah ada di sistem.</div>';
                        }
                        */
                      ?>
                      </span>
                      <input readonly required type="text" class="form-control" name="phone" placeholder="Nomor Handphone" id="phone" value="<?php echo $phone; ?>" autocomplete="off" >
                    </div>
                  </div> 
                  <!--end of col-md-6--> 

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Role 
                        <!--
                        <span class="text-warning">*</span>
                        -->
                      </label>
                      <?php
                        if(isset($_GET["id"])) {
                          $idKaryawan = $_GET["id"];
                          $karyawan_Role="select * from karyawan_role_list where karyawanID='$idKaryawan'";
                          $karyawanResult=mysqli_query($conn,$karyawan_Role);
                          $kr_array=[];
                          foreach($karyawanResult as $rowKr) {
                              $kr_array[]=$rowKr["rolesID"];
                          }
                        }
                      ?>
                 
                      <select disabled multiple="multiple" class="custom-select custom-select-sm" id="role" name="role[]" required>
                        <option value="">--Pilih Role--</option>
                        <?php
                          $DB= "select * from master_roles where status='Aktif'";
                          $resultRole = mysqli_query($conn,$DB);
                            while($rowRole = mysqli_fetch_array($resultRole)){
                            ?> 
                        <option value="<?php echo $rowRole["id"]; ?>"
                            <?php
                              echo in_array($rowRole["id"],$kr_array) ? 'selected':''
                             ?>
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
                <a class="btn btn-secondary btn-sm" href="admin.php?page=karyawan-data"><i class="fas fa-arrow-left"> Kembali</i></a>
              </div>
            </form>
            
          </div>
        </div>
      </div>
    </div>
  </div>