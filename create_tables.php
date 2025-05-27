<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_order";
$port = 3307;

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Cek koneksi
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

// Buat tabel menu
$sql_menu = "CREATE TABLE IF NOT EXISTS menu (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  harga INT NOT NULL
)";
$conn->query($sql_menu);

// Buat tabel pesanan
$sql_pesanan = "CREATE TABLE IF NOT EXISTS pesanan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_pemesan VARCHAR(100) NOT NULL,
  total_harga INT NOT NULL,
  ongkir INT NOT NULL,
  total_bayar INT NOT NULL
)";
$conn->query($sql_pesanan);

echo "Tabel berhasil dibuat";
$conn->close();
?>