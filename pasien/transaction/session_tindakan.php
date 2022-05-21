<?php

include('../../connection.php');
session_start();

$tindakanID = $_GET['tindakanID'];
$_SESSION['tindakanID'] = $tindakanID;

$nik = $_SESSION['nik'];
$registerTo = $_SESSION['type-registration'];
$nikTo = $_SESSION['nikTo'];
$outletID = $_SESSION['outletID'];
$sessTindakanID = $_SESSION['tindakanID'];
$gejala = $_SESSION['gejala'];
$deskripsiGejala = $_SESSION['deskripsiGejala'];


$cek_master_tindakan = mysqli_query($conn, "SELECT * FROM outlet_tindakan_list WHERE outletTindakan = '$tindakanID' AND outletID='$outletID'");
$price = mysqli_fetch_array($cek_master_tindakan);
$fetchPrice = $price['price'];


if ($tindakanID != null || $tindakanID != "") {
    # code...
    $query = "select * from temp_cart where nik='$nik' && registerTo='$registerTo'";
    $row = mysqli_num_rows(mysqli_query($conn, $query));

    if ($registerTo == 'Sendiri') {
        # code...
        $querySQL = mysqli_query($conn, "insert into temp_cart (id, nik, nikTo, outletID, tindakanID, registerTo, gejala, deskripsiGejala, qty, price) 
        values (null, '$nik', '$nik', '$outletID', '$tindakanID', '$registerTo', '$gejala', '$deskripsiGejala', 1, '$fetchPrice')") or die($conn->error);

        if ($querySQL) {
            # code...
            header("location: ../main/index.php?page=cart", true, 301);
        } else {
            echo "Maaf terjadi kesalahan";
        }
    } else {
        // $querySQL = mysqli_query($conn, "update temp_cart set outletID='$outletID', tindakanID='$tindakanID', gejala='$gejala', deskripsiGejala='$deskripsiGejala', price='$fetchPrice' where nik='$nik' && registerTo='$registerTo'") or die(mysqli_error($conn));

        // if ($querySQL) {
        //     # code...
        //     header("location: ../main/index.php?page=cart", true, 301);
        // } else {
        //     echo "Maaf terjadi kesalahan";
        // }
        $querySQL = mysqli_query($conn, "insert into temp_cart (id, nik, nikTo, outletID, tindakanID, registerTo, gejala, deskripsiGejala, qty, price) 
        values (null, '$nik', '$nikTo', '$outletID', '$tindakanID', '$registerTo', '$gejala', '$deskripsiGejala', 1, '$fetchPrice')") or die($conn->error);

        if ($querySQL) {
            # code...
            header("location: ../main/index.php?page=cart", true, 301);
        } else {
            echo "Maaf terjadi kesalahan";
        }
    }
}
