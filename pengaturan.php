<?php
// file: pengaturan.php
$page_title = 'Pengaturan Aplikasi';
require_once 'includes/header.php';

// Hanya admin yang boleh akses
if ($_SESSION['peran'] !== 'admin') {
    die("Akses ditolak. Halaman ini hanya untuk admin.");
}

$message = '';

// --- LOGIKA PENGATURAN UMUM ---
if (isset($_POST['simpan_pengaturan'])) {
    $nama_sekolah = $_POST['nama_sekolah'];
    $kepala_sekolah_id = $_POST['kepala_sekolah_id'];

    try {
        // Gunakan INSERT ... ON DUPLICATE KEY UPDATE untuk menyederhanakan
        $stmt = $pdo->prepare("
            INSERT INTO pengaturan (pengaturan_id, pengaturan_value) VALUES (?, ?), (?, ?)
            ON DUPLICATE KEY UPDATE pengaturan_value = VALUES(pengaturan_value)
        ");
        $stmt->execute(['nama_sekolah', $nama_sekolah, 'kepala_sekolah_id', $kepala_sekolah_id]);
        $message .= '<div class="alert alert-success">Pengaturan umum berhasil disimpan.</div>';
    } catch (PDOException $e) {
        $message .= '<div class="alert alert-error">Gagal menyimpan pengaturan: ' . $e->getMessage() . '</div>';
    }
}

// --- LOGIKA HARI LIBUR (MODIFIKASI) ---
if (isset($_POST['tambah_libur'])) {
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_akhir = $_POST['tanggal_akhir'];
    $keterangan_libur = $_POST['keterangan_libur'];

    try {
        $pdo->beginTransaction();

        $start = new DateTime($tanggal_mulai);
        $end = new DateTime($tanggal_akhir);
        $end->modify('+1 day'); // Tambahkan 1 hari agar tanggal akhir ikut terhitung
        $interval = new DateInterval('P1D');
        $period = new DatePeriod($start, $interval, $end);

        $stmt = $pdo->prepare("INSERT INTO hari_libur (tanggal, keterangan) VALUES (?, ?)");

        foreach ($period as $date) {
            $tanggal = $date->format('Y-m-d');
            $stmt->execute([$tanggal, $keterangan_libur]);
        }

        $pdo->commit();
        $message .= '<div class="alert alert-success">Hari libur berhasil ditambahkan untuk periode yang dipilih.</div>';
    } catch (PDOException $e) {
        $pdo->rollBack();
        $message .= '<div class="alert alert-error">Gagal menambah hari libur: ' . $e->getMessage() . '</div>';
    }
}

// Hapus hari libur
if (isset($_GET['hapus_libur'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM hari_libur WHERE id = ?");
        $stmt->execute([$_GET['hapus_libur']]);
        $message .= '<div class="alert alert-success">Hari libur berhasil dihapus.</div>';
    } catch (PDOException $e) {
        $message .= '<div class="alert alert-error">Gagal menghapus hari libur: ' . $e->getMessage() . '</div>';
    }
}

// --- AMBIL DATA UNTUK TAMPILAN ---
$pengaturan_raw = $pdo->query("SELECT * FROM pengaturan")->fetchAll(PDO::FETCH_KEY_PAIR);
$pengaturan['nama_sekolah'] = $pengaturan_raw['nama_sekolah'] ?? 'SDN Sukokerto 01';
$pengaturan['kepala_sekolah_id'] = $pengaturan_raw['kepala_sekolah_id'] ?? '';

$wali_list = $pdo->query("SELECT id, nama_wali FROM wali_kelas ORDER BY nama_wali")->fetchAll();
$libur_list = $pdo->query("SELECT * FROM hari_libur ORDER BY tanggal DESC")->fetchAll();
?>

<?= $message ?>

<div class="card">
    <h2>Pengaturan Umum</h2>
    <form method="POST">
        <div>
            <label for="nama_sekolah">Nama Sekolah</label>
            <input type="text" name="nama_sekolah" id="nama_sekolah" value="<?= htmlspecialchars($pengaturan['nama_sekolah']) ?>" required>
        </div>
        <div>
            <label for="kepala_sekolah_id">Kepala Sekolah</label>
            <select name="kepala_sekolah_id" id="kepala_sekolah_id" required>
                <option value="">-- Pilih Kepala Sekolah --</option>
                <?php foreach ($wali_list as $wali): ?>
                    <option value="<?= $wali['id'] ?>" <?= ($pengaturan['kepala_sekolah_id'] == $wali['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($wali['nama_wali']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" name="simpan_pengaturan" class="btn btn-primary">Simpan Pengaturan</button>
    </form>
</div>

<div class="card">
    <h2>Manajemen Hari Libur Nasional</h2>
    <form method="POST" style="margin-bottom: 2rem;">
        <label for="tanggal_mulai">Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai" required>
        <label for="tanggal_akhir">Tanggal Akhir</label>
        <input type="date" name="tanggal_akhir" required>
        <label for="keterangan_libur">Keterangan</label>
        <input type="text" name="keterangan_libur" required>
        <button type="submit" name="tambah_libur" class="btn btn-primary">Tambah Hari Libur</button>
    </form>

    <table class="data-table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($libur_list as $libur): ?>
            <tr>
                <td><?= date('d F Y', strtotime($libur['tanggal'])) ?></td>
                <td><?= htmlspecialchars($libur['keterangan']) ?></td>
                <td><a href="?hapus_libur=<?= $libur['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus tanggal libur ini?')">Hapus</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once 'includes/footer.php'; ?>