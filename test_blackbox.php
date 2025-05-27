<?php
// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

function hitungTotalBayar($harga_items, $makan_di_tempat) {
    $total_harga = array_sum($harga_items);

    if ($makan_di_tempat === 'ya') {
        $ongkir = 0;
    } else {
        $ongkir = ($total_harga >= 70000) ? 0 : 10000;
    }

    $total_bayar = $total_harga + $ongkir;

    return [$total_harga, $ongkir, $total_bayar];
}

// Simpan semua hasil test ke array untuk ditampilkan dalam tabel
$test_results = [];

// Menu harga:
$menu1 = 20000;
$menu2 = 15000;
$menu3 = 40000;

// Daftar test case
$test_cases = [
    ["TC1", "Makan di tempat, total < 70rb", [$menu1, $menu2], "ya", 0, 35000],
    ["TC2", "Tidak makan di tempat, total < 70rb", [$menu1, $menu2], "tidak", 10000, 45000],
    ["TC3", "Tidak makan di tempat, total >= 70rb", [$menu1, $menu2, $menu3], "tidak", 0, 75000],
    ["TC4", "Makan di tempat, total >= 70rb", [$menu1, $menu2, $menu3], "ya", 0, 75000],
    ["TC5", "Tidak pilih menu apapun", [], "tidak", 10000, 10000],
];

// Proses semua test case
foreach ($test_cases as $tc) {
    list($kode, $skenario, $harga_items, $makan_di_tempat, $expected_ongkir, $expected_total_bayar) = $tc;
    list($total_harga, $ongkir, $total_bayar) = hitungTotalBayar($harga_items, $makan_di_tempat);
    $status = ($ongkir == $expected_ongkir && $total_bayar == $expected_total_bayar) ? "✅ Lulus" : "❌ Gagal";

    $test_results[] = [
        'kode' => $kode,
        'skenario' => $skenario,
        'total_harga' => $total_harga,
        'ongkir' => $ongkir,
        'total_bayar' => $total_bayar,
        'expected_ongkir' => $expected_ongkir,
        'expected_total_bayar' => $expected_total_bayar,
        'status' => $status
    ];
}

// Tampilkan hasil dalam tabel HTML
echo <<<HTML
<h2>Hasil Black Box Testing</h2>
<table border="1" cellpadding="8" cellspacing="0">
  <thead style="background-color:#f2f2f2;">
    <tr>
      <th>Test Case</th>
      <th>Skenario</th>
      <th>Total Harga</th>
      <th>Ongkir</th>
      <th>Total Bayar</th>
      <th>Hasil</th>
    </tr>
  </thead>
  <tbody>
HTML;

foreach ($test_results as $result) {
    $color = strpos($result['status'], '✅') !== false ? 'green' : 'red';
    echo "<tr>
        <td>{$result['kode']}</td>
        <td>{$result['skenario']}</td>
        <td>Rp" . number_format($result['total_harga'], 0, ',', '.') . "</td>
        <td>Rp" . number_format($result['ongkir'], 0, ',', '.') . "</td>
        <td>Rp" . number_format($result['total_bayar'], 0, ',', '.') . "</td>
        <td style='color:{$color};'><strong>{$result['status']}</strong></td>
    </tr>";
}

echo "</tbody></table>";
?>