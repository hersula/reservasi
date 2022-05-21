<?php  

  include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}


$id_pasien    = $_GET['id'];
$name           = "";
$description    ="";
$price          ="";
$typeTindakan   ="";

if(isset($_GET["id"])){
      $id_pasien = $_GET['id'];
      $sql = "select * from master_pasien where id='$id_pasien'";
      $result = mysqli_query($conn,$sql);
      if($row = mysqli_fetch_array($result)){
        $id_pasien    = $row["id"];
        $nik          = $row["nik"];
        $name         = $row["name"];
        $phone        = $row["phone"];
        $address      = $row["address"];
        $gender       = $row["gender"];
        $placeOfBirth = $row["placeOfBirth"];
        $dateOfBirth  = $row["dateOfBirth"];
        $passport     = $row["passport"];
        $country      = $row["country"];
        $isWNA        = $row["isWNA"];
        $email        = $row["email"];
        $avatar       = $row["avatar"];
       
        $sql1 = "update master_pasien set status='Non Aktif' where id='$id_pasien'";
        mysqli_query($conn, $sql1);
        
        $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Hapus data pasien') ";
        mysqli_query($conn, $sql_query1);

        if(mysqli_error($conn) == ""){
           echo '<script>
                swal({
                title: "Sukses!",
                text: "Data Pasien berhasil dihapus.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=master-pasien-data";
                });
                </script>'; 
        }else{  
            echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Pasien tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=master-pasien-data";
                });
                </script>'; 
        }
    }else{

        echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Pasien tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=master-pasien-data";
                });
                </script>';  
    }
}else{
        echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Pasien tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=master-pasien-data";
                });
                </script>'; 
}
?>