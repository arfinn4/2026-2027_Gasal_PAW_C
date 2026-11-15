<?php
include "koneksi.php";

// Menyiapkan variabel untuk grafik, tabel, dan ringkasan.
$labels = [];
$data_total = [];
$rekap = [];
$total_pendapatan = 0;
$total_pelanggan = 0;
$mulai = "";
$selesai = "";
$pesan = "";
$filter_dijalankan = isset($_GET['tampilkan']);

// Memeriksa dan memvalidasi tanggal yang dikirim melalui form.
if ($filter_dijalankan) {
    $mulai = $_GET['tanggal_mulai'] ?? "";
    $selesai = $_GET['tanggal_selesai'] ?? "";

    $format_mulai = DateTime::createFromFormat('!Y-m-d', $mulai);
    $format_selesai = DateTime::createFromFormat('!Y-m-d', $selesai);

    if (
        !$format_mulai ||
        !$format_selesai ||
        $format_mulai->format('Y-m-d') !== $mulai ||
        $format_selesai->format('Y-m-d') !== $selesai
    ) {
        $pesan = "Format tanggal tidak valid!";
    } elseif ($mulai > $selesai) {
        $pesan = "Tanggal mulai tidak boleh melebihi tanggal selesai!";
    } else {
        /*
         * Tanggal selesai dibuat inklusif.
         * Kondisi < DATE_ADD(..., INTERVAL 1 DAY) memastikan semua transaksi
         * pada tanggal selesai, termasuk yang memiliki jam, ikut dihitung.
         */
        $kondisi_tanggal = "waktu_transaksi >= ?
                            AND waktu_transaksi < DATE_ADD(?, INTERVAL 1 DAY)";

        // 1. Menghitung total pendapatan setiap hari.
        $sql = "SELECT DATE(waktu_transaksi) AS tgl,
                       SUM(total) AS total_harian
                FROM transaksi
                WHERE $kondisi_tanggal
                GROUP BY DATE(waktu_transaksi)
                ORDER BY tgl ASC";

        $query = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($query, "ss", $mulai, $selesai);
        mysqli_stmt_execute($query);
        $hasil = mysqli_stmt_get_result($query);

        while ($row = mysqli_fetch_assoc($hasil)) {
            $labels[] = $row['tgl'];
            $data_total[] = (float) $row['total_harian'];
            $rekap[] = $row;
            $total_pendapatan += (float) $row['total_harian'];
        }
        mysqli_stmt_close($query);

        // 2. Menghitung jumlah pelanggan unik pada periode yang dipilih.
        $sql_pelanggan = "SELECT COUNT(DISTINCT pelanggan_id) AS jml
                          FROM transaksi
                          WHERE $kondisi_tanggal";

        $query_pelanggan = mysqli_prepare($koneksi, $sql_pelanggan);
        mysqli_stmt_bind_param($query_pelanggan, "ss", $mulai, $selesai);
        mysqli_stmt_execute($query_pelanggan);
        $hasil_pelanggan = mysqli_stmt_get_result($query_pelanggan);
        $row_pelanggan = mysqli_fetch_assoc($hasil_pelanggan);
        $total_pelanggan = (int) ($row_pelanggan['jml'] ?? 0);
        mysqli_stmt_close($query_pelanggan);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan dan Grafik</title>

    <!-- Memanggil pustaka Chart.js untuk membuat grafik. -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 25px;
            color: #222;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f0f0f0;
        }

        .filter-area {
            margin-bottom: 20px;
        }

        .filter-area form {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
        }

        button, .tombol-excel {
            display: inline-block;
            padding: 8px 14px;
            border: 1px solid #555;
            border-radius: 4px;
            background: #f2f2f2;
            color: #111;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .area-grafik {
            width: 100%;
            max-width: 800px;
            height: 350px;
        }

        .ringkasan {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-top: 15px;
        }

        .card-ringkasan {
            flex: 1 1 220px;
            padding: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #f8f9fa;
        }

        .card-ringkasan h3 {
            margin: 0 0 10px;
            font-size: 16px;
        }

        .nilai-ringkasan {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                margin: 10mm;
                color: #000;
            }

            .area-grafik {
                max-width: 100%;
                break-inside: avoid;
            }

            .card-ringkasan {
                background: #fff;
                border: 1px solid #777;
                break-inside: avoid;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

    <!-- Form filter serta tombol aksi tidak ikut dicetak. -->
    <div class="no-print filter-area">
        <h1>Filter Laporan Penjualan</h1>

        <form method="GET" action="">
            <label for="tanggal_mulai">Dari:</label>
            <input
                type="date"
                id="tanggal_mulai"
                name="tanggal_mulai"
                value="<?php echo htmlspecialchars($mulai); ?>"
                required
            >

            <label for="tanggal_selesai">Sampai:</label>
            <input
                type="date"
                id="tanggal_selesai"
                name="tanggal_selesai"
                value="<?php echo htmlspecialchars($selesai); ?>"
                required
            >

            <button type="submit" name="tampilkan" value="1">Tampilkan</button>
        </form>

        <?php if ($filter_dijalankan && $pesan === ""): ?>
            <br>
            <button type="button" onclick="window.print()">Cetak</button>
            <a class="tombol-excel"
               href="export_excel.php?tanggal_mulai=<?php echo urlencode($mulai); ?>&amp;tanggal_selesai=<?php echo urlencode($selesai); ?>">
                Excel
            </a>
        <?php endif; ?>
    </div>

    <?php if ($pesan !== ""): ?>
        <p><?php echo htmlspecialchars($pesan); ?></p>
    <?php endif; ?>

    <?php if ($filter_dijalankan && $pesan === ""): ?>
        <h2>Laporan Penjualan</h2>
        <p>
            Periode:
            <?php echo htmlspecialchars($mulai); ?>
            sampai
            <?php echo htmlspecialchars($selesai); ?>
        </p>

        <?php if (!empty($labels)): ?>
            <h2>Grafik Penjualan</h2>
            <div class="area-grafik">
                <canvas id="myChart"></canvas>
            </div>

            <script>
                const ctx = document.getElementById('myChart').getContext('2d');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($labels); ?>,
                        datasets: [{
                            label: 'Total Pendapatan',
                            data: <?php echo json_encode($data_total); ?>,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Tanggal Transaksi'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Total Pendapatan (Rp)'
                                }
                            }
                        }
                    }
                });
            </script>

            <h2>Rekapitulasi Penjualan Harian</h2>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Total Pendapatan</th>
                        <th>Tanggal Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($rekap as $row): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td>
                                Rp. <?php echo number_format(
                                    (float) $row['total_harian'],
                                    0,
                                    ',',
                                    '.'
                                ); ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['tgl']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Card ringkasan kumulatif sesuai ketentuan Modul 7. -->
            <h2>Ringkasan Penjualan</h2>
            <div class="ringkasan">
                <div class="card-ringkasan">
                    <h3>Jumlah Pelanggan Unik</h3>
                    <p class="nilai-ringkasan">
                        <?php echo number_format($total_pelanggan, 0, ',', '.'); ?> Orang
                    </p>
                </div>

                <div class="card-ringkasan">
                    <h3>Total Pendapatan Keseluruhan</h3>
                    <p class="nilai-ringkasan">
                        Rp. <?php echo number_format($total_pendapatan, 0, ',', '.'); ?>
                    </p>
                </div>
            </div>
        <?php else: ?>
            <p>Tidak ada data penjualan pada rentang tanggal tersebut.</p>
        <?php endif; ?>
    <?php endif; ?>

</body>
</html>
