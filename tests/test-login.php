<?php
// Simulasi logic login sederhana (tanpa HTTP request)
function login($username, $password) {
    // Anggap kamu punya username dan password tersimpan
    $validUser = "testuser";
    $validPass = "123456";

    return $username === $validUser && $password === $validPass;
}

// Jalankan test
if (login("testuser", "123456")) {
    echo "✅ Test Login berhasil\n";
    exit(0); // sukses
} else {
    echo "❌ Test Login gagal\n";
    exit(1); // gagal
}
