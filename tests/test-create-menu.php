<?php
// Simulasi logika tambah menu

function createMenu($name, $price) {
    return !empty($name) && is_numeric($price) && $price > 0;
}

// Jalankan test
if (createMenu("Nasi Goreng", 15000)) {
    echo "✅ Test tambah menu berhasil\n";
    exit(0);
} else {
    echo "❌ Test tambah menu gagal\n";
    exit(1);
}
