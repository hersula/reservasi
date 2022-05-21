<?php  

  include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}


  $id_client    = $_GET['id'];
  $typeClientID ="";
  $nameClient   ="";
  $address      ="";
  $phone        ="";


if(isset($_GET["id"])){
      $id_client = $_GET['id'];
      $sql = "select * from master_client where id='$id_client'";
      $result = mysqli_query($conn,$sql);
      if($row = mysqli_fetch_array($result)){
        $id_client          = $row["id"];
        $typeClientID       = $row["typeClientID"];
        $nameClient         = $row["nameClient"];
        $address            = $row["address"];
        $phone              = $row["phone"];
       

        $sql1 = "update master_client set status='Non Aktif' where id='$id_client'";
        mysqli_query($conn, $sql1);
        
        $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Hapus data klien') ";
        mysqli_query($conn, $sql_query1);

        if(mysqli_error($conn) == ""){
            echo '<script>
                swal({
                title: "Sukses!",
                text: "Data Klien berhasil dihapus.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=klien-data";
                });
                </script>'; 
        }else{
            echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Klien tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=klien-data";
                });
                </script>';   
        }
    }else{
         echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Klien tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=klien-data";
                });
                </script>'; 
    }
}else{
         echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Klien tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=klien-data";
                });
                </script>'; 
}
?>