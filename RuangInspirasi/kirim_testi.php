<?php
include("assets/config.php");

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login/index.php");
    exit();
}

if (isset($_POST['submit'])) {
  $nama = $conn->real_escape_string($_POST['nama']);
  $kesan = $conn->real_escape_string($_POST['kesan']);
  $pesan = $conn->real_escape_string($_POST['pesan']);

  $sql = "INSERT INTO testimoni (nama, kesan, pesan) VALUES ('$nama', '$kesan', '$pesan')";

  if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
  } else {
    echo "Error: " . $conn->error;
  }
}

$conn->close();
?>
