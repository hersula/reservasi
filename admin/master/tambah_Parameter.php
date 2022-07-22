<?php 

include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}

$idTindakan = "";
$satuan  ="";
$nilai_min    = 0;
$nilai_max = 0;
$kelamin = "";
$isFaskes ="1";

$error       = 0;
$errorName   = 0;
$errorAddress=0;

if(isset($_POST["simpan"])){
    $idTindakan = $_POST["idTindakan"];
    $satuan = $_POST["satuan"];
    $nilai_min = $_POST["nilai_min"];
    $nilai_max = $_POST["nilai_max"];
    $kelamin = $_POST["kelamin"];
    
  //Pengecekan Error
  // if($idTindakan == ""){
  //   $error = 1;
  //   $errorName = 1;
  // }else{
  //   $sql = "select * from master_tindakan where id='$idTindakan'";
  //   $cekData = mysqli_query($conn,$sql);
  //   if(mysqli_num_rows($cekData) > 0){
  //     $error = 1;
  //     $errorName = 2;
  //   }
  // }

  // if($address == ""){
  //   $error = 1;
  //   $errorAddress = 1;
  // }else{
  //   $sql = "select * from master_outlet where address='$address'";
  //   $cekData = mysqli_query($conn,$sql);
  //   if(mysqli_num_rows($cekData) > 0){
  //     $error = 1;
  //     $errorAddress = 2;
  //   }
  // }


  if($error == 0){
      $query = "insert into master_parameter_lab (tindakanID, satuan, nilai_min, nilai_max, kelamin, status)
                values ('$idTindakan', '$satuan', '$nilai_min', '$nilai_max', '$kelamin', 'Aktif')";
      mysqli_query($conn, $query);
      
      $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Tambah data parameter lab') ";
      mysqli_query($conn, $sql_query1);

      if(mysqli_error($conn) == "") {
        echo '<script>
                swal({
                title: "Sukses!",
                text: "Data Parameter baru berhasil ditambahkan ke dalam sistem.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=parameter-data";
                });
                </script>';
      }else{
          echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Parameter baru tidak berhasil ditambahkan ke dalam sistem.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=parameter-data";
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
          <h1 class="m-0">Tambah Data Parameter</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/norbu-clinic/pasien/main">Home</a></li>
            <li class="breadcrumb-item active">Data Parameter Lab</li>
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
              <h3 class="card-title">Form Tambah Data Parameter</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="" method="POST">
              <div class="card-body">
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Tindakan <span class="text-warning">*</span></label>
                      <select type="text" class="custom-select custom-select-sm"  name="idTindakan" required>
                        <option value="">--Pilih Tindakan--</option>
                        <?php
                          $query= "select * from master_tindakan where status='Aktif' and typeTindakan='LAB'";
                          $resultTindakan = mysqli_query($conn,$query);
                            while($rowTindakan = mysqli_fetch_array($resultTindakan)){
                            ?> 
                        <option value="<?php echo $rowTindakan["id"]; ?>"
                            <?php
                              if($rowTindakan["id"] == $idTindakan){
                                echo "selected";
                              } ?>
                              ><?php echo $rowTindakan["name"]; ?></option><?php
                              }
                            ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Satuan
                       <span class="text-warning">*</span>
                      </label>
                      <input type="text" class="form-control form-control-sm" id="satuan" name="satuan" placeholder="Satuan" autocomplete="off" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="text-sm">Nilai Min
                       <span class="text-warning">*</span>
                      </label>
                      <input type="number" class="form-control form-control-sm" data-decimal="1" id="nilai_min" name="nilai_min" placeholder="0" min="0" autocomplete="off" />
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="text-sm">Nilai Max
                       <span class="text-warning">*</span>
                      </label>
                      <input type="number" class="form-control form-control-sm" id="nilai_max" data-decimal="1" name="nilai_max" placeholder="0" min="0" autocomplete="off" />
                    </div>
                  </div>   
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="text-sm">Jenis Kelamin <span class="text-warning">*</span></label>
                      <select type="text" class="custom-select custom-select-sm"  name="kelamin" required>
                        <option value="">--Pilih Kelamin--</option>
                        <option value="L">L</option>
                        <option value="P">P</option>
                        <option value="L/P">L/P</option>
                      </select>
                    </div>
                  </div>               
                </div>
                 <!--end of row alamat dan isFaskes-->
              </div>
              <!-- /.card-body -->
               <div class="card-footer">
                <button type="submit" name="simpan" class="btn btn-success btn-sm"><i class="far fa-save"> Simpan</i></button>
                <a class="btn btn-secondary btn-sm" href="admin.php?page=parameter-data"><i class="fas fa-arrow-left"> Kembali</i></a>
              </div>
              </form>
             
       
          </div>
        </div>
      </div>
    </div>
  </div>
