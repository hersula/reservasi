<?php 

include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}

$id_tindakan   ="";
$name         = "";
$description  ="";
$price        ="";
$typeTindakan ="";
$outlet       ="";
$outletTindakan="";
$isVisibleToPasien="1";
$spesimen         ="";

$error                =0;
//$errorEmail         =0;
//$errorPhone         =0;

if(isset($_GET["id"])){
    $id_tindakan = $_GET["id"];

    $cekOutletTindakanList1= "select * from outlet_tindakan_list 
                             where outletTindakan='$id_tindakan'";
    $cekHasilOTL1 = mysqli_query($conn,$cekOutletTindakanList1);

    if(mysqli_num_rows($cekHasilOTL1) > 0) {
        $sql = "select t.id, t.name, t.description, otl.price, t.typeTindakan, t.spesimen, 
                otl.outletID, otl.outletTindakan,  otl.isVisibleToPasien 
                from master_tindakan t join outlet_tindakan_list otl 
                on otl.outletTindakan=t.id where t.id='$id_tindakan'";
        $result = mysqli_query($conn,$sql);
        $count_tindakan = mysqli_num_rows($result);
        if($row = mysqli_fetch_array($result)){
          $id_tindakan  = $row["id"];
          $name         = $row["name"];
          $price        = $row["price"];
          $description  = $row["description"];
          $typeTindakan = $row["typeTindakan"];
          $outlet       = $row["outletID"];
          $outletTindakan= $row["outletTindakan"];
          $isVisibleToPasien = $row["isVisibleToPasien"];
          $spesimen          = $row["spesimen"];
        }else{
           echo '<script>
                    swal({
                    title: "Maaf!",
                    text: "Data Tindakan tidak berhasil diubah.",
                    type: "error"
                    }).then(function() {
                    window.location = "admin.php?page=ubah-tindakan-data&id='.$_GET['id'].'";
                    });
                    </script>';  
        }
    }else{
        $query1 = "select * from master_tindakan where id='$id_tindakan'";
        $result1 = mysqli_query($conn,$query1);
        if($row = mysqli_fetch_array($result1)){
          $id_tindakan        = $row["id"];
          $name               = $row["name"];
          $description        = $row["description"];
          $price              = $row["price"];
          $typeTindakan       = $row["typeTindakan"];
          $spesimen           = $row["spesimen"];

        }else{
            echo '<script>
                  swal({
                  title: "Maaf!",
                  text: "Data Tindakan tidak berhasil diubah.",
                  type: "error"
                  }).then(function() {
                  window.location = "admin.php?page=ubah-tindakan-data&id='.$_GET['id'].'";
                  });
                  </script>';    
        }

    }
}else{
        echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Tindakan tidak berhasil diubah.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=ubah-tindakan-data&id='.$_GET['id'].'";
                });
                </script>';   
}

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
    /*
  if($email == ""){
    $error = 1;
    $errorEmail = 1;
  }else{
    $sql = "select * from master_karyawan where email='$email' and status='Aktif'";
    $cekData = mysqli_query($conn,$sql);
    if(mysqli_num_rows($cekData) > 0){
      $error = 1;
      $errorEmail = 2;
    }
  }

  if($phone == ""){
    $error = 1;
    $errorPhone = 1;
  }else{
    $sql = "select * from master_karyawan where phone='$phone' and status='Aktif'";
    $cekData = mysqli_query($conn,$sql);
    if(mysqli_num_rows($cekData) > 0){
      $error = 1;
      $errorPhone = 2;
    }
  }
  */
  if($error == 0){
       $sql2 = "update master_tindakan set name='$name', description='$description',
                typeTindakan='$typeTindakan', spesimen='$spesimen' 
                where id='$id_tindakan'";
      mysqli_query($conn, $sql2);

      $sql3 = "delete from outlet_tindakan_list where outletTindakan='$id_tindakan'";
      mysqli_query($conn, $sql3);

      for ($i = 0; $i < count($outlet) - 1; $i++) {
            $sql3= "insert into outlet_tindakan_list (outletID, outletTindakan, price,
                      isVisibleToPasien, status) 
                      values ('$outlet[$i]', '$outletTindakan', '$price[$i]','$isVisibleToPasien', 'Aktif')";
            mysqli_query($conn, $sql3);
        }
        
      $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Ubah data tindakan') ";
      mysqli_query($conn, $sql_query1);
     
      if(mysqli_error($conn) == "") {
        echo '<script>
                swal({
                title: "Sukses!",
                text: "Data Tindakan berhasil diubah.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=ubah-tindakan-data&id='.$_GET['id'].'";
                });
                </script>';
      }else{
          echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Tindakan tidak berhasil diubah.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=ubah-tindakan-data&id='.$_GET['id'].'";
                });
                </script>';
      }
  }
}

