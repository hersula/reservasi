<?php  

  include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}


$idKaryawan = $_GET["id"]; 
$name       = "";
$email      = "";
$phone      ="";
$password   ="";
$outlet     ="";
$roleID     ="";
$karyawanID ="";

if(isset($_GET["id"])){
    $idKaryawan = $_GET["id"];
 
    $sql = "select k.id, k.outletID, k.name, k.email, k.phone, k.password, 
            krl.rolesID as 'rolesID', r.roleName as 'roleName' 
            from master_karyawan k join karyawan_role_list krl
            on k.id=krl.karyawanID join master_roles r on r.id=krl.rolesID 
            where k.id='$idKaryawan'";

    $result = mysqli_query($conn,$sql);
    if($row = mysqli_fetch_array($result)){
      $idKaryawan   = $row["id"];
      $outlet       = $row["outletID"];
      $name         = $row["name"];
      $email        = $row["email"];
      $phone        = $row["phone"];
      $password     = $row["password"];
      $roleID       = $row["rolesID"];



    $sql1 = "update master_karyawan set status='Non Aktif' where id='$idKaryawan'";
    mysqli_query($conn, $sql1);

    $sql2 = "update karyawan_role_list set status='Non Aktif' where karyawanID='$idKaryawan'";
    mysqli_query($conn, $sql2);
    
    $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Hapus data karyawan') ";
    mysqli_query($conn, $sql_query1);


        if(mysqli_error($conn) == ""){
          echo '<script>
                swal({
                title: "Sukses!",
                text: "Data Karyawan berhasil dihapus.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=karyawan-data";
                });
                </script>';
        }else{
  
        echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Karyawan tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=karyawan-data";
                });
                </script>';
        }
    }else{
            echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Karyawan tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=karyawan-data";
                });
                </script>'; 
    }
}else{

             echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Karyawan tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=karyawan-data";
                });
                </script>';
}
?>