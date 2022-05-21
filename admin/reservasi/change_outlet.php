<?php 

include('../../connection.php');

$transactionID        = isset($_POST['transactionID']) ? $_POST['transactionID'] : '';
$outletID             = isset($_POST['outletTindakan']) ? $_POST['outletTindakan'] : '';

if($outletID != '') {
    $query_change_outlet  = $conn->query("UPDATE transaksi_rawat_jalan SET outletID = '$outletID' WHERE id='$transactionID'") or die($conn->error);
    if ($query_change_outlet) {
    
        /*log file*/
        $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                        values ('$_SESSION[idKaryawan]',NOW(),'Ubah outlet pasien di halaman riwayat tindakan') ";
          mysqli_query($conn, $sql_query1);
        /*log file*/
        header('location: ' . $_SERVER['HTTP_REFERER']);
    }
} else {
    echo '<script>alert("Maaf, mohon untuk memilih perubahan outlet tindakan !");history.go(-1);</script>';
}


?>