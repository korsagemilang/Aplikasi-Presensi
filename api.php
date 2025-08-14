<?php
// file: api.php
header('Content-Type: application/json');
require_once 'includes/koneksi.php';

// Pastikan ada parameter 'action'
if (!isset($_GET['action'])) {
    echo json_encode(['status' => 'error', 'message' => 'Aksi tidak ditentukan.']);
    exit;
}
$action = $_GET['action'];
switch ($action) {

    // Mengambil daftar siswa berdasarkan kelas
    case 'get_siswa':
        if (!isset($_GET['kelas_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'ID Kelas dibutuhkan.']);
            exit;
        }
        $kelas_id = $_GET['kelas_id'];
        $stmt = $pdo->prepare("SELECT id, nama_siswa FROM siswa WHERE kelas_id = ? ORDER BY no_induk ASC");
        $stmt->execute([$kelas_id]);
        $siswa = $stmt->fetchAll();
        echo json_encode($siswa);
        break;

    // Menyimpan data presensi
    case 'save_presensi':
        // Ambil data JSON dari body request
        $json_data = file_get_contents('php://input');
        $data_array = json_decode($json_data, true);
        if (empty($data_array)) {
            echo json_encode(['status' => 'error', 'message' => 'Tidak ada data presensi yang diterima.']);
            exit;
        }

        // Dapatkan tahun ajaran saat ini
        $bulan = date('n');
        $tahun = date('Y');
        $tahun_ajaran = ($bulan >= 7) ? "$tahun/" . ($tahun + 1) : ($tahun - 1) . "/$tahun";

        // Gunakan transaksi untuk memastikan semua data masuk atau tidak sama sekali
        $pdo->beginTransaction();
        try {
            // Siapkan statement di luar loop untuk efisiensi
            $stmt = $pdo->prepare("
                INSERT INTO presensi (siswa_id, tanggal, status, tahun_ajaran)
                VALUES (?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE status = VALUES(status), tahun_ajaran = VALUES(tahun_ajaran)
            ");
            foreach ($data_array as $item) {
                $stmt->execute([
                    $item['siswa_id'],
                    $item['tanggal'],
                    $item['status'],
                    $tahun_ajaran
                ]);
            }

            // Jika semua berhasil, commit transaksi
            $pdo->commit();
            echo json_encode(['status' => 'success', 'message' => 'Presensi berhasil disimpan!']);
        } catch (Exception $e) {

            // Jika ada error, batalkan semua perubahan
            $pdo->rollBack();
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan presensi: ' . $e->getMessage()]);
        }
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Aksi tidak valid.']);
        break;
}
?>