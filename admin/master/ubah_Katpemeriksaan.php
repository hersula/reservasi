<?php 

include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}


$nameKat= "";
// $targetGenID="";
// $reagenID="";
$isActive="1";


$error = 0;

$errorNameKat= 0;


if(isset($_GET["id"])){
  $id_kat = $_GET["id"];
    $sql = "select * from master_kat_pemeriksaan 
            where id='$id_kat' and status='1'";
    $result = mysqli_query($conn,$sql);
    if($row = mysqli_fetch_array($result)){
      $id_kat   = $row["id"];
      $nameKat  = $row["kat_pemeriksaan"];
      $isActive    = $row['status'];
    //   $targetGenID = $row["targetGenID"];
    //   $reagenID    = $row["reagenID"];
  
    }else{
        echo '<script>
              swal({
              title: "Maaf!",
              text: "Data Kategori tidak berhasil diubah.",
              type: "error"
              }).then(function() {
              window.location = "admin.php?page=kategori-data";
              });
              </script>';    
    }
}else{
        echo '<script>
              swal({
              title: "Maaf!",
              text: "Data Kategori tidak berhasil diubah.",
              type: "error"
              }).then(function() {
              window.location = "admin.php?page=kategori-data";
              });
              </script>';   
    
}

if(isset($_POST["simpan"])){
    $nameKat = $_POST["kat_pemeriksaan"];
    // $targetGenID  = $_POST["targetGenID"];
    $isActive     = $_POST["status"];
  
   //Pengecekan Error
  if($nameKat   == ""){
    $error = 1;
    $errorNameKat = 1;
  }else{
    $sql = "select * from master_kat_pemeriksaan where kat_pemeriksaan='$nameKat' and id<>'$id_kat'";
    $cekData = mysqli_query($conn,$sql);
    if(mysqli_num_rows($cekData) > 0){
      $error = 1;
      $errorNameKat = 2;
    }
  }


  if($error == 0){
      $sql2 = "update master_kat_pemeriksaan set kat_pemeriksaan='$nameKat', status='$isActive' 
              where id='$id_kat'";
      mysqli_query($conn, $sql2);
     
       $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Ubah data Kategori Pemeriksaan') ";
        mysqli_query($conn, $sql_query1);

      if(mysqli_error($conn) == "") {
          echo '<script>
                swal({
                title: "Sukses!",
                text: "Data Kategori berhasil diubah.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=kategori-data";
                });
                </script>';   
          
      }
      else{
          echo '<script>
              swal({
              title: "Maaf!",
              text: "Data Kategori tidak berhasil diubah.",
              type: "error"
              }).then(function() {
              window.location = "admin.php?page=kategori-data";
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
          <h1 class="m-0">Ubah Data Kategori Pemeriksaan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/norbu-clinic/pasien/main">Home</a></li>
            <li class="breadcrumb-item active">Data Kategori</li>
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
              <h3 class="card-title">Form Ubah Data Kategori Pemeriksaan</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="" method="POST">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group ">
                      <label class="text-sm">Nama Kategori
                      <span class="text-warning">*</span>
                      </label>            
                      <span class="help-block">
                      <?php                      
                        if($errorNameKat == 2){
                          echo '<div class="alert alert-danger">Maaf! Nama Kategori sudah ada di sistem.</div>';
                        }                 
                      ?>
                      </span>
                      <input required type="text" class="form-control" name="nameKat" placeholder="Nama Kategori" id="nameKat" value="<?php echo $nameKat; ?>" autocomplete="off" />
                    </div>
                  </div>
                  <!--end of col-md-6-->
                </div>
                 <!--end of row Reagen dan Target Gen-->

                <!--row isActive(Aktif dipakai sekarang?)-->
                <div class="row">
                  <div class="col-md-6">
                    <div  class="form-group" >
                      <label class="text-sm">
                        Aktif dipakai sekarang?
                      <span class="text-warning">*</span>
                      </label>
                      <div class="col-sm-6">
                        <div class="form-check-inline">
                          <label class="form-check-label" for="rbYa">
                          <input type="radio" class="form-check-input" id="isActive" name="isActive" <?php if($isActive == "1") { echo "checked"; } ?> value="1">Ya
                          </label>
                        </div>
                        <div class="form-check-inline">
                          <label class="form-check-label" for="rbTidak">
                          <input type="radio" class="form-check-input" id="isActive" 
                          name="isActive"
                          <?php if($isActive == "0") { echo "checked"; } ?> value="0">Tidak
                          </label>
                        </div>
                      </div>
                    </div>
                    <!--Akhir form group Radio Button isActive(Aktif dipakai sekarang?)-->
                  </div>
                  <!--end of col-md-6--> 
                </div>
                <!--end of row isActive(Aktif dipakai sekarang?)-->
              </div>
              <!-- /.card-body -->
               <div class="card-footer">
                <button type="submit" name="simpan" class="btn btn-success btn-sm"><i class="far fa-save"> Simpan</i></button>
                <a class="btn btn-secondary btn-sm" href="admin.php?page=kategori-data"><i class="fas fa-arrow-left"> Kembali</i></a>
              </div>
              </form>
             
       
          </div>
        </div>
      </div>
    </div>
  </div>