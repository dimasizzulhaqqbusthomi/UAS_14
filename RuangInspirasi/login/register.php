<?php
include ("../assets/config.php");

session_start();

$error = "";
$success = "";

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $full_name = $_POST["full_name"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];

    if (empty($username) || empty($full_name) || empty($phone) || empty($password)) {
        $error = "Semua kolom wajib diisi.";
    } else {
        $checkUsername = mysqli_query($conn, "SELECT * FROM accounts WHERE username = '$username'");
        if (mysqli_num_rows($checkUsername) > 0) {
            $error = "Username sudah digunakan. Silakan pilih username lain.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $result = mysqli_query($conn, "INSERT INTO accounts (username, full_name, phone, password) 
                VALUES ('$username', '$full_name', '$phone', '$hashedPassword')");
            if ($result) {
                $_SESSION['success'] = "Berhasil registrasi akun.";
                header("Location: index.php");
                exit();
            } else {
                $error = "Terjadi kesalahan saat mendaftarkan akun.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Poppins", sans-serif;
        }
    </style>
  </head>
  <body class="bg-[#fffffe]">
    <section class="max-w-7xl mx-auto">
      <div class="mx-30 my-10 bg-[#bae8e8] rounded-b-4xl max-lg:mx-20 max-sm:mx-5">
        <div class="bg-[#272343] flex justify-between items-center px-4 py-4">
          <h1 class="text-2xl font-bold text-white">Ruang Inspirasi</h1>
          <a href="index.php"><p class="bg-gray-200 text-[#272343] py-2 rounded px-5 ">Kembali</p></a>
        </div>
        <div class="flex h-auto max-sm:flex-col">
          <div class="flex items-center w-[50%] p-15 max-sm:hidden">
            <img src="../img/Data-security.svg" alt="" />
          </div>
          <div class="w-[50%] px-15 bg-[#4fe2e2] py-6 max-sm:w-full max-sm:px-5">
            <h1 class="text-left font-bold pt-4 text-3xl text-[#272343]">Daftar Akun Baru</h1>
            <p class="text-left text-md py-2 text-gray-800">Daftar untuk mulai berbelanja.</p>

            <?php if (!empty($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
              <?= $error ?>
            </div>
            <?php endif; ?>

            <form action="" method="post">
              <div class="flex flex-col gap-4 pt-5">
                <div class="flex flex-col gap-2">
                  <label for="" class="font-semibold">Username</label>
                  <input type="text" name="username" class="bg-[#fffffe] p-3 rounded" placeholder="Pilih username unik" />
                </div>
                <div class="flex flex-col gap-2">
                  <label for="" class="font-semibold">Nama</label>
                  <input type="text" name="full_name" class="bg-[#fffffe] p-3 rounded" placeholder="Contoh: Adit Maulana" />
                </div>
                <div class="flex flex-col gap-2">
                  <label for="" class="font-semibold">No. Telpon</label>
                  <input type="number" name="phone" class="bg-[#fffffe] p-3 rounded" placeholder="Contoh: 08123456789" />
                </div>
                <div class="flex flex-col gap-2">
                  <label for="" class="font-semibold">Password</label>
                  <input type="password" name="password" class="bg-[#fffffe] p-3 rounded" placeholder="Masukkan Password" />
                </div>
                <div class="bg-[#2d334a] rounded text-center p-3">
                  <button name="submit" value="submit" class="text-white">Daftar</button>
                </div>
                <div class="text-center">
                  <p class="text-black">
                    Sudah punya akun? <a href="index.php"><span class="font-bold text-[#272343] hover:underline">Masuk di sini</span></a>
                  </p>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
