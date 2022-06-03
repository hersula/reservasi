<?php  

  include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}


  $id_kat      = $_GET['id'];
  $nameKat     = "";
//   $targetGenID    ="";
  $isActive="1";


if(isset($_GET["id"])){
      $id_kat = $_GET['id'];
      $sql = "select * from master_kat_pemeriksaan 
            where id='$id_kat' and status='1'";
      $result = mysqli_query($conn,$sql);
      if($row = mysqli_fetch_array($result)){
          $id_kat   = $row["id"];
          $nameKat  = $row["kat_pemeriksaan"];
          $isActive    = $row['status'];
        //   $targetGenID = $row["targetGenID"];
        //   $reagenID    = $row["reagenID"];
  

        $sql1 = "update master_kat_pemeriksaan set status='2' where id='$id_kat'";
        mysqli_query($conn, $sql1);

        // $sql2 = "update target_gen_list set status='Non Aktif' where reagenID='$id_reagen'";
        // mysqli_query($conn, $sql2);
        
        $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Hapus data Kategori Pemeriksaan') ";
        mysqli_query($conn, $sql_query1);

        if(mysqli_error($conn) == ""){
            echo '<script>
                swal({
                title: "Sukses!",
                text: "Data Kategori berhasil dihapus.",
                type: "success"
                }).then(function() {
                window.location = "admin.php?page=kategori-data";
                });
                </script>'; 
        }else{
            echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Kategori tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=kategori-data";
                });
                </script>';   
        }
    }else{
         echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Kategori tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=kategori-data";
                });
                </script>'; 
    }
}else{
         echo '<script>
                swal({
                title: "Maaf!",
                text: "Data Kategori tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location = "admin.php?page=kategori-data";
                });
                </script>'; 
}
?>