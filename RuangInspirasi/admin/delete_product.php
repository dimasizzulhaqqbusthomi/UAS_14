<?php
include '../assets/config.php';
$id = $_GET['id'];
$sql = "DELETE FROM `products` WHERE product_id = $id";
$result = mysqli_query($conn, $sql);

if ($result) {
    header("Location: product.php?message=deleted");
    exit();
}

?>