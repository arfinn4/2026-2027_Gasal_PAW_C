
<?php

include "koneksi.php";

// Memeriksa ID barang
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID barang tidak valid.");
}

$id = (int) $_GET['id'];

// Memeriksa apakah barang masih digunakan
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT COUNT(*) AS jumlah
     FROM transaksi_detail
     WHERE barang_id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_fetch_assoc(
    mysqli_stmt_get_result($stmt)
);

// Jika barang sudah digunakan
if ($result['jumlah'] > 0) {

    echo "<script>
        alert('Barang tidak dapat dihapus karena masih digunakan dalam transaksi!');
        window.location='barang.php';
    </script>";

    exit;
}

// Menghapus barang jika belum digunakan
$stmt = mysqli_prepare(
    $koneksi,
    "DELETE FROM barang WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {

    echo "<script>
        alert('Data barang berhasil dihapus!');
        window.location='barang.php';
    </script>";

} else {

    echo "<script>
        alert('Data barang gagal dihapus!');
        window.location='barang.php';
    </script>";

}

?>
