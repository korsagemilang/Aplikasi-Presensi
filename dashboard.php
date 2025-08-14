<?php

// file: dashboard.php
$page_title = 'Dashboard';
require_once 'includes/header.php';

// Ambil data ringkasan dari database
$total_siswa = $pdo->query("SELECT COUNT(*) FROM siswa")->fetchColumn();
$total_kelas = $pdo->query("SELECT COUNT(*) FROM kelas")->fetchColumn();
$total_guru = $pdo->query("SELECT COUNT(*) FROM wali_kelas")->fetchColumn();
$nama_sekolah = $pdo->query("SELECT pengaturan_value FROM pengaturan WHERE pengaturan_id = 'nama_sekolah'")->fetchColumn();
?>

<h2>Selamat Datang <?= htmlspecialchars($_SESSION['nama_lengkap']) ?>!</h2>
<p>Anda login sebagai <?= htmlspecialchars($_SESSION['peran']) ?> di <?= htmlspecialchars($nama_sekolah) ?>.</p>
<div class="summary-cards" style="display: flex; gap: 1rem; margin-top: 2rem;">
    <div class="card" style="flex: 1; text-align: center;">
        <h3>Total Peserta Didik</h3>
        <p style="font-size: 2rem; font-weight: bold;"><?= $total_siswa ?></p>
    </div>
    <div class="card" style="flex: 1; text-align: center;">
        <h3>Total Rombongan Belajar</h3>
        <p style="font-size: 2rem; font-weight: bold;"><?= $total_kelas ?></p>
    </div>
    <div class="card" style="flex: 1; text-align: center;">
        <h3>Total Guru</h3>
        <p style="font-size: 2rem; font-weight: bold;"><?= $total_guru ?></p>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>