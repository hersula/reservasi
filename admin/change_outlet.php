<?php  

include('../connection.php');
session_start();

$karyawanID = $_SESSION['idKaryawan'];
$outletID   = isset($_POST['outletID']) ? $_POST['outletID'] : '';

if ($outletID != '') {
    # code...
    $query = $conn->query("UPDATE master_karyawan SET outletID ='$outletID' WHERE id='$karyawanID'") or die($conn->error);
    
    if ($query) {
        # code...
        $query_select = $conn->query("SELECT * from master_karyawan WHERE id='$karyawanID'") or die($conn->error);
        $result = $query_select->fetch_array();
        $_SESSION['outletID'] = $result['outletID'];
        unset($_SESSION['outletSelected']);
        header('Location: ../admin/admin.php');
    }
}

?>