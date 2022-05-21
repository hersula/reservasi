<?php

include('../../connection.php');

$transaksiID = isset($_GET['id']) ? $_GET['id'] : '';
$pasienID    = isset($_GET['pasienID']) ? $_GET['pasienID'] : '';

if ($transaksiID != '' && $pasienID != '') {
    # code...
    $query_delete       = $conn->query("DELETE FROM master_hasil_tes WHERE idTransaction = '$transaksiID' AND idPasien ='$pasienID'");

    if ($query_delete) {
        # code...
        $query_update   = $conn->query("UPDATE transaksi_rawat_jalan SET status = 'On Process' WHERE transaksiID = '$transaksiID' AND pasienID = '$pasienID'");

        if ($query_update) {
            # code...
            header('location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
} else {
    header('location: ' . $_SERVER['HTTP_REFERER']);
}
