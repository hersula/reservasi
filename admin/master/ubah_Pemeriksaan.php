<?php 

include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}

$id_pemeriksaan   ="";
$name         = "";
$description  ="";
$price        ="";
$Kategori ="";
$katID        ="";
$outlet       ="";
$outletPemeriksaan="";
$isVisibleToPasien="1";
$spesimen         ="";

$error                =0;
//$errorEmail         =0;
//$errorPhone         =0;

if(isset($_GET["id"])){
    $id_pemeriksaan = $_GET["id"];

    $cekOutletPemeriksaanList1= "select * from outlet_pemeriksaan_list 
                             where outletPemeriksaan='$id_pemeriksaan'";
    $cekHasilOTL1 = mysqli_query($conn,$cekOutletPemeriksaanList1);

    if(mysqli_num_rows($cekHasilOTL1) > 0) {
        $sql = "select t.id, t.name, t.description, otl.price, k.id as katid, k.kat_pemeriksaan, t.spesimen, 
                otl.outletID, otl.outletPemeriksaan,  otl.isVisibleToPasien 
                from master_pemeriksaan t join outlet_pemeriksaan_list otl 
                on otl.outletPemeriksaan=t.id join master_kat_pemeriksaan k on k.id=t.kategori where t.id='$id_pemeriksaan'";
        $result = mysqli_query($conn,$sql);
        $count_pemeriksaan = mysqli_num_rows($result);
        if($row = mysqli_fetch_array($result)){
          $id_pemeriksaan  = $row["id"];
          $name         = $row["name"];
          $price        = $row["price"];
          $description  = $row["description"];
          $Kategori     = $row["kat_pemeriksaan"];
          $katID        = $row['katid'];
          $outlet       = $row["outletID"];
          $outletPemeriksaan= $row["outletPemeriksaan"];
          $isVisibleToPasien = $row["isVisibleToPasien"];
          $spesimen          = $row["spesimen"];
        }else{
           echo '<script>
                    swal({
                    title: "Maaf!",
                    text: "Data Pemeriksaan tidak berhasil diubah.",
                    type: "error"
                    }).then(function() {
                    window.location = "admin.php?page=ubah-pemeriksaan-data&id='.$_GET['id'].'";
                    });
                    </script>';  
        }
    }else{
        $query1 = "select a.id, a.name, a.description, a.price, k.id as katid, a.spesimen from master_pemeriksaan a
                   join master_kat_pemeriksaan k on k.id=a.kategori where a.id='$id_pemeriksaan'";
        $result1 = mysqli_query($conn,$query1);
        if($row = mysqli_fetch_array($result1)){
          $id_pemeriksaan     = $row["id"];
          $name               = $row["name"];
          $description        = $row["description"];
          $price              = $row["price"];
          $katID              = $row["katid"];
          $spesimen           = $row["spesimen"];

        }else{
            echo '<script>
                  swal({
                  title: "Maaf!",
                  text: "Data Pemeriksaan tidak berhasil diubah.",
                  type: "error"
                  }).then(function() {
                  window.location = "admin.php?page=ubah-pemeriksaan-data&id='.$_GET['id'].'";
                  });
                  </script>';    
        }

    }
}else{
        echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Pemeriksaan tidak berhasil diubah.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=ubah-pemeriksaan-data&id='.$_GET['id'].'";
                });
                </script>';   
}

if(isset($_POST["simpan"])){
    $name              = $_POST["name"];
    $description       = $_POST["description"];
    $price             = $_POST["price"];
    $Kategori          = $_POST["kategori"];
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
       $sql2 = "update master_pemeriksaan set name='$name', description='$description',
                kategori='$Kategori', spesimen='$spesimen' 
                where id='$id_pemeriksaan'";
      mysqli_query($conn, $sql2);

      $sql3 = "delete from outlet_pemeriksaan_list where outletPemeriksaan='$id_pemeriksaan'";
      mysqli_query($conn, $sql3);

      for ($i = 0; $i < count($outlet) - 1; $i++) {
            $sql3= "insert into outlet_pemeriksaan_list (outletID, outletPemeriksaan, price,
                      isVisibleToPasien, status) 
                      values ('$outlet[$i]', '$outletPemeriksaan', '$price[$i]','$isVisibleToPasien', 'Aktif')";
            mysqli_query($conn, $sql3);
        }
        
      $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Ubah data pemeriksaan') ";
      mysqli_query($conn, $sql_query1);
     
      if(mysqli_error($conn) == "") {
        echo '<script>
                swal({
                title: "Sukses!",
                text: "Data Pemeriksaan berhasil diubah.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=ubah-pemeriksaan-data&id='.$_GET['id'].'";
                });
                </script>';
      }else{
          echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Pemeriksaan tidak berhasil diubah.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=ubah-pemeriksaan-data&id='.$_GET['id'].'";
                });
                </script>';
      }
  }
}

