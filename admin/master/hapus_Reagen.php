<?php  

  include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}


  $id_reagen      = $_GET['id'];
  $nameReagen     = "";
  $targetGenID    ="";
  $isActive="1";


if(isset($_GET["id"])){
      $id_reagen = $_GET['id'];
      $sql = "select mr.*, tg.reagenID as 'reagenID', tg.targetGenID as 'targetGenID',
            mt.nameTargetGen from master_reagen mr join target_gen_list tg on mr.id=tg.reagenID 
            join master_target_gen mt on mt.id=tg.targetGenID 
            where mr.id='$id_reagen' and mr.status='Aktif'";
      $result = mysqli_query($conn,$sql);
      if($row = mysqli_fetch_array($result)){
          $id_reagen   = $row["id"];
          $nameReagen  = $row["nameReagen"];
          $isActive    = $row['isActive'];
          $targetGenID = $row["targetGenID"];
          $reagenID    = $row["reagenID"];
  

        $sql1 = "update master_reagen set status='Non Aktif' where id='$id_reagen'";
        mysqli_query($conn, $sql1);

        $sql2 = "update target_gen_list set status='Non Aktif' where reagenID='$id_reagen'";
        mysqli_query($conn, $sql2);
        
        $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Hapus data reagen') ";
        mysqli_query($conn, $sql_query1);

        if(mysqli_error($conn) == ""){
            echo '<script>
                swal({
                title: "Sukses!",
                text: "Data Reagen berhasil dihapus.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=reagen-data";
                });
                </script>'; 
        }else{
            echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Reagen tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=reagen-data";
                });
                </script>';   
        }
    }else{
         echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Reagen tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=reagen-data";
                });
                </script>'; 
    }
}else{
         echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Reagen tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=reagen-data";
                });
                </script>'; 
}
?>