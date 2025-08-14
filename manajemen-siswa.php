<?php
// file: manajemen-siswa.php
$page_title = 'Manajemen Siswa';
require_once 'includes/header.php';

$message = '';
$message_import = '';

// --- LOGIKA IMPOR CSV ---
if (isset($_POST['import_csv'])) {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['csv_file']['tmp_name'];
        $handle = fopen($file_tmp, "r");

        if ($handle === FALSE) {
            $message_import = '<div class="alert alert-error">Gagal membaca file.</div>';
        } else {
            // Gunakan transaksi untuk memastikan semua data masuk atau tidak sama sekali
            $pdo->beginTransaction();
            $success_count = 0;
            $fail_rows = [];
            $line_num = 0;

            // Dapatkan ID kelas dari DB untuk lookup cepat
            $kelas_map = $pdo->query("SELECT id, nama_kelas FROM kelas")->fetchAll(PDO::FETCH_KEY_PAIR);
            $kelas_map = array_flip($kelas_map);

            // Lewati baris header
            fgetcsv($handle, 1000, ",");

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $line_num++;
                if (count($data) < 3) {
                    $fail_rows[] = "Baris $line_num: Data tidak lengkap.";
                    continue;
                }

                $no_induk = trim($data[0]);
                $nama_siswa = trim($data[1]);
                $nama_kelas = trim($data[2]);

                if (!isset($kelas_map[$nama_kelas])) {
                    $fail_rows[] = "Baris $line_num ($nama_siswa): Nama kelas '$nama_kelas' tidak ditemukan.";
                    continue;
                }
                $kelas_id = $kelas_map[$nama_kelas];

                try {
                    $stmt = $pdo->prepare("
                        INSERT INTO siswa (no_induk, nama_siswa, kelas_id) VALUES (?, ?, ?)
                        ON DUPLICATE KEY UPDATE nama_siswa = VALUES(nama_siswa), kelas_id = VALUES(kelas_id)
                    ");
                    $stmt->execute([$no_induk, $nama_siswa, $kelas_id]);
                    $success_count++;
                } catch (PDOException $e) {
                    $fail_rows[] = "Baris $line_num ($nama_siswa): Gagal menyimpan. Error: " . $e->getMessage();
                }
            }
            fclose($handle);
            
            // Commit atau Rollback transaksi
            if (empty($fail_rows)) {
                $pdo->commit();
                $message_import = '<div class="alert alert-success">Berhasil mengimpor ' . $success_count . ' siswa.</div>';
            } else {
                $pdo->rollBack();
                $message_import = '<div class="alert alert-error">Gagal mengimpor data. ' . $success_count . ' siswa berhasil diproses sebelum error.<ul><li>' . implode('</li><li>', $fail_rows) . '</li></ul></div>';
            }
        }
    } else {
        $message_import = '<div class="alert alert-error">Gagal mengunggah file. Pastikan Anda memilih file yang benar.</div>';
    }
}

// --- LOGIKA CRUD SISWA ---

// HAPUS SISWA
if (isset($_GET['action']) && $_GET['action'] == 'hapus' && isset($_GET['id'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM siswa WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $message = '<div class="alert alert-success">Siswa berhasil dihapus.</div>';
    } catch (PDOException $e) {
        $message = '<div class="alert alert-error">Gagal menghapus siswa: ' . $e->getMessage() . '</div>';
    }
}

// TAMBAH ATAU EDIT SISWA
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['import_csv'])) {
    $no_induk = $_POST['no_induk'];
    $nama_siswa = $_POST['nama_siswa'];
    $kelas_id = $_POST['kelas_id'];
    $id = $_POST['id'] ?? null;

    try {
        if ($id) { // Proses Edit
            $stmt = $pdo->prepare("UPDATE siswa SET no_induk = ?, nama_siswa = ?, kelas_id = ? WHERE id = ?");
            $stmt->execute([$no_induk, $nama_siswa, $kelas_id, $id]);
            $message = '<div class="alert alert-success">Data siswa berhasil diperbarui.</div>';
        } else { // Proses Tambah
            $stmt = $pdo->prepare("INSERT INTO siswa (no_induk, nama_siswa, kelas_id) VALUES (?, ?, ?)");
            $stmt->execute([$no_induk, $nama_siswa, $kelas_id]);
            $message = '<div class="alert alert-success">Siswa baru berhasil ditambahkan.</div>';
        }
    } catch (PDOException $e) {
        // Cek jika error karena duplikat no_induk
        if ($e->getCode() == 23000) {
            $message = '<div class="alert alert-error">Gagal: No Induk sudah terdaftar.</div>';
        } else {
            $message = '<div class="alert alert-error">Terjadi kesalahan: ' . $e->getMessage() . '</div>';
        }
    }
}

