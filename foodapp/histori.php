<?php
$conn = new mysqli("localhost", "root", "", "food_order", 3307);
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$query = $conn->query("SELECT * FROM pesanan ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Histori Pesanan</title>
    <style>
        body { font-family: Arial; padding: 20px; background-color: #f9f9f9; }
        .pesanan { border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; border-radius: 10px; background: #fff; }
        h3 { color: #00796b; }
        ul { padding-left: 20px; }
    </style>
</head>
<body>
<h2>Histori Pemesanan</h2>

<?php while ($row = $query->fetch_assoc()): ?>
    <div class="pesanan">
        <h3>Pesanan #<?= $row['id'] ?> - <?= htmlspecialchars($row['nama_pemesan']) ?></h3>
        <p><strong>Total Harga:</strong> Rp<?= number_format($row['total_harga'], 0, ',', '.') ?></p>
        <p><strong>Ongkir:</strong> Rp<?= number_format($row['ongkir'], 0, ',', '.') ?></p>
        <p><strong>Total Bayar:</strong> Rp<?= number_format($row['total_bayar'], 0, ',', '.') ?></p>
        <p><strong>Item yang dipesan:</strong></p>
        <ul>
        <?php
        $pesanan_id = $row['id'];
        $detail = $conn->query("SELECT m.nama FROM pesanan_detail pd JOIN menu m ON pd.menu_id = m.id WHERE pd.pesanan_id = $pesanan_id");
        while ($item = $detail->fetch_assoc()) {
            echo "<li>" . htmlspecialchars($item['nama']) . "</li>";
        }
        ?>
        </ul>
    </div>
<?php endwhile; ?>

</body>
</html>
