<?php

// file: koneksi.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database";
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Untuk production, jangan tampilkan error detail
    die("Koneksi ke database gagal: " . $e->getMessage());
}
// Mulai session di sini agar tersedia di semua halaman
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
