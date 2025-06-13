<?php 
include '../assets/config.php';

session_start();

$succes = '';
$error = '';

if (!isset($_SESSION['username'])) {
    header("Location: ../login/index.php");
    exit();

} else {
  if (isset($_POST['submit'])) {
  $image = $_FILES['img']['name'];
  $tmp = $_FILES['img']['tmp_name'];
  $name = $_POST['name'];
  $description = $_POST['description'];
  $price = $_POST['price'];

  if (empty($image) || empty($name) || empty($description) || empty($price)) {
    $error = "Gagal menambahkan produk ke database.";
  } else {
    $path = "../img/" . $image;
    move_uploaded_file($tmp, $path);
    $query = "INSERT INTO products (name, description, price, image_url) VALUES ('$name', '$description', '$price', '../img/$image')";

    mysqli_query($conn, $query);
  
    $_SESSION['success'] = "Produk baru berhasil ditambahkan!";
    header("Location: product.php");
} }
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
        <div class="bg-[#272343] p-5 rounded-t">
          <h1 class="font-semibold text-xl py-2 text-white">Add Product</h1>
            <?php if (!empty($error)) : ?>
              <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md" role="alert">
                <p class="font-bold">Gagal!</p>
                <p><?php echo htmlspecialchars($error); ?></p>
              </div>
            <?php endif; ?>
          </div>
        <form action="" method="post" enctype="multipart/form-data" class="pb-10">
          <div class="flex justify-center bg-gray-500 text-center items-center text-white border-b-2 border-black">
            <label for="">Select Image</label>
            <input type="file" name="img" accept="../img/*" class="bg-gray-400 w-full p-5 text-center" />
          </div>
          <div class="flex flex-col bg-gray-300 p-2">
            <label for="">Name Product</label>
            <input class="bg-gray-400 rounded p-2 text-white" type="text" name="name" />
          </div>
          <div class="flex flex-col bg-gray-300 p-2">
            <label for="">Description</label>
            <textarea class="bg-gray-400 rounded p-2 text-white" name="description" id=""></textarea>
          </div>
          <div class="flex flex-col bg-gray-300 p-2 rounded-b">
            <label for="">Price</label>
            <input class="bg-gray-400 rounded p-2 text-white" type="text" name="price" />
            <button type="submit" name="submit" class="bg-[#3adada] p-2 rounded my-3">Add Product</button>
          </div>
        </form>
      </div>
    </section>
  </body>
</html>
