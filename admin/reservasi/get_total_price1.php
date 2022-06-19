<?php
include('../../connection.php');
$pemeriksaanID = $_POST['tindakanID'];
$outletID = $_POST['outletID'];
$query = "SELECT price FROM outlet_pemeriksaan_list WHERE outletPemeriksaan='$pemeriksaanID' AND outletID='$outletID'";
$fetch = mysqli_query($conn, $query);
?>
<?php
while($row = mysqli_fetch_array($fetch)) {
?>
<?= $row["price"]?>
<?php
}
?>