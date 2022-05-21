<?php  

  include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}


  $id_role      = $_GET['id'];
  $roleName     = "";

if(isset($_GET["id"])){
      $id_role = $_GET['id'];
      $sql = "select * from master_roles where id='$id_role'";
      $result = mysqli_query($conn,$sql);
      if($row = mysqli_fetch_array($result)){
        $id_role      = $row["id"];
        $roleName     = $row["roleName"];
       

        $sql1 = "update master_roles set status='Non Aktif' where id='$id_role'";
        mysqli_query($conn, $sql1);
        
        $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Hapus data roles') ";
        mysqli_query($conn, $sql_query1);

        if(mysqli_error($conn) == ""){
          echo '<script>
                swal({
                title: "Sukses!",
                text: "Data Role berhasil dihapus.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=roles-data";
                });
                </script>';
        }else{
  
        echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Role tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=roles-data";
                });
                </script>';
        }
    }else{
            echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Role tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=roles-data";
                });
                </script>'; 
    }
}else{

             echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Role tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=roles-data";
                });
                </script>';
}
?>