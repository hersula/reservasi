<?php  

  include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}


  $id_target_gen    = $_GET['id'];
  $nameTargetGen= "";

if(isset($_GET["id"])){
      $id_target_gen = $_GET['id'];
      $sql = "select * from master_target_gen where id='$id_target_gen'";
      $result = mysqli_query($conn,$sql);
      if($row = mysqli_fetch_array($result)){
        $id_target_gen    = $row["id"];
        $nameTargetGen    = $row["nameTargetGen"];
       

        $sql1 = "update master_target_gen set status='Non Aktif' where id='$id_target_gen'";
        mysqli_query($conn, $sql1);
        
        $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Hapus data targe gen') ";
        mysqli_query($conn, $sql_query1);

        if(mysqli_error($conn) == ""){
            echo '<script>
                swal({
                title: "Sukses!",
                text: "Data Target Gen berhasil dihapus.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=target-gen-data";
                });
                </script>'; 
        }else{
            echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Target Gen tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=target-gen-data";
                });
                </script>';   
        }
    }else{
         echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Target Gen tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=target-gen-data";
                });
                </script>'; 
    }
}else{
         echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Target Gen tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=target-gen-data";
                });
                </script>'; 
}
?>