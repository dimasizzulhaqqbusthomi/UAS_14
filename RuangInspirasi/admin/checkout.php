<?php

include ("../assets/config.php");

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/index.php");
    exit();
}

$status_yang_diizinkan = ['di proses', 'dikirim', 'diterima', 'dibatalkan'];

if (isset($_POST['update_status'])) {
    
    $id_checkout = filter_var($_POST['id_checkout'], FILTER_VALIDATE_INT);
    $status_baru = $_POST['status'];

    if ($id_checkout && in_array($status_baru, $status_yang_diizinkan)) {
        
        $sql_update = "UPDATE checkouts SET status = ? WHERE checkout_id = ?";
      
        $pernyataan = mysqli_prepare($conn, $sql_update);
       
        if ($pernyataan) {
            mysqli_stmt_bind_param($pernyataan, "si", $status_baru, $id_checkout);
            mysqli_stmt_execute($pernyataan);
            mysqli_stmt_close($pernyataan);
        }
    }
    
    header("Location: checkout.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Checkout</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://kit.fontawesome.com/e4ca1991ae.js" crossorigin="anonymous"></script>
  </head>
  <body class="bg-gray-200">
    <nav class="bg-[#272343] m-1 rounded-tl-xl py-10 text-white">
      <div class="mx-15 flex justify-between max-sm:mx-5">
        <div class="font-bold text-2xl">
          <a href="index.php"><h1>Daftar Checkout</h1></a>
        </div>
        <div class="flex gap-6 justify-center items-center max-sm:gap-2">
          <a href="product.php"><p class="hover:bg-[#ffd803] py-2 px-4 text-white rounded-2xl transition-all duration-200 max-sm:hidden"><i class="fa-solid fa-bag-shopping"></i> Product Handmade</p></a>
          <a href="checkout.php"><p class="bg-[#ffd803] py-2 px-4 text-white rounded-2xl transition-all duration-200 max-sm:w-40 text-center"><i class="fa-solid fa-cart-shopping"></i> Checkout</p></a>
          <a href="account.php"><p class="hover:bg-[#ffd803] py-2 px-4 text-white rounded-2xl transition-all duration-200 max-sm:hidden"><i class="fa-solid fa-users"></i> Daftar Pengguna</p></a>
          <a href="testimoni.php"><p class="hover:bg-[#ffd803] py-2 px-4 text-white rounded-2xl transition-all duration-200 max-sm:hidden"><i class="fa-solid fa-spa"></i> Testimoni Pengguna</p></a>
          <a href="../login/logout.php" class="hover:bg-[#ffd803] py-2 px-3 rounded-full transition-all duration-200"><i class="fa-solid fa-right-from-bracket"></i></a>
        </div>
      </div>
    </nav>
    <div class="flex bg-[#3f3668] p-2 mx-1 min-md:hidden justify-between">
      <a href="product.php"
        ><p class="hover:bg-[#ffd803] py-2 px-2 text-white rounded-2xl transition-all duration-200">
          <i class="fa-solid fa-bag-shopping"></i> Products
        </p></a
      >
      <a href="account.php"
        ><p class="hover:bg-[#ffd803] py-2 px-2 text-white rounded-2xl transition-all duration-200">
          <i class="fa-solid fa-users"></i> Daftar Pengguna
        </p></a
      >
      <a href="testimoni.php"
        ><p class="hover:bg-[#ffd803] py-2 px-2 text-white rounded-2xl transition-all duration-200">
          <i class="fa-solid fa-spa"></i> Testimoni
        </p></a
      >
    </div>

    <section class="max-w-7xl mx-auto">
      <div class="mx-5 my-10">
        <div class="flex justify-between items-center bg-[#272343] p-5 rounded-t">
          <h1 class="font-semibold text-xl py-2 text-white">Checkout</h1>
        </div>
        
        <div class="overflow-x-auto bg-white rounded-b-lg text-gray-700">
            <div class="grid grid-cols-12 bg-gray-600 text-white font-bold text-sm">
                <div class="col-span-3 text-left py-3 px-6">Tanggal</div>
                <div class="col-span-3 text-left py-3 px-6">Customer</div>
                <div class="col-span-3 text-left py-3 px-6">Total Harga</div>
                <div class="col-span-3 text-center py-3 px-6">Status</div>
            </div>

            <?php
                $sql_select = "SELECT 
                            c.checkout_id, c.checkout_date, c.recipient_name, c.shipping_address, c.total_price, c.status,
                            GROUP_CONCAT(p.name ORDER BY p.name ASC SEPARATOR '||') AS product_names,
                            GROUP_CONCAT(ci.quantity ORDER BY p.name ASC SEPARATOR '||') AS quantities,
                            GROUP_CONCAT((ci.quantity * ci.price_per_item) ORDER BY p.name ASC SEPARATOR '||') AS sub_prices
                        FROM checkouts c
                        JOIN checkout_items ci ON c.checkout_id = ci.checkout_id
                        JOIN products p ON ci.product_id = p.product_id
                        GROUP BY c.checkout_id, c.checkout_date, c.recipient_name, c.shipping_address, c.total_price, c.status
                        ORDER BY c.checkout_date DESC";
                $hasil = mysqli_query($conn, $sql_select);
                if (mysqli_num_rows($hasil) > 0) {
                    while ($baris = mysqli_fetch_assoc($hasil)) {
                        $warna_status = 'bg-gray-200 text-gray-800';
                        if ($baris['status'] == 'diterima') $warna_status = 'bg-green-100 text-green-800';
                        if ($baris['status'] == 'dikirim') $warna_status = 'bg-blue-100 text-blue-800';
                        if ($baris['status'] == 'di proses') $warna_status = 'bg-yellow-100 text-yellow-800';
                        if ($baris['status'] == 'dibatalkan') $warna_status = 'bg-red-100 text-red-800';
            ?>
            <details class="border-b border-gray-200">
                <summary class="grid grid-cols-12 p-0 hover:bg-gray-50 cursor-pointer">
                    <div class="col-span-3 py-4 px-6 font-medium"><?php echo strftime('%d %b %Y, %H:%M', strtotime($baris['checkout_date'])); ?></div>
                    <div class="col-span-3 py-4 px-6"><?php echo htmlspecialchars($baris['recipient_name']); ?></div>
                    <div class="col-span-3 py-4 px-6 font-semibold"><?php echo 'Rp ' . number_format($baris['total_price'], 0, ',', '.'); ?></div>
                    <div class="col-span-3 py-4 px-6 text-center">
                        <span class="py-1 px-3 rounded-full text-xs font-semibold <?php echo $warna_status; ?>">
                            <?php echo ucfirst($baris['status']); ?>
                        </span>
                    </div>
                </summary>
                <div class="p-6 bg-gray-50">
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-bold text-gray-700 mb-2">Detail Produk</h4>
                            <table class="min-w-full text-sm">
                                <thead><tr class="border-b"><th class="text-left pb-1 font-medium">Produk</th><th class="text-right pb-1 font-medium">Qty</th><th class="text-right pb-1 font-medium">Subtotal</th></tr></thead>
                                <tbody>
                                <?php
                                    $daftar_produk = explode('||', $baris['product_names']);
                                    $daftar_kuantitas = explode('||', $baris['quantities']);
                                    $daftar_sub_harga = explode('||', $baris['sub_prices']);
                                    for ($i = 0; $i < count($daftar_produk); $i++):
                                ?>
                                    <tr>
                                        <td class="py-1"><?php echo htmlspecialchars($daftar_produk[$i]); ?></td>
                                        <td class="text-right py-1"><?php echo htmlspecialchars($daftar_kuantitas[$i]); ?>x</td>
                                        <td class="text-right py-1"><?php echo 'Rp ' . number_format($daftar_sub_harga[$i], 0, ',', '.'); ?></td>
                                    </tr>
                                <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-700 mb-2">Info Pengiriman</h4>
                            <p class="text-sm text-gray-600 leading-relaxed"><?php echo nl2br(htmlspecialchars($baris['shipping_address'])); ?></p>
                            <hr class="my-4">
                            <h4 class="font-bold text-gray-700 mb-2">Ubah Status</h4>
                            <form method="POST" action="checkout.php" class="flex items-center gap-2">
                                <input type="hidden" name="id_checkout" value="<?php echo $baris['checkout_id']; ?>">
                                <input type="hidden" name="update_status" value="1">
                                <select name="status" class="p-2 w-full rounded-md bg-white border">
                                    <?php foreach ($status_yang_diizinkan as $status): ?>
                                    <option value="<?php echo $status; ?>" <?php echo ($baris['status'] == $status) ? 'selected' : ''; ?>>
                                        <?php echo ucfirst($status); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-700">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </details>
            <?php
                    }
                } 
            ?>
        </div>
      </div>
    </section>
  </body>
</html>