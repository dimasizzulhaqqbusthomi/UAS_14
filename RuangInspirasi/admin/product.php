<?php

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
      <div class="mx-15 flex justify-between max-sm:mx-5">
        <div class="font-bold text-2xl">
          <a href="index.php"><h1>Daftar Product</h1></a>
        </div>
        <div class="flex gap-6 justify-center items-center max-sm:gap-2">
          <a href="product.php"
            ><p class="bg-[#ffd803] py-2 px-4 text-white rounded-2xl transition-all duration-200">
              <i class="fa-solid fa-bag-shopping"></i> Product Handmade
            </p></a
          >
          <a href="checkout.php"
            ><p class="hover:bg-[#ffd803] py-2 px-4 max-sm:hidden text-white rounded-2xl transition-all duration-200">
              <i class="fa-solid fa-cart-shopping"></i> Checkout
            </p></a
          >
          <a href="account.php"
            ><p class="hover:bg-[#ffd803] py-2 px-4 max-sm:hidden text-white rounded-2xl transition-all duration-200">
              <i class="fa-solid fa-users"></i> Daftar Pengguna
            </p></a
          >
          <a href="testimoni.php"><p class="hover:bg-[#ffd803] py-2 px-4 text-white rounded-2xl transition-all duration-200 max-sm:hidden"><i class="fa-solid fa-spa"></i> Testimoni Pengguna</p></a>
          <a href="../login/logout.php" class="hover:bg-[#ffd803] py-2 px-3 rounded-full transition-all duration-200">
            <i class="fa-solid fa-right-from-bracket"></i>
          </a>
        </div>
      </div>
    </nav>
    <div class="flex bg-[#3f3668] p-2 mx-1 min-md:hidden justify-between">
      <a href="checkout.php"
        ><p class="hover:bg-[#ffd803] py-2 px-2 text-white rounded-2xl transition-all duration-200">
          <i class="fa-solid fa-cart-shopping"></i> Checkout
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
      <div class="mx-10 my-10 max-sm:mx-2">
        <div class="flex justify-between items-center bg-[#272343] p-5 rounded-t">
          <h1 class="font-semibold text-xl py-2 text-white">Product</h1>
          <a href="add_product.php" class="bg-[#bae8e8] py-2 px-4 rounded-full font-semibold hover:bg-[#9dbebe]"><p>+ Add Product</p></a>
        </div>
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

        <?php if (isset($_GET['message']) && $_GET['message'] == 'deleted') : ?>
          <div class="bg-green-100 border-l-4 border-green-500 p-5 text-green-800 p-4rounded-lg shadow-md">
            <p class="font-bold">Sukses!</p>
            <p> Data berhasil dihapus!</p>
          </div>
        <?php endif; ?>

        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'updated') : ?>
          <div class="bg-green-100 border-l-4 border-green-500 p-5 text-green-800 p-4rounded-lg shadow-md">
            <p class="font-bold">Sukses!</p>
            <p> Data berhasil diubah!</p>
          </div>
        <?php endif; ?>

        <table class="min-w-full">
          <thead class="bg-gray-600">
            <tr class="text-white">
              <th class="text-left py-3 px-4">Image</th>
              <th class="text-left py-3 px-4">Name</th>
              <th class="text-left py-3 px-4">Description</th>
              <th class="text-left py-3 px-4">Price</th>
              <th class="text-center py-3 px-4">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include ("../assets/config.php");
          
            $sql = mysqli_query($conn, "SELECT * FROM products" );
            while ($data = mysqli_fetch_assoc($sql)) {
            
            ?>
            <tr class="border-b bg-gray-300 hover:bg-gray-400">
              <td class="py-3 px-4 text-left">
                <img src="<?= $data['image_url'] ?>" alt="<?= $data['image_url'] ?>" class="h-16 w-auto object-cover rounded" />
              </td>
              </td>
              <td class="py-3 px-4 text-left"><?= $data['name']?></td>
              <td class="py-3 px-4 text-left"><?= $data['description']?></td>
              <td class="py-3 px-4 text-left"><?= (number_format($data['price']))?></td>
              <td class="py-3 px-4 text-center">
                <div class="">
                  <button class="text-blue-500 hover:underline"><a href="edit_product.php?id=<?php echo $data['product_id'] ?>">Edit</a></button>
                  <button class="text-red-500 hover:underline"><a href="delete_product.php?id=<?php echo $data['product_id'] ?>">Hapus</a></button>
                </div>
              </td>
            </tr>
            <?php
            };
            ?>
          </tbody>
        </table>
      </div>
    </section>
  </body>
</html>
