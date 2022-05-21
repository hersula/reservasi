<?php  

include('../../../connection.php');
include('../../../helper/base_url.php');

$id = isset($_GET['id']) ? $_GET['id'] : '';


$query_delete = $conn->query("UPDATE transaksi_rawat_jalan SET status='Failed', deletedAt=NOW() WHERE id='$id'");
if ($query_delete) {
    # code...
    header('location: ' . BASE_URL . 'pasien/main/index.php?page=history');

}