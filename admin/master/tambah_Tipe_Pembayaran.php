<?php 

include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}

$namePayment = "";

$error = 0;
$errorNamePayment= 0;

if(isset($_POST["simpan"])){
    $namePayment = $_POST["namePayment"];
  
  //Pengecekan Error
  if($namePayment == ""){
    $error = 1;
    $errorNamePayment = 1;
  }else{
    $sql = "select * from master_payment where namePayment='$namePayment'";
    $cekData = mysqli_query($conn,$sql);
    if(mysqli_num_rows($cekData) > 0){
      $error = 1;
      $errorNamePayment = 2;
    }
  }

  if($error == 0){
      $sql_query = "insert into master_payment (namePayment, status)
               values ('$namePayment', 'Aktif')";
      mysqli_query($conn, $sql_query);

      if(mysqli_error($conn) == "") {
        echo '<script>
                swal({
                title: "Sukses!",
                text: "Data Tipe Pembayaran baru berhasil ditambahkan ke dalam sistem.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=tipe-pembayaran-data";
                });
                </script>';
      }else{
          echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Tipe Pembayaran baru tidak berhasil ditambahkan ke dalam sistem.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=tipe-pembayaran-data";
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
          <h1 class="m-0">Tambah Data Tipe Pembayaran</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/norbu-clinic/pasien/main">Home</a></li>
            <li class="breadcrumb-item active">Data Tipe Pembayaran</li>
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
              <h3 class="card-title">Form Tambah Data Tipe Pembayaran</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="" method="POST">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group ">
                      <label class="text-sm">Nama Tipe Pembayaran
                      <span class="text-warning">*</span>
                      </label>
                      <span class="help-block">
                      <?php
                        if($errorNamePayment == 2){
                          echo '<div class="alert alert-danger">Maaf! Nama Tipe Pembayaran sudah ada di sistem.</div>';
                        }
                      ?>
                      </span>
                      <input required type="text" class="form-control form-control-sm" name="namePayment" placeholder="Nama Tipe Pembayaran" id="namePayment" value="<?php echo $namePayment; ?>" />
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
               <div class="card-footer">
                <button type="submit" name="simpan" class="btn btn-success btn-sm"><i class="far fa-save"> Simpan</i></button>
                <a class="btn btn-secondary btn-sm" href="admin.php?page=tipe-pembayaran-data"><i class="fas fa-arrow-left"> Kembali</i></a>
              </div>
              </form>
             
       
          </div>
        </div>
      </div>
    </div>
  </div>