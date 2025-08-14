<?php
// file: manajemen-wali.php
$page_title = 'Manajemen Guru & Kelas';
require_once 'includes/header.php';

$message = '';

// --- LOGIKA CRUD WALI KELAS ---
// TAMBAH ATAU EDIT GURU
if (isset($_POST['simpan_wali'])) {
$nip = $_POST['nip'];
$nama_wali = $_POST['nama_wali'];
$id = $_POST['id'] ?? null;

// Ubah string kosong menjadi NULL agar tidak melanggar batasan UNIQUE
$nip = empty($nip) ? null : $nip;

    try {
        if ($id) { // Proses Edit
            $stmt = $pdo->prepare("UPDATE wali_kelas SET nip = ?, nama_wali = ? WHERE id = ?");
            $stmt->execute([$nip, $nama_wali, $id]);
            $message .= '<div class="alert alert-success">Data guru berhasil diperbarui.</div>';
        } else { // Proses Tambah
            $stmt = $pdo->prepare("INSERT INTO wali_kelas (nip, nama_wali) VALUES (?, ?)");
            $stmt->execute([$nip, $nama_wali]);
            $message .= '<div class="alert alert-success">Guru baru berhasil ditambahkan.</div>';
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $message .= '<div class="alert alert-error">Gagal: NIP sudah terdaftar.</div>';
        } else {
            $message .= '<div class="alert alert-error">Terjadi kesalahan: ' . $e->getMessage() . '</div>';
        }
    }
}
// HAPUS GURU
if (isset($_GET['action_wali']) && $_GET['action_wali'] == 'hapus' && isset($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM wali_kelas WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $message .= '<div class="alert alert-success">Guru berhasil dihapus.</div>';
    } catch (PDOException $e) {
        $message .= '<div class="alert alert-error">Gagal menghapus guru: ' . $e->getMessage() . '</div>';
    }
}

// --- LOGIKA CRUD KELAS ---
// TAMBAH ATAU EDIT KELAS
if (isset($_POST['simpan_kelas'])) {
    $nama_kelas = $_POST['nama_kelas'];
    $wali_kelas_id = $_POST['wali_kelas_id'] ?: null; // Handle jika tidak ada wali kelas
    $id = $_POST['id'] ?? null;

    try {
        if ($id) { // Proses Edit
            $stmt = $pdo->prepare("UPDATE kelas SET nama_kelas = ?, wali_kelas_id = ? WHERE id = ?");
            $stmt->execute([$nama_kelas, $wali_kelas_id, $id]);
            $message .= '<div class="alert alert-success">Data kelas berhasil diperbarui.</div>';
        } else { // Proses Tambah
            $stmt = $pdo->prepare("INSERT INTO kelas (nama_kelas, wali_kelas_id) VALUES (?, ?)");
            $stmt->execute([$nama_kelas, $wali_kelas_id]);
            $message .= '<div class="alert alert-success">Kelas baru berhasil ditambahkan.</div>';
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $message .= '<div class="alert alert-error">Gagal: Nama kelas sudah terdaftar.</div>';
        } else {
            $message .= '<div class="alert alert-error">Terjadi kesalahan: ' . $e->getMessage() . '</div>';
        }
    }
}
// HAPUS KELAS
if (isset($_GET['action_kelas']) && $_GET['action_kelas'] == 'hapus' && isset($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM kelas WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $message .= '<div class="alert alert-success">Kelas berhasil dihapus.</div>';
    } catch (PDOException $e) {
        $message .= '<div class="alert alert-error">Gagal menghapus kelas: ' . $e->getMessage() . '</div>';
    }
}

// --- AMBIL DATA UNTUK TAMPILAN ---
$edit_wali = null;
if (isset($_GET['action_wali']) && $_GET['action_wali'] == 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM wali_kelas WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $edit_wali = $stmt->fetch();
}
$edit_kelas = null;
if (isset($_GET['action_kelas']) && $_GET['action_kelas'] == 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM kelas WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $edit_kelas = $stmt->fetch();
}

