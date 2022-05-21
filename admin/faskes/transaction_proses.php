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

function insert_transaction($idTransaction, $pasienID, $tindakanID, $outletID, $gejala, $deskripsiGejala, $karyawanID)
{
    // Access the global $conn variable
    Global $conn;

    
    $query_select_price = $conn->query("SELECT price FROM outlet_tindakan_list WHERE outletTindakan='$tindakanID' AND outletID='$outletID'");
    $fetchPrice         = $query_select_price->fetch_array();
    $price              = $fetchPrice['price'];

    $tglTindakan        = date('Y-m-d');

    $query_insert = $conn->query("INSERT INTO transaksi_rawat_jalan (id, transaksiID, barcodeLab, softDeleteBarcode, pasienID, tindakanID, outletID, targetGenID, price, totalDisc, Tax, grandTotal, nikAccount, gejala, deskripsiGejala, tglTindakan, paymentType, paymentURL, billTo, status, createdFrom, deletedFrom, confirmPaymentFrom, confirmGetSample, createdAt, deletedAt, sampleTime, barcodeLabTime, resultTime,  isSelfRegister)
                                  VALUES (null, '$idTransaction', 'Belum dibarcode', null, '$pasienID', '$tindakanID', '$outletID', null, '$price', 0, 0, '$price', null, '$gejala', '$deskripsiGejala', '$tglTindakan', 5, null, null, 'On Process', $karyawanID, null, $karyawanID, $karyawanID, NOW(), null, NOW(), null, null, 0)") or die($conn->error);

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
$name                = isset($_POST['name']) ? str_replace("'", "`", strtoupper($_POST['name'])) : '';
$phone               = isset($_POST['phone']) ? $_POST['phone'] : '';
$isWNA               = isset($_POST['isWNA']) ? $_POST['isWNA'] : '';
$country             = isset($_POST['country']) ? $_POST['country'] : '';
$gender              = isset($_POST['gender']) ? $_POST['gender'] : '';
$address             = isset($_POST['address']) ? str_replace("'", "`", strtoupper($_POST['address'])) : '';
$placeOfBirth        = isset($_POST['placeOfBirth']) ? str_replace("'", "`", strtoupper($_POST['placeOfBirth'])) : '';
$dateOfBirth         = isset($_POST['dateOfBirth']) ? $_POST['dateOfBirth'] : '';
$gejala              = isset($_POST['gejala']) ? $_POST['gejala'] : '';
$deskripsiGejala     = isset($_POST['deskripsiGejala']) ? $_POST['deskripsiGejala'] : '';
$tindakanID          = isset($_POST['tindakanID']) ? $_POST['tindakanID'] : '';
// $karyawanID          = $_SESSION['idKaryawan'];
$karyawanID          = isset($_SESSION['idKaryawan']) ? (int)$_SESSION['idKaryawan'] : 0;

// variable check pasien
$pasien_id_exist = check_pasien_exist($nik);

if ($name == '' || $address == '' || $dateOfBirth == '' || $gejala == '') {
    # code...
    echo '<script>alert("Mohon untuk melengkapi field yang tersedia !");history.go(-1);</script>';
} else if(strlen($nik) > 16 ) {
    echo '<script>alert("Panjang NIK minimal 16 karakter !");history.go(-1);</script>';
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
            // Transaction ID sudah terdaftar. Rollback!!
            $conn->rollback();
            echo '<script>alert("Maaf terjadi kesalahan, mohon lakukan penginputan ulang!");history.go(-1);</script>';
        } else {
            if ($pasien_id_exist != false) {
                # code...
                $input_transaction = insert_transaction($idTransaction, $pasien_id_exist, $tindakanID, $outletID, $gejala, $deskripsiGejala, $karyawanID);
                
                if ($input_transaction) {
                    # code...
                    /*log file*/
                    $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                                    values ('$_SESSION[idKaryawan]',NOW(),'Faskes melakukan pendaftaran pasien ID $pasien_id_exist dan transaksi $idTransaction') ";
                    mysqli_query($conn, $sql_query1);
                    /*log file*/
                    
                    // Everything OKE. Commit!!
                    $conn->commit();
                    echo '<script>alert("Tindakan baru berhasil ditambahkan !");window.location.replace("../admin.php?page=reservation-faskes");</script>';
                } else {
                    # code...
                    
                    // Something wrong. Rollback!
                    $conn->rollback();
                    echo '<script>alert("Tindakan baru gagal ditambahkan ! Mohon periksa kembali datanya!");history.go(-1);</script>';
                }
            } else {
                $last_id_pasien_from_input = insert_pasien($nik, $name, $passport, $phone, $isWNA, $country, $gender, $address, $placeOfBirth, $dateOfBirth);
                if ($last_id_pasien_from_input != false) {
                    # code...
                    $input_transaction = insert_transaction($idTransaction, $last_id_pasien_from_input, $tindakanID, $outletID, $gejala, $deskripsiGejala, $karyawanID);
                    if ($input_transaction) {
                        # code...
                        /*log file*/
                        $sql_query1 = "insert into log_file (karyawanID, waktu, infoActivity) 
                                        values ('$_SESSION[idKaryawan]',NOW(),'Faskes melakukan pendaftaran pasien ID $last_id_pasien_from_input dan transaksi $idTransaction') ";
                          mysqli_query($conn, $sql_query1);
                        /*log file*/
                        
                        // Everything OKE. Commit!!
                        $conn->commit();
                        echo '<script>alert("Tindakan baru berhasil ditambahkan !");window.location.replace("../admin.php?page=reservation-faskes")</script>';
                    } else {
                        # code...
                        // Something wrong. Rollback!!
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
