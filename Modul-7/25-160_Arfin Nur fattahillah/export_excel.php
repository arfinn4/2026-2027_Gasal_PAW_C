<?php
include "koneksi.php";

// Mengambil tanggal dari URL.
$mulai = $_GET['tanggal_mulai'] ?? "";
$selesai = $_GET['tanggal_selesai'] ?? "";

// Memvalidasi format dan urutan tanggal.
$format_mulai = DateTime::createFromFormat('!Y-m-d', $mulai);
$format_selesai = DateTime::createFromFormat('!Y-m-d', $selesai);

if (
    !$format_mulai ||
    !$format_selesai ||
    $format_mulai->format('Y-m-d') !== $mulai ||
    $format_selesai->format('Y-m-d') !== $selesai ||
    $mulai > $selesai
) {
    die("Tanggal tidak valid!");
}

// Mengambil rekap penjualan harian.
// Batas tanggal selesai dibuat inklusif agar semua jam pada tanggal tersebut masuk.
$sql = "SELECT DATE(waktu_transaksi) AS tgl,
               SUM(total) AS total_harian
        FROM transaksi
        WHERE waktu_transaksi >= ?
          AND waktu_transaksi < DATE_ADD(?, INTERVAL 1 DAY)
        GROUP BY DATE(waktu_transaksi)
        ORDER BY tgl ASC";

$query = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($query, "ss", $mulai, $selesai);
mysqli_stmt_execute($query);
$hasil = mysqli_stmt_get_result($query);

// Menyiapkan nama file hasil ekspor.
$nama_file = "laporan_penjualan_" . $mulai . "_sampai_" . $selesai . ".xls";

// Mengirim HTTP Response Header agar browser mengunduh file sebagai Excel.
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=\"$nama_file\"");
header("Pragma: no-cache");
header("Expires: 0");

// BOM UTF-8 membantu Excel membaca karakter dengan benar.
echo "\xEF\xBB\xBF";

echo "<table border='1'>";
echo "<tr><th colspan='3'>LAPORAN PENJUALAN HARIAN</th></tr>";
echo "<tr><td colspan='3'>Periode: " .
     htmlspecialchars($mulai) . " sampai " .
     htmlspecialchars($selesai) . "</td></tr>";
echo "<tr><th>No</th><th>Total Pendapatan</th><th>Tanggal Transaksi</th></tr>";

$no = 1;
$total_keseluruhan = 0;

while ($row = mysqli_fetch_assoc($hasil)) {
    $total_harian = (float) $row['total_harian'];

    echo "<tr>";
    echo "<td>" . $no++ . "</td>";
    echo "<td>" . $total_harian . "</td>";
    echo "<td>" . htmlspecialchars($row['tgl']) . "</td>";
    echo "</tr>";

    $total_keseluruhan += $total_harian;
}

echo "<tr>";
echo "<th>Total Keseluruhan</th>";
echo "<th>" . $total_keseluruhan . "</th>";
echo "<th></th>";
echo "</tr>";
echo "</table>";

mysqli_stmt_close($query);
exit;
?>