if (isset($_POST['delete'])) {
  $id_delete = $_POST['id_delete'];
  $sql_delete = "Delete From outlet_pemeriksaan_list where outlet_pemeriksaan_list.id = '".$id_delete."'";
  mysqli_query($conn, $sql_delete);

  if(mysqli_error($conn) == "") {
        echo '<script>
                swal({
                title: "Sukses!",
                text: "List Outlet berhasil dihapus.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=ubah-pemeriksaan-data&id='.$_GET['id'].'";
                });
                </script>';
      }else{
          echo '<script>
                swal({
                title: "Maaf!",
                text: "List Outlet gagal dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=-ubah-pemeriksaan-data&id='.$_GET['id'].'";
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
          <h1 class="m-0">Ubah Data Pemeriksaan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/norbu-clinic/pasien/main">Home</a></li>
            <li class="breadcrumb-item active">Data Pemeriksaan</li>
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
              <h3 class="card-title">Form Ubah Data Pemeriksaan</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="" method="POST" enctype="multipart/form-data">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="text-sm">Kategori <span class="text-warning">*</span></label>
                      <select class="custom-select custom-select-sm" id="kategori" name="kategori" required>
                        <option value="">--Pilih Kategori--</option>
                        <?php
                          $query= "select id, kat_pemeriksaan from master_kat_pemeriksaan where status='1'";
                          $resultKat = mysqli_query($conn,$query);
                            while($rowKat = mysqli_fetch_array($resultKat)){
                            ?> 
                        <option value="<?php echo $rowKat["id"]; ?>"
                            <?php
                              if($rowKat["id"] == $katID){
                                echo "selected";
                              } ?>
                              ><?php echo $rowKat["kat_pemeriksaan"]; ?></option><?php
                              }
                            ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group ">
                      <label class="text-sm">Nama Pemeriksaan
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
                      <input required type="text" class="form-control form-control-sm" name="name" placeholder="Nama Pemeriksaan" id="name" value="<?php echo $name; ?>" autocomplete="off">
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
                  if ($count_pemeriksaan > 1) {
                      $i_del = 0;
                    while($rowPemeriksaan = mysqli_fetch_array($result)){
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
                              if($rowPemeriksaan["outletID"] == $rowOutlet['id']){
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
                      <input type="text" class="form-control form-control-sm" name="price[]" placeholder="Harga Pemeriksaan Di Tiap Outlet" id="price" value="<?php echo $rowTindakan['price']; ?>" autocomplete="off" >
                      <font color="blue">
                        <b>Contoh: 75000
                        </b>
                      </font><br/>
                    </div>
                  </div> 
                  <br/>
                  <div class="input-group-addon" style="margin-top:30px;"> 
                      <?php
                        $query_delete= "SELECT * FROM `outlet_pemeriksaan_list` where outletID = '".$rowPemeriksaan['outletID']."' and outletPemeriksaan='".$rowPemeriksaan['outletPemeriksaan']."'";
                        $resultOutlet_del = mysqli_query($conn,$query_delete);
                        $rowOutlet_del = mysqli_fetch_array($resultOutlet_del);
                      ?>
                      <!--<input type="hidden" name="id_delete" value="<?=$rowOutlet_del['id']?>">-->
                      <!--<button class="btn btn-danger" name="delete" type="submit" value="delete" onclick="deleteTindakan(<?=$i_del?>)"><i class="fas fa-trash"></i></button>-->
                      <!--<button class="btn btn-danger" onclick="deleteTindakan(<?=$i_del?>);"><i class="fas fa-trash"></i></button>-->
                      <a href="javascript:void(0)" class="btn btn-danger removePemeriksaan_<?=$i_del?>"><i class="fas fa-trash"></i></a>
                    <!-- <a href="javascript:void(0)" class="btn btn-danger remove"><i class="fas fa-trash"></i></a> -->
                </div>
                </div>
                <!--end of row outlet dan Harga-->
                
                <script type="text/javascript">
                // function deleteTindakan(<?=$i_del?>){
                //     alert(<?=$i_del?>);
                //     $("#list_outlet_<?=$i_del?>".toString()).remove();
                // }
                $("body").on("click",".removePemeriksaan_<?=$i_del?>",function(){ 
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
                      <input type="text" class="form-control form-control-sm" name="price[]" placeholder="Harga Pemeriksaan Di Tiap Outlet" id="price" autocomplete="off" >
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
                <a class="btn btn-secondary btn-sm" href="admin.php?page=pemeriksaan-data"><i class="fas fa-arrow-left"> Kembali</i></a>
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