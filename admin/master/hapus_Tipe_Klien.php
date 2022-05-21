<?php  

  include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}


 $id = $_GET["id"];
 $nameType = "";

if(isset($_GET["id"])){
      $id = $_GET["id"];
      $sql = "select * from master_tipe_client where id='$id'";
      $result = mysqli_query($conn,$sql);
      if($row = mysqli_fetch_array($result)){
        $id       = $row["id"];
        $nameType = $row["nameType"];

        $sql2 = "update master_tipe_client set status='Non Aktif' where id='$id'";
        mysqli_query($conn, $sql2);
        
        $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Hapus data tipe klien') ";
        mysqli_query($conn, $sql_query1);

        if(mysqli_error($conn) == ""){
          echo '<script>
                swal({
                title: "Sukses!",
                text: "Data Tipe Klien berhasil dihapus.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=tipe-klien-data";
                });
                </script>';
        }else{
  
        echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Tipe Klien tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=tipe-klien-data";
                });
                </script>';
        }
    }else{
            echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Tipe Klien tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=tipe-klien-data";
                });
                </script>'; 
    }
}else{

             echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Tipe Klien tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=tipe-klien-data";
                });
                </script>';
}
?>