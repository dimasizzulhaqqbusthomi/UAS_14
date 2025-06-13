<?php
include ("../assets/config.php");

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://kit.fontawesome.com/e4ca1991ae.js" crossorigin="anonymous"></script>
  </head>
  <body class="bg-gray-200">
    <nav class="bg-[#272343] m-1 rounded-tl-xl py-10 text-white">
      <div class="mx-15 flex justify-between max-lg:mx-5">
        <div class="font-bold text-2xl">
          <h1>Dashboard Ruang Inspirasi</h1>
        </div>
        <div class="flex gap-6 justify-center items-center max-lg:gap-2">
          <a href="product.php"
            ><p class="hover:bg-[#ffd803] py-2 px-4 text-white rounded-2xl transition-all duration-200 max-sm:hidden">
              <i class="fa-solid fa-bag-shopping"></i> Product Handmade
            </p></a
          >
          <a href="checkout.php"
            ><p class="hover:bg-[#ffd803] py-2 px-4 text-white rounded-2xl transition-all duration-200 max-sm:hidden">
              <i class="fa-solid fa-cart-shopping"></i> Checkout
            </p></a
          >
          <a href="account.php"
            ><p class="hover:bg-[#ffd803] py-2 px-4 text-white rounded-2xl transition-all duration-200 max-sm:hidden">
              <i class="fa-solid fa-users"></i> Daftar Pengguna
            </p></a
          >
          <a href="testimoni.php"
            ><p class="hover:bg-[#ffd803] py-2 px-4 text-white rounded-2xl transition-all duration-200 max-sm:hidden">
              <i class="fa-solid fa-spa"></i> Testimoni
            </p></a
          >
          <a href="../login/logout.php" class="hover:bg-[#ffd803] py-2 px-3 rounded-full transition-all duration-200">
            <i class="fa-solid fa-right-from-bracket"></i>
          </a>
        </div>
      </div>
    </nav>

    <section class="max-w-7xl mx-auto">
      <div class="mx-20 py-20 text-center">
        <h1 class="font-bold text-4xl text-[#272343] max-sm:text-2xl">Selamat Datang di Dashboard Ruang Inspirasi</h1>
        <p class="text-[#272343] py-5">
          Platform manajemen terpadu untuk membantu pelanggan mengelola data dan aktivitas secara efisien dalam satu sistem yang mudah digunakan.
        </p>
      </div>
    </section>

    <section class="max-w-7xl mx-auto pb-6">
      <div class="grid gap-4 md:grid-cols-2 mx-3">
        <a href="product.php">
          <div class="flex flex-col gap-5 text-[#272343] bg-white p-10 h-75 text-center rounded-xl hover:bg-[#bae8e8] transition-all duration-200">
            <i class="fa-solid fa-bag-shopping text-5xl"></i>
            <h1 class="font-bold text-2xl">Product Handmade</h1>
            <p class="text-sm text-justify">
              Pantau, tambahkan, ubah, atau hapus data produk handmade yang tersedia di sistem. Pastikan semua produk selalu up to date dan siap ditampilkan ke pelanggan.
            </p>
          </div>
        </a>
        <a href="checkout.php">
          <div class="flex flex-col gap-5 text-[#272343] bg-white p-10 h-75 text-center rounded-xl hover:bg-[#bae8e8] transition-all duration-200">
            <i class="fa-solid fa-cart-shopping text-5xl"></i>
            <h1 class="font-bold text-2xl">Checkout Pelanggan</h1>
            <p class="text-sm text-justify">
              Lihat dan kelola riwayat checkout pelanggan secara real-time. Pastikan setiap transaksi berjalan lancar dan sesuai prosedur.
            </p>
          </div>
        </a>
        <a href="account.php">
          <div class="flex flex-col gap-5 text-[#272343] bg-white p-10 h-75 text-center rounded-xl hover:bg-[#bae8e8] transition-all duration-200">
            <i class="fa-solid fa-users text-5xl"></i>
            <h1 class="font-bold text-2xl">Data Pelanggan</h1>
            <p class="text-sm text-justify">
              Kelola data pelanggan secara menyeluruh. Perbarui informasi jika diperlukan dan pastikan database pelanggan tetap aman dan akurat.
            </p>
          </div>
        </a>
        <a href="testimoni.php">
          <div class="flex flex-col gap-5 text-[#272343] bg-white p-10 h-75 text-center rounded-xl hover:bg-[#bae8e8] transition-all duration-200">
            <i class="fa-solid fa-spa text-5xl"></i>
            <h1 class="font-bold text-2xl">Testimoni Pelanggan</h1>
            <p class="text-sm text-justify">
              Pantau ulasan atau testimoni yang masuk. Anda dapat menyetujui, mengedit, atau menghapus testimoni untuk menjaga kualitas dan kepercayaan pengguna.
            </p>
          </div>
        </a>
      </div>
    </section>
  </body>
</html>
