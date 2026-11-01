
<?php
include "koneksi.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID pelanggan tidak valid.");
}

$id = (int) $_GET['id'];

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT * FROM pelanggan WHERE id = ?"
);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$data) {
    die("Data pelanggan tidak ditemukan.");
}

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $stmt = mysqli_prepare(
        $koneksi,
        "UPDATE pelanggan
         SET nama = ?, jenis_kelamin = ?, telp = ?, alamat = ?
         WHERE id = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssssi",
        $nama,
        $jenis_kelamin,
        $telp,
        $alamat,
        $id
    );

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal mengubah data: " .
             htmlspecialchars(mysqli_error($koneksi));
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Pelanggan</title>
</head>
<body>

<h2>Edit Data Pelanggan</h2>

<form method="POST">

    <label>Nama Pelanggan</label><br>
    <input type="text" name="nama"
           value="<?= htmlspecialchars($data['nama']) ?>"
           required>
    <br><br>

    <label>Jenis Kelamin</label><br>
    <select name="jenis_kelamin" required>
        <option value="L"
            <?= $data['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>
            Laki-laki
        </option>

        <option value="P"
            <?= $data['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>
            Perempuan
        </option>
    </select>
    <br><br>

    <label>Nomor Telepon</label><br>
    <input type="text" name="telp"
           value="<?= htmlspecialchars($data['telp']) ?>"
           required>
    <br><br>

    <label>Alamat</label><br>
    <textarea name="alamat" required><?= htmlspecialchars($data['alamat']) ?></textarea>
    <br><br>

    <!-- Tombol untuk menyimpan perubahan -->
    <button type="submit" name="update">
        Simpan Perubahan
    </button>

    <a href="index.php">
        <button type="button">Kembali</button>
    </a>

</form>

</body>
</html>
