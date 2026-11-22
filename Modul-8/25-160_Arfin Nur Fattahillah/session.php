<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function cekLogin() {
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
        header("Location: login.php");
        exit;
    }
}

function cek_owner() {
    cekLogin();

    if ($_SESSION['level'] != 1) {
        header("Location: index.php");
        exit;
    }
}
?>