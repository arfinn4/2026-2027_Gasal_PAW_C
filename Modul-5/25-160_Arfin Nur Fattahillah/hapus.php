
<?php
include "koneksi.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID pelanggan tidak valid.");
}

$id = (int) $_GET['id'];

$stmt = mysqli_prepare(
    $koneksi,
    "DELETE FROM pelanggan WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        header("Location: index.php?tabel=pelanggan");
        exit;
    } else {
        echo "Data pelanggan tidak ditemukan.";
    }

} else {
    echo "Gagal menghapus data. Kemungkinan data pelanggan masih digunakan dalam transaksi.";
}

mysqli_stmt_close($stmt);
?>

<br>
<a href="index.php?tabel=pelanggan">Kembali ke Data Pelanggan</a>
