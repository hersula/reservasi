<?php

require '../../connection.php';
require_once '../../midtrans/midtrans-php/Midtrans.php';

function format_id_transaction($name_outlet, $outletID)
{
    // Access the Global $conn
    Global $conn;

    // check data by month and year
    $fullYMD        = date('ymd');
    $thisDay        = date('d');
    $thisMonth      = date('m');
    $thisYear       = date('Y');

    // Check whether we already have any transaction today
    $query_cek_this_day = $conn->query("SELECT * FROM transaksi_rawat_jalan a JOIN master_outlet b on a.outletID = b.id WHERE DAY(a.createdAt) = '$thisDay' AND MONTH(a.createdAt) = '$thisMonth' AND YEAR(a.createdAt) = '$thisYear'");

    if ($query_cek_this_day->num_rows >= 1) {
        # code...
        // $query = $conn->query("SELECT MAX(transaksiID) noAntrian FROM transaksi_rawat_jalan
        //                       WHERE Month(createdAt) = '$thisMonth' AND Year(createdAt) ='$thisYear'") or die($conn->error);
        
        $query = $conn->query("SELECT transaksiID as noAntrian FROM transaksi_rawat_jalan WHERE DAY(createdAt) = '$thisDay' AND Month(createdAt) = '$thisMonth' AND Year(createdAt) ='$thisYear' ORDER BY id DESC LIMIT 1 FOR UPDATE") or die($conn->error);
        $fetchAntrian = $query->fetch_array();
        $antrian = $fetchAntrian['noAntrian'];
        $antrianInt = (int)substr($antrian, 6) + 1;

        if ($antrianInt > 9999) {
             $invID = str_pad($antrianInt, 5, '0', STR_PAD_LEFT);
        } else {
            $invID = str_pad($antrianInt, 4, '0', STR_PAD_LEFT);
        }
        
        return $fullYMD . $invID;
    } else {
        # code...
        $invID = str_pad('1', 4, '0', STR_PAD_LEFT);

        return $fullYMD . $invID;
    }
}

session_start();

$date_now = date('Y-m-d');
$nik = $_SESSION['nik'];

$outletIDs = $_GET['outletID'];

// get name outlet for string id transaction
$get_name_outlet = $conn->query("SELECT name FROM master_outlet WHERE id='$outletIDs'");
$fetch_name = $get_name_outlet->fetch_array();

// cut string name outlet uppercase
$subst_name_outlet = substr(strtoupper($fetch_name['name']), 0, 5);

$paymentType = isset($_POST['payment']) ? (int)$_POST['payment'] : '';
$dateTindakan = isset($_POST['tgl_tindakan']) ? $_POST['tgl_tindakan'] : '';
$totalPrice = $_GET['total'];


