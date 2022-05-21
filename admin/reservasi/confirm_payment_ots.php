<?php  

include('../../connection.php');

session_start();
// $idTransaction = isset($_GET['idTransaction']) ? $_GET['idTransaction'] : '';
// $idPasien = isset($_GET['idPasien']) ? $_GET['idPasien'] : '';
// $tglTindakan = isset($_GET['tglTindakan']) ? $_GET['tglTindakan'] : '';
$idKaryawan = $_SESSION['idKaryawan'];

// $query_update_status = $conn->query("update transaksi_rawat_jalan set status='Paid', confirmPaymentFrom='$idKaryawan' where transaksiID='$idTransaction' && pasienID='$idPasien' && tglTindakan='$tglTindakan'");
// if ($query_update_status) {
//     # code...
//     header('location: ' . $_SERVER['HTTP_REFERER']);
// }


$transactionID      = isset($_POST['transactionID']) ? $_POST['transactionID'] : '';
$namePayment        = isset($_POST['typePayment']) ? $_POST['typePayment'] : '';

if($namePayment != '') {
    $query_update_payment = $conn->query("UPDATE transaksi_rawat_jalan set paymentType='$namePayment', status='Paid', confirmPaymentFrom='$idKaryawan' WHERE id='$transactionID'") or die($conn->error);
    if ($query_update_payment) {
   
        
    /*log file*/
    $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                    values ('$_SESSION[idKaryawan]',NOW(),'Konfirmasi pembayaran pasien di halaman riwayat tindakan') ";
      mysqli_query($conn, $sql_query1);
    /*log file*/
        header('location: ' . $_SERVER['HTTP_REFERER']);
    }
} else {
    echo '<script>alert("Maaf, mohon untuk memilih tipe pembayaran yang digunakan !");history.go(-1);</script>';
}