<?php 

include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}

$idHasilTes     ="";
$idTransaction  ="";
$idPasien       ="";
$pemeriksaan    ="";
$spesimen       ="";
$hasil          ="";
$keterangan     ="";
$nameTargetGen  ="";
$gen0           ="";
$gen1           ="";
$gen2           ="";
$gen3           ="";
$gen4           ="";
$gen5           ="";

if(isset($_GET["id"])){
  $idHasilTes = $_GET["id"];
    $sql = "select * from master_hasil_tes where id='$idHasilTes'";
    $result = mysqli_query($conn,$sql);
    if($row = mysqli_fetch_array($result)){
      $idHasilTes     = $row["id"];
      $idTransaction  = $row["idTransaction"];
      $idPasien       = $row["idPasien"];
      $pemeriksaan    = $row["pemeriksaan"];
      $spesimen       = $row["spesimen"];
      $hasil          = $row["hasil"];
      $keterangan     = $row["keterangan"];
      $nameTargetGen  = $row["nameTargetGen"];
      $gen0           = $row["gen0"];
      $gen1           = $row["gen1"];
      $gen2           = $row["gen2"];
      $gen3           = $row["gen3"];
      $gen4           = $row["gen4"];
      $gen5           = $row["gen5"];
    }else{
        echo '<script>
                setTimeout(function() {
                swal({
                title: "Maaf!",
                text: "Data Hasil Tes tidak berhasil diubah.",
                type: "error"
                }, function() {
                window.location.href="admin.php?page=master-hasil-tes-data";
                });
                }, 1000);
                </script>';   
        echo '<script>
              swal({
              title: "Maaf!",
              text: "Data Hasil Tes tidak berhasil diubah.",
              type: "error"
              }).then(function() {
              window.location = "admin.php?page=master-hasil-tes-data";
              });
              </script>';    
    }
}else{
          echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Hasil Tes tidak berhasil diubah.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=master-hasil-tes-data";
                });
                </script>';  
    
}