$cek_temp_cart = mysqli_query($conn, "select temp_cart.*, master_pasien.id as pasienID from temp_cart 
JOIN master_pasien on temp_cart.nikTo = master_pasien.nik where temp_cart.nik='$nik'");

$day = explode('-', $date_now);
$day_tindakan_exp = explode('-', $dateTindakan);

$day_tindakan = mktime($day_tindakan_exp[1],$day_tindakan_exp[2],$day_tindakan_exp[0]);
$expired_day = mktime($day[1],$day[2],$day[0]);

if($day_tindakan < $expired_day){
    echo "<script>
            alert('Tanggal yang dipilih tidak boleh kurang dari hari ini.');
            window.location.href = '../main/index.php?page=cart';
        </script>";
    exit;
}else{
    $date_insert = $dateTindakan;
}

// Start database transaction
$conn->begin_transaction();

// Get transaksiID
$invoice = format_id_transaction($subst_name_outlet, $outletIDs);

try {
    if ($paymentType == 1) {
        // Payment by Cash
        
        while ($result_cek_cart = mysqli_fetch_array($cek_temp_cart)) {
            # code...
            $pasienID = $result_cek_cart['pasienID'];
            $outletID = $result_cek_cart['outletID'];
            $tindakanID = $result_cek_cart['tindakanID'];
            $gejala = $result_cek_cart['gejala'];
            $deskripsiGejala = $result_cek_cart['deskripsiGejala'];
            $qty = $result_cek_cart['qty'];
            $price = $result_cek_cart['price'];
    
            $select_discount = $conn->query("select isFaskes from master_outlet where id='$outletID'") or die(mysqli_error($conn));
            $fetch           = $select_discount->fetch_array();
           
            $isFaskes        = $fetch['isFaskes'];
    
            if ($isFaskes == '0') {
                # code...
                $insert_rawat_jalan = mysqli_query($conn, "insert into transaksi_rawat_jalan values 
                    (null, '$invoice', 'Belum dibarcode', null, '$pasienID', '$tindakanID', '$outletID', null, '$price', 0, 0,'$price', '$nik', '$gejala', '$deskripsiGejala', '$date_insert', $paymentType, null, null, 'Open', null, null, null, null, null, NOW(), null, null, null, null,1)") or die(mysqli_error($conn));
            } else {
                $insert_rawat_jalan = mysqli_query($conn, "insert into transaksi_rawat_jalan values 
                    (null, '$invoice', 'Belum dibarcode', null, '$pasienID', '$tindakanID', '$outletID', null, '$price', 0, 0,'$price' ,'$nik', '$gejala', '$deskripsiGejala', '$date_insert', $paymentType, null, null, 'Open', null, null, null, null, null, NOW(), null, NOW(), null, null,1)") or die(mysqli_error($conn));
            }
            
            $invoice++;
        }
        
        if ($insert_rawat_jalan) {
            # code...
            $delete_temp_cart = mysqli_query($conn, "delete from temp_cart where nik='$nik'") or die(mysqli_error($conn));
            
            // everything OK. Commit!
            $conn->commit();
    
            header("location:  ../main/index.php?page=invoice&invoice_id=$invoice", true, 301); exit();
        } else {
            // Something wrong. Rollback!
            $conn->rollback();
        }
        
    } else {
        // Payment by Midtrans
        
        // this is sandbox
        // Midtrans\Config::$serverKey = 'SB-Mid-server-YJs6MvLmAO5IVqa466m9iI0L';
        // Midtrans\Config::$isProduction = false;
        // Midtrans\Config::$isSanitized = true;
        // Midtrans\Config::$is3ds = true;
        
        Midtrans\Config::$serverKey = 'Mid-server-BvxOYaNyd56SVPkYp0KCbeZz';
        Midtrans\Config::$isProduction = true;
        Midtrans\Config::$isSanitized = true;
        Midtrans\Config::$is3ds = true;
    
        $params = [
            'transaction_details' => [
                'order_id' => $invoice,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $_SESSION['name'],
                'email' => $_SESSION['email'],
                'phone' => $_SESSION['phone'],
            ],
    
        ];
    
        $tokenURL = \Midtrans\Snap::getSnapToken($params);
        
    
        while ($result_cek_cart = mysqli_fetch_array($cek_temp_cart)) {
            $pasienID = $result_cek_cart['pasienID'];
            $outletID = $result_cek_cart['outletID'];
            $tindakanID = $result_cek_cart['tindakanID'];
            $gejala = $result_cek_cart['gejala'];
            $deskripsiGejala = $result_cek_cart['deskripsiGejala'];
            $qty = $result_cek_cart['qty'];
            $price = $result_cek_cart['price'];
            
            $select_discount = $conn->query("select isFaskes from master_outlet where id='$outletID'") or die(mysqli_error($conn));
            $fetch           = $select_discount->fetch_array();
            $isFaskes        = $fetch['isFaskes'];
            
            
            if ($isFaskes == '0') {
                # code...
                $insert_rawat_jalan = mysqli_query($conn, "insert into transaksi_rawat_jalan values 
                    (null, '$invoice', 'Belum dibarcode', null, '$pasienID', '$tindakanID', '$outletID', null, '$price', 0, 0, '$price', '$nik', '$gejala', '$deskripsiGejala', '$date_insert', $paymentType, '$tokenURL', null, 'Open', null, null, null, null, null, NOW(), null, null, null, null)") or die(mysqli_error($conn));
            } else {
                $insert_rawat_jalan = mysqli_query($conn, "insert into transaksi_rawat_jalan values 
                    (null, '$invoice', 'Belum dibarcode', null, '$pasienID', '$tindakanID', '$outletID', null, '$price', 0, 0, '$price', '$nik', '$gejala', '$deskripsiGejala', '$date_insert', $paymentType, '$tokenURL', null, 'Open', null, null, null, null, null, NOW(), null, NOW(), null, null)") or die(mysqli_error($conn));
            }
            
            $invoice++;
        }
    
        if ($insert_rawat_jalan) {
            # code...
            $delete_temp_cart = mysqli_query($conn, "delete from temp_cart where nik='$nik'") or die(mysqli_error($conn));
    
            $conn->commit();
            
            header("location:  ../main/index.php?page=invoice&invoice_id=$invoice", true, 301); exit();
        } else {
            $conn->rollback();
        }
    }
} catch (Exception $e) {
    $conn->rollback();
}
