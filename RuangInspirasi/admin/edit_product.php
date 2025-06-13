<?php 
include '../assets/config.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login/index.php");
    exit();
}

$id =  $_GET['id'];
$sql = "SELECT * FROM products WHERE product_id = $id";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {
    $image = $_FILES['img']['name'];
    $tmp = $_FILES['img']['tmp_name'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $path = "../img/" . $image;
    move_uploaded_file($tmp, $path);
    
    $update = mysqli_query($conn,"UPDATE products SET 
        name = '$name',
        description = '$description',
        price = '$price',
        image_url = '$path'
        WHERE product_id = $id");

    header("Location: product.php?msg=updated");
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Data</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://kit.fontawesome.com/e4ca1991ae.js" crossorigin="anonymous"></script>
  </head>
  <body class="bg-gray-100 min-h-screen">
    <nav class="bg-[#272343] m-1 rounded-tl-xl py-10 text-white">
      <div class="mx-15 flex justify-between">
        <div class="font-bold text-2xl">
          <a href="index.php"><h1>Daftar Product</h1></a>
        </div>
        <div class="flex gap-6 justify-center items-center">
          <a href="product.php"
            ><p class="bg-[#ffd803] py-2 px-4 text-white rounded-2xl transition-all duration-200">
              <i class="fa-solid fa-bag-shopping"></i> Product Handmade
            </p></a
          >
          <a href="checkout.php"
            ><p class="hover:bg-[#ffd803] py-2 px-4 text-white rounded-2xl transition-all duration-200">
              <i class="fa-solid fa-cart-shopping"></i> Checkout
            </p></a
          >
          <a href="account.php"
            ><p class="hover:bg-[#ffd803] py-2 px-4 text-white rounded-2xl transition-all duration-200">
              <i class="fa-solid fa-users"></i> Daftar Pengguna
            </p></a
          >
          <a href="../login/logout.php" class="hover:bg-[#ffd803] py-2 px-3 rounded-full transition-all duration-200">
            <i class="fa-solid fa-right-from-bracket"></i>
          </a>
        </div>
      </div>
    </nav>
    <section class="max-w-7xl">
      <div class="mx-30 my-10">
        <div class="flex justify-between items-center bg-[#272343] p-5 rounded-t">
          <h1 class="font-semibold text-xl py-2 text-white">Add Product</h1>
        </div>
        <form action="" method="post" enctype="multipart/form-data" class="pb-10">
          <div class="flex justify-center bg-gray-500 text-center items-center text-white border-b-2 border-black">
            <label for="">Select Image</label>
            <input type="file" name="img" accept="../img/*" value="<?= $data['image_url']?>" class="bg-gray-400 w-full p-5 text-center" />
          </div>
          <div class="flex flex-col bg-gray-300 p-2">
            <label for="">Name Product</label>
            <input class="bg-gray-400 rounded p-2 text-white" value="<?= $data['name']?>"  type="text" name="name" />
          </div>
          <div class="flex flex-col bg-gray-300 p-2">
            <label for="">Description</label>
            <textarea class="bg-gray-400 rounded p-2 text-white" name="description" id=""><?= $data['description']?></textarea>
          </div>
          <div class="flex flex-col bg-gray-300 p-2 rounded-b">
            <label for="">Price</label>
            <input class="bg-gray-400 rounded p-2 text-white" value="<?= $data['price']?>"  type="text" name="price" />
            <button type="submit" name="submit" class="bg-[#3adada] p-2 rounded my-3">Add Product</button>
          </div>
        </form>
      </div>
    </section>
  </body>
</html>
