<?php
// file: laporan-presensi.php
$page_title = 'Laporan Presensi';
require_once 'includes/header.php';

// Ambil daftar kelas dari DB
$kelas_list = $pdo->query("SELECT id, nama_kelas FROM kelas ORDER BY nama_kelas ASC")->fetchAll();

// Data Tanggal
$current_month = date('m');
$current_month_num = date('m');
$current_year = date('Y');

// Hitung tahun ajaran saat ini
if ($current_month_num >= 7) { // Juli - Desember
    $current_tahun_ajaran = $current_year . '/' . ($current_year + 1);
} else { // Januari - Juni
    $current_tahun_ajaran = ($current_year - 1) . '/' . $current_year;
}

// Daftar nama bulan dalam Bahasa Indonesia
$bulan_list = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
];
?>

<h2>Laporan Presensi Bulanan</h2>
<div class="card">
    <form action="cetak-presensi.php" method="GET" target="_blank">
        <div>
            <label for="kelas">Pilih Kelas</label>
            <select id="kelas" name="kelas" required>
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelas_list as $kelas): ?>
                    <option value="<?= $kelas['id'] ?>"><?= htmlspecialchars($kelas['nama_kelas']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="bulan">Pilih Bulan</label>
            <select id="bulan" name="bulan" required>
                <?php foreach ($bulan_list as $nomor => $nama_bulan): ?>
                    <option value="<?= $nama_bulan ?>" <?= ($nomor == $current_month_num) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($nama_bulan) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="tahun">Pilih Tahun</label>
            <select id="tahun" name="tahun" required>
                <?php for ($i = $current_year; $i >= $current_year - 5; $i--): ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <input type="hidden" name="tahunAjaran" id="tahunAjaran" value="<?= htmlspecialchars($current_tahun_ajaran) ?>">
        <button type="submit" class="btn btn-primary">Cetak Laporan</button>
    </form>
</div>
<script>
    // Fungsi untuk mengubah nama bulan ke angka (tetap sama)
    const getMonthNumber = (monthName) => {
        const months = {
            'Januari': 1, 'Februari': 2, 'Maret': 3, 'April': 4, 'Mei': 5, 'Juni': 6,
            'Juli': 7, 'Agustus': 8, 'September': 9, 'Oktober': 10, 'November': 11, 'Desember': 12
        };
        return months[monthName] || 1;
    };

    // Fungsi untuk mengupdate nilai tahun ajaran
    const updateTahunAjaran = () => {
        // Mendapatkan elemen-elemen HTML
        const bulanSelect = document.getElementById('bulan');
        const tahunSelect = document.getElementById('tahun');
        const tahunAjaranInput = document.getElementById('tahunAjaran');

        // Pastikan semua elemen ditemukan
        if (!bulanSelect || !tahunSelect || !tahunAjaranInput) {
            console.error('Satu atau lebih elemen formulir tidak ditemukan.');
            return;
        }

        // Mengambil teks (nama bulan) dari pilihan yang dipilih
        const bulanName = bulanSelect.options[bulanSelect.selectedIndex].text;
        
        // Mengambil nilai tahun dari pilihan yang dipilih
        const tahun = parseInt(tahunSelect.value);

        // Jika salah satu nilai tidak valid, hentikan fungsi
        if (!bulanName || isNaN(tahun)) {
            return;
        }

        // Mengubah nama bulan menjadi angka
        const bulanNum = getMonthNumber(bulanName);

        // Menghitung tahun ajaran
        let tahunAjaranBaru;
        if (bulanNum >= 7) { // Juli (7) hingga Desember (12)
            tahunAjaranBaru = `${tahun}/${tahun + 1}`;
        } else { // Januari (1) hingga Juni (6)
            tahunAjaranBaru = `${tahun - 1}/${tahun}`;
        }
        
        // Memperbarui nilai input hidden
        tahunAjaranInput.value = tahunAjaranBaru;
    };

    // Panggil fungsi saat halaman dimuat dan setiap kali pilihan di dropdown berubah
    document.addEventListener('DOMContentLoaded', () => {
        updateTahunAjaran(); // Panggil fungsi saat halaman pertama kali dimuat
        const bulanSelect = document.getElementById('bulan');
        const tahunSelect = document.getElementById('tahun');
        if (bulanSelect) bulanSelect.addEventListener('change', updateTahunAjaran);
        if (tahunSelect) tahunSelect.addEventListener('change', updateTahunAjaran);
    });
</script>
<?php require_once 'includes/footer.php'; ?>