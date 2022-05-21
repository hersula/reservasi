<?php  

include('../../connection.php');

$id         = isset($_GET['id']) ? $_GET['id'] : '';
$idKaryawan = isset($_GET['karyawanID']) ? $_GET['karyawanID'] : '';
$query_update_status = $conn->query("update transaksi_rawat_jalan set status='Failed', 	deletedFrom='$idKaryawan', 	deletedAt=NOW()  WHERE id='$id'") or die($conn->error);
if ($query_update_status) {
    # code...
    header('location: ' . $_SERVER['HTTP_REFERER']);
}