$wali_list = $pdo->query("SELECT * FROM wali_kelas ORDER BY nama_wali")->fetchAll();
$kelas_list = $pdo->query("
    SELECT k.id, k.nama_kelas, w.nama_wali
    FROM kelas k
    LEFT JOIN wali_kelas w ON k.wali_kelas_id = w.id
    ORDER BY k.nama_kelas
")->fetchAll();
?>

<?= $message ?>

<div class="card">
    <h2><?= $edit_wali ? 'Edit Data Guru' : 'Tambah Guru / Wali Kelas' ?></h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $edit_wali['id'] ?? '' ?>">
        <div>
            <label for="nip">NIP</label>
            <input type="text" id="nip" name="nip" value="<?= htmlspecialchars($edit_wali['nip'] ?? '') ?>" >
        </div>
        <div>
            <label for="nama_wali">Nama Guru</label>
            <input type="text" id="nama_wali" name="nama_wali" value="<?= htmlspecialchars($edit_wali['nama_wali'] ?? '') ?>" required>
        </div>
        <div class="form-actions">
            <button type="submit" name="simpan_wali" class="btn btn-primary"><?= $edit_wali ? 'Update Guru' : 'Simpan Guru' ?></button>
            <?php if ($edit_wali): ?>
                <a href="manajemen-wali.php" class="btn btn-secondary">Batal Edit</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="card">
    <h2>Daftar Guru / Wali Kelas</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>NIP</th>
                <th>Nama Guru</th>
                <th class="actions">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($wali_list)): ?>
                <tr><td colspan="3">Belum ada data guru.</td></tr>
            <?php else: ?>
                <?php foreach ($wali_list as $wali): ?>
                    <tr>
                        <td><?= htmlspecialchars($wali['nip']) ?></td>
                        <td><?= htmlspecialchars($wali['nama_wali']) ?></td>
                        <td class="actions">
                            <a href="?action_wali=edit&id=<?= $wali['id'] ?>" class="btn btn-secondary">Edit</a>
                            <a href="?action_wali=hapus&id=<?= $wali['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus guru ini? Semua kelas yang diasuh akan kosong.')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="card">
    <h2><?= $edit_kelas ? 'Edit Data Kelas' : 'Tambah Kelas Baru' ?></h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $edit_kelas['id'] ?? '' ?>">
        <div>
            <label for="nama_kelas">Nama Kelas</label>
            <input type="text" id="nama_kelas" name="nama_kelas" value="<?= htmlspecialchars($edit_kelas['nama_kelas'] ?? '') ?>" required>
        </div>
        <div>
            <label for="wali_kelas_id">Wali Kelas</label>
            <select id="wali_kelas_id" name="wali_kelas_id">
                <option value="">-- Tidak ada --</option>
                <?php foreach ($wali_list as $wali): ?>
                    <option value="<?= $wali['id'] ?>" <?= (isset($edit_kelas['wali_kelas_id']) && $edit_kelas['wali_kelas_id'] == $wali['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($wali['nama_wali']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit" name="simpan_kelas" class="btn btn-primary"><?= $edit_kelas ? 'Update Kelas' : 'Simpan Kelas' ?></button>
            <?php if ($edit_kelas): ?>
                <a href="manajemen-wali.php" class="btn btn-secondary">Batal Edit</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="card">
    <h2>Daftar Semua Kelas</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Nama Kelas</th>
                <th>Wali Kelas</th>
                <th class="actions">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($kelas_list)): ?>
                <tr><td colspan="3">Belum ada data kelas.</td></tr>
            <?php else: ?>
                <?php foreach ($kelas_list as $kelas): ?>
                    <tr>
                        <td><?= htmlspecialchars($kelas['nama_kelas']) ?></td>
                        <td><?= htmlspecialchars($kelas['nama_wali'] ?? '<i>Belum ditentukan</i>') ?></td>
                        <td class="actions">
                            <a href="?action_kelas=edit&id=<?= $kelas['id'] ?>" class="btn btn-secondary">Edit</a>
                            <a href="?action_kelas=hapus&id=<?= $kelas['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus kelas ini? Semua siswa di dalamnya juga akan terhapus.')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'includes/footer.php'; ?>