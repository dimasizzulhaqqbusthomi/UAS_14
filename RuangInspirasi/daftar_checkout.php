<?php
session_start();

include('assets/config.php');

if (!isset($_SESSION['username'])) {
    header('Location: login/index.php'); 
    exit();
}
$riwayat_pesanan = [];

$username_sekarang = $_SESSION['username'];

$sql_user = "SELECT account_id FROM accounts WHERE username = ?";
$stmt_user = mysqli_prepare($conn, $sql_user);

mysqli_stmt_bind_param($stmt_user, "s", $username_sekarang);
mysqli_stmt_execute($stmt_user);
$hasil_user = mysqli_stmt_get_result($stmt_user);

if ($data_user = mysqli_fetch_assoc($hasil_user)) {
    $id_akun = $data_user['account_id'];

    $sql_pesanan = "SELECT 
                        c.checkout_id, c.checkout_date, c.total_price, c.status,
                        GROUP_CONCAT(p.name ORDER BY p.name ASC SEPARATOR '||') AS product_names,
                        GROUP_CONCAT(ci.quantity ORDER BY p.name ASC SEPARATOR '||') AS quantities
                    FROM checkouts c
                    JOIN checkout_items ci ON c.checkout_id = ci.checkout_id
                    JOIN products p ON ci.product_id = p.product_id
                    WHERE c.account_id = ?
                    GROUP BY c.checkout_id
                    ORDER BY c.checkout_date DESC";
    
    $stmt_pesanan = mysqli_prepare($conn, $sql_pesanan);
    mysqli_stmt_bind_param($stmt_pesanan, "i", $id_akun);
    mysqli_stmt_execute($stmt_pesanan);
    $hasil_pesanan = mysqli_stmt_get_result($stmt_pesanan);

    while ($pesanan = mysqli_fetch_assoc($hasil_pesanan)) {
        $riwayat_pesanan[] = $pesanan;
    }
    mysqli_stmt_close($stmt_pesanan);
}

mysqli_stmt_close($stmt_user);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Riwayat Pesanan - Ruang Inspirasi</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/e4ca1991ae.js" crossorigin="anonymous"></script>
</head>
<body class="bg-[#fffffe]">

  <nav class="bg-[#272343] m-1 rounded-tl-xl py-7 px-10 max-sm:px-0 text-white">
    <div class="mx-15 flex justify-between items-center max-sm:mx-5">
      <div class="font-bold text-2xl p-2 border-b">
        <a href="index.php"><h1>Checkout</h1></a>
      </div>
      <div class="flex items-center gap-7 max-sm:gap-2">
        <a href="checkout.php" class="font-bold py-2 px-3 rounded-full hover:text-yellow-400 hover:bg-white transition-all duration-200"><i class="fa-solid fa-cart-shopping"></i><span class="max-sm:hidden"> Checkout</span></a>
        <a href="login/logout.php" class="text-3xl max-sm:text-2xl hover:bg-white py-2 px-3 rounded-full hover:text-yellow-400 transition-all duration-200"><i class="fa-solid fa-right-from-bracket"></i></a>
      </div>
    </div>
  </nav>

  <section class="max-w-5xl mx-auto my-10">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-5 bg-gray-50 border-b">
            <h1 class="font-bold text-2xl text-gray-800">Riwayat Pesanan Anda</h1>
            <p class="text-gray-600">Klik pada setiap pesanan untuk melihat detail barang.</p>
        </div>
        <div class="space-y-2 p-4 bg-gray-100">
            <?php if (!empty($riwayat_pesanan)): ?>
                <?php foreach($riwayat_pesanan as $pesanan): 
                    $warna_status = 'bg-gray-300 text-gray-800';
                    if ($pesanan['status'] == 'diterima') $warna_status = 'bg-green-100 text-green-800';
                    if ($pesanan['status'] == 'dikirim') $warna_status = 'bg-blue-100 text-blue-800';
                    if ($pesanan['status'] == 'di proses') $warna_status = 'bg-yellow-100 text-yellow-800';
                    if ($pesanan['status'] == 'dibatalkan') $warna_status = 'bg-red-100 text-red-800';
                ?>
                    <details class="bg-white border rounded-md shadow-sm">
                        <summary class="p-4 flex justify-between items-center hover:bg-gray-50">
                            <div>
                                <p class="font-bold text-gray-800">Pesanan #<?php echo $pesanan['checkout_id']; ?></p>
                                <p class="text-sm text-gray-500"><?php echo strftime('%d %B %Y', strtotime($pesanan['checkout_date'])); ?></p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold">Rp. <?php echo number_format($pesanan['total_price']); ?></p>
                                <span class="py-1 px-2 mt-1 inline-block rounded-full text-xs font-semibold <?php echo $warna_status; ?>">
                                    <?php echo ucfirst($pesanan['status']); ?>
                                </span>
                            </div>
                        </summary>
                        <div class="p-4 bg-gray-50 border-t">
                            <h4 class="font-semibold mb-2 text-gray-700">Barang yang dipesan:</h4>
                            <ul class="list-disc list-inside text-gray-600 text-sm space-y-1">
                                <?php
                                $daftar_produk = explode('||', $pesanan['product_names']);
                                $daftar_kuantitas = explode('||', $pesanan['quantities']);
                                for ($i = 0; $i < count($daftar_produk); $i++):
                                ?>
                                    <li><?php echo htmlspecialchars($daftar_produk[$i]); ?> (<?php echo htmlspecialchars($daftar_kuantitas[$i]); ?>x)</li>
                                <?php endfor;  ?>
                            </ul>
                        </div>
                    </details>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center text-gray-500 bg-white p-10 rounded-md">
                    <i class="fas fa-box-open fa-3x text-gray-400"></i>
                    <p class="mt-4 font-semibold">Anda belum memiliki riwayat pesanan.</p>
                    <p class="text-sm">Silakan lakukan pemesanan pertama Anda!</p>
                </div>
            <?php endif;  ?>
        </div>
    </div>
  </section>

</body>
</html>