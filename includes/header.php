<?php
date_default_timezone_set('Asia/Jakarta');

// file: includes/header.php
require_once 'koneksi.php';

// Cek apakah pengguna sudah login, jika tidak, tendang ke halaman login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$stmt = $pdo->query("SELECT pengaturan_value FROM pengaturan WHERE pengaturan_id = 'nama_sekolah'");
$nama_sekolah = $stmt->fetchColumn() ?: 'Sistem Presensi';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title ?? 'Dashboard') ?> - <?= htmlspecialchars($nama_sekolah) ?></title>
    <link rel="icon" href="logo.png">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    
<!-- Header -->
    <header class="main-header">
        <h1><?= htmlspecialchars($nama_sekolah) ?></h1>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="input-presensi.php">Input Presensi</a>
            <a href="laporan-presensi.php">Laporan</a>
            <?php if ($_SESSION['peran'] === 'admin'): ?>
            <a href="manajemen-pengguna.php">Pengguna</a>
            <a href="manajemen-siswa.php">Siswa</a>
            <a href="manajemen-wali.php">Guru dan Kelas</a>
            <a href="pengaturan.php">Pengaturan</a>
            <?php endif; ?>
            <a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['nama_lengkap']) ?>)</a>
        </nav>
         <button class="mobile-menu-button" id="mobileMenuButton">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path id="menuIcon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                <path id="closeIcon" style="display: none;" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="mobile-menu" id="mobileMenu">
            <div class="user-info">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <span style="font-weight: 600;"><?= htmlspecialchars($_SESSION['nama_lengkap']) ?></span>
                </div>
            </div>
            <a href="dashboard.php">Dashboard</a>
            <a href="input-presensi.php">Input Presensi</a>
            <a href="laporan-presensi.php">Laporan</a>
            <?php if ($_SESSION['peran'] === 'admin'): ?>
            <a href="manajemen-pengguna.php">Pengguna</a>
            <a href="manajemen-siswa.php">Siswa</a>
            <a href="manajemen-wali.php">Guru dan Kelas</a>
            <a href="pengaturan.php">Pengaturan</a>
            <?php endif; ?>
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <main class="container">
