<?php  

include('../../connection.php');

session_start();
$idTransaction = isset($_GET['idTransaction']) ? $_GET['idTransaction'] : '';
$idPasien = isset($_GET['idPasien']) ? $_GET['idPasien'] : '';
$tglTindakan = isset($_GET['tglTindakan']) ? $_GET['tglTindakan'] : '';
$idKaryawan = $_SESSION['idKaryawan'];

$query_update_status = $conn->query("update transaksi_rawat_jalan set status='On Process', confirmGetSample='$idKaryawan', sampleTime=NOW() where transaksiID='$idTransaction' && pasienID='$idPasien' && tglTindakan='$tglTindakan'");
if ($query_update_status) {
    # code...
    header('location: ' . $_SERVER['HTTP_REFERER']);

}
