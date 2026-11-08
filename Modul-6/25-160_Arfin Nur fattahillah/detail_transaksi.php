
<?php
include "koneksi.php";

// Validasi ID transaksi
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID transaksi tidak valid.");
}

$id = (int) $_GET['id'];

// Mengambil data transaksi master
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT * FROM transaksi WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$transaksi = mysqli_fetch_assoc(
    mysqli_stmt_get_result($stmt)
);

if (!$transaksi) {
    die("Transaksi tidak ditemukan.");
}

// Proses penyimpanan detail
if (isset($_POST['simpan'])) {

    $barang_id = (int) $_POST['barang_id'];
    $qty = (int) $_POST['qty'];

    if ($barang_id <= 0 || $qty <= 0) {
        die("Barang dan jumlah harus diisi dengan benar.");
    }

    mysqli_begin_transaction($koneksi);

    try {

        // Mengambil harga barang
        $stmt = mysqli_prepare(
            $koneksi,
            "SELECT harga FROM barang
             WHERE id = ?"
        );

        mysqli_stmt_bind_param($stmt, "i", $barang_id);
        mysqli_stmt_execute($stmt);

        $barang = mysqli_fetch_assoc(
            mysqli_stmt_get_result($stmt)
        );

        if (!$barang) {
            throw new Exception("Barang tidak ditemukan.");
        }

        // Memeriksa barang yang sudah dipilih
        $stmt = mysqli_prepare(
            $koneksi,
            "SELECT barang_id
             FROM transaksi_detail
             WHERE transaksi_id = ?
             AND barang_id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "ii",
            $id,
            $barang_id
        );

        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_get_result($stmt)->num_rows > 0) {
            throw new Exception(
                "Barang sudah dimasukkan ke transaksi ini."
            );
        }

        $harga = $barang['harga'];

        // Menyimpan detail transaksi
        $stmt = mysqli_prepare(
            $koneksi,
            "INSERT INTO transaksi_detail
            (transaksi_id, barang_id, harga, qty)
            VALUES (?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "iidi",
            $id,
            $barang_id,
            $harga,
            $qty
        );

        mysqli_stmt_execute($stmt);

        // Menghitung ulang total transaksi
        $stmt = mysqli_prepare(
            $koneksi,
            "UPDATE transaksi
             SET total = (
                SELECT COALESCE(SUM(harga * qty), 0)
                FROM transaksi_detail
                WHERE transaksi_id = ?
             )
             WHERE id = ?"
        );

        mysqli_stmt_bind_param($stmt, "ii", $id, $id);
        mysqli_stmt_execute($stmt);

        // Menyimpan perubahan database
        mysqli_commit($koneksi);

        header("Location: detail_transaksi.php?id=" . $id);
        exit;

    } catch (Throwable $e) {

        mysqli_rollback($koneksi);

        echo "<script>alert(" .
             json_encode($e->getMessage()) .
             ");</script>";
    }
}

// Mengambil barang yang belum dipilih
$barang = mysqli_prepare(
    $koneksi,
    "SELECT * FROM barang b
     WHERE NOT EXISTS (
        SELECT 1
        FROM transaksi_detail td
        WHERE td.transaksi_id = ?
        AND td.barang_id = b.id
     )
     ORDER BY b.nama_barang ASC"
);

mysqli_stmt_bind_param($barang, "i", $id);
mysqli_stmt_execute($barang);

$daftar_barang = mysqli_stmt_get_result($barang);

// Mengambil detail transaksi
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT td.*, b.kode_barang, b.nama_barang
     FROM transaksi_detail td, barang b
     WHERE td.barang_id = b.id
     AND td.transaksi_id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$data_detail = mysqli_stmt_get_result($stmt);

// Mengambil total transaksi
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT total FROM transaksi WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$total = mysqli_fetch_assoc(
    mysqli_stmt_get_result($stmt)
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi</title>
</head>
<body>

<h2>Detail Transaksi</h2>

<p>ID Transaksi: <?= $transaksi['id']; ?></p>

<p>
    Keterangan:
    <?= htmlspecialchars($transaksi['keterangan']); ?>
</p>

<hr>

<h3>Tambah Barang</h3>

<form method="POST">

    <label>Pilih Barang</label><br>

    <select name="barang_id" required>

        <option value="">-- Pilih Barang --</option>

        <?php while ($b = mysqli_fetch_assoc($daftar_barang)) { ?>

            <option value="<?= $b['id']; ?>">
                <?= htmlspecialchars($b['nama_barang']); ?>
                - Rp <?= number_format($b['harga']); ?>
            </option>

        <?php } ?>

    </select>

    <br><br>

    <label>Jumlah Barang</label><br>

    <input type="number" name="qty" min="1" required>

    <br><br>

    <button type="submit" name="simpan">
        Tambah Barang
    </button>

</form>

<hr>

<h3>Daftar Detail Barang</h3>

<table border="1" cellpadding="10">

    <tr>
        <th>No</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Qty</th>
        <th>Subtotal</th>
    </tr>

    <?php
    $no = 1;

    while ($d = mysqli_fetch_assoc($data_detail)) {
    ?>

    <tr>
        <td><?= $no++; ?></td>

        <td><?= htmlspecialchars($d['kode_barang']); ?></td>

        <td><?= htmlspecialchars($d['nama_barang']); ?></td>

        <td>Rp <?= number_format($d['harga']); ?></td>

        <td><?= $d['qty']; ?></td>

        <td>
            Rp <?= number_format($d['harga'] * $d['qty']); ?>
        </td>
    </tr>

    <?php } ?>

</table>

<h3>
    Total Transaksi:
    Rp <?= number_format($total['total']); ?>
</h3>

<a href="transaksi.php">Kembali ke Transaksi</a>

</body>
</html>
