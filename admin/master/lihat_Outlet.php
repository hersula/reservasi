<?php 

include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}

$name     = "";
$address  ="";
$phone    ="";
$isFaskes ="1";


if(isset($_GET["id"])){
  $id_outlet = $_GET["id"];
    $sql = "select * from master_outlet where id='$id_outlet'";
    $result = mysqli_query($conn,$sql);
    if($row = mysqli_fetch_array($result)){
      $id_outlet    = $row["id"];
      $name         = $row["name"];
      $address      = $row["address"];
      $phone        = $row["phone"];
      $isFaskes     = $row["isFaskes"];
    }else{ 
          echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Outlet tidak berhasil dilihat.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=outlet-data";
                });
                </script>';   
    }
    
    $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Lihat data outlet') ";
    mysqli_query($conn, $sql_query1);
}else{
         echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Outlet tidak berhasil dilihat.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=outlet-data";
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
          <h1 class="m-0">Lihat Data Outlet</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/norbu-clinic/pasien/main">Home</a></li>
            <li class="breadcrumb-item active">Data Outlet</li>
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
              <h3 class="card-title">Form Lihat Data Outlet</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="" method="POST">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group ">
                      <label class="text-sm">Nama Outlet
                      <!--
                      <span class="text-warning">*</span>
                      -->
                      </label>
                     
                      <input disabled required type="text" class="form-control form-control-sm" name="name" placeholder="Nama Outlet" id="name" value="<?php echo $name; ?>" autocomplete="off"/>
                    </div>
                  </div>
                  
                   <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Nomor Telepon
                      <!--
                       <span class="text-warning">*</span>
                     -->
                      </label>
                      <input disabled type="text" class="form-control form-control-sm" id="phone" name="phone" placeholder="Nomor Telepon" value="<?php echo $phone; ?>" autocomplete="off"/>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group ">
                      <label class="text-sm">Alamat Outlet
                      <!--
                      <span class="text-warning">*</span>
                      -->
                      </label>
                  
                      <input disabled required type="text" class="form-control form-control-sm" name="address" placeholder="Alamat Outlet" id="address" value="<?php echo $address; ?>" autocomplete="off" />
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div  class="form-group" >
                      <label class="text-sm">
                        Termasuk Faskes?
                      <!--
                      <span class="text-warning">*</span>
                      -->
                      </label>
                      <input disabled required type="text" class="form-control form-control-sm" name="isFaskes"  id="isFaskes" value="
                     <?php if($isFaskes=="1") { 
                        echo "Ya";  
                      } else {
                        echo "Tidak"; 
                      }
                      ?>" 
                      autocomplete="off" />
                    </div>
                    <!--Akhir form group Radio Button isFaskes-->
                  </div>

                </div>
                 <!--end of row alamat dan karyawan-->
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <a class="btn btn-secondary btn-sm" href="admin.php?page=outlet-data"><i class="fas fa-arrow-left"> Kembali</i></a>
              </div>
            </form> 
          </div>
        </div>
      </div>
    </div>
  </div>