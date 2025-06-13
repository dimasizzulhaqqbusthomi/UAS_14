<?php
include ("../assets/config.php");

session_start();

if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $error = '';

  $query = "SELECT * FROM accounts WHERE username = '$username'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    if (password_verify($password, $user["password"])) {
      if ($user["username"] === "AdminRuang") {
        $_SESSION["username"] = $user["username"];
        header("Location:../admin/index.php");
      } else {
        $_SESSION["username"] = $user["username"];
        header("Location: ../index.php");
      }
    } else {
      $error = "Password salah!";
    }
  } else {
    $error = "Username tidak ditemukan!";
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
        <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap");
        body {
            font-family: "Poppins", sans-serif;
        }
    </style>
  </head>
  <body class="bg-[#fffffe]">
    <section class="max-w-7xl mx-auto" id="login">
      <div class="mx-40 my-10 bg-[#bae8e8] rounded-b-4xl max-lg:mx-20 max-sm:mx-5">
        <div class="bg-[#272343] flex justify-between items-center px-4 py-4">
          <h1 class="text-2xl font-bold text-white max-sm:hidden">Ruang Inspirasi</h1>
          <a href="../index.php"><p class="bg-gray-200 text-[#272343] py-2 rounded px-5 ">Kembali ke Beranda</p></a>
        </div>
        <div class="flex h-auto max-lg:h-auto max-sm:flex-col"> 
          <div class="flex items-center w-[50%] p-10 max-sm:hidden">
            <img src="../img/Login.svg" alt="" />
          </div>
          <div class="w-[50%] px-10 bg-[#4fe2e2] pt-6 max-sm:w-full ">
            <h1 class="text-left font-bold pt-4 text-3xl max-sm:mx-auto">Masuk ke Akun Anda</h1>
            <p class="text-left text-[1rem] py-2 text-gray-800">Selamat datang kembali!</p>
            
            <?php
            if (isset($_SESSION['success'])) {
              echo '
                <div class="bg-green-100 border-l-4 border-green-500 p-5 text-green-800 p-4rounded-lg shadow-md">
                  <p class="font-bold">Sukses!</p>
                  <p>' . htmlspecialchars($_SESSION['success']) . '</p>
                </div>';
                unset($_SESSION['success']);
            }
            ?>

            <?php if (!empty($error)): ?>
              <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= $error ?>
              </div>
            <?php endif; ?>

            <form action="" method="post">
              <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-2">
                  <label for="">Username</label>
                  <input type="text" name="username" class="bg-[#fffffe] p-3 rounded" placeholder="Contoh: Adit Maulana" />
                </div>
                <div class="flex flex-col gap-2">
                  <label for="">Password</label>
                  <input type="password" name="password" class="bg-[#fffffe] p-3 rounded" placeholder="Masukkan Password" />
                </div>
                <div class="bg-[#2d334a] rounded-md py-3 text-center font-extrabold text-xl">
                  <button name="submit" value="submit" class="text-white">Masuk</button>
                </div>
                <div class="text-center py-6">
                  <p class="text-md">
                    Belum punya akun?
                    <a href="register.php"><span class="font-bold text-[#272343] hover:underline" onclick="Register()">Daftar di sini</span></a>
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
