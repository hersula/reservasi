<?php
include('../../connection.php');
$tindakanID = $_POST['tindakanID'];
$outletID = $_POST['outletID'];
$query = "SELECT price FROM outlet_tindakan_list WHERE outletTindakan='$tindakanID' AND outletID='$outletID'";
$fetch = mysqli_query($conn, $query);
?>
<?php
while($row = mysqli_fetch_array($fetch)) {
?>
<?= $row["price"]?>
<?php
}
?>