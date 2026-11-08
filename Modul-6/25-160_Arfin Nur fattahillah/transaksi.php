
<?php
include "koneksi.php";

// Proses simpan transaksi master
if (isset($_POST['simpan'])) {

    $pelanggan_id = (int) $_POST['pelanggan_id'];
    $keterangan = trim($_POST['keterangan']);

    $stmt = mysqli_prepare(
        $koneksi,
        "INSERT INTO transaksi
        (waktu_transaksi, keterangan, total, pelanggan_id)
        VALUES (NOW(), ?, 0, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "si",
        $keterangan,
        $pelanggan_id
    );

    if (mysqli_stmt_execute($stmt)) {

        $id = mysqli_insert_id($koneksi);

        header("Location: detail_transaksi.php?id=" . $id);
        exit;

    } else {
        echo "Gagal menyimpan transaksi.";
    }
}

// Mengambil data pelanggan
$pelanggan = mysqli_query(
    $koneksi,
    "SELECT * FROM pelanggan ORDER BY nama ASC"
);

// Mengambil data transaksi
$data = mysqli_query(
    $koneksi,
    "SELECT transaksi.*, pelanggan.nama
     FROM transaksi, pelanggan
     WHERE transaksi.pelanggan_id = pelanggan.id
     ORDER BY transaksi.id DESC"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Transaksi</title>
</head>
<body>

<h2>Tambah Transaksi</h2>

<form method="POST">

    <label>Pilih Pelanggan</label><br>

    <select name="pelanggan_id" required>
        <option value="">-- Pilih Pelanggan --</option>

        <?php while ($p = mysqli_fetch_assoc($pelanggan)) { ?>

            <option value="<?= $p['id']; ?>">
                <?= htmlspecialchars($p['nama']); ?>
            </option>

        <?php } ?>

    </select>

    <br><br>

    <label>Keterangan Transaksi</label><br>

    <textarea name="keterangan" required></textarea>

    <br><br>

    <button type="submit" name="simpan">
        Simpan Transaksi
    </button>

</form>

<hr>

<h2>Daftar Transaksi</h2>

<table border="1" cellpadding="10">

    <tr>
        <th>ID</th>
        <th>Waktu Transaksi</th>
        <th>Pelanggan</th>
        <th>Keterangan</th>
        <th>Total</th>
        <th>Aksi</th>
    </tr>

    <?php while ($t = mysqli_fetch_assoc($data)) { ?>

    <tr>
        <td><?= $t['id']; ?></td>

        <td><?= $t['waktu_transaksi']; ?></td>

        <td><?= htmlspecialchars($t['nama']); ?></td>

        <td><?= htmlspecialchars($t['keterangan']); ?></td>

        <td>Rp <?= number_format($t['total']); ?></td>

        <td>
            <a href="detail_transaksi.php?id=<?= $t['id']; ?>">
                Detail
            </a>
        </td>
    </tr>

    <?php } ?>

</table>

</body>
</html>
