<?php
session_start();
include('assets/config.php');

if (!isset($_SESSION['username'])) {
    header('Location: login/index.php'); 
    exit();
}

$cart = $_SESSION['cart'] ?? [];

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id_to_delete = $_GET['id'];
    unset($_SESSION['cart'][$id_to_delete]);
    header("Location: checkout.php");
    exit();
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];

    if ($action == 'tambah_qty') {
        $_SESSION['cart'][$id]['quantity']++;
    }

    if ($action == 'kurangi_qty') {
        $_SESSION['cart'][$id]['quantity']--;
        if ($_SESSION['cart'][$id]['quantity'] <= 0) {
            unset($_SESSION['cart'][$id]);
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
  <title>Checkout - Ruang Inspirasi</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/e4ca1991ae.js" crossorigin="anonymous"></script>
</head>
<body class="bg-[#fffffe]">

  <nav class="bg-[#272343] m-1 rounded-tl-xl py-7 text-white">
    <div class="mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
      <div class="font-bold text-xl md:text-2xl p-2 border-b">
        <a href="index.php"><h1>Checkout</h1></a>
      </div>
      <div class="flex items-center gap-2 md:gap-7">
        <a href="daftar_checkout.php" class="font-bold py-2 px-3 rounded-full hover:text-yellow-400 hover:bg-white transition-all duration-200">
            <i class="fas fa-history"></i><span class="hidden sm:inline ml-2">Pesanan Saya</span>
        </a>
        <a href="login/logout.php" class="text-2xl md:text-3xl hover:bg-white py-2 px-3 rounded-full hover:text-yellow-400 transition-all duration-200"><i class="fa-solid fa-right-from-bracket"></i></a>
      </div>
    </div>
  </nav>

  <section class="max-w-5xl mx-auto my-10 p-2 md:p-0">
    <div class="rounded bg-[#272343]">
      <div class="text-white p-5 rounded-t-lg text-lg">
        <?php
          if (isset($_SESSION['checkout_message'])) {
          echo '
          <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-4 mb-6 rounded-lg shadow-md">
            <p class="font-bold">Sukses!</p>
            <p>' . htmlspecialchars($_SESSION['checkout_message']) . '</p>
          </div>';
          unset($_SESSION['checkout_message']);
        }
        ?>
        <h1>Pilih Produk Untuk Dipesan</h1>
      </div>

      <form action="checkout_process.php" method="post" class="flex flex-col gap-2 p-4">
        <div class="menu flex flex-col gap-3">
          <?php 
          $grand_total = 0;
          if (!empty($cart)):
            foreach ($cart as $id => $item):
              $subtotal = $item['price'] * $item['quantity'];
              $grand_total += $subtotal;
          ?>
              <div class="bg-gray-300 w-full p-3 rounded flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4 w-full">
                  <input type="checkbox" class="product-checkbox h-5 w-5" name="selected_products[]" value="<?= $id ?>" data-subtotal="<?= $subtotal ?>" checked />
                  <img src="img/<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="w-16 h-16 object-cover bg-white rounded" />
                  <div>
                    <p class="font-bold"><?= htmlspecialchars($item['name']) ?></p>
                    <p class="text-sm text-gray-700">Rp. <?= number_format($item['price']) ?></p>
                  </div>
                </div>
                <div class="flex items-center justify-between w-full sm:w-auto sm:justify-end gap-4 pr-2">
                  <p class="font-bold text-lg whitespace-nowrap">Rp. <?= number_format($subtotal) ?></p>
                  <div class="flex items-center justify-center gap-2">
                    <a href="checkout.php?action=kurangi_qty&id=<?= $id ?>" class="bg-yellow-300 hover:bg-yellow-400 w-8 text-center py-1 font-bold text-lg rounded"><i class="fa-solid fa-minus"></i></a>
                    <p class="border py-1 px-4 rounded bg-white"><?= $item['quantity'] ?></p>
                    <a href="checkout.php?action=tambah_qty&id=<?= $id ?>" class="bg-green-400 hover:bg-green-500 w-8 text-center py-1 font-bold text-lg rounded"><i class="fa-solid fa-plus"></i></a>
                  </div>
                  <a href="checkout.php?action=delete&id=<?= $id ?>" class="text-red-600 hover:text-red-800" title="Hapus item"><i class="fas fa-trash-alt fa-lg"></i></a>
                </div>
              </div>
          <?php
            endforeach;
            echo '
            <hr class="border-t border-gray-500 my-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex flex-col gap-2"><label for="nama" class="text-white">Nama</label><input id="nama" type="text" name="nama" class="bg-gray-200 p-2 rounded" required/></div>
                <div class="flex flex-col gap-2"><label for="telp" class="text-white">No. Telpon</label><input id="telp" type="text" name="telp" class="bg-gray-200 p-2 rounded" required/></div>
            </div>
            <div class="flex flex-col gap-2 mt-4"><label for="alamat" class="text-white">Alamat</label><textarea id="alamat" name="alamat" class="bg-gray-200 p-2 rounded" required></textarea></div>
            <div class="flex flex-col gap-2 mt-4"><label for="pesan" class="text-white">Pesan Tambahan</label><textarea id="pesan" name="pesan" class="bg-gray-200 p-2 rounded"></textarea></div>
            <div class="flex flex-col sm:flex-row items-center justify-between mt-6 gap-4">
              <p class="text-white text-xl sm:text-2xl font-semibold">Total <span id="grandTotal" class="text-yellow-400">Rp. '. number_format($grand_total) .'</span></p>
              <button type="submit" name="submit" class="w-full sm:w-auto bg-[#bae8e8] py-3 px-6 rounded font-bold hover:bg-[#78afaf] transition-colors duration-200">Buat Pesanan</button>
            </div>
          </form>';
          else:
            echo '<div class="w-full"><p class="text-white text-center bg-yellow-400 rounded p-5">Keranjang Anda masih kosong.</p></div>';
          endif;
          ?>
        </div>
    </div>
  </section>

  <script>
    function formatRupiah(angka) {
      return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
      }).format(angka);
    }

    function updateGrandTotal() {
      let checkboxes = document.querySelectorAll('.product-checkbox');
      let total = 0;
      checkboxes.forEach(cb => {
        if (cb.checked) {
          total += parseInt(cb.dataset.subtotal);
        }
      });
      document.getElementById('grandTotal').innerText = formatRupiah(total);
    }

    updateGrandTotal();

    document.querySelectorAll('.product-checkbox').forEach(cb => {
      cb.addEventListener('change', updateGrandTotal);
    });
  </script>

</body>
</html>