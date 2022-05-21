<?php  

  include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}


  $id_outlet= $_GET['id'];
  $name     = "";
  $address  ="";
  $phone    ="";
  $isFaskes="1";

if(isset($_GET["id"])){
      $id_outlet = $_GET['id'];
      $sql = "select * from master_outlet where id='$id_outlet'";
      $result = mysqli_query($conn,$sql);
      if($row = mysqli_fetch_array($result)){
        $id_outlet    = $row["id"];
        $name         = $row["name"];
        $address      = $row["address"];
        $phone        = $row["phone"];
        $isFaskes    = $row["isFaskes"];
       

        $sql1 = "update master_outlet set status='Non Aktif' where id='$id_outlet'";
        mysqli_query($conn, $sql1);
        
        $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Hapus data outlet') ";
        mysqli_query($conn, $sql_query1);

        if(mysqli_error($conn) == ""){
            echo '<script>
                swal({
                title: "Sukses!",
                text: "Data Outlet berhasil dihapus.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=outlet-data";
                });
                </script>'; 
        }else{
            echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Outlet tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=outlet-data";
                });
                </script>'; 
        }
    }else{
        echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Outlet tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=outlet-data";
                });
                </script>'; 
    }
}else{
        echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Outlet tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=outlet-data";
                });
                </script>'; 
}
?>