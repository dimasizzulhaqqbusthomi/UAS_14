<?php
include ('assets/config.php') ;

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login/index.php"); 
    exit();
}
$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM products WHERE product_id = $id");
$product = mysqli_fetch_assoc($result);

if ($product) {
    $_SESSION['cart'][$id] = [
        'id' => $product['product_id'],
        'name' => $product['name'],
        'price' => $product['price'],
        'image_url' => $product['image_url'],
        'quantity' => 1
    ];
}

header("Location: index.php#products");
exit();

?>