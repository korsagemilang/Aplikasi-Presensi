<?php
// file: input-presensi.php
$page_title = 'Input Presensi';
require_once 'includes/header.php';

// Asumsi koneksi database $pdo sudah ada
$kelas_list = $pdo->query("SELECT id, nama_kelas FROM kelas ORDER BY nama_kelas ASC")->fetchAll();
?>
<div class="container mt-5">
    <div class="card">
    <h2>
        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Input Presensi Kehadiran
    </h2>

    <div class="date-display">
        <div class="date-label">Tanggal Presensi</div>
        <div class="date-value" id="currentDate"></div>
    </div>

    <div>
        <h3>Pilih Kelas:</h3>
        <div class="selection-controls">
            <select id="kelasSelect">
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelas_list as $kelas): ?>
                    <option value="<?= $kelas['id'] ?>"><?= htmlspecialchars($kelas['nama_kelas']) ?></option>
                <?php endforeach; ?>
            </select>
            <button id="loadData" class="btn btn-primary">
                Tampilkan Siswa
            </button>
        </div>
    </div>
</div>

    <div id="loadingState" class="card loading" style="display: none;">
        <div class="loading-spinner"></div>
        <p>Memuat data siswa...</p>
    </div>

    <div id="presensiForm" class="card attendance-form" style="display: none;">
        <h2>Daftar Kehadiran Siswa</h2>
        
        <form id="attendanceForm">
            <input type="hidden" id="tanggal" value="<?= date('Y-m-d') ?>">
           <div class="table-container">
    <table class="attendance-table" id="presensiTable">
        <thead>
            <tr>
                <th class="column-no">No</th>
                <th class="column-nama">Nama Siswa</th>
                <th class="column-status">Hadir</th>
                <th class="column-status">Izin</th>
                <th class="column-status">Sakit</th>
                <th class="column-status">Alpa</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    Simpan Presensi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date();
        const dateString = today.toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        const currentDateElement = document.getElementById('currentDate');
        if (currentDateElement) {
            currentDateElement.textContent = dateString;
        }

        const tanggalInput = document.getElementById('tanggal');
        if (tanggalInput) {
            tanggalInput.value = today.toISOString().split('T')[0];
        }

        setupAttendanceForm();
    });

    function setupAttendanceForm() {
        const loadDataBtn = document.getElementById('loadData');
        const markAllPresentBtn = document.getElementById('markAllPresent');
        const attendanceForm = document.getElementById('attendanceForm');

        if (loadDataBtn) {
            loadDataBtn.addEventListener('click', function() {
                const kelasId = document.getElementById('kelasSelect').value;
                if (!kelasId) {
                    showAlert('Pilih kelas terlebih dahulu!', 'error');
                    return;
                }
                loadStudentData(kelasId);
            });
        }

        if (markAllPresentBtn) {
            markAllPresentBtn.addEventListener('click', function() {
                const hadirRadios = document.querySelectorAll('input[value="H"]');
                hadirRadios.forEach(radio => {
                    radio.checked = true;
                });
                updateSummary();
            });
        }

        if (attendanceForm) {
            attendanceForm.addEventListener('submit', function(e) {
                e.preventDefault();
                saveAttendance();
            });
        }
    }

    function loadStudentData(kelasId) {
        const loadingState = document.getElementById('loadingState');
        const presensiForm = document.getElementById('presensiForm');
        if (loadingState) loadingState.style.display = 'block';
        if (presensiForm) presensiForm.style.display = 'none';

        fetch(`api.php?action=get_siswa&kelas_id=${kelasId}`)
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json();
            })
            .then(students => {
                if (loadingState) loadingState.style.display = 'none';
                if (presensiForm) presensiForm.style.display = 'block';
                if (students.length === 0) {
                    showAlert('Tidak ada siswa ditemukan untuk kelas ini.', 'info');
                }
                populateStudentTable(students);
            })
            .catch(error => {
                console.error('Error fetching student data:', error);
                if (loadingState) loadingState.style.display = 'none';
                showAlert('Gagal mengambil data siswa. Silakan coba lagi.', 'error');
            });
    }

