<?php
session_start(); 

include('assets/config.php'); 

if (!isset($_SESSION['username'])) {
    header('Location: login/index.php'); 
    exit();
}


$nama = $_POST['nama']; 
$alamat = $_POST['alamat']; 
$telp = $_POST['telp']; 
$produk_terpilih = $_POST['selected_products'] ?? []; 

$cart = $_SESSION['cart'] ?? []; 

$username = $_SESSION['username'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT account_id FROM accounts WHERE username = '$username'"));
$account_id = $user['account_id'] ?? null; 

if (!$account_id || empty($produk_terpilih)) {
    echo "Akun tidak ditemukan atau tidak ada produk yang dipilih.";
    exit();
}

$total = 0;
foreach ($produk_terpilih as $id) {
    $total += $cart[$id]['price'] * $cart[$id]['quantity']; 
}

mysqli_query($conn, "INSERT INTO checkouts (account_id, recipient_name, shipping_address, phone_number, total_price, status, checkout_date) 
VALUES ('$account_id', '$nama', '$alamat', '$telp', '$total', 'di proses', NOW())");

$checkout_id = mysqli_insert_id($conn);

foreach ($produk_terpilih as $id) {
    $qty = $cart[$id]['quantity']; 
    $harga = $cart[$id]['price']; 
    mysqli_query($conn, "INSERT INTO checkout_items (checkout_id, product_id, quantity, price_per_item) 
    VALUES ('$checkout_id', '$id', '$qty', '$harga')");
}

foreach ($produk_terpilih as $id) {
    unset($_SESSION['cart'][$id]);
}

$_SESSION['checkout_message'] = "Berhasil checkout barang! Pesanan Anda sedang kami proses.";

header("Location: checkout.php");
exit();
?>
