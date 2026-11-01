
<?php
include "koneksi.php";

$tabel = [
    "pelanggan",
    "transaksi",
    "transaksi_detail",
    "barang",
    "supplier",
    "user",
    "pembayaran"
];

$pilih = $_GET['tabel'] ?? 'pelanggan';

if (!in_array($pilih, $tabel)) {
    $pilih = 'pelanggan';
}

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM `$pilih`"
);

if (!$query) {
    die("Gagal mengambil data: " .
        mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Database</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            margin: 30px;
        }

        h2, h3 {
            color: #23456b;
        }

        .menu {
            margin-bottom: 20px;
        }

        .menu a {
            display: inline-block;
            padding: 10px 15px;
            background: #23456b;
            color: white;
            text-decoration: none;
            margin: 4px;
            border-radius: 5px;
        }

        .menu a:hover {
            background: #3979b9;
        }

        .tambah {
            display: inline-block;
            padding: 10px 15px;
            background: #198754;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .tombol-edit {
            display: inline-block;
            padding: 7px 12px;
            background: #ffc107;
            color: black;
            text-decoration: none;
            border-radius: 4px;
        }

        .tombol-hapus {
            display: inline-block;
            padding: 7px 12px;
            background: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .tombol-edit:hover {
            background: #e0a800;
        }

        .tombol-hapus:hover {
            background: #bb2d3b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #23456b;
            color: white;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }
    </style>
</head>

<body>

    <h3>Menampilkan Data Database</h3>

    <?php if ($pilih === 'pelanggan'): ?>
        <p>
            <a class="tambah" href="tambah_pelanggan.php">
                + Tambah Pelanggan
            </a>
        </p>
    <?php endif; ?>

    <div class="menu">
        <?php foreach ($tabel as $nama): ?>
            <a href="?tabel=<?= urlencode($nama) ?>">
                <?= htmlspecialchars($nama) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <h3>Data Tabel: <?= htmlspecialchars($pilih) ?></h3>

    <table>
        <tr>
            <?php
            while ($field = mysqli_fetch_field($query)) {
                echo "<th>" .
                    htmlspecialchars($field->name) .
                    "</th>";
            }

            if ($pilih === 'pelanggan') {
                echo "<th>Aksi</th>";
            }
            ?>
        </tr>

        <?php
        while ($data = mysqli_fetch_assoc($query)) {
            echo "<tr>";

            foreach ($data as $isi) {
                echo "<td>" .
                    htmlspecialchars((string)$isi) .
                    "</td>";
            }

            if ($pilih === 'pelanggan') {
                echo "<td>";

                echo "<a class='tombol-edit'
                    href='edit.php?id=" .
                    urlencode($data['id']) .
                    "'>Edit</a> ";

                echo "<a class='tombol-hapus'
                    href='hapus.php?id=" .
                    urlencode($data['id']) .
                    "'
                    onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?')\">
                    Hapus
                    </a>";

                echo "</td>";
            }

            echo "</tr>";
        }
        ?>
    </table>

</body>
</html>
