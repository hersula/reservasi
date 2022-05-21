<?php  

include('../../connection.php');

session_start();
$idKaryawan = $_SESSION['idKaryawan'];

$transactionID      = isset($_POST['transactionID']) ? $_POST['transactionID'] : '';

if($transactionID != '') {
    $query_remove_tindakan = $conn->query("update transaksi_rawat_jalan set status='Failed', deletedFrom='$idKaryawan', deletedAt=NOW()  WHERE id='$transactionID'") or die($conn->error);
    if ($query_remove_tindakan) {
  
    /*log file*/
    $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Hapus riwayat tindakan pasien di halaman riwayat tindakan') ";
      mysqli_query($conn, $sql_query1);
    /*log file*/
    
        header('location: ' . $_SERVER['HTTP_REFERER']);
    }
} else {
    echo '<script>alert("Maaf, ID Transaksi tidak ditemukan !");history.go(-1);</script>';
}