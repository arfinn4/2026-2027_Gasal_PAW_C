
<?php
require_once "koneksi.php";
require_once "session.php";

cekLogin();

$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';

$labels = [];
$data_total = [];
$rekap = [];

$total_pendapatan = 0;
$total_pelanggan = 0;

if ($mulai != '' && $selesai != '') {

    // Validasi rentang tanggal
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

    // Query laporan penjualan harian
    $query = mysqli_prepare(
        $koneksi,
        "SELECT DATE(waktu_transaksi) AS tgl,
                SUM(total) AS total_harian
         FROM transaksi
         WHERE waktu_transaksi BETWEEN ? AND ?
         GROUP BY DATE(waktu_transaksi)
         ORDER BY tgl ASC"
    );

    $waktuMulai = $mulai . " 00:00:00";
    $waktuSelesai = $selesai . " 23:59:59";

    mysqli_stmt_bind_param(
        $query,
        "ss",
        $waktuMulai,
        $waktuSelesai
    );

    mysqli_stmt_execute($query);

    $hasil = mysqli_stmt_get_result($query);

    while ($row = mysqli_fetch_assoc($hasil)) {

        $labels[] = $row['tgl'];

        $data_total[] = (float) $row['total_harian'];

        $rekap[] = $row;

        $total_pendapatan += $row['total_harian'];
    }

    // Menghitung jumlah pelanggan unik
    $queryPelanggan = mysqli_prepare(
        $koneksi,
        "SELECT COUNT(DISTINCT pelanggan_id) AS jumlah
         FROM transaksi
         WHERE waktu_transaksi BETWEEN ? AND ?"
    );

    mysqli_stmt_bind_param(
        $queryPelanggan,
        "ss",
        $waktuMulai,
        $waktuSelesai
    );

    mysqli_stmt_execute($queryPelanggan);

    $hasilPelanggan = mysqli_stmt_get_result($queryPelanggan);

    $dataPelanggan = mysqli_fetch_assoc($hasilPelanggan);

    $total_pelanggan = $dataPelanggan['jumlah'] ?? 0;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>Laporan Penjualan</title>

    <link rel="stylesheet" href="style.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>

<div class="container">

    <div class="card no-print">

        <h2>Filter Laporan Penjualan</h2>

        <form method="GET">

            <label>Tanggal Mulai</label>

            <input
                type="date"
                name="mulai"
                value="<?= htmlspecialchars($mulai) ?>"
                required
            >

            <label>Tanggal Selesai</label>

            <input
                type="date"
                name="selesai"
                value="<?= htmlspecialchars($selesai) ?>"
                required
            >

            <button type="submit">
                Tampilkan
            </button>

        </form>

        <button onclick="window.print()">
            Cetak
        </button>

        <?php if ($mulai != '' && $selesai != '') { ?>

            <a href="export_excel.php?mulai=<?= urlencode($mulai) ?>&selesai=<?= urlencode($selesai) ?>"
               class="btn-kembali">
                Excel
            </a>

        <?php } ?>

    </div>

    <?php if ($mulai != '' && $selesai != '') { ?>

    <div class="card">

        <h2>Grafik Penjualan</h2>

        <?php if (count($labels) > 0) { ?>

            <div style="width:100%; max-width:800px; margin:auto;">
                <canvas id="myChart"></canvas>
            </div>

        <?php } else { ?>

            <p>Tidak ada transaksi pada rentang tanggal tersebut.</p>

        <?php } ?>

    </div>

    <div class="card">

        <h2>Rekapitulasi Penjualan</h2>

        <table>

            <tr>
                <th>No</th>
                <th>Total Pendapatan</th>
                <th>Tanggal Transaksi</th>
            </tr>

            <?php $no = 1; ?>

            <?php foreach ($rekap as $row) { ?>

            <tr>

                <td><?= $no++ ?></td>

                <td>
                    Rp <?= number_format(
                        $row['total_harian'],
                        0,
                        ',',
                        '.'
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars($row['tgl']) ?>
                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

    <div class="card">

        <h2>Ringkasan Laporan</h2>

        <p>
            <b>Jumlah Pelanggan Unik:</b>
            <?= $total_pelanggan ?> Orang
        </p>

        <p>
            <b>Total Pendapatan:</b>
            Rp <?= number_format(
                $total_pendapatan,
                0,
                ',',
                '.'
            ) ?>
        </p>

        <p>
            <b>Periode:</b>
            <?= htmlspecialchars($mulai) ?>
            sampai
            <?= htmlspecialchars($selesai) ?>
        </p>

    </div>

    <?php } ?>

    <a href="index.php" class="btn-kembali no-print">
        Kembali ke Home
    </a>

</div>

<?php if (!empty($labels)) { ?>

<script>

const ctx = document.getElementById('myChart');

new Chart(ctx, {

    type: 'bar',

    data: {

        labels: <?= json_encode($labels) ?>,

        datasets: [{

            label: 'Total Penjualan',

            data: <?= json_encode($data_total) ?>,

            backgroundColor: '#2563eb',

            borderColor: '#1d4ed8',

            borderWidth: 1

        }]

    },

    options: {

        responsive: true,

        scales: {

            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Total Pendapatan (Rp)'
                }
            },

            x: {
                title: {
                    display: true,
                    text: 'Tanggal Transaksi'
                }
            }

        }

    }

});

</script>

<?php } ?>

</body>
</html>