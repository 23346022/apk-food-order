<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_order";
$conn = new mysqli($servername, $username, $password, $dbname, 3307);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$makanan = $conn->query("SELECT * FROM menu WHERE kategori = 'makanan' ORDER BY nama");
$minuman = $conn->query("SELECT * FROM menu WHERE kategori = 'minuman' ORDER BY nama");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Form Pemesanan Makanan</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-image: url('images/background.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      margin: 0;
      padding: 20px;
    }

    .container {
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 10px;
      padding: 25px;
      max-width: 600px;
      margin: auto;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    }

    h2 {
      text-align: center;
      color: #00796b;
    }

    label {
      font-weight: bold;
    }

    .submit-btn {
      background-color: #00796b;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 10px;
    }

    .submit-btn:hover {
      background-color: #004d40;
    }

    .hasil {
      margin-top: 20px;
      background-color: #f1f8e9;
      padding: 15px;
      border-radius: 10px;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Form Pemesanan Makanan</h2>

  <form method="post" action="">
    <label>Nama Pemesan:</label>
    <input type="text" name="nama" required><br><br>

    <label>Makan di Tempat?</label>
    <select name="makan_di_tempat" required>
      <option value="">-- Pilih --</option>
      <option value="ya">Ya</option>
      <option value="tidak">Tidak</option>
    </select><br><br>

    <label>Pilih Menu Makanan:</label><br>
    <?php while ($row = $makanan->fetch_assoc()): ?>
      <input type="checkbox" name="menu[]" value="<?= $row['id'] ?>"> <?= htmlspecialchars($row['nama']) ?> (Rp<?= number_format($row['harga'], 0, ',', '.') ?>)<br>
    <?php endwhile; ?>

    <br><label>Pilih Menu Minuman:</label><br>
    <?php while ($row = $minuman->fetch_assoc()): ?>
      <input type="checkbox" name="menu[]" value="<?= $row['id'] ?>"> <?= htmlspecialchars($row['nama']) ?> (Rp<?= number_format($row['harga'], 0, ',', '.') ?>)<br>
    <?php endwhile; ?>

    <br><input type="submit" name="submit" value="Pesan" class="submit-btn">
  </form>

<?php
if (isset($_POST['submit'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $makan_di_tempat = $_POST['makan_di_tempat'];
    $menu = $_POST['menu'] ?? [];
    $total_harga = 0;

    foreach ($menu as $id) {
        $id = (int)$id;
        $query = $conn->query("SELECT harga FROM menu WHERE id = $id");
        if ($query && $query->num_rows > 0) {
            $row = $query->fetch_assoc();
            $total_harga += $row['harga'];
        }
    }

    // Aturan ongkir baru
    if ($makan_di_tempat === 'ya') {
        $ongkir = 0;
    } else {
        $ongkir = ($total_harga >= 70000) ? 0 : 10000;
    }

    $total_bayar = $total_harga + $ongkir;

    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO pesanan (nama_pemesan, total_harga, ongkir, total_bayar) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siii", $nama, $total_harga, $ongkir, $total_bayar);
    $stmt->execute();
    $stmt->close();

   echo "<div class='hasil'>";
   echo "Pesanan berhasil disimpan!<br>";
   echo "<ul>";

foreach ($menu as $id) {
    $id = (int)$id;
    $query = $conn->query("SELECT nama, harga FROM menu WHERE id = $id");
    if ($query && $query->num_rows > 0) {
        $row = $query->fetch_assoc();
        echo "<li>" . htmlspecialchars($row['nama']) . " (Rp" . number_format($row['harga'], 0, ',', '.') . ")</li>";
    }
}

  echo "</ul>";
  echo "Total Harga: Rp" . number_format($total_harga, 0, ',', '.') . "<br>";
  echo "Ongkir: Rp" . number_format($ongkir, 0, ',', '.') . "<br>";
  echo "Total Bayar: Rp" . number_format($total_bayar, 0, ',', '.') . "<br><br>";
  echo "<strong>Terima kasih udah pesen di sini, " . htmlspecialchars($nama) . "! 😊 </strong>";
  echo "</div>"; 
}

$conn->close();
?>
</div>
</body>
</html>