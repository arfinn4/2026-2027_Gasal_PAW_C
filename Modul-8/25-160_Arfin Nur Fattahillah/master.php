<?php
require_once "koneksi.php";
require_once "session.php";

cek_owner();

$jenis = $_GET['jenis'] ?? '';

$daftar = [
    'barang' => [
        'judul' => 'Data Barang',
        'tabel' => 'barang',
        'kolom' => [
            'kode_barang' => 'Kode Barang',
            'nama_barang' => 'Nama Barang',
            'harga' => 'Harga',
            'stok' => 'Stok'
        ]
    ],

    'supplier' => [
        'judul' => 'Data Supplier',
        'tabel' => 'supplier',
        'kolom' => [
            'nama_supplier' => 'Nama Supplier',
            'alamat' => 'Alamat',
            'telepon' => 'Telepon'
        ]
    ],

    'pelanggan' => [
        'judul' => 'Data Pelanggan',
        'tabel' => 'pelanggan',
        'kolom' => [
            'nama_pelanggan' => 'Nama Pelanggan',
            'alamat' => 'Alamat',
            'telepon' => 'Telepon'
        ]
    ],

    'pengguna' => [
        'judul' => 'Data Pengguna',
        'tabel' => 'user',
        'kolom' => [
            'username' => 'Username',
            'nama' => 'Nama',
            'level' => 'Level'
        ]
    ]
];

if (!isset($daftar[$jenis])) {
    die("Halaman tidak ditemukan.");
}

$config = $daftar[$jenis];
$tabel = $config['tabel'];
$kolom = $config['kolom'];

$primary = ($jenis == 'pengguna') ? 'id_user' : 'id';

// Simpan data
if (isset($_POST['simpan'])) {

    $id = (int)($_POST['id'] ?? 0);
    $values = [];

    foreach ($kolom as $field => $label) {
        $values[$field] = mysqli_real_escape_string(
            $koneksi,
            trim($_POST[$field] ?? '')
        );
    }

    if ($jenis == 'pengguna') {

        $password = $_POST['password'] ?? '';

        if ($id == 0 && $password == '') {
            die("Password wajib diisi.");
        }

        if ($password != '') {
            $values['password'] = password_hash(
                $password,
                PASSWORD_DEFAULT
            );
        }
    }

    if ($id > 0) {

        if ($jenis == 'pengguna' && empty($values['password'])) {
            unset($values['password']);
        }

        $set = [];

        foreach ($values as $field => $value) {
            $set[] = "`$field`='$value'";
        }

        $sql = "UPDATE `$tabel` SET " .
               implode(", ", $set) .
               " WHERE `$primary`=$id";

    } else {

        $fields = implode(
            ", ",
            array_map(fn($f) => "`$f`", array_keys($values))
        );

        $data = [];

        foreach ($values as $value) {
            $data[] = "'" . $value . "'";
        }

        $sql = "INSERT INTO `$tabel` ($fields)
                VALUES (" . implode(", ", $data) . ")";
    }

    if (!mysqli_query($koneksi, $sql)) {
        die("Gagal menyimpan data: " . mysqli_error($koneksi));
    }

    header("Location: master.php?jenis=$jenis");
    exit;
}

// Hapus data
if (isset($_GET['hapus'])) {

    $id = (int)$_GET['hapus'];

    if ($jenis == 'pengguna' && $id == $_SESSION['id_user']) {
        die("Tidak dapat menghapus akun sendiri.");
    }

    mysqli_query(
        $koneksi,
        "DELETE FROM `$tabel` WHERE `$primary`=$id"
    );

    header("Location: master.php?jenis=$jenis");
    exit;
}

// Ambil data edit
$edit = null;

if (isset($_GET['edit'])) {

    $id = (int)$_GET['edit'];

    $hasil = mysqli_query(
        $koneksi,
        "SELECT * FROM `$tabel` WHERE `$primary`=$id"
    );

    $edit = mysqli_fetch_assoc($hasil);
}

// Tampilkan data
$result = mysqli_query(
    $koneksi,
    "SELECT * FROM `$tabel` ORDER BY `$primary` DESC"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $config['judul'] ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <div class="card">

        <h2><?= $config['judul'] ?></h2>

        <h3><?= $edit ? 'Edit Data' : 'Tambah Data' ?></h3>

        <form method="POST">

            <input type="hidden" name="id"
                value="<?= $edit[$primary] ?? 0 ?>">

            <?php foreach ($kolom as $field => $label) { ?>

                <label><?= $label ?></label>

                <?php if ($field == 'level') { ?>

                    <select name="level" required>
                        <option value="1"
                            <?= (($edit['level'] ?? '') == 1) ? 'selected' : '' ?>>
                            Owner
                        </option>

                        <option value="2"
                            <?= (($edit['level'] ?? '') == 2) ? 'selected' : '' ?>>
                            Kasir
                        </option>
                    </select>

                <?php } else { ?>

                    <input
                        type="text"
                        name="<?= $field ?>"
                        value="<?= htmlspecialchars($edit[$field] ?? '') ?>"
                        required
                    >

                <?php } ?>

            <?php } ?>

            <?php if ($jenis == 'pengguna') { ?>

                <label>Password</label>

                <input type="password" name="password"
                    <?= $edit ? '' : 'required' ?>>

            <?php } ?>

            <button type="submit" name="simpan">
                Simpan
            </button>

            <a href="<?= $jenis ?>.php" class="btn-kembali">
                Kembali
            </a>

        </form>

    </div>

    <div class="card">

        <h3>Daftar Data</h3>

        <table>

            <tr>
                <th>No</th>

                <?php foreach ($kolom as $label) { ?>
                    <th><?= $label ?></th>
                <?php } ?>

                <th>Aksi</th>
            </tr>

            <?php $no = 1; ?>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                <tr>

                    <td><?= $no++ ?></td>

                    <?php foreach ($kolom as $field => $label) { ?>

                        <td>
                            <?= htmlspecialchars((string)$row[$field]) ?>
                        </td>

                    <?php } ?>

                    <td>
                        <a href="master.php?jenis=<?= $jenis ?>&edit=<?= $row[$primary] ?>">
                            Edit
                        </a>

                        |

                        <a
                            href="master.php?jenis=<?= $jenis ?>&hapus=<?= $row[$primary] ?>"
                            onclick="return confirm('Yakin ingin menghapus data?')"
                        >
                            Hapus
                        </a>
                    </td>

                </tr>

            <?php } ?>

        </table>

    </div>

    <a href="index.php" class="btn-kembali">Kembali ke Home</a>

</div>

</body>
</html>