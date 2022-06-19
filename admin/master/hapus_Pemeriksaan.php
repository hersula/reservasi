<?php  

  include "../connection.php";

if (!$_SESSION['logged_on']) {
  header('location:index.php');
}



$id_tindakan    = $_GET['id'];
$name         = "";
$description  ="";
$price        ="";
$Kategori     ="";
$outlet       ="";
$outletTindakan="";
$isVisibleToPasien="1";
$spesimen         ="";


if(isset($_GET["id"])){
    $id_tindakan = $_GET["id"];

    $cekOutletTindakanList= "select * from outlet_pemeriksaan_list 
                             where outletPemeriksaan='$id_tindakan'";
    $cekHasilOTL = mysqli_query($conn,$cekOutletTindakanList);

        if(mysqli_num_rows($cekHasilOTL) > 0) {
            $sql = "select t.id, k.kat_pemeriksaan, t.name, t.description, t.price, t.spesimen, 
                otl.outletID, otl.outletPemeriksaan,  otl.isVisibleToPasien 
                from master_pemeriksaan t join outlet_pemeriksaan_list otl 
                on otl.outletPemeriksaan=t.id join master_kat_pemeriksaan k on k.id=t.kategori where t.id='$id_tindakan'";

              $result = mysqli_query($conn,$sql);
              if($row = mysqli_fetch_array($result)){
                $id_tindakan  = $row["id"];
                $name         = $row["name"];
                $price        = $row["price"];
                $description  = $row["description"];
                $Kategori     = $row["kat_pemeriksaan"];
                $outlet       = $row["outletID"];
                $isVisibleToPasien = $row["isVisibleToPasien"];
                $spesimen          = $row["spesimen"];
               

                $sql1 = "update master_pemeriksaan set status='Non Aktif' where id='$id_tindakan'";
                mysqli_query($conn, $sql1);

                $sql3 = "update outlet_pemeriksaan_list set status='Non Aktif'
                        where outletPemeriksaan='$id_tindakan'";
                mysqli_query($conn, $sql3);
                
                $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Hapus data pemeriksaan') ";
                mysqli_query($conn, $sql_query1);

                if(mysqli_error($conn) == ""){
                    echo '<script>
                        swal({
                        title: "Sukses!",
                        text: "Data Pemeriksaan berhasil dihapus.",
                        type: "success"
                        }).then(function() {
                        window.location = "admin.php?page=pemeriksaan-data";
                        });
                        </script>';
                }else{
                    echo '<script>
                        swal({
                        title: "Maaf!",
                        text: "2Data Pemeriksaan tidak berhasil dihapus.",
                        type: "error"
                        }).then(function() {
                        window.location="admin.php?page=pemeriksaan-data";
                        });
                        </script>'; 
                }


            }else{
                 echo '<script>
                        swal({
                        title: "Maaf!",
                        text: "3Data Pemeriksaan tidak berhasil dihapus.",
                        type: "error"
                        }).then(function() {
                        window.location="admin.php?page=pemeriksaan-data";
                        });
                        </script>'; 
            }   

        /*jika tidak ada id Tindakan tidak ada di outlet tindakan list*/
        }else {
             $id_tindakan = $_GET["id"];
             $sql = "select * from master_pemeriksaan p join master_kat_pemeriksaan k on k.id = p.kategori where p.id='$id_tindakan'";

              $result = mysqli_query($conn,$sql);
              if($row = mysqli_fetch_array($result)){
                $id_tindakan        = $row["id"];
                $name               = $row["name"];
                $description        = $row["description"];
                $price              = $row["price"];
                $Kategori           = $row["kat_pemeriksaan"];
                $spesimen           = $row["spesimen"];
               

                $sql1 = "update master_pemeriksaan set status='Non Aktif' where id='$id_tindakan'";
                mysqli_query($conn, $sql1);
                
                $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]','".date("Y-m-d H:i:s")."','Hapus data pemeriksaan') ";
                mysqli_query($conn, $sql_query1);


                if(mysqli_error($conn) == ""){
                    echo '<script>
                        swal({
                        title: "Sukses!",
                        text: "Data Pemeriksaan berhasil dihapus.",
                        type: "success"
                        }).then(function() {
                        window.location = "admin.php?page=pemeriksaan-data";
                        });
                        </script>';
                }else{
                    echo '<script>
                        swal({
                        title: "Maaf!",
                        text: "4Data Pemeriksaan tidak berhasil dihapus.",
                        type: "error"
                        }).then(function() {
                        window.location="admin.php?page=pemeriksaan-data";
                        });
                        </script>'; 
                }


            }else{
                 echo '<script>
                        swal({
                        title: "Maaf!",
                        text: "5Data Pemeriksaan tidak berhasil dihapus.",
                        type: "error"
                        }).then(function() {
                        window.location="admin.php?page=pemeriksaan-data";
                        });
                        </script>'; 
            }   
        }
}else{
        echo '<script>
                swal({
                title: "Maaf!",
                text: "6Data Pemeriksaan tidak berhasil dihapus.",
                type: "error"
                }).then(function() {
                window.location="admin.php?page=pemeriksaan-data";
                });
                </script>'; 
}
?>