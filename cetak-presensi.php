<?php
date_default_timezone_set('Asia/Jakarta');

// file: cetak-presensi.php
require_once 'includes/koneksi.php'; // Hanya butuh koneksi

// --- FUNGSI BANTU (HELPER) ---
function toRoman($number) {
  $map = [
    '10' => 'X', '9' => 'IX', '8' => 'VIII', '7' => 'VII', '6' => 'VI',
    '5' => 'V', '4' => 'IV', '3' => 'III', '2' => 'II', '1' => 'I'
  ];
  $result = '';
  foreach ($map as $int => $roman) {
    while ($number >= (int)$int) {
      $result .= $roman;
      $number -= (int)$int;
    }
  }
  return $result;
}

function bulanIndoKeAngka($bulan) {
  $daftar = [
    'Januari' => 1, 'Februari' => 2, 'Maret' => 3, 'April' => 4, 'Mei' => 5,
    'Juni' => 6, 'Juli' => 7, 'Agustus' => 8, 'September' => 9, 'Oktober' => 10,
    'November' => 11, 'Desember' => 12
  ];
  return $daftar[$bulan] ?? 1;
}

// --- AMBIL PARAMETER DARI URL ---
$kelasId = $_GET['kelas'] ?? '1';
$bulan = $_GET['bulan'] ?? 'Januari';
$tahun = $_GET['tahun'] ?? date('Y');
$tahunAjaran = $_GET['tahunAjaran'] ?? date('Y').'/'.(date('Y')+1);

// --- LOGIKA SEMESTER GENAP/GANJIL ---
$bulanNum = bulanIndoKeAngka($bulan);
if ($bulanNum >= 1 && $bulanNum <= 6) {
    $semester = 'GENAP';
} else {
    $semester = 'GANJIL';
}

// --- FETCH DATA DARI DATABASE ---
// 1. Dapatkan info kelas & wali kelas
$stmt = $pdo->prepare("
    SELECT k.nama_kelas, w.nama_wali, w.nip
    FROM kelas k
    LEFT JOIN wali_kelas w ON k.wali_kelas_id = w.id
    WHERE k.id = ?
");
$stmt->execute([$kelasId]);
$kelasInfo = $stmt->fetch();
$kelasRomawi = $kelasInfo['nama_kelas'] ?? 'Tidak Ditemukan';

// 2. Dapatkan info Kepala Sekolah dari tabel pengaturan
$stmt = $pdo->query("SELECT pengaturan_value FROM pengaturan WHERE pengaturan_id = 'kepala_sekolah_id'");
$kepsekId = $stmt->fetchColumn();
$stmt = $pdo->prepare("SELECT nama_wali, nip FROM wali_kelas WHERE id = ?");
$stmt->execute([$kepsekId]);
$kepsekInfo = $stmt->fetch();
$ttdMap = [
    'Kepala Sekolah' => ['nama' => $kepsekInfo['nama_wali'] ?? '-', 'nip' => $kepsekInfo['nip'] ?? '-'],
    'Wali Kelas' => ['nama' => $kelasInfo['nama_wali'] ?? '-', 'nip' => $kelasInfo['nip'] ?? '-']
];

// 3. Dapatkan daftar siswa di kelas tersebut
$stmt = $pdo->prepare("SELECT id, no_induk, nama_siswa FROM siswa WHERE kelas_id = ? ORDER BY no_induk ASC");
$stmt->execute([$kelasId]);
$siswaData = $stmt->fetchAll();
$siswaMap = [];
foreach ($siswaData as $siswa) {
    $siswaMap[$siswa['id']] = [
        'nis' => $siswa['no_induk'],
        'nama' => $siswa['nama_siswa'],
        'presensi' => [],
        'jumlah' => ['S' => 0, 'I' => 0, 'A' => 0]
    ];
}

// 4. Dapatkan data presensi untuk siswa & bulan yang relevan
$bulanNum = bulanIndoKeAngka($bulan);
$startDate = "$tahun-$bulanNum-01";
$endDate = date("Y-m-t", strtotime($startDate));
$siswaIds = array_keys($siswaMap);
if (!empty($siswaIds)) {
    $placeholders = implode(',', array_fill(0, count($siswaIds), '?'));
    $stmt = $pdo->prepare("
        SELECT siswa_id, tanggal, status FROM presensi
        WHERE siswa_id IN ($placeholders) AND tanggal BETWEEN ? AND ?
    ");
    $params = array_merge($siswaIds, [$startDate, $endDate]);
    $stmt->execute($params);
    $presensiData = $stmt->fetchAll();
    foreach ($presensiData as $p) {
        $siswaMap[$p['siswa_id']]['presensi'][$p['tanggal']] = ($p['status'] == 'H') ? '.' : $p['status'];
        if (in_array($p['status'], ['S', 'I', 'A'])) {
            $siswaMap[$p['siswa_id']]['jumlah'][$p['status']]++;
        }
    }
}

// 5. Dapatkan hari libur
$stmt = $pdo->prepare("SELECT tanggal FROM hari_libur WHERE tanggal BETWEEN ? AND ?");
$stmt->execute([$startDate, $endDate]);
$liburNasional = $stmt->fetchAll(PDO::FETCH_COLUMN);

// --- LOGIKA PROSES ---
// Isi otomatis hari kosong (libur, alpa, atau belum terjadi)
$hariIni = date('Y-m-d');
foreach ($siswaMap as $id => &$siswa) {
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $bulanNum, (int)$tahun);
    for ($i = 1; $i <= $daysInMonth; $i++) {
        $tanggalStr = sprintf("%04d-%02d-%02d", $tahun, $bulanNum, $i);
        if (isset($siswa['presensi'][$tanggalStr])) continue;
        $hariKe = date('w', strtotime($tanggalStr));
        $isLibur = in_array($tanggalStr, $liburNasional);
        if ($hariKe == 0 || $isLibur) {
            $siswa['presensi'][$tanggalStr] = ''; 
        } elseif ($tanggalStr < $hariIni) {
            $siswa['presensi'][$tanggalStr] = 'A'; 
            $siswa['jumlah']['A']++;
        } else {
            $siswa['presensi'][$tanggalStr] = ''; 
        }
    }
}
unset($siswa);

$stmt = $pdo->query("SELECT pengaturan_value FROM pengaturan WHERE pengaturan_id = 'nama_sekolah'");
$nama_sekolah = $stmt->fetchColumn() ?: 'Sistem Presensi';

// --- TAMPILKAN TEMPLATE ---
include 'template/template-presensi.php';
?>
<script>
  window.print();
</script>