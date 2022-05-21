v<?php 

include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}

$id_pasien    ="";
$nik          ="";
$name         ="";
$phone        ="";
$address      ="";
$gender       ="";
$placeOfBirth ="";
$dateofbirth  =date("Y-m-d");
$passport     ="";
$country      ="";
$isWNA        ="";
$email        ="";
$avatar       ="";


/*variabel untuk pengecekan error */
$error        = 0;
$errorNIK     = 0;
$errorPhone   = 0;
$errorEmail   = 0;
/*end of variabel untuk pengecekan error*/


if(isset($_GET["id"])){
  $id_pasien    = $_GET["id"];
    $sql = "select * from master_pasien where id='$id_pasien'";
    $result = mysqli_query($conn,$sql);
    if($row = mysqli_fetch_array($result)){
      $id_pasien    = $row["id"];
      $nik          = $row["nik"];
      $name         = $row["name"];
      $phone        = $row["phone"];
      $address      = $row["address"];
      $gender       = $row["gender"];
      $placeOfBirth = $row["placeOfBirth"];
      $dateOfBirth  = $row["dateOfBirth"];
      $passport     = $row["passport"];
      $country      = $row["country"];
      $isWNA        = $row["isWNA"];
      $email        = $row["email"];
      $avatar       = $row["avatar"];
     
    }else{    
        echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Pasien tidak berhasil dilihat.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=master-pasien-data";
                });
                </script>';  
    }
    
        $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Lihat data pasien') ";
        mysqli_query($conn, $sql_query1);
}else{
         echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Pasien tidak berhasil dilihat.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=master-pasien-data";
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
          <h1 class="m-0">Ubah Data Outlet</h1>
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
              <h3 class="card-title">Form Ubah Data Pasien</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
             <form action="" method="POST">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <input type="hidden" class="form-control-sm" name="id_pasien" id="id_pasien" value="<?php echo $row['id']; ?>">
                    <div class="form-group ">
                      <label class="text-sm">NIK (Nomor Induk Kependudukan)</label>
                      <input readonly type="text" class="form-control form-control-sm" name="nik" placeholder="Identity Number (KTP/Passport)" id="nik" value="<?php echo $nik; ?>" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Passport (Opsional)</label>
                      <input readonly type="text" class="form-control form-control-sm" id="passport" name="passport" placeholder="Identity Number (Passport)" value="<?php echo $passport; ?>" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Nama 
                        <!--
                        <span class="text-warning">*</span>
                       -->
                      </label>
                      <input readonly type="text" class="form-control form-control-sm" id="name" name="name" required placeholder="Full Name" value="<?php echo $name; ?>" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Nomor Handphone</label>
                      <span class="help-block">
                      <?php
                      /*
                        if($errorPhone == 2){
                          echo '<div class="alert alert-danger">Maaf! Nomor Handphone sudah ada di sistem.</div>';
                        }
                        */
                      ?>
                      </span>
                      <input readonly type="text" class="form-control form-control-sm" id="phone" name="phone" placeholder="Phone Number" value="<?php echo $phone; ?>" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Kewarganegaraan</label>
                      <select disabled type="text" class="custom-select custom-select-sm" 
                      name="isWNA" id="isWNA" required>
                        <option value="">Your Citizenship</option>
                        <option value="0" <?php if($isWNA == "0") { echo "selected"; } ?>>WNI</option><option value="1" <?php if($isWNA == "1") { echo "selected"; } ?>>WNA</option>
                      
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Country</label>
                      <input readonly type="text" class="form-control form-control-sm" id="country" name="country" placeholder="Country" value="<?php echo $country; ?>" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Jenis Kelamin 
                        <!--
                        <span class="text-warning">*</span>
                        -->
                      </label>
                      <select disabled type="text" class="custom-select custom-select-sm" id="gender" name="gender" required>
                        <option value="">Your Gender</option>
                        <option value="Laki-laki" <?php if($gender == "Laki-laki") { echo "selected"; } ?>>Laki-laki</option>  
                        <option value="Laki-laki" <?php if($gender == "Perempuan") { echo "selected"; } ?>>Perempuan</option>  
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Alamat 
                        <!--
                        <span class="text-warning">*</span>
                        -->
                      </label>
                      <input readonly type="text" class="form-control form-control-sm" id="address" name="address" required placeholder="Address" value="<?php echo $address; ?>" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Tempat Lahir
                        <!-- 
                        <span class="text-warning">*</span>
                        -->
                      </label>
                      <input readonly type="text" class="form-control form-control-sm" name="placeOfBirth" 
                      id="placeOfBirth" required placeholder="Place of Birth" value="<?php echo $placeOfBirth; ?>" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Tanggal Lahir 
                        <!--
                        <span class="text-warning">*</span>
                        -->
                      </label>
                      <input readonly type="date" class="form-control form-control-sm" name="dateOfBirth" id="dateOfBirth" required placeholder="Date of Birth" value="<?php echo $dateOfBirth; ?>" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Email </label>
                      <span class="help-block">
                      <?php
                      /*
                        if($errorEmail == 2){
                          echo '<div class="alert alert-danger">Maaf! Email sudah ada di sistem.</div>';
                        }
                        */
                      ?>
                      </span>
                      <input readonly type="text" class="form-control form-control-sm" name="email" 
                      id="email" placeholder="Email" value="<?php echo $email; ?>" />
                    </div>
                  </div>
                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="UploadFoto" style="padding-top:9px;">Foto</label>
                        <div class="col-sm-3">
                        <?php 
                        $queryFoto= "select avatar from master_pasien where avatar='$avatar'";
                        $cekFoto = mysqli_query($conn,$queryFoto);
                        if($getRow = mysqli_fetch_array($cekFoto)){
                          if($getRow['avatar']=='' || $getRow['avatar']=='null' ||
                            $getRow['avatar']=='NULL') {
                          ?>
                            <img src="../images/icon_avatar.png" width='210' height='200'>
                          <?php
                          }else {
                            ?>
                            <img src="<?php echo $row['avatar']; ?>" width='210' height='200'>
                          <?php
                          }
                        }
                        ?>
                        </div>
                      </div>
                  </div>
                </div>
              
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <a class="btn btn-secondary btn-sm" href="admin.php?page=master-pasien-data"><i class="fas fa-arrow-left"> Kembali</i></a>
              </div>
            </form>
            
      
          </div>
        </div>
      </div>
    </div>
  </div>