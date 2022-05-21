<?php

include('../connection.php');
include('../midtrans/midtrans-php/Midtrans.php');

\Midtrans\Config::$isProduction = true;
// \Midtrans\Config::$serverKey = 'SB-Mid-server-YJs6MvLmAO5IVqa466m9iI0L'; // this is sandbox
\Midtrans\Config::$serverKey = 'Mid-server-BvxOYaNyd56SVPkYp0KCbeZz';

$notif = new \Midtrans\Notification();

$transaction = $notif->transaction_status;
$type = $notif->payment_type;
$order_id = $notif->order_id;
$fraud = $notif->fraud_status;



if ($transaction == 'capture') {
    // For credit card transaction, we need to check whether transaction is challenge by FDS or not
    if ($type == 'credit_card') {
        if ($fraud == 'challenge') {
            // TODO set payment status in merchant's database to 'Challenge by FDS'
            // TODO merchant should decide whether this transaction is authorized or not in MAP
            echo "Transaction order_id: " . $order_id . " is challenged by FDS";
            mysqli_query($conn, "update transaksi_rawat_jalan set status = 'Pending' where transaksiID ='$order_id'");
        } else {
            // TODO set payment status in merchant's database to 'Success'
            echo "Transaction order_id: " . $order_id . " successfully captured using " . $type;
            mysqli_query($conn, "update transaksi_rawat_jalan set status = 'Paid' where transaksiID ='$order_id'");
        }
    }
} else if ($transaction == 'settlement') {
    // TODO set payment status in merchant's database to 'Settlement'
    echo "Transaction order_id: " . $order_id . " successfully transfered using " . $type;
    mysqli_query($conn, "update transaksi_rawat_jalan set status = 'Paid' where transaksiID ='$order_id'");
} else if ($transaction == 'pending') {
    // TODO set payment status in merchant's database to 'Pending'
    echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
    mysqli_query($conn, "update transaksi_rawat_jalan set status = 'Pending' where transaksiID ='$order_id'");
} else if ($transaction == 'deny') {
    // TODO set payment status in merchant's database to 'Denied'
    echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
    mysqli_query($conn, "update transaksi_rawat_jalan set status = 'Failed' where transaksiID ='$order_id'");
} else if ($transaction == 'expire') {
    // TODO set payment status in merchant's database to 'expire'
    echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
    mysqli_query($conn, "update transaksi_rawat_jalan set status = 'Failed' where transaksiID ='$order_id'");
} else if ($transaction == 'cancel') {
    // TODO set payment status in merchant's database to 'Denied'
    echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
    mysqli_query($conn, "update transaksi_rawat_jalan set status = 'Failed' where transaksiID ='$order_id'");
}
