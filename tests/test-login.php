<?php
// Simulasi blackbox test login
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://localhost/foodapp/login.php");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "username=testuser&password=123456");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

// Contoh pengecekan hasil
if (strpos($response, "Berhasil Login") !== false) {
    echo "✅ Test Login berhasil\n";
    exit(0); // Berarti test sukses
} else {
    echo "❌ Test Login gagal\n";
    exit(1); // Berarti test gagal
}

