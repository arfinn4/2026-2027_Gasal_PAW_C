export_excel.php
<?php
require_once "koneksi.php";
require_once "session.php";

cekLogin();

// Mengambil tanggal dari URL
$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';

// Validasi tanggal
$tanggalMulai = DateTime::createFromFormat('!Y-m-d', $mulai);
$tanggalSelesai = DateTime::createFromFormat('!Y-m-d', $selesai);

if (
    !$tanggalMulai ||
    !$tanggalSelesai ||
    $tanggalMulai->format('Y-m-d') !== $mulai ||
    $tanggalSelesai->format('Y-m-d') !== $selesai ||
    $mulai > $selesai
) {
    die("Rentang tanggal tidak valid.");
}

$waktuMulai = $mulai . " 00:00:00";
$waktuSelesai = $selesai . " 23:59:59";

// Mengambil data laporan
$query = mysqli_prepare(
    $koneksi,
    "SELECT DATE(waktu_transaksi) AS tgl,
            SUM(total) AS total_harian
     FROM transaksi
     WHERE waktu_transaksi BETWEEN ? AND ?
     GROUP BY DATE(waktu_transaksi)
     ORDER BY tgl ASC"
);

mysqli_stmt_bind_param(
    $query,
    "ss",
    $waktuMulai,
    $waktuSelesai
);

mysqli_stmt_execute($query);

$hasil = mysqli_stmt_get_result($query);

// Mengatur header Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_penjualan.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>

<table border="1">

    <tr>
        <th>No</th>
        <th>Total Pendapatan</th>
        <th>Tanggal Transaksi</th>
    </tr>

    <?php
    $no = 1;
    $total_pendapatan = 0;

    while ($row = mysqli_fetch_assoc($hasil)) {

        $total_pendapatan += $row['total_harian'];
    ?>

    <tr>
        <td><?= $no++ ?></td>

        <td>
            <?= $row['total_harian'] ?>
        </td>

        <td>
            <?= htmlspecialchars($row['tgl']) ?>
        </td>
    </tr>

    <?php } ?>

    <tr>
        <th>Total Pendapatan</th>
        <th><?= $total_pendapatan ?></th>
        <th></th>
    </tr>

</table>