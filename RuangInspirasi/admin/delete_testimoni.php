<?php
include '../assets/config.php';
$id = $_GET['id'];
$sql = "DELETE FROM `testimoni` WHERE id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
    header("Location: testimoni.php?message=deleted");
    exit();
}

?>