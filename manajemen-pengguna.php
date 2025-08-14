<?php
// file: manajemen-pengguna.php
$page_title = 'Manajemen Pengguna';
require_once 'includes/header.php';

// Pastikan hanya admin yang bisa mengakses halaman ini
if ($_SESSION['peran'] !== 'admin') {
    die("Akses ditolak. Halaman ini hanya untuk administrator.");
}

$message = '';
$edit_user = null;

// --- LOGIKA CRUD PENGGUNA ---

// HAPUS PENGGUNA
if (isset($_GET['action']) && $_GET['action'] == 'hapus' && isset($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM pengguna WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $message = '<div class="alert alert-success">Pengguna berhasil dihapus.</div>';
    } catch (PDOException $e) {
        $message = '<div class="alert alert-error">Gagal menghapus pengguna: ' . $e->getMessage() . '</div>';
    }
}

// TAMBAH ATAU EDIT PENGGUNA
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $peran = $_POST['peran'];
    $id = $_POST['id'] ?? null;
    $password = $_POST['password'] ?? '';

    try {
        if ($id) { // Proses Edit
            // Query UPDATE tanpa password
            $sql = "UPDATE pengguna SET username = ?, nama_lengkap = ?, peran = ? WHERE id = ?";
            $params = [$username, $nama_lengkap, $peran, $id];

            // Jika password baru diisi, tambahkan password ke query
            if (!empty($password)) {
                $password_hashed = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE pengguna SET username = ?, nama_lengkap = ?, peran = ?, password = ? WHERE id = ?";
                $params = [$username, $nama_lengkap, $peran, $password_hashed, $id];
            }

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $message = '<div class="alert alert-success">Data pengguna berhasil diperbarui.</div>';
        } else { // Proses Tambah
            if (empty($password)) {
                 $message = '<div class="alert alert-error">Password tidak boleh kosong untuk pengguna baru.</div>';
            } else {
                $password_hashed = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO pengguna (username, password, nama_lengkap, peran) VALUES (?, ?, ?, ?)");
                $stmt->execute([$username, $password_hashed, $nama_lengkap, $peran]);
                $message = '<div class="alert alert-success">Pengguna baru berhasil ditambahkan.</div>';
            }
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $message = '<div class="alert alert-error">Gagal: Username sudah terdaftar.</div>';
        } else {
            $message = '<div class="alert alert-error">Terjadi kesalahan: ' . $e->getMessage() . '</div>';
        }
    }
}

// Ambil data pengguna untuk diedit jika ada
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT id, username, nama_lengkap, peran FROM pengguna WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $edit_user = $stmt->fetch();
}

// --- AMBIL SEMUA DATA PENGGUNA UNTUK DITAMPILKAN ---
$pengguna_list = $pdo->query("SELECT id, username, nama_lengkap, peran FROM pengguna ORDER BY peran, username")->fetchAll();
?>

<?= $message ?>

<div class="card">
    <h2><?= $edit_user ? 'Edit Pengguna' : 'Tambah Pengguna Baru' ?></h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $edit_user['id'] ?? '' ?>">
        <div>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($edit_user['username'] ?? '') ?>" required>
        </div>
        <div>
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?= htmlspecialchars($edit_user['nama_lengkap'] ?? '') ?>" required>
        </div>
        <div>
            <label for="password">Password <?= $edit_user ? '<small>(Kosongkan jika tidak ingin diubah)</small>' : '' ?></label>
            <input type="password" id="password" name="password" <?= $edit_user ? '' : 'required' ?>>
        </div>
        <div>
            <label for="peran">Peran</label>
            <select id="peran" name="peran" required>
                <option value="guru" <?= (isset($edit_user['peran']) && $edit_user['peran'] == 'guru') ? 'selected' : '' ?>>Guru</option>
                <option value="admin" <?= (isset($edit_user['peran']) && $edit_user['peran'] == 'admin') ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $edit_user ? 'Update Pengguna' : 'Simpan Pengguna' ?></button>
            <?php if ($edit_user): ?>
                <a href="manajemen-pengguna.php" class="btn btn-secondary">Batal Edit</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="card">
    <h2>Daftar Semua Pengguna</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>Username</th>
                <th>Nama Lengkap</th>
                <th>Peran</th>
                <th class="actions">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($pengguna_list)): ?>
                <tr>
                    <td colspan="4">Belum ada data pengguna.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($pengguna_list as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['nama_lengkap']) ?></td>
                        <td><?= htmlspecialchars($user['peran']) ?></td>
                        <td class="actions">
                            <a href="?action=edit&id=<?= $user['id'] ?>" class="btn btn-secondary">Edit</a>
                            <a href="?action=hapus&id=<?= $user['id'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'includes/footer.php'; ?>