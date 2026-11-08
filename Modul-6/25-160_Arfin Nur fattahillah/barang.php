
<?php
include "koneksi.php";

// Mengambil data barang dan nama supplier
$query = mysqli_query(
    $koneksi,
    "SELECT barang.*, supplier.nama AS nama_supplier
     FROM barang, supplier
     WHERE barang.supplier_id = supplier.id
     ORDER BY barang.id ASC"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Barang</title>
</head>
<body>

<h2>DATA BARANG</h2>

<table border="1" cellpadding="10" cellspacing="0">

    <tr>
        <th>ID</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Supplier</th>
        <th>Aksi</th>
    </tr>

    <?php while ($b = mysqli_fetch_assoc($query)) { ?>

    <tr>
        <td><?= $b['id']; ?></td>

        <td><?= htmlspecialchars($b['kode_barang']); ?></td>

        <td><?= htmlspecialchars($b['nama_barang']); ?></td>

        <td>Rp <?= number_format($b['harga']); ?></td>

        <td><?= $b['stok']; ?></td>

        <td><?= htmlspecialchars($b['nama_supplier']); ?></td>

        <td>
            <a
                href="hapus_barang.php?id=<?= $b['id']; ?>"
                onclick="return confirm('Yakin ingin menghapus barang ini?')"
            >
                Hapus
            </a>
        </td>
    </tr>

    <?php } ?>

</table>

<br>

<a href="transaksi.php">Kembali ke Transaksi</a>

</body>
</html>