function populateStudentTable(students) {
    const tbody = document.querySelector('#presensiTable tbody');
    if (!tbody) return;
    tbody.innerHTML = '';

    students.forEach((siswa, index) => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="student-number">${index + 1}</td>
            <td class="student-name">${siswa.nama_siswa}</td>
            <td>
                <div class="radio-group">
                    <div class="radio-option hadir">
                        <input type="radio" name="presensi_${siswa.id}" value="." id="hadir_${siswa.id}">
                        <label for="hadir_${siswa.id}">H</label>
                    </div>
                </div>
            </td>
            <td>
                <div class="radio-group">
                    <div class="radio-option izin">
                        <input type="radio" name="presensi_${siswa.id}" value="I" id="izin_${siswa.id}">
                        <label for="izin_${siswa.id}">I</label>
                    </div>
                </div>
            </td>
            <td>
                <div class="radio-group">
                    <div class="radio-option sakit">
                        <input type="radio" name="presensi_${siswa.id}" value="S" id="sakit_${siswa.id}">
                        <label for="sakit_${siswa.id}">S</label>
                    </div>
                </div>
            </td>
            <td>
                <div class="radio-group">
                    <div class="radio-option alpa">
                        <input type="radio" name="presensi_${siswa.id}" value="A" id="alpa_${siswa.id}">
                        <label for="alpa_${siswa.id}">A</label>
                    </div>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });

    const radioInputs = document.querySelectorAll('#presensiTable input[type="radio"]');
    radioInputs.forEach(input => {
        input.addEventListener('change', updateSummary);
    });

    updateSummary();
}

    function updateSummary() {
        const counts = { H: 0, I: 0, S: 0, A: 0 };
        const checkedInputs = document.querySelectorAll('#presensiTable input[type="radio"]:checked');
        checkedInputs.forEach(input => {
            counts[input.value]++;
        });

        const hadirCountEl = document.getElementById('hadirCount');
        if (hadirCountEl) hadirCountEl.textContent = counts.H;

        const izinCountEl = document.getElementById('izinCount');
        if (izinCountEl) izinCountEl.textContent = counts.I;

        const sakitCountEl = document.getElementById('sakitCount');
        if (sakitCountEl) sakitCountEl.textContent = counts.S;
        
        const alpaCountEl = document.getElementById('alpaCount');
        if (alpaCountEl) alpaCountEl.textContent = counts.A;
    }

    function saveAttendance() {
        const presensiData = [];
        const tanggal = document.getElementById('tanggal').value;
        const kelasId = document.getElementById('kelasSelect').value;

        const checkedInputs = document.querySelectorAll('#presensiTable input[type="radio"]:checked');
        checkedInputs.forEach(input => {
            presensiData.push({
                siswa_id: input.name.split('_')[1],
                status: input.value,
                tanggal: tanggal,
                kelas_id: kelasId
            });
        });

        if (presensiData.length === 0) {
            showAlert('Tidak ada data presensi untuk disimpan.', 'error');
            return;
        }

        const submitBtn = document.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<div class="loading-spinner" style="width: 20px; height: 20px; margin-right: 0.5rem;"></div>Menyimpan...';
        submitBtn.disabled = true;

        fetch('api.php?action=save_presensi', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(presensiData)
        })
        .then(res => res.json())
        .then(response => {
            showAlert(response.message, response.status);
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            if (response.status === 'success') {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error saving attendance data:', error);
            showAlert('Gagal menyimpan presensi. Silakan coba lagi.', 'error');
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    }

    function showAlert(message, type = 'info') {
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());

        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        
        const icon = type === 'success' ? '✅' : type === 'error' ? '❌' : 'ℹ️';
        alert.innerHTML = `${icon} ${message}`;
        
        const container = document.querySelector('.container');
        if (container) {
            container.insertBefore(alert, container.firstChild);
        }

        setTimeout(() => {
            alert.remove();
        }, 5000);
    }
</script>
<?php require_once 'includes/footer.php'; ?>