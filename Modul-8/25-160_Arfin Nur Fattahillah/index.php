<?php
require_once "session.php";
cekLogin();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Halaman Utama</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">

    <h2>Sistem Penjualan</h2>

    <div class="menu">
        <a href="index.php">Home</a>

        <?php if ($_SESSION['level'] == 1) { ?>

            <a href="barang.php">Barang</a>
            <a href="supplier.php">Supplier</a>
            <a href="pelanggan.php">Pelanggan</a>
            <a href="pengguna.php">Pengguna</a>

        <?php } ?>

        <a href="transaksi.php">Transaksi</a>
        <a href="laporan.php">Laporan</a>
        <a href="logout.php">Logout</a>
    </div>

</div>

<div class="container">

    <div class="card">

        <h2>Halaman Home</h2>

        <p>
            Selamat datang,
            <b><?= htmlspecialchars($_SESSION['nama']) ?></b>
        </p>

        <p>
            Username:
            <?= htmlspecialchars($_SESSION['username']) ?>
        </p>

        <p>
            Level:
            <?= ($_SESSION['level'] == 1) ? "Owner" : "Kasir" ?>
        </p>

    </div>

</div>

</body>
</html>