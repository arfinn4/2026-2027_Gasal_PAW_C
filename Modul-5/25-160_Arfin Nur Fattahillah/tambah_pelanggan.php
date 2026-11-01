
<?php
include 'koneksi.php';

$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $telp = trim($_POST['telp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');

    if ($nama === '' || $jenis_kelamin === '') {
        $pesan = 'Nama dan jenis kelamin wajib diisi.';
    } else {
        $sql = "INSERT INTO pelanggan (nama, jenis_kelamin, telp, alamat)
                VALUES (?, ?, ?, ?)";

        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "ssss",
            $nama,
            $jenis_kelamin,
            $telp,
            $alamat
        );

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?tabel=pelanggan");
            exit;
        } else {
            $pesan = 'Gagal menyimpan data: ' . mysqli_error($koneksi);
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pelanggan</title>
</head>
<body>
    <h2>Tambah Data Pelanggan</h2>

    <?php if ($pesan !== ''): ?>
        <p style="color:red;">
            <?= htmlspecialchars($pesan) ?>
        </p>
    <?php endif; ?>

    <form method="POST">
        <p>
            Nama pelanggan:<br>
            <input type="text" name="nama" required>
        </p>

        <p>
            Jenis kelamin:<br>
            <select name="jenis_kelamin" required>
                <option value="">-- Pilih --</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
        </p>

        <p>
            Nomor telepon:<br>
            <input type="text" name="telp">
        </p>

        <p>
            Alamat:<br>
            <textarea name="alamat"></textarea>
        </p>

        <button type="submit">Simpan</button>
        <a href="index.php?tabel=pelanggan">Kembali</a>
    </form>
</body>
</html>
