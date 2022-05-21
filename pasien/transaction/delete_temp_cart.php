<?php  

include('../../connection.php');

$id = isset($_GET['id']) ? $_GET['id'] : '';


$query_delete = $conn->query("DELETE FROM temp_cart WHERE id='$id'");
if ($query_delete) {
    # code...
    header('location: ' . $_SERVER['HTTP_REFERER']);

}
