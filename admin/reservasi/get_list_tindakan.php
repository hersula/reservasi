
    
<?php
include('../../connection.php');
$outletID = $_POST['outletID'];
$query = "SELECT outlet_tindakan_list.id, outlet_tindakan_list.outletID, outlet_tindakan_list.outletTindakan,master_tindakan.id tindakanID, master_tindakan.name as name_tindakan, master_tindakan.price FROM outlet_tindakan_list JOIN master_tindakan ON outlet_tindakan_list.outletTindakan = master_tindakan.id LEFT JOIN master_outlet ON outlet_tindakan_list.outletID = master_outlet.id WHERE master_outlet.id='$outletID'";
$fetch = mysqli_query($conn, $query);
?>
<option value="">Pilih Tindakan</option>
<?php
while($row = mysqli_fetch_array($fetch)) {
?>
<option value="<?php echo $row["tindakanID"];?>"><?php echo $row["name_tindakan"];?></option>
<?php
}
?>