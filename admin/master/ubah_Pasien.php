<?php 

include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}

$id_pasien    ="";
$nik          ="";
$name         ="";
$phone        ="";
$address      ="";
$gender       ="Laki-laki";
$placeOfBirth ="";
$DOB          =date("Y-m-d");
$passport     ="";
$country      ="";
$isWNA        ="";
$email        ="";
$avatar       ="";


/*variabel untuk pengecekan error */
$error        = 0;
//$errorNIK     = 0;
//$errorPhone   = 0;
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
      $DOB          = $row["dateOfBirth"];
      $passport     = $row["passport"];
      $country      = $row["country"];
      $isWNA        = $row["isWNA"];
      $email        = $row["email"];
      $avatar       = $row["avatar"];
     
    }else{
        echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Pasien tidak berhasil diubah.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=pasien-data";
                });
                </script>';   
    }
}else{
       echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Pasien tidak berhasil diubah.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=pasien-data";
                });
                </script>';
    
}

if(isset($_POST["simpan"])) {
  $nik          = $_POST["nik"];
  $name         = strtoupper(str_replace("'", "`", $_POST['name']));
  $address      = strtoupper(str_replace("'", "`", $_POST['address']));
  $phone        = $_POST["phone"];
  $email        =$_POST["email"];
  $isWNA        =$_POST["isWNA"];
  $country      = empty($_POST['country']) ? "Indonesia" : $_POST['country'];
  $passport     =$_POST["passport"];
  $gender       =$_POST["gender"];
  $placeOfBirth = strtoupper(str_replace("'", "`", $_POST['placeOfBirth']));
  $DOB          =$_POST["DOB"];
  $avatar       ="../images/".$_FILES["avatar"]["name"];
  $target_dir   = "../images/";
  $target_file  = $target_dir . basename($_FILES["avatar"]["name"]);
  $uploadOk= 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

   /*Pengecekan Error */
   /*
  if($nik == ""){
    $error = 1;
    $errorNIK = 1;
  }else{
    $sql = "select * from master_pasien where nik='$nik' and id<>'$id_pasien'";
    $resultCek = mysqli_query($conn,$sql);
      if(mysqli_num_rows($resultCek) > 0){
        $error = 1;
        $errorNIK = 2;
      }
  }
      
  if($phone == ""){
    $error = 1;
    $errorPhone = 1;
  }else{
    $sql = "select * from master_pasien where phone='$phone' and id<>'$id_pasien'";
    $resultCek = mysqli_query($conn,$sql);
      if(mysqli_num_rows($resultCek) > 0){
        $error = 1;
        $errorPhone = 2;
      }
  }
  */
  if($email == ""){
    $error = 1;
    $errorEmail = 1;
  }else{
    //$sql = "select * from master_pasien where email='$email' and id<>'$id_pasien'";
    $sql = "select * from master_pasien where email='$email' and email !='null' and email !='' and email !='NULL' and id<>'$id_pasien'";
    $resultCek = mysqli_query($conn,$sql);
      if(mysqli_num_rows($resultCek) > 0){
        $error = 1;
        $errorEmail = 2;
      }
  }

  /*End of Pengecekan Error */

  if($error == 0){
    //$max_filesize = 100000;
    if ($_FILES["avatar"]["name"]==""){
      $gbr="";
    }else {
      $gbr="../images/".$_FILES["avatar"]["name"];
        move_uploaded_file($_FILES["avatar"]["tmp_name"],"../images/" .$_FILES["avatar"]["name"]);
    }
      $avatar = $gbr;
      if ($avatar == "" ){
       
        $hasil = mysqli_query($conn, "select avatar from master_pasien 
                    where id='$id_pasien'");
 
        while ($rowResult=mysqli_fetch_array($hasil,MYSQLI_ASSOC)){
          echo $rowResult["avatar"];
          $Foto=$rowResult["avatar"];

        }
          $sql1 = "update master_pasien set nik='$nik', name='$name', phone='$phone', 
                  address='$address', gender='$gender', placeOfBirth='$placeOfBirth', 
                  dateOfBirth='$DOB', passport='$passport', email='$email', 
                  avatar='$Foto',status='Aktif', country='$country', isWNA='$isWNA', 
                  createdAt=NOW() where id='$id_pasien'";
                mysqli_query($conn, $sql1);  
        $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Ubah data pasien') ";
        mysqli_query($conn, $sql_query1);
                echo '<script>
                      swal({
                      title: "Sukses!",
                      text: "Data Pasien berhasil diubah.",
                      type: "success"
                      }).then(function() {
                      window.location = "admin.php?page=master-pasien-data";
                      });
                      </script>';
      }else if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {              
              echo '<script>
                    swal({
                    title: "Maaf!",
                    text: "Upload foto pasien hanya boleh format .JPEG, .JPG, atau .PNG",
                    type: "error"
                    }).then(function() {
                    window.location = "admin.php?page=master-pasien-data";
                    });
                    </script>';
               $uploadOk = 0;
      }else if ($avatar!=""){
                $sql2 = "update master_pasien set nik='$nik', name='$name', phone='$phone', 
                      address='$address', gender='$gender', placeOfBirth='$placeOfBirth', 
                      dateOfBirth='$DOB', passport='$passport',email='$email', 
                      avatar='$avatar',status='Aktif', country='$country', isWNA='$isWNA', 
                      createdAt=NOW() where id='$id_pasien'";
                mysqli_query($conn, $sql2);  
                
                $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Ubah data pasien') ";
                mysqli_query($conn, $sql_query1);
                
                echo '<script>
                      swal({
                      title: "Sukses!",
                      text: "Data Pasien berhasil diubah.",
                      type: "success"
                      }).then(function() {
                      window.location = "admin.php?page=master-pasien-data";
                      });
                      </script>'; 

      }   
        //echo '<meta http-equiv="refresh" content="0;url=admin.php?page=master-pasien-data">';
  }

}

?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Ubah Data Pasien</h1>
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
             <form action="" method="POST" enctype="multipart/form-data">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <input type="hidden" class="form-control-sm" name="id_pasien" id="id_pasien" value="<?php echo $row['id']; ?>">
                    <div class="form-group ">
                      <label class="text-sm">NIK (Nomor Induk Kependudukan)</label>
                      <input type="text" class="form-control form-control-sm" name="nik" placeholder="Identity Number (KTP/Passport)" id="nik" value="<?php echo $nik; ?>" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Passport (Opsional)</label>
                      <input type="text" class="form-control form-control-sm" id="passport" name="passport" placeholder="Identity Number (Passport)" value="<?php echo $passport; ?>" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Nama <span class="text-warning">*</span></label>
                      <input type="text" class="form-control form-control-sm" id="name" name="name" required placeholder="Full Name" value="<?php echo $name; ?>" />
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
                      <input type="text" class="form-control form-control-sm" id="phone" name="phone" placeholder="Phone Number" value="<?php echo $phone; ?>" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Kewarganegaraan</label>
                      <select type="text" class="custom-select custom-select-sm" name="isWNA" 
                      id="isWNA" required>
                        <option value="">Your Citizenship</option>
                        <option value="0" <?php if($isWNA == "0") { echo "selected"; } ?>>WNI</option><option value="1" <?php if($isWNA == "1") { echo "selected"; } ?>>WNA</option>
                      
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Country</label>
                      <input type="text" class="form-control form-control-sm" id="country" name="country" placeholder="Country" value="<?php echo $country; ?>" />
                    </div>
                  </div>
                </div>
                <div class="row">
              
                  <!--col-md-6 Gender--> 
                  <div class="col-md-6">
                    <div  class="form-group" >
                      <label class="text-sm">
                        Jenis Kelamin
                      <span class="text-warning">*</span>
                      </label>
                      <div class="col-sm-6">
                        <div class="form-check-inline">
                          <label class="form-check-label" for="rbYa">
                          <input type="radio" class="form-check-input" id="rbPria" name="gender" <?php if($gender == "Laki-laki") { echo "checked"; } ?> value="Laki-laki">Laki-laki
                          </label>
                        </div>
                        <div class="form-check-inline">
                          <label class="form-check-label" for="rbTidak">
                          <input type="radio" class="form-check-input" id="rbWanita" 
                          name="gender"
                          <?php if($gender == "Perempuan") { echo "checked"; } ?> value="Perempuan">Perempuan
                          </label>
                        </div>
                      </div>
                    </div>
                    <!--Akhir form group Radio Button Gender-->
                  </div>
                  <!--end of col-md-6 Gender--> 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Alamat <span class="text-warning">*</span></label>
                      <input type="text" class="form-control form-control-sm" id="address" name="address" required placeholder="Address" value="<?php echo $address; ?>" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Tempat Lahir <span class="text-warning">*</span></label>
                      <input type="text" class="form-control form-control-sm" name="placeOfBirth" 
                      id="placeOfBirth" required placeholder="Place of Birth" value="<?php echo $placeOfBirth; ?>" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Tanggal Lahir <span class="text-warning">*</span></label>
                      <input type="date" class="form-control form-control-sm" name="DOB" id="DOB" required placeholder="Date of Birth" value="<?php echo $DOB; ?>" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Email </label>
                      <span class="help-block">
                      <?php
                     
                        if($errorEmail == 2){
                          echo '<div class="alert alert-danger">Maaf! Email sudah ada di sistem.</div>';
                        }
                      
                      ?>
                      </span>
                      <input type="text" class="form-control form-control-sm" name="email" 
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
                        <div class="col-sm-3">
                          <input type="file" name="avatar" value="<?php echo $avatar; ?>">
                        </div>
                      </div>
                      <div class="col-sm-10">
                          <span style="color:blue; font-weight:bold;">Format Foto: .JPEG,.JPG, atau .PNG</span>
                      </div>
                  </div>
                </div>
              
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" name="simpan" class="btn btn-success btn-sm"><i class="far fa-save"> Simpan</i></button>
                <a class="btn btn-secondary btn-sm" href="admin.php?page=master-pasien-data"><i class="fas fa-arrow-left"> Kembali</i></a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>