if (isset($_POST['delete'])) {
  $id_delete = $_POST['id_delete'];
  $sql_delete = "Delete From outlet_tindakan_list where outlet_tindakan_list.id = '".$id_delete."'";
  mysqli_query($conn, $sql_delete);

  if(mysqli_error($conn) == "") {
        echo '<script>
                swal({
                title: "Sukses!",
                text: "List Outlet berhasil dihapus.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=ubah-tindakan-data&id='.$_GET['id'].'";
                });
                </script>';
      }else{
          echo '<script>
                swal({
                title: "Maaf!",
                text: "List Outlet gagal dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=-ubah-tindakan-data&id='.$_GET['id'].'";
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
          <h1 class="m-0">Ubah Data Tindakan</h1>
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
              <h3 class="card-title">Form Ubah Data Tindakan</h3>
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
                        <option value="PCR" <?php
                              if($typeTindakan == 'PCR'){
                                echo "selected";
                              } ?> >PCR</option>
                        <option value="Antigen" <?php
                              if($typeTindakan == 'Antigen'){
                                echo "selected";
                              } ?> >Antigen</option>
                        <option value="LAB" <?php
                              if($typeTindakan == 'LAB'){
                                echo "selected";
                              } ?> >LAB</option>
                        <option value="Non Result" <?php
                              if($typeTindakan == 'Non Result'){
                                echo "selected";
                              } ?> >Non Result</option>
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
                        <option value="nasopharyngeal" <?php
                              if($spesimen == 'nasopharyngeal'){
                                echo "selected";
                              } ?> >nasopharyngeal</option>
                        <option value="nasal" <?php
                              if($spesimen == 'nasal'){
                                echo "selected";
                              } ?> >nasal</option>
                        <option value="nasopharyngeal & oropharyngeal" <?php
                              if($spesimen == 'nasopharyngeal & oropharyngeal'){
                                echo "selected";
                              } ?> >nasopharyngeal & oropharyngeal
                        </option>
                        <option value="oropharyngeal" <?php
                              if($spesimen == 'oropharyngeal'){
                                echo "selected";
                              } ?> >oropharyngeal</option>
                        <option value="darah" <?php
                              if($spesimen == 'darah'){
                                echo "selected";
                              } ?> >Darah</option>
                        <option value="urine" <?php
                              if($spesimen == 'urine'){
                                echo "selected";
                              } ?> >Urine</option>
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

                <?php
                  if ($count_tindakan > 1) {
                      $i_del = 0;
                    while($rowTindakan = mysqli_fetch_array($result)){
                      $i_del++;
                      //echo $i_del;
                ?>
                <!--row outlet dan Harga -->
                <div class="row" id="list_outlet_<?=$i_del?>">
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
                              if($rowTindakan["outletID"] == $rowOutlet['id']){
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
                      <input type="text" class="form-control form-control-sm" name="price[]" placeholder="Harga Tindakan Di Tiap Outlet" id="price" value="<?php echo $rowTindakan['price']; ?>" autocomplete="off" >
                      <font color="blue">
                        <b>Contoh: 75000
                        </b>
                      </font><br/>
                    </div>
                  </div> 
                  <br/>
                  <div class="input-group-addon" style="margin-top:30px;"> 
                      <?php
                        $query_delete= "SELECT * FROM `outlet_tindakan_list` where outletID = '".$rowTindakan['outletID']."' and outletTindakan='".$rowTindakan['outletTindakan']."'";
                        $resultOutlet_del = mysqli_query($conn,$query_delete);
                        $rowOutlet_del = mysqli_fetch_array($resultOutlet_del);
                      ?>
                      <!--<input type="hidden" name="id_delete" value="<?=$rowOutlet_del['id']?>">-->
                      <!--<button class="btn btn-danger" name="delete" type="submit" value="delete" onclick="deleteTindakan(<?=$i_del?>)"><i class="fas fa-trash"></i></button>-->
                      <!--<button class="btn btn-danger" onclick="deleteTindakan(<?=$i_del?>);"><i class="fas fa-trash"></i></button>-->
                      <a href="javascript:void(0)" class="btn btn-danger removeTindakan_<?=$i_del?>"><i class="fas fa-trash"></i></a>
                    <!-- <a href="javascript:void(0)" class="btn btn-danger remove"><i class="fas fa-trash"></i></a> -->
                </div>
                </div>
                <!--end of row outlet dan Harga-->
                
                <script type="text/javascript">
                // function deleteTindakan(<?=$i_del?>){
                //     alert(<?=$i_del?>);
                //     $("#list_outlet_<?=$i_del?>".toString()).remove();
                // }
                $("body").on("click",".removeTindakan_<?=$i_del?>",function(){ 
                    $("#list_outlet_<?=$i_del?>".toString()).remove();
                });
                    // deleteTindakan = function(<?=$i_del?>){
                    //   $("#list_outlet_<?=$i_del?>".toString()).remove();
                    // }
                </script>
                
                <?php
                      }
                    }
                ?>

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
                        <option value="<?php echo $rowOutlet["id"]; ?>"><?php echo $rowOutlet["name"]; ?></option><?php
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
                      <input type="text" class="form-control form-control-sm" name="price[]" placeholder="Harga Tindakan Di Tiap Outlet" id="price" autocomplete="off" >
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