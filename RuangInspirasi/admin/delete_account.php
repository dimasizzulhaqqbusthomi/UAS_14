<?php
include '../assets/config.php';
$id = $_GET['id'];
$sql = "DELETE FROM `accounts` WHERE account_id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
    header("Location: account.php?message=deleted");
    exit();
}

?>