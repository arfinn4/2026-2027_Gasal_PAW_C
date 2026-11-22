<?php
require_once "koneksi.php";
require_once "session.php";

if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: index.php");
    exit;
}

$error = "";

if (isset($_POST['login'])) {

    $username = mysqli_real_escape_string(
        $koneksi,
        $_POST['username']
    );

    $password = $_POST['password'];

    $query = mysqli_query(
        $koneksi,
        "SELECT * FROM user WHERE username='$username'"
    );

    $data = mysqli_fetch_assoc($query);

    if ($data) {

        $passwordBenar = false;

        if (password_verify($password, $data['password'])) {
            $passwordBenar = true;
        } elseif ($data['password'] === md5($password)) {
            $passwordBenar = true;
        }

        if ($passwordBenar) {

            session_regenerate_id(true);

            $_SESSION['login'] = true;
            $_SESSION['id_user'] = $data['id_user'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['level'] = $data['level'];

            header("Location: index.php");
            exit;
        }
    }

    $error = "Username atau password salah!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Sistem Penjualan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">

<div class="login-box">

    <h2>Login Sistem Penjualan</h2>

    <p>Silakan masukkan username dan password.</p>

    <?php if ($error != "") { ?>
        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php } ?>

    <form method="POST">

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" name="login">
            Login
        </button>

    </form>

</div>

</body>
</html>