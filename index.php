<?php
// file: index.php
session_start();

// Periksa apakah pengguna sudah login
if (isset($_SESSION['user_id'])) {
    // Jika sudah login, arahkan ke dashboard
    header('Location: dashboard.php');
    exit;
} else {
    // Jika belum login, arahkan ke halaman login
    header('Location: login.php');
    exit;
}
?>