// Ambil data siswa untuk diedit jika ada
$edit_siswa = null;
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM siswa WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $edit_siswa = $stmt->fetch();
}

// --- AMBIL DATA UNTUK TAMPILAN ---
$siswa_list = $pdo->query("
    SELECT s.id, s.no_induk, s.nama_siswa, k.nama_kelas
    FROM siswa s
    JOIN kelas k ON s.kelas_id = k.id
    ORDER BY k.nama_kelas, s.nama_siswa
")->fetchAll();

$kelas_list = $pdo->query("SELECT id, nama_kelas FROM kelas ORDER BY nama_kelas")->fetchAll();

?>

<?= $message_import ?>
<?= $message ?>

<div class="card">
    <h2>Impor Siswa dari CSV</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="csv_file">Pilih file CSV</label>
        <input type="file" name="csv_file" id="csv_file" accept=".csv" required>
        <button type="submit" name="import_csv" class="btn btn-primary">Impor Siswa</button>
    </form>
    <small style="display:block; margin-top:1rem;">*Gunakan format file CSV: **no_induk,nama_siswa,nama_kelas**</small>
</div>

<div class="card">
    <h2><?= $edit_siswa ? 'Edit Data Siswa' : 'Tambah Siswa Baru' ?></h2>
    <form method="POST" action="manajemen-siswa.php">
        <input type="hidden" name="id" value="<?= $edit_siswa['id'] ?? '' ?>">
        <div>
            <label for="no_induk">No Induk</label>
            <input type="text" id="no_induk" name="no_induk" value="<?= htmlspecialchars($edit_siswa['no_induk'] ?? '') ?>" required>
        </div>
        <div>
            <label for="nama_siswa">Nama Lengkap Siswa</label>
            <input type="text" id="nama_siswa" name="nama_siswa" value="<?= htmlspecialchars($edit_siswa['nama_siswa'] ?? '') ?>" required>
        </div>
        <div>
            <label for="kelas_id">Kelas</label>
            <select id="kelas_id" name="kelas_id" required>
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelas_list as $kelas): ?>
                    <option value="<?= $kelas['id'] ?>" <?= (isset($edit_siswa['kelas_id']) && $edit_siswa['kelas_id'] == $kelas['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($kelas['nama_kelas']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><?= $edit_siswa ? 'Update Siswa' : 'Simpan Siswa' ?></button>
            <?php if ($edit_siswa): ?>
                <a href="manajemen-siswa.php" class="btn btn-secondary">Batal Edit</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<div class="card">
    <h2>Daftar Semua Siswa</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>No Induk</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th class="actions">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($siswa_list)): ?>
                <tr>
                    <td colspan="5">Belum ada data siswa.</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach ($siswa_list as $siswa): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($siswa['no_induk']) ?></td>
                        <td><?= htmlspecialchars($siswa['nama_siswa']) ?></td>
                        <td><?= htmlspecialchars($siswa['nama_kelas']) ?></td>
                        <td class="actions">
                            <a href="manajemen-siswa.php?action=edit&id=<?= $siswa['id'] ?>" class="btn btn-secondary">Edit</a>
                            <a href="manajemen-siswa.php?action=hapus&id=<?= $siswa['id'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'includes/footer.php'; ?>