if(isset($_POST["simpan"])){
    $idTransaction  = $_POST["idTransaction"];
    $idPasien       = $_POST["idPasien"];
    $pemeriksaan    = $_POST["pemeriksaan"];
    $spesimen       = $_POST["spesimen"];
    $hasil          = $_POST["hasil"];
    $keterangan     = $_POST["keterangan"];
    $nameTargetGen  = $_POST["nameTargetGen"];
    $gen0           = $_POST["gen0"];
    $gen1           = $_POST["gen1"];
    $gen2           = $_POST["gen2"];
    $gen3           = $_POST["gen3"];
    $gen4           = $_POST["gen4"];
    $gen5           = $_POST["gen5"];


      $sql2 = "update master_hasil_tes set idTransaction='$idTransaction', idPasien='$idPasien',
              pemeriksaan='$pemeriksaan', spesimen='$spesimen', hasil='$hasil', 
              keterangan='$keterangan', nameTargetGen='$nameTargetGen', gen0='$gen0',
              gen1='$gen1', gen2='$gen2', gen3='$gen3', gen4='$gen4', gen5='$gen5' 
              where id='$idHasilTes'";
      mysqli_query($conn, $sql2);
      
      $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Ubah data master hasil tes') ";
      mysqli_query($conn, $sql_query1);

      if(mysqli_error($conn) == "") {
          echo '<script>
                swal({
                title: "Sukses!",
                text: "Data Hasil Tes berhasil diubah.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=master-hasil-tes-data";
                });
                </script>';  
          
      }else{
          echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Hasil Tes tidak berhasil diubah.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=master-hasil-tes-data";
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
          <h1 class="m-0">Ubah Data Hasil Tes</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/norbu-clinic/pasien/main">Home</a></li>
            <li class="breadcrumb-item active">Data Hasil Tes</li>
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
              <h3 class="card-title">Form Ubah Data Hasil Tes</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="" method="POST" enctype="multipart/form-data">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <input type="hidden" class="form-control-sm" name="idHasilTes" id="idHasilTes" value="<?php echo $row['id']; ?>">
                    <div class="form-group ">
                      <label class="text-sm">ID Transaksi
                      <!--
                      <span class="text-warning">*</span>
                      -->
                      </label>
                      <input readonly type="text" class="form-control form-control-sm" name="idTransaction" placeholder="ID Transaksi" id="idTransaction" value="<?php echo $idTransaction; ?>" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Nama Pasien <span class="text-warning">*</span></label>
                      <select readonly type="text" class="custom-select custom-select-sm" id="idPasien" name="idPasien" required>
                        <option value=""></option>
                        <?php
                          $query1= "select * from master_pasien where status='Aktif'";
                          $resultPasien = mysqli_query($conn,$query1);
                            while($rowPasien = mysqli_fetch_array($resultPasien)){
                            ?> 
                        <option value="<?php echo $rowPasien["id"]; ?>"
                            <?php
                              if($rowPasien["id"] == $idPasien){
                                echo "selected";
                              } ?>
                              ><?php echo $rowPasien["name"]; ?></option><?php
                              }
                            ?>
                      </select>
                    </div>
                    <!--end of form group Nama Pasien-->
                  </div>              
                </div>
                <!--end of row ID Transaksi dan Nama Pasien -->

                <!--row Pemeriksaan dan Spesimen-->
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Pemeriksaan 
                       <span class="text-warning">*</span>
                      </label>
                         <input required type="text" class="form-control form-control-sm" name="pemeriksaan" placeholder="Pemeriksaan" id="pemeriksaan" value="<?php echo $pemeriksaan; ?>" autocomplete="off" >
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Spesimen 
                       <span class="text-warning">*</span>
                      </label>
                         <input required type="text" class="form-control form-control-sm" name="spesimen" placeholder="Spesimen" id="spesimen" value="<?php echo $spesimen; ?>" autocomplete="off" >
                    </div>
                  </div>
                </div>
                 <!--end of row Pemeriksaan dan Spesimen-->

                 <!--row Pemeriksaan dan Spesimen-->
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Hasil
                       <span class="text-warning">*</span>
                      </label>
                         <input required type="text" class="form-control form-control-sm" name="hasil" placeholder="Hasil Tes" id="hasil" value="<?php echo $hasil; ?>" autocomplete="off" >
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Keterangan 
                       <span class="text-warning">*</span>
                      </label>
                         <input required type="text" class="form-control form-control-sm" name="keterangan" placeholder="Keterangan" id="keterangan" value="<?php echo $keterangan; ?>" autocomplete="off" >
                    </div>
                  </div>
                </div>
                 <!--end of row Pemeriksaan dan Spesimen-->

                <!--row nameTargetGen dan Gen0-->
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Nama Target Gen
                       <span class="text-warning">*</span>
                      </label>
                         <input required type="text" class="form-control form-control-sm" name="nameTargetGen" placeholder="Nama Target Gen" id="nameTargetGen" value="<?php echo $nameTargetGen; ?>" autocomplete="off" >
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Gen 0
                      <!--
                       <span class="text-warning">*</span>
                      -->
                      </label>
                         <input type="text" class="form-control form-control-sm" name="gen0" placeholder="Gen 0" id="gen0" value="<?php echo $gen0; ?>" autocomplete="off" >
                    </div>
                  </div>
                </div>
                 <!--end of row nameTargetGen dan Gen0-->

                <!--row Gen1 dan Gen2-->
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Gen 1
                      <!--
                       <span class="text-warning">*</span>
                      -->
                      </label>
                         <input type="text" class="form-control form-control-sm" name="gen1" id="gen1"  placeholder="Gen 1" value="<?php echo $gen1; ?>" autocomplete="off" >
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Gen 2
                      <!--
                       <span class="text-warning">*</span>
                      -->
                      </label>
                         <input type="text" class="form-control form-control-sm" name="gen2" id="gen2"  placeholder="Gen 2" value="<?php echo $gen2; ?>" autocomplete="off" >
                    </div>
                  </div>
                </div>
                 <!--end of row Gen1 dan Gen2-->

                <!--row Gen3 dan Gen4-->
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Gen 3
                      <!--
                       <span class="text-warning">*</span>
                      -->
                      </label>
                         <input type="text" class="form-control form-control-sm" name="gen3" id="gen3"  placeholder="Gen 3" value="<?php echo $gen3; ?>" autocomplete="off" >
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Gen 4
                      <!--
                       <span class="text-warning">*</span>
                      -->
                      </label>
                         <input type="text" class="form-control form-control-sm" name="gen4" id="gen4"  placeholder="Gen 4" value="<?php echo $gen4; ?>" autocomplete="off" >
                    </div>
                  </div>
                </div>
                 <!--end of row Gen1 dan Gen2-->

                <!--row Gen5-->
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Gen 5
                      <!--
                       <span class="text-warning">*</span>
                      -->
                      </label>
                         <input type="text" class="form-control form-control-sm" name="gen5" id="gen5"  placeholder="Gen 5" value="<?php echo $gen5; ?>" autocomplete="off" >
                    </div>
                  </div>

                  <div class="col-md-6">
                    
                  </div>
                </div>
                 <!--end of row Gen5-->


              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" name="simpan" class="btn btn-success btn-sm"><i class="far fa-save"> Simpan</i></button>
                <a class="btn btn-secondary btn-sm" href="admin.php?page=master-hasil-tes-data"><i class="fas fa-arrow-left"> Kembali</i></a>
              </div>
            </form>
             
      
          </div>
        </div>
      </div>
    </div>
  </div>