<?php 

include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}


$name         = "";
$description  ="";
$price        ="";
$typeTindakan ="";
$outlet       ="";
//$discount     ="";
$idTindakan   ="";
$outletTindakan="";
$isVisibleToPasien="1";
$spesimen         ="";

$error            =0;
//$errorName        =0;
//$errorDescription =0;

if(isset($_POST["simpan"])){

    $name              = $_POST["name"];
    $description       = $_POST["description"];
    $price             = $_POST["price"];
    $typeTindakan      = $_POST["typeTindakan"];
    $outlet            = $_POST["outlet"];
    //$discount          = $_POST["discount"];
    $isVisibleToPasien = $_POST["isVisibleToPasien"];
    $spesimen          = $_POST["spesimen"];
  
  //Pengecekan Error
  
  // if($name == ""){
  //   $error = 1;
  //   $errorName = 1;
  // }else{
  //   $sql = "select * from master_tindakan where name='$name' and status='Aktif'";
  //   $cekData = mysqli_query($conn,$sql);
  //   if(mysqli_num_rows($cekData) > 0){
  //     $error = 1;
  //     $errorName = 2;
  //   }
  // }

  // if($description == ""){
  //   $error = 1;
  //   $errorDescription = 1;
  // }else{
  //   $sql = "select * from master_tindakan where description='$description' and status='Aktif'";
  //   $cekData = mysqli_query($conn,$sql);
  //   if(mysqli_num_rows($cekData) > 0){
  //     $error = 1;
  //     $errorDescription = 2;
  //   }
  // }

    echo $name;
    if($error == 0){
        $sql1 = "insert into master_tindakan (name, description, price, typeTindakan,
                spesimen, status, createdAt)
                values ('$name', '$description', '$price[0]','$typeTindakan', '$spesimen', 'Aktif',
                NOW())";
        mysqli_query($conn, $sql1);
        
        // query untuk get last id dari tabel master_tindakan
        $result = mysqli_query($conn, "select id from master_tindakan order by id 
                  desc LIMIT 1");
 
        // tampilkan last id dari tabel master_tindakan
        while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
          echo $row['id'];
          $outletTindakan=$row["id"];

        }

        //foreach ($_POST['outlet'] as $value) {
        for ($i = 0; $i < count($outlet) - 1; $i++) {
            $sql3= "insert into outlet_tindakan_list (outletID, outletTindakan, price,
                      isVisibleToPasien, status) 
                      values ('$outlet[$i]', '$outletTindakan', '$price[$i]','$isVisibleToPasien', 'Aktif')";
            mysqli_query($conn, $sql3);
        }
        
        $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Tambah data tindakan') ";
        mysqli_query($conn, $sql_query1);
        
        if (!empty($_GET['bug'])) {
          echo "Sql 1 :".$sql1."</br>";
          echo "Sql 2 :".$sql3."</br>";
          echo "Sql 3 :".$sql_query1."</br>";
          exit;
        }

        if(mysqli_error($conn) == "") {
          echo '<script>
                    swal({
                    title: "Sukses!",
                    text: "Data Tindakan baru berhasil ditambahkan ke dalam sistem.",
                    type: "success"
                    }).then(function() {
                    window.location = "admin.php?page=tindakan-data";
                    });
                    </script>';
        }else{
          echo '<script>
                    swal({
                    title: "Maaf!",
                    text: "Data Tindakan baru tidak berhasil ditambahkan ke dalam sistem.",
                    type: "error"
                    }).then(function() {
                    window.location = "admin.php?page=tindakan-data";
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
          <h1 class="m-0">Tambah Data Tindakan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/norbu-clinic/pasien/main">Home</a></li>
            <li class="breadcrumb-item active">Data Tindakan</li>
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
              <h3 class="card-title">Form Tambah Data Tindakan</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="" method="POST" enctype="multipart/form-data">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group ">
                      <label class="text-sm">Nama Tindakan
                      <span class="text-warning">*</span>
                      </label>
                      <span class="help-block">
                      <?php
                        /*
                        if($errorName == 2){
                          echo '<div class="alert alert-danger">Maaf! Nama Tindakan sudah ada di sistem.</div>';
                        }
                        */
                      ?>
                      </span>
                      <input required type="text" class="form-control form-control-sm" name="name" placeholder="Nama Tindakan" id="name" value="<?php echo $name; ?>" autocomplete="off">
                    </div>
                  </div>


                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Jenis
                      <span class="text-warning">*</span></label>
                      <select type="text" class="custom-select custom-select-sm" name="typeTindakan" 
                      id="typeTindakan" required>
                        <option value="">--Pilih Jenis Tindakan--</option>
                        <option value="PCR">PCR</option>
                        <option value="Antigen">Antigen</option>
                        <option value="LAB">LAB</option>
                        <option value="Non Result">Non Result</optioNon Resultn>
                      </select>
                    </div>
                  </div>

                             
                </div>
                <!--end of row Nama Tindakan dan Jenis Tindakan -->

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Deskripsi 
                       <span class="text-warning">*</span>
                      </label>
                      <span class="help-block">
                      <?php
                        /*
                        if($errorDescription == 2){
                          echo '<div class="alert alert-danger">Maaf! Deskripsi Tindakan ini sudah ada di sistem.</div>';
                        }
                       */
                      ?>
                      </span>
                         <input required type="text" class="form-control form-control-sm" name="description" placeholder="Deskripsi Tindakan" id="description" value="<?php echo $description; ?>" autocomplete="off" >
                    </div>
                  </div>
                  <!--end of col-md-6-->

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Jenis Spesimen
                      <span class="text-warning">*</span></label>
                      <select type="text" class="custom-select custom-select-sm" name="spesimen" 
                      id="spesimen" required>
                        <option value="">--Pilih Spesimen--</option>
                        <option value="nasopharyngeal">nasopharyngeal</option>
                        <option value="nasal">nasal</option>
                        <option value="nasopharyngeal & oropharyngeal">nasopharyngeal & oropharyngeal
                        </option>
                        <option value="oropharyngeal">oropharyngeal</option>
                        <option value="darah">Darah</option>
                        <option value="urine">Urine</option>
                      </select>
                    </div>
                  </div>
                  <!--end of col-md-6-->

                </div>
                 <!--end of row Deskripsi dan Jenis Spesimen-->

                <!--row outlet dan Harga -->
                <div class="row fieldGroup">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="text-sm">Outlet <span class="text-warning">*</span></label>
                      <select class="custom-select custom-select-sm" id="outlet" name="outlet[]" required>
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
                  <!--end of col-md-3-->

                  <div class="col-md-3">
                    <div class="form-group ">
                      <label class="text-sm">Harga Per Unit Di Outlet
                      <span class="text-warning">*</span>
                      </label>
                      <input required type="text" class="form-control form-control-sm" name="price[]" placeholder="Harga Tindakan Di Tiap Outlet" id="price" value="<?php echo $price; ?>" autocomplete="off" >
                      <font color="blue">
                        <b>Contoh: 75000
                        </b>
                      </font><br/>
                    </div>
                  </div> 
                  <div class="input-group-addon" style="margin-top:30px;"> 
                    <a href="javascript:void(0)" class="btn btn-success addMore"><i class="fas fa-plus"></i></a>
                  </div>
                </div>
                <!--end of row outlet dan Harga-->
                <!--
                <button class="btn btn-info btn-sm add-more" id="add-more" type="button">
                  <i class="fas fa-plus"></i>  Add Outlet & Harga
                </button>
                -->

                <!--row outlet dan Harga -->
                <div class="row fieldGroupCopy" style="display:none;">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label class="text-sm">Outlet <span class="text-warning">*</span></label>
                      <select class="custom-select custom-select-sm" id="outlet" name="outlet[]">
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
                  <!--end of col-md-3-->

                  <div class="col-md-3">
                    <div class="form-group ">
                      <label class="text-sm">Harga Per Unit Di Outlet
                      <span class="text-warning">*</span>
                      </label>
                      <input type="text" class="form-control form-control-sm" name="price[]" placeholder="Harga Tindakan Di Tiap Outlet" id="price" value="<?php echo $price; ?>" autocomplete="off" >
                      <font color="blue">
                        <b>Contoh: 75000
                        </b>
                      </font><br/>
                    </div>
                  </div> 
                  <br/>
                  <div class="input-group-addon" style="margin-top:30px;"> 
                    <a href="javascript:void(0)" class="btn btn-danger remove"><i class="fas fa-trash"></i></a>
                </div>
                </div>
                <!--end of row outlet dan Harga-->

                <br/>
                <div class="row">
                  <div class="col-md-6">
                    <div  class="form-group" >
                      <label class="text-sm">
                        Dapat dilihat pasien?
                      <span class="text-warning">*</span>
                      </label>
                      <div class="col-sm-6">
                        <div class="form-check-inline">
                          <label class="form-check-label" for="rbYa">
                          <input type="radio" class="form-check-input" id="isVisibleToPasien" name="isVisibleToPasien" <?php if($isVisibleToPasien == "1") { echo "checked"; } ?> value="1">Ya
                          </label>
                        </div>
                        <div class="form-check-inline">
                          <label class="form-check-label" for="rbTidak">
                          <input type="radio" class="form-check-input" id="isVisibleToPasien" 
                          name="isVisibleToPasien"
                          <?php if($isVisibleToPasien == "0") { echo "checked"; } ?> value="0">Tidak
                          </label>
                        </div>
                      </div>
                    </div>
                    <!--Akhir form group Radio Button isVisibleToPasien-->
                  </div>
                  <!--end of col-md-6--> 
                </div>
                <!--end of row isVisibleToPasien-->
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" name="simpan" value="simpan" class="btn btn-success btn-sm"><i class="far fa-save"> Simpan</i></button>
                <a class="btn btn-secondary btn-sm" href="admin.php?page=tindakan-data"><i class="fas fa-arrow-left"> Kembali</i></a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

    <script>
    $(document).ready(function(){
    // membatasi jumlah inputan
    var maxGroup = 50;
    
    //melakukan proses multiple input 
    $(".addMore").click(function(){
        if($('body').find('.fieldGroup').length < maxGroup){
            var fieldHTML = '<div class="row fieldGroup">'+$(".fieldGroupCopy").html()+'</div>';
            $('body').find('.fieldGroup:last').after(fieldHTML);
        }else{
            alert('Maximum '+maxGroup+' groups are allowed.');
        }
    });
    
    //remove fields group
    $("body").on("click",".remove",function(){ 
        $(this).parents(".fieldGroup").remove();
    });
});
  </script>