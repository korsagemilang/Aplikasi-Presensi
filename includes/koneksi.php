<?php
// file: koneksi.php

$servername = "sql203.infinityfree.com";
$username = "if0_39696997";
$password = "Korsa20523318";
$dbname = "if0_39696997_presensi";

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