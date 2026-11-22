
<?php
require_once "koneksi.php";
require_once "session.php";

cekLogin();

$pesan = "";

if (isset($_POST['simpan'])) {

    $pelanggan_id = (int) $_POST['pelanggan_id'];
    $total = (float) $_POST['total'];
    $waktu_transaksi = $_POST['waktu_transaksi'];

    if ($pelanggan_id > 0 && $total > 0 && !empty($waktu_transaksi)) {

        $query = mysqli_prepare(
            $koneksi,
            "INSERT INTO transaksi
            (pelanggan_id, total, waktu_transaksi)
            VALUES (?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $query,
            "ids",
            $pelanggan_id,
            $total,
            $waktu_transaksi
        );

        if (mysqli_stmt_execute($query)) {
            $pesan = "Transaksi berhasil disimpan!";
        } else {
            $pesan = "Transaksi gagal disimpan!";
        }

    } else {
        $pesan = "Semua data harus diisi dengan benar!";
    }
}

$data = mysqli_query(
    $koneksi,
    "SELECT * FROM transaksi ORDER BY waktu_transaksi DESC"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Penjualan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <div class="card">

        <h2>Transaksi Penjualan</h2>

        <?php if ($pesan != "") { ?>
            <p><?= htmlspecialchars($pesan) ?></p>
        <?php } ?>

        <form method="POST">

            <label>ID Pelanggan</label>
            <input
                type="number"
                name="pelanggan_id"
                min="1"
                required
            >

            <label>Total Penjualan</label>
            <input
                type="number"
                name="total"
                min="1"
                required
            >

            <label>Waktu Transaksi</label>
            <input
                type="datetime-local"
                name="waktu_transaksi"
                required
            >

            <button type="submit" name="simpan">
                Simpan Transaksi
            </button>

        </form>

    </div>

    <div class="card">

        <h2>Data Transaksi</h2>

        <table>
            <tr>
                <th>No</th>
                <th>ID Pelanggan</th>
                <th>Total</th>
                <th>Waktu Transaksi</th>
            </tr>

            <?php $no = 1; ?>

            <?php while ($row = mysqli_fetch_assoc($data)) { ?>

            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['pelanggan_id']) ?></td>
                <td>
                    Rp <?= number_format($row['total'], 0, ',', '.') ?>
                </td>
                <td><?= htmlspecialchars($row['waktu_transaksi']) ?></td>
            </tr>

            <?php } ?>

        </table>

    </div>

    <a href="index.php" class="btn-kembali">
        Kembali ke Home
    </a>

</div>

</body>
</html>