<?php

// include connection database
include('../../connection.php');


function format_id_transaction($name_outlet, $outletID)
{
    // Access the global $conn variable
    Global $conn;
    
    // check data by month and year
    $fullYMD        = date('ymd');
    $thisDay        = date('d');
    $thisMonth      = date('m');
    $thisYear       = date('Y');

    $query_cek_this_day = $conn->query("SELECT * FROM transaksi_rawat_jalan a JOIN master_outlet b on a.outletID = b.id WHERE DAY(a.createdAt) = '$thisDay' AND MONTH(a.createdAt) = '$thisMonth' AND YEAR(a.createdAt) = '$thisYear'");
    // printf("Select returned %d rows.\n", $query_cek_this_month->num_rows);
    // exit();

    if ($query_cek_this_day->num_rows >= 1) {
        # code...
        // $query = $conn->query("SELECT MAX(transaksiID) noAntrian FROM transaksi_rawat_jalan
        //                       WHERE Month(createdAt) = '$thisMonth' AND Year(createdAt) ='$thisYear'");
         $query = $conn->query("SELECT transaksiID as noAntrian FROM transaksi_rawat_jalan WHERE DAY(createdAt) = '$thisDay' AND Month(createdAt) = '$thisMonth' AND Year(createdAt) ='$thisYear' ORDER BY id DESC LIMIT 1 FOR UPDATE");
         
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

function typeTindakan($tindakanID)
{
    Global $conn;
    
    $query_check_typeTindakan = $conn->query("SELECT typeTindakan FROM master_tindakan WHERE id='$tindakanID'");

    if ($query_check_typeTindakan->num_rows > 0) {
        # code...
        $fetch_type_tindakan = $query_check_typeTindakan->fetch_array();
        return $fetch_type_tindakan['typeTindakan'];
    } else {
        return false;
    }
}

function check_pasien_exist($nik)
{
    // Access the global $conn variable
    Global $conn;
    
    $query_check_pasien = $conn->query("SELECT * FROM master_pasien WHERE nik='$nik'");

    if ($query_check_pasien->num_rows > 0) {
        # code...
        $fetch_id_pasien = $query_check_pasien->fetch_array();
        return $fetch_id_pasien['id'];
    } else {
        return false;
    }
}

function insert_transaction($idTransaction, $pasienID, $tindakanID, $outletID, $gejala, $deskripsiGejala, $paymentType, $discount, $tax, $grandTotal, $karyawanID, $billTo, $typeTindakan)
{
    // Access the global $conn variable
    Global $conn;
    $tglTindakan        = date('Y-m-d');
    // Insert Header
    $query_insert = $conn->query("INSERT INTO transaksi_rawat_jalan_h (id, transaksiID, tglTindakan, pasienID, outletID, grandtotal, status, created_date, created_by)
    values(null, '$idTransaction', '$tglTindakan', '$pasienID', '$outletID', $grandTotal, '1', NOW(), $karyawanID)") or die($conn->error);
    // mysqli_query($conn, $sql_header);

    // $price tindakan
    $query_select_price = $conn->query("SELECT price FROM outlet_tindakan_list WHERE outletTindakan='$tindakanID' AND outletID='$outletID'");
    $fetchPrice         = $query_select_price->fetch_array();
    $price              = $fetchPrice['price'];
    
    
    
    if($paymentType == '5' || $paymentType == '7') {
        if($typeTindakan == 'Non Result') {
            $query_insert = $conn->query("INSERT INTO transaksi_rawat_jalan (id, transaksiID, barcodeLab, softDeleteBarcode, pasienID, tindakanID, outletID, targetGenID, price, totalDisc, Tax, grandTotal, nikAccount, gejala, deskripsiGejala, tglTindakan, paymentType, paymentURL, billTo, status, createdFrom, deletedFrom, confirmPaymentFrom, confirmGetSample, createdAt, 	deletedAt, sampleTime, barcodeLabTime, resultTime, isSelfRegister)
                                  VALUES (null, '$idTransaction', 'Belum dibarcode', null, '$pasienID', '$tindakanID', '$outletID', null, '$price', $discount, $tax, $grandTotal, null, '$gejala', '$deskripsiGejala', '$tglTindakan', $paymentType, null, '$billTo', 'Close', $karyawanID, null, $karyawanID, $karyawanID, NOW(), null, NOW(), null, NOW(), 0)") or die($conn->error);
        } else {
            $query_insert = $conn->query("INSERT INTO transaksi_rawat_jalan (id, transaksiID, barcodeLab, softDeleteBarcode, pasienID, tindakanID, outletID, targetGenID, price, totalDisc, Tax, grandTotal, nikAccount, gejala, deskripsiGejala, tglTindakan, paymentType, paymentURL, billTo, status, createdFrom, deletedFrom, confirmPaymentFrom, confirmGetSample, createdAt, 	deletedAt, sampleTime, barcodeLabTime, resultTime, isSelfRegister)
                                  VALUES (null, '$idTransaction', 'Belum dibarcode', null, '$pasienID', '$tindakanID', '$outletID', null, '$price', $discount, $tax, $grandTotal, null, '$gejala', '$deskripsiGejala', '$tglTindakan', $paymentType, null, '$billTo', 'Paid', $karyawanID, null, null, null, NOW(), null, null, null, null, 0)") or die($conn->error);
        }
    } else {
        if($typeTindakan == 'Non Result') {
            $query_insert = $conn->query("INSERT INTO transaksi_rawat_jalan (id, transaksiID, barcodeLab, softDeleteBarcode, pasienID, tindakanID, outletID, targetGenID, price, totalDisc, Tax, grandTotal, nikAccount, gejala, deskripsiGejala, tglTindakan, paymentType, paymentURL, billTo, status, createdFrom, deletedFrom, confirmPaymentFrom, confirmGetSample, createdAt, 	deletedAt, sampleTime, barcodeLabTime, resultTime, isSelfRegister)
                                  VALUES (null, '$idTransaction', 'Belum dibarcode', null, '$pasienID', '$tindakanID', '$outletID', null, '$price', $discount, $tax, $grandTotal, null, '$gejala', '$deskripsiGejala', '$tglTindakan', $paymentType, null, '$billTo', 'Close', $karyawanID, null, $karyawanID, $karyawanID, NOW(), null, NOW(), null, NOW(), 0)") or die($conn->error);
        } else {
            $query_insert = $conn->query("INSERT INTO transaksi_rawat_jalan (id, transaksiID, barcodeLab, softDeleteBarcode, pasienID, tindakanID, outletID, targetGenID, price, totalDisc, Tax, grandTotal, nikAccount, gejala, deskripsiGejala, tglTindakan, paymentType, paymentURL, billTo, status, createdFrom, deletedFrom, confirmPaymentFrom, confirmGetSample, createdAt, 	deletedAt, sampleTime, barcodeLabTime, resultTime, isSelfRegister)
                                  VALUES (null, '$idTransaction', 'Belum dibarcode', null, '$pasienID', '$tindakanID', '$outletID', null, '$price', $discount, $tax, $grandTotal, null, '$gejala', '$deskripsiGejala', '$tglTindakan', $paymentType, null, '$billTo', 'Open', $karyawanID, null, null, null, NOW(), null, null, null, null, 0)") or die($conn->error);
        }
        
    }

    foreach ($_POST['targetGenID'] as $value) {
        $query_select_price = $conn->query("SELECT price FROM outlet_pemeriksaan_list WHERE outletPemeriksaan='$value' AND outletID='$outletID'");
        $fetchPrice         = $query_select_price->fetch_array();
        $nprice              = $fetchPrice['price'];
        
        $query_insert = $conn->query("insert into transaksi_rawat_jalan (id, transaksiID, barcodeLab, softDeleteBarcode, pasienID, targetGenID, outletID, price, totalDisc, Tax, grandTotal, nikAccount, gejala, deskripsiGejala, tglTindakan, paymentType, paymentURL, billTo, status, createdFrom, deletedFrom, confirmPaymentFrom, confirmGetSample, createdAt, 	deletedAt, sampleTime, barcodeLabTime, resultTime, isSelfRegister)
        VALUES (null, '$idTransaction', 'Belum dibarcode', null, '$pasienID', '$value', '$outletID', '$price', $discount, $tax, $grandTotal, null, '$gejala', '$deskripsiGejala', '$tglTindakan', $paymentType, null, '$billTo', 'Open', $karyawanID, null, null, null, NOW(), null, null, null, null, 0)") or die($conn->error);
        // mysqli_query($conn, $sql);
    }
    
    if ($query_insert) {
        # code...
        return true;
    } else {
        # code...
        return false;
    }
    
    
    
}

function insert_pasien($nik, $name, $passport, $phone, $isWNA, $country, $gender, $address, $placeOfBirth, $dateOfBirth)
{
    // Access the global $conn variable
    Global $conn;
    
    if ($nik == '' || $nik == null) {

        $query_insert = $conn->query("INSERT INTO master_pasien (id, nik, name, email, phone, address, gender, placeOfBirth, dateOfBirth, password, avatar, token, status, passport, country, isWNA, isSelfRegister, isEmailVerified, createdAt)
                                  VALUES (null, '$passport', '$name', 'null', '$phone', '$address', '$gender', '$placeOfBirth', '$dateOfBirth', 'null', 'null', 'null', 'Aktif', '$passport', '$country', '$isWNA', 0, 0, NOW())") or die($conn->error);
    } else {
        $query_insert = $conn->query("INSERT INTO master_pasien (id, nik, name, email, phone, address, gender, placeOfBirth, dateOfBirth, password, avatar, token, status, passport, country, isWNA, isSelfRegister, isEmailVerified, createdAt)
                                  VALUES (null, '$nik', '$name', 'null', '$phone', '$address', '$gender', '$placeOfBirth', '$dateOfBirth', 'null', 'null', 'null', 'Aktif', '$passport', '$country', '$isWNA', 0, 0, NOW())") or die($conn->error);
    }
    
    if ($query_insert) {
        # code...
        return $conn->insert_id;
    } else {
        # code...
        return false;
    }
}

function grandTotal($tindakanID, $tax, $discount,$outletID)
{
    // Access the global $conn variable
    Global $conn;
    
    $query    = $conn->query("SELECT price FROM outlet_tindakan_list WHERE outletTindakan='$tindakanID' AND outletID='$outletID'");
    $fetch    = $query->fetch_array();
    $price    = $fetch['price'];
    $taxs     = (int)$tax/100;
    $grandTotal = (int)$price + (int)($price * $taxs) - (int)$discount;

    return $grandTotal;
}

session_start();
// variable post outletID
$outletID = isset($_POST['outletID']) ? $_POST['outletID'] : '';

// get name outlet for string id transaction
$get_name_outlet = $conn->query("SELECT name FROM master_outlet WHERE id='$outletID'");
$fetch_name = $get_name_outlet->fetch_array();

// cut string name outlet uppercase
$subst_name_outlet = substr(strtoupper($fetch_name['name']), 0, 5);

// set data variable post
$nik                 = isset($_POST['nik']) ? $_POST['nik'] : '';
$passport            = isset($_POST['passport']) ? $_POST['passport'] : '';
$name                = isset($_POST['name']) ? str_replace("'", "`", $_POST['name']) : '';
$phone               = isset($_POST['phone']) ? $_POST['phone'] : '';
$isWNA               = isset($_POST['isWNA']) ? $_POST['isWNA'] : '';
$country             = isset($_POST['country']) ? $_POST['country'] : '';
$gender              = isset($_POST['gender']) ? $_POST['gender'] : '';
$address             = isset($_POST['address']) ? str_replace("'", "`", $_POST['address']) : '';
$placeOfBirth        = isset($_POST['placeOfBirth']) ? str_replace("'", "`", $_POST['placeOfBirth']) : '';
$dateOfBirth         = isset($_POST['dateOfBirth']) ? $_POST['dateOfBirth'] : '';
$gejala              = isset($_POST['gejala']) ? $_POST['gejala'] : '';
$deskripsiGejala     = isset($_POST['deskripsiGejala']) ? $_POST['deskripsiGejala'] : '';
$tindakanID          = isset($_POST['tindakanID']) ? $_POST['tindakanID'] : '';
$paymentType         = isset($_POST['paymentType']) ? (int)$_POST['paymentType'] : '';
$billTo              = isset($_POST['billTo']) ? (int)$_POST['billTo'] : 0;
$karyawanID          = isset($_SESSION['idKaryawan']) ? (int)$_SESSION['idKaryawan'] : 0;
$discount            = isset($_POST['diskon']) ? (int)$_POST['diskon'] : '';
$tax                 = isset($_POST['tax']) ? (int)$_POST['tax'] : '';
$grandTotal          = (int)grandTotal($tindakanID, $tax, $discount, $outletID);
$typeTindakan        = typeTindakan($tindakanID);


// variable check pasien
$pasien_id_exist = check_pasien_exist($nik);

if ($name == '' || $address == '' || $dateOfBirth == '' || $gejala == '') {
    // check semua required Fields apakah sudah terisi
    # code...
    echo '<script>alert("Mohon untuk melengkapi field yang tersedia !");history.go(-1);</script>';
} else if(strlen($nik) > 16) {
    echo '<script>alert("Panjang NIK maksimal 16 karakter !");history.go(-1);</script>';
} else if ($nik == '' && $passport == '') {
    echo '<script>alert("NIK atau Passport tidak boleh kosong !");history.go(-1);</script>';
} else {
    
    try {
        // Do all this in a single transaction
        $conn->begin_transaction();
        
        // get next transactionID
        $idTransaction = format_id_transaction($subst_name_outlet, $outletID);
        
        // Check apakah transaksiID tersebut sudah ada di database
        $select_id_transaction = $conn->query("select transaksiID from transaksi_rawat_jalan where transaksiID = '$idTransaction'") or die($conn->error);
        
        if($select_id_transaction->num_rows == 1) {
            $conn->rollback();
            echo '<script>alert("Maaf terjadi kesalahan. Transaksi ID ' . $idTransaction . ' sudah terdaftar di system. Mohon lakukan penginputan ulang!");history.go(-1);</script>';
        } else {
            if ($pasien_id_exist != false) {
                # code...
                $input_transaction = insert_transaction($idTransaction, $pasien_id_exist, $tindakanID, $outletID, $gejala, $deskripsiGejala, $paymentType, $discount, $tax, $grandTotal, $karyawanID, $billTo, $typeTindakan);
        
                if ($input_transaction) {
                    # code...
                             
                    /*log file*/
                    $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                                    values ('$_SESSION[idKaryawan]',NOW(),'Admin melakukan pendaftaran pasien ID $pasien_id_exist dan transaksi ID $idTransaction') ";
                      mysqli_query($conn, $sql_query1);
                    /*log file*/
                    
                    // Everything OKE, Commit!!
                    $conn->commit();
                    
                    echo '<script>alert("Tindakan baru berhasil ditambahkan !");window.location.replace("../admin.php?page=reservation");</script>';
                } else {
                    # code...
                    
                    // Something wrong, Rollback!!
                    $conn->rollback();
                    
                    echo '<script>alert("Tindakan baru gagal ditambahkan ! Mohon periksa kembali datanya!");history.go(-1);</script>';
                }
            } else {
                $last_id_pasien_from_input = insert_pasien($nik, $name, $passport, $phone, $isWNA, $country, $gender, $address, $placeOfBirth, $dateOfBirth);
                if ($last_id_pasien_from_input != false) {
                    # code...
                    $input_transaction = insert_transaction($idTransaction, $last_id_pasien_from_input, $tindakanID, $outletID, $gejala, $deskripsiGejala, $paymentType, $discount, $tax, $grandTotal, $karyawanID, $billTo, $typeTindakan);
                    if ($input_transaction) {
                        # code...
                         
                        /*log file*/
                        $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                                        values ('$_SESSION[idKaryawan]',NOW(),'Admin melakukan pendaftaran pasien ID $last_id_pasien_from_input dan transaksi ID $idTransaction') ";
                          mysqli_query($conn, $sql_query1);
                        /*log file*/
                        
                        // Everything OK, Commit!!
                        $conn->commit();
                        
                        echo '<script>alert("Tindakan baru berhasil ditambahkan !");window.location.replace("../admin.php?page=reservation")</script>';
                    } else {
                        // Something wrong, rollback!!
                        $conn->rollback();
                        
                        echo '<script>alert("Tindakan baru gagal ditambahkan ! Mohon periksa kembali datanya!");history.go(-1);</script>';
                    }
                }
            }
        } 
    } catch (Exception $e) {
        $conn->rollback();
    }
}