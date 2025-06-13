<?php
session_start();

include ("assets/config.php");

?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ruang Inspirasi</title>
    <link rel="stylesheet" href="" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://kit.fontawesome.com/e4ca1991ae.js" crossorigin="anonymous"></script>
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap");
      body {
        font-family: "Poppins", sans-serif;
        background-color: #f3f4f6;
        color: #1f2937;
        transition: all 0.5s ease, color 0.5s ease;
      }
      .dark-mode {
        color: white;
        transition: all 0.8s ease;
      }

      .dark-mode .login {
        color: white;
      }

      .dark-mode .products,
      .dark-mode .products h1 {
        color:white;
        background-color: #1f2937;
        transition: all 0.8s ease;
      }
      
      .dark-mode .kami {
        color: white;
        transition: all 0.8s ease;
      }
      
      .dark-mode .pesan {
        background-color: #111827;
        transition: all 0.8s ease;
      }
      .dark-mode .pesan h1,
      .dark-mode .lapor h1,
      .dark-mode .wa-text {
        color: white;
        transition: all 0.8s ease;
      }

      .dark-mode .about,
      .dark-mode .lapor{
        background-color: #1f2937;
        transition: all 0.8s ease;
      }

      .dark-mode .about h1,
      .dark-mode .about h2 {
        color: #bfdbfe;
        transition: all 0.8s ease;
      }

      .dark-mode .wa,
      .dark-mode .card  {
        background-color: #374151;
      }

      .dark-mode .kesan {
        color: white;
        background-color: #374151;
        transition: all 0.8s ease;
      }

      .dark-mode .card-text {
        color: white;
      }

    </style>
  </head>
  <body class="bg-gray-100">
    <nav class="bg-[#272343]/90 backdrop-blur-sm my-2 mx-7 rounded-xl text-white sticky top-2 z-50 shadow-md max-sm:mx-2">
      <div class="mx-auto px-8 h-20 flex items-center justify-between">
        <div class="font-bold text-2xl">
          <h1><a href="#">Ruang Inspirasi</a></h1>
        </div>
        <div class="flex items-center gap-8 max-sm:hidden">
            <p class="hover:text-yellow-400"><a href="#products">Produk</a></p>
            <p class="hover:text-yellow-400"><a href="#pesan">Testimoni</a></p>
            <p class="hover:text-yellow-400"><a href="#kontak">Kontak</a></p>
          </div>
        <div class="flex justify-between gap-5 items-center max-sm:gap-2">
          <div class="flex justify-center items-center gap-4">
            <?php if (isset($_SESSION['username'])) :?>
            <a
              href="checkout.php"
              class="flex justify-center items-center text-xl hover:bg-white w-10 h-10 rounded-full hover:text-yellow-400 transition-all duration-200"
              ><i class="fa-solid fa-cart-shopping"></i
            ></a>
            <?php endif;?>
            <?php if (isset($_SESSION['username'])): ?>
            <a
              href="login/logout.php"
              class="flex justify-center items-center text-xl w-10 h-10 hover:bg-white rounded-full hover:text-yellow-400 transition-all duration-200"
              ><i class="fa-solid fa-right-from-bracket"></i
            ></a>
            <?php else: ?>
            <a href="login/index.php"><button class="bg-[#ffd803] px-6 py-2 font-bold text-[#272343] rounded-full hover:bg-yellow-400 hover:scale-105 transition-all duration-300 login">Login</button></a>
            <?php endif; ?>
          </div>
          <div class="flex text-md text-[#272343] bg-gray-300 rounded-full w-10 h-10 items-center justify-center hover:bg-blue-200 transition-all duration-300">
            <div id="moon-icon" class="block" onclick="toggleMode()">
              <i class="fa-solid fa-moon"></i>
            </div>
            <div id="sun-icon" class="hidden" onclick="toggleMode()">
              <i class="fa-solid fa-sun hidden"></i>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <section id="landing" class="">
      <div class="mx-20 max-sm:mx-5">
        <div class="flex flex-col items-center text-center py-25">
          <h1 class="font-extrabold text-6xl text-[#272343] max-sm:w-90 max-sm:text-4xl">Selamat Datang di Ruang Inspirasi</h1>
          <p class="text-[#2d334a] py-5 text-xl max-w-2xl max-sm:text-lg">
            Temukan sentuhan karya handmade yang penuh makna dan kehangatan. Setiap produk dibuat dengan hati, untuk menginspirasi hari-harimu.
          </p>
          <div class="flex gap-3 pt-15 max-sm:flex-col">
            <a href="#products"
              ><button class="bg-[#272343] hover:bg-gray-800 shadow-lg w-60 py-3 rounded-full text-white font-semibold transition-all duration-300 transform hover:scale-105 kami">Lihat Produk</button></a
            >
            <a href="#tentang_kami"
              ><button class="bg-[#ffd803] hover:bg-yellow-400 shadow-lg w-60 py-3 rounded-full text-[#272343] font-semibold transition-all duration-300 transform hover:scale-105 kami">Tentang Kami</button></a
            >
          </div>
        </div>
      </div>
    </section>

    <section id="products" class="bg-gray-100 products">
      <div class="mx-20 max-lg:mx-0 py-10">
        <h1 class="font-bold text-4xl text-center text-[#272343] py-10">Produk Tersedia</h1>
        <div class="menu flex flex-wrap justify-center py-5 gap-4">
          <?php

          $sql = mysqli_query($conn, "SELECT * FROM  products" );
          while ($data = mysqli_fetch_assoc($sql)) {
            
          ?>
          <div
            class="card bg-white rounded-b-md shadow-lg flex flex-col justify-between w-90 hover:shadow-2xl max-sm:w-auto max-sm:mx-5 hover:-translate-y-2 transition-all duration-300 border-t-4 border-blue-600"
          >
            <div class="flex flex-col items-center">
              <img src="img/<?= $data['image_url']?>" alt="ini gambar" class="w-full h-56 object-cover rounded" />
              <div class="desk flex flex-col items-start p-3">
                <p id="judulProduk" class="font-bold text-xl"><?= $data['name']?></p>
                <p class="text-justify text-gray-600 text-sm py-2 card-text">
                  <?= $data['description']?>
                </p>
             </div>
            </div>
            <div class="flex flex-col gap-2">
              <p class="text-2xl px-4 font-extrabold text-blue-600">
                Rp.
                <?= (number_format($data['price'], 0, ',', '.'))?>
              </p>
              <div class="flex items-center py-2 px-4 border-t border-gray-200 gap-2">
                <a href="beli_langsung.php?id=<?= $data['product_id'] ?>">
                  <p class="bg-blue-600 w-70 text-white py-2 px-2 rounded-md hover:bg-blue-700 text-center">Beli Sekarang</p>
                </a>
                <a
                  href="keranjang.php?id=<?= $data['product_id'] ?>"
                  class="bg-white border-1 border-gray-300 py-2 text-gray-400 hover:bg-gray-300 hover:text-blue-600 transition-all duration-300 px-3 rounded text-center card"
                >
                  <i class="fa-solid fa-cart-shopping"></i>
                </a>
              </div>
            </div>
          </div>
          <?php
          };
          ?>
        </div>
      </div>
    </section>

    <section class="bg-gray-50 py-10 pesan" id="pesan">
      <h1 class="font-bold text-4xl py-10 text-center text-[#272343]">Apa Kata Mereka?</h1>
      <div class="mx-auto max-w-7xl flex flex-wrap gap-4 px-6">
        <?php
        $sql_testi = mysqli_query($conn, "SELECT * FROM testimoni ORDER BY id DESC");
        while ($row = mysqli_fetch_assoc($sql_testi)) {
        ?>
        <div class="card bg-white max-w-100 p-5 rounded-lg shadow hover:shadow-2xl transition-all duration-200 max-lg:max-w-90 max-lg:mx-auto">
          <i class="fa-solid fa-quote-left text-blue-200 text-3xl mb-4"></i>
          <p class="text-lg text-gray-600 pb-4 italic card-text"><?= htmlspecialchars($row['kesan']) ?></p>
          <div class="border-t border-gray-400 ">
            <p class="pt-4 pb-3 font-bold card-text"><?= htmlspecialchars($row['nama']) ?></p>
            <p class="text-sm text-gray-600 card-text">
              <span class="font-bold text-black card-text">Saran: </span
              ><?= htmlspecialchars($row['pesan']) ?>
            </p>
          </div>
        </div>
        <?php 
        };
        ?>
      </div>
    </section>

    <section class="py-16 px-4 md:px-8 text-center about" id="tentang_kami">
      <h1 class="text-4xl font-bold text-blue-800 mb-9 py-9">TENTANG KAMI</h1>
      <div class="flex flex-col md:flex-row justify-center items-stretch gap-8">
        <div
          class="bg-gray-100 rounded-xl p-8 w-full max-w-sm shadow hover:shadow-2xl transition-all duration-200 flex flex-col justify-between h-[500px] card"
        >
          <div class="flex flex-col items-center text-center">
            <img src="img/dimas.png" alt="Dimas" class="rounded-full w-40 h-40 object-cover border-4 border-blue-500 mb-4" />
            <h2 class="text-2xl font-bold text-blue-700">DIMAS IZZULHAQQ BUSTHOMI</h2>
            <p class="italic text-gray-500 mb-4 card-text">Bangkalan, 31 Mei 2006</p>
          </div>
          <p class="text-justify text-gray-700 card-text">
            Nama saya Dimas. Ngoding, ngedesain, dan nyari solusi pakai teknologi adalah hal yang saya nikmati. Saya percaya, inovasi yang baik
            dimulai dari niat yang benar dan semangat belajar yang konsisten.
          </p>
        </div>
        <div
          class="bg-gray-100 rounded-xl p-8 w-full max-w-sm shadow hover:shadow-2xl transition-all duration-200 flex flex-col justify-between h-[500px] card"
        >
          <div class="flex flex-col items-center text-center">
            <img src="img/naisa.png" alt="Naisa" class="rounded-full w-40 h-40 object-cover border-4 border-blue-500 mb-4" />
            <h2 class="text-2xl font-bold text-blue-700">KHOLIFATUN NAISA</h2>
            <p class="italic text-gray-500 mb-4 card-text">Sumenep, 17 Juli 2006</p>
          </div>
          <p class="text-justify text-gray-700 card-text">
            Saya adalah mahasiswa aktif yang memiliki ketertarikan di bidang teknologi. Aktif mengikuti berbagai kegiatan organisasi. Saya senang
            belajar hal-hal baru, bekerja sama dalam tim, dan berkontribusi dalam proyek yang bermanfaat.
          </p>
        </div>
      </div>
    </section>

    <section id="kontak" class=" bg-[#bae8e8] py-20 wa">
      <div class="max-w-7xl mx-auto ">
        <div class="flex justify-center items-center my-5 max-lg:mx-5" id="card-kendala">
          <div class="flex gap-8 bg-white/50 rounded-lg shadow-xl p-8 max-sm:w-85 max-sm:flex-col max-sm:p-5">
            <div class="text-8xl text-[#272343] flex items-center max-sm:justify-center max-sm:text-6xl wa-text">
              <i class="fa-brands fa-whatsapp"></i>
            </div>
            <div class="flex flex-col gap-4 text-[#272343] max-sm:justify-center max-sm:items-center ">
              <h1 class="font-bold text-4xl mt-4 max-sm:text-3xl max-sm:text-center wa-text">Ada Kendala? Chat Kami!</h1>
              <p class="text-lg mt-2 max-sm:text-center wa-text">
                Tim kami siap membantu setiap kendala yang kamu alami. Laporkan masalahmu dan kami akan segera menindaklanjutinya dengan cepat dan profesional.
              </p>
              <a href="" class="bg-green-500 p-3 mb-4 rounded-full w-60 text-center font-bold text-white hover:bg-green-600 transition-all duration-300 transform hover:scale-105 "><p>Hubungi via WhatsApp</p></a>
            </div>
          </div>
        </div>
      </div>
      
    </section>

    <section class="pb-20 pt-10 bg-gray-200 lapor" id="contact">
      <h1 class="font-bold text-center text-[#272343] text-4xl py-10">Masukan Anda Berharga Bagi Kami</h1>
      <div class="max-w-7xl mx-auto max-lg:mx-10 max-lg:shadow-2xl max-sm:mx-5">
        <div class="flex shadow rounded-xl max-lg:flex-col">
          <iframe
            class="max-lg:w-full w-[50%] max-lg:h-100"
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d5933.428431030748!2d113.88879815001339!3d-6.998877656317341!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd9e5f31c9e2b53%3A0xf090e3478a409028!2sMitra%20Elektrik.!5e0!3m2!1sid!2sid!4v1749294423357!5m2!1sid!2sid"
            width=""
            height=""
            style="border: 0"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
          ></iframe>
            <div class="ps-20 pb-10 pe-10 w-[50%] text-[#272343] pt-10 bg-white max-lg:w-full max-lg:ps-10 kesan">
              <h1 class="font-bold text-2xl ">Kirim Pesan & Kesan Anda</h1>
              <form action="kirim_testi.php" method="post" class="flex flex-col">
                <label for="" class="pt-5 pb-4 font-semibold">Nama</label>
                <input name="nama" type="text" class="bg-gray-200 p-3 rounded-lg" placeholder="Masukkan Nama Anda" />
                <label for="" class="pt-5 pb-4 font-semibold">Kesan</label>
                <textarea name="kesan" id="" class="bg-gray-200 p-3 rounded-lg" placeholder="Bagaimana kesan Anda terhadap layanan kami?"></textarea>
                <label for="" class="pt-5 pb-4 font-semibold">Saran</label>
                <textarea name="pesan" id="" class="bg-gray-200 p-3 rounded-lg" placeholder="Adakah saran untuk membuat kami lebih baik?"></textarea>
                <button type="submit" name="submit" class="mt-5 p-2 text-white rounded bg-green-500 hover:bg-green-600 transition-all duration-200">
                  Kirim Pesan
                </button>
              </form>
            </div>
        </div>
      </div>
    </section>

    <footer class="bg-[#272343] text-white">
      <div class="mx-auto py-16 px-15 flex justify-between max-lg:flex-wrap max-sm:justify-center max-sm:px-5">
        <div class="w-80 max-lg:w-[40%] pt-10 max-sm:w-auto max-sm:text-center">
          <h1 class="mb-5 text-3xl font-bold">Ruang Inspirasi</h1>
          <p class="mt-4 text-[#bae8e8]/70 text-sm">Karya handmade penuh makna untuk menginspirasi hari-harimu.</p>
        </div>
        <div class="max-lg:w-[40%] pt-10 max-sm:w-auto max-sm:text-center">
          <h1 class="mb-5 text-lg font-bold">Navigasi</h1>
          <ul class="space-y-3">
              <li><a href="#products" class="hover:text-[#ffd803] transition-colors duration-300">Produk</a></li>
              <li><a href="#pesan" class="hover:text-[#ffd803] transition-colors duration-300">Testimoni</a></li>
              <li><a href="#tentang_kami" class="hover:text-[#ffd803] transition-colors duration-300">Tentang Kami</a></li>
              <li><a href="#kontak" class="hover:text-[#ffd803] transition-colors duration-300">Kontak</a></li>
            </ul>
        </div>
        <div class="w-80 max-lg:w-[40%] pt-10 max-sm:w-auto max-sm:text-center">
          <h1 class="mb-5 text-lg font-bold">Alamat</h1>
          <div class="flex gap-3 items-start justify-center md:justify-start">
              <i class="fa-solid fa-location-dot mt-1 text-[#bae8e8]"></i>
              <p class="text-[#bae8e8]/80 text-sm">
                <a href="#" class="hover:text-[#ffd803]"> Jl. Raya Telang, Kamal, Kabupaten Bangkalan, Jawa Timur 69162 </a>
              </p>
            </div>
        </div>
        <div class="max-lg:w-[40%] pt-10 max-sm:w-auto max-sm:text-center">
          <h1 class="mb-5 text-lg font-bold">Hubungi Kami</h1>
          <ul class="space-y-3 text-sm">
              <li class="flex items-center gap-3 justify-center md:justify-start">
                <i class="fa-solid fa-envelope text-[#bae8e8]"></i>
                <a href="mailto:ruanginspirasi@gmail.com" class="hover:text-[#ffd803] transition-colors duration-300">ruanginspirasi@gmail.com</a>
              </li>
              <li class="flex items-center gap-3 justify-center md:justify-start">
                <i class="fa-solid fa-phone text-[#bae8e8]"></i>
                <a
                  href="https://api.whatsapp.com/send/?phone=6287872176733"
                  target="_blank"
                  class="hover:text-[#ffd803] transition-colors duration-300"
                  >+62 878-7217-6733</a
                >
              </li>
              <li class="flex items-center gap-3 justify-center md:justify-start">
                <i class="fa-solid fa-clock text-[#bae8e8]"></i>
                <span class="text-[#bae8e8]/80">Setiap Hari, 06.00 - 21.00 WIB</span>
              </li>
            </ul>
        </div>
      </div>
      <div class="border-t border-white/20 mt-12 py-8 text-center text-sm text-gray-400">
          <p>© 2025 Ruang Inspirasi. Dirancang di Bangkalan, Indonesia. All rights reserved.</p>
        </div>
    </footer>
    <script src="assets/script.js"></script>
  </body>
</html>
