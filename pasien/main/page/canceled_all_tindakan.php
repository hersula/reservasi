<?php  

include('../../../connection.php');
include('../../../helper/base_url.php');

$idTransaction = isset($_GET['idTransaction']) ? $_GET['idTransaction'] : '';


$query_delete = $conn->query("UPDATE transaksi_rawat_jalan SET status='Failed', deletedAt=NOW() WHERE transaksiID='$idTransaction'");
if ($query_delete) {
    # code...
    header('location: ' . BASE_URL . 'pasien/main/index.php?page=history');

}