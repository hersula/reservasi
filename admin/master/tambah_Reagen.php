<?php 

include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}


$nameReagen= "";
$targetGenID="";
$isActive="1";

$error = 0;
$errorNameReagen= 0;

if(isset($_POST["simpan"])){
    $nameReagen   = $_POST["nameReagen"];
    $targetGenID  = $_POST["targetGenID"];
    $isActive     = $_POST["isActive"];

  
  //Pengecekan Error
  if($nameReagen   == ""){
    $error = 1;
    $errorNameReagen = 1;
  }else{
    $sql = "select * from master_reagen where nameReagen='$nameReagen'";
    $cekData = mysqli_query($conn,$sql);
    if(mysqli_num_rows($cekData) > 0){
      $error = 1;
      $errorNameReagen = 2;
    }
  }
 


  if($error == 0){
      $sql_query = "insert into master_reagen (nameReagen, isActive, status)
               values ('$nameReagen', '$isActive', 'Aktif')";
      mysqli_query($conn, $sql_query);

      // query untuk get last id dari tabel master_reagen
      $result = mysqli_query($conn, "select id from master_reagen order by id desc LIMIT 1");
 
      // tampilkan last id dari tabel master_reagen
      while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
        echo $row['id'];
        $reagenID=$row["id"];

      }

      //perulangan data array dari inputan combobox
      foreach ($_POST['targetGenID'] as $value) {
          $sql3= "insert into target_gen_list (reagenID, targetGenID, status) 
                  values ('$reagenID', '".$value."', 'Aktif')";
          mysqli_query($conn, $sql3);
      }

       $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Tambah data reagen') ";
        mysqli_query($conn, $sql_query1);

      if(mysqli_error($conn) == "") { 
        echo '<script>
                swal({
                title: "Sukses!",
                text: "Data Reagen baru berhasil ditambahkan ke dalam sistem.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=reagen-data";
                });
                </script>'; 
      }else{
        echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Reagen baru tidak berhasil ditambahkan ke dalam sistem.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=reagen-data";
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
          <h1 class="m-0">Tambah Data Reagen</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/norbu-clinic/pasien/main">Home</a></li>
            <li class="breadcrumb-item active">Data Reagen</li>
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
              <h3 class="card-title">Form Tambah Data Reagen</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="" method="POST">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group ">
                      <label class="text-sm">Nama Reagen
                      <span class="text-warning">*</span>
                      </label>
                      <span class="help-block">
                      <?php
                        if($errorNameReagen == 2){
                          echo '<div class="alert alert-danger">Maaf! Nama Reagen sudah ada di sistem.</div>';
                        }
                      ?>
                      </span>
                      <input required type="text" class="form-control" name="nameReagen" placeholder="Nama Reagen" id="nameReagen" value="<?php echo $nameReagen; ?>" autocomplete="off" />
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Target Gen <span class="text-warning">*</span></label>
                      <select multiple="multiple" class="custom-select custom-select-sm" id="targetGenID" name="targetGenID[]" required>
                        <option value="">--Pilih Target Gen--</option>
                        <?php
                          $query= "select * from master_target_gen where status='Aktif'";
                          $resultTargetGen = mysqli_query($conn,$query);
                            while($rowTargetGen = mysqli_fetch_array($resultTargetGen)){
                            ?> 
                        <option value="<?php echo $rowTargetGen["id"]; ?>"
                            <?php
                              if($rowTargetGen["id"] == $targetGenID){
                                echo "selected";
                              } ?>
                              ><?php echo $rowTargetGen["nameTargetGen"]; ?></option><?php
                              }
                            ?>
                      </select>
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
                <a class="btn btn-secondary btn-sm" href="admin.php?page=reagen-data"><i class="fas fa-arrow-left"> Kembali</i></a>
              </div>
              </form>
             
       
          </div>
        </div>
      </div>
    </div>
  </div>