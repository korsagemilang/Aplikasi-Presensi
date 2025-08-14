<?php
// file: logout.php
session_start(); // Mulai session
session_destroy(); // Hancurkan semua data sesi
header('Location: login.php'); // Arahkan kembali ke halaman login
exit;
?>