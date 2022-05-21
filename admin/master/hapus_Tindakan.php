<?php  

  include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}



$id_tindakan    = $_GET['id'];
$name         = "";
$description  ="";
$price        ="";
$typeTindakan ="";
$outlet       ="";
$outletTindakan="";
$isVisibleToPasien="1";
$spesimen         ="";


if(isset($_GET["id"])){
    $id_tindakan = $_GET["id"];

    $cekOutletTindakanList= "select * from outlet_tindakan_list 
                             where outletTindakan='$id_tindakan'";
    $cekHasilOTL = mysqli_query($conn,$cekOutletTindakanList);

        if(mysqli_num_rows($cekHasilOTL) > 0) {
            $sql = "select t.id, t.name, t.description, t.price, t.typeTindakan, t.spesimen, 
                otl.outletID, otl.outletTindakan,  otl.isVisibleToPasien 
                from master_tindakan t join outlet_tindakan_list otl 
                on otl.outletTindakan=t.id where t.id='$id_tindakan'";

              $result = mysqli_query($conn,$sql);
              if($row = mysqli_fetch_array($result)){
                $id_tindakan  = $row["id"];
                $name         = $row["name"];
                $price        = $row["price"];
                $description  = $row["description"];
                $typeTindakan = $row["typeTindakan"];
                $outlet       = $row["outletID"];
                $isVisibleToPasien = $row["isVisibleToPasien"];
                $spesimen          = $row["spesimen"];
               

                $sql1 = "update master_tindakan set status='Non Aktif' where id='$id_tindakan'";
                mysqli_query($conn, $sql1);

                $sql3 = "update outlet_tindakan_list set status='Non Aktif'
                        where outletTindakan='$id_tindakan'";
                mysqli_query($conn, $sql3);
                
                $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Hapus data tindakan') ";
                mysqli_query($conn, $sql_query1);

                if(mysqli_error($conn) == ""){
                    echo '<script>
                        swal({
                        title: "Sukses!",
                        text: "Data Tindakan berhasil dihapus.",
                        type: "success"
                        }).then(function() {
                        window.location = "admin.php?page=tindakan-data";
                        });
                        </script>';
                }else{
                    echo '<script>
                        swal({
                        title: "Maaf!",
                        text: "2Data Tindakan tidak berhasil dihapus.",
                        type: "error"
                        }).then(function() {
                        window.location="admin.php?page=tindakan-data";
                        });
                        </script>'; 
                }


            }else{
                 echo '<script>
                        swal({
                        title: "Maaf!",
                        text: "3Data Tindakan tidak berhasil dihapus.",
                        type: "error"
                        }).then(function() {
                        window.location="admin.php?page=tindakan-data";
                        });
                        </script>'; 
            }   

        /*jika tidak ada id Tindakan tidak ada di outlet tindakan list*/
        }else {
             $id_tindakan = $_GET["id"];
             $sql = "select * from master_tindakan where id='$id_tindakan'";

              $result = mysqli_query($conn,$sql);
              if($row = mysqli_fetch_array($result)){
                $id_tindakan        = $row["id"];
                $name               = $row["name"];
                $description        = $row["description"];
                $price              = $row["price"];
                $typeTindakan       = $row["typeTindakan"];
                $spesimen           = $row["spesimen"];
               

                $sql1 = "update master_tindakan set status='Non Aktif' where id='$id_tindakan'";
                mysqli_query($conn, $sql1);
                
                $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]','".date("Y-m-d H:i:s")."','Hapus data tindakan') ";
                mysqli_query($conn, $sql_query1);


                if(mysqli_error($conn) == ""){
                    echo '<script>
                        swal({
                        title: "Sukses!",
                        text: "Data Tindakan berhasil dihapus.",
                        type: "success"
                        }).then(function() {
                        window.location = "admin.php?page=tindakan-data";
                        });
                        </script>';
                }else{
                    echo '<script>
                        swal({
                        title: "Maaf!",
                        text: "4Data Tindakan tidak berhasil dihapus.",
                        type: "error"
                        }).then(function() {
                        window.location="admin.php?page=tindakan-data";
                        });
                        </script>'; 
                }


            }else{
                 echo '<script>
                        swal({
                        title: "Maaf!",
                        text: "5Data Tindakan tidak berhasil dihapus.",
                        type: "error"
                        }).then(function() {
                        window.location="admin.php?page=tindakan-data";
                        });
                        </script>'; 
            }   
        }
}else{
        echo '<script>
                swal({
                title: "Maaf!",
                text: "6Data Tindakan tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location="admin.php?page=tindakan-data";
                });
                </script>'; 
}
?>