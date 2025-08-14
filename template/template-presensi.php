<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Daftar Kehadiran Peserta Didik <?= htmlspecialchars($kelasRomawi) ?> Bulan <?= ucwords(strtolower(htmlspecialchars($bulan))) ?> Tahun <?= htmlspecialchars($tahun) ?></title>
  <link rel="icon" href="https://sdnsukokerto01.sch.id/media_library/images/055091ea17934ab44e724535199244e5.png">
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 9px;
      margin: 20px;
    }
    .header {
      text-align: center;
      font-weight: bold;
      margin-bottom: 10px;
    }
    .info-table {
      border-collapse: collapse;
      width: auto;
      margin-bottom: 10px;
      font-weight: bold;
      border: none; 
    }
    .info-table td {
      padding: 2px 6px;
      text-align: left;
      border: none;
    }
    table {
      border-collapse: collapse;
      width: 100%;
      table-layout: fixed;
    }
    th, td {
      border: 1px solid black;
      padding: 2px;
      text-align: center;
      word-wrap: break-word;
    }
    td.name {
      text-align: left;
      padding-left: 4px;
    }
  </style>
</head>
<body>
<br>
<br>
  <div class="header">
    DAFTAR KEHADIRAN PESERTA DIDIK<br>
    <?= htmlspecialchars($nama_sekolah) ?><br>
    SEMESTER <?= $semester ?> TAHUN AJARAN <?= $tahunAjaran ?>
  </div>
 <table class="info-table">
  <tr>
    <td><strong>KELAS</strong></td>
    <td>: <?= str_replace("Kelas ", "", $kelasRomawi); ?></td>
  </tr>
  <tr>
    <td><strong>BULAN</strong></td>
    <td>: <?= ucwords(strtolower(htmlspecialchars($bulan))) ?></td>
  </tr>
  <tr>
    <td><strong>TAHUN</strong></td>
    <td>: <?= htmlspecialchars($tahun) ?></td>
  </tr>
</table>
  <table>
    <thead>
      <tr>
        <th rowspan="2">NO</th>
        <th rowspan="2" style="width: 50px;">NO INDUK</th>
        <th rowspan="2" style="width: 200px;">NAMA PESERTA DIDIK</th>
        <th colspan="31">TANGGAL</th>
        <th colspan="3">JUMLAH</th>
      </tr>
      <tr>
        <?php for ($i = 1; $i <= 31; $i++): ?>
          <th><?= $i ?></th>
        <?php endfor; ?>
        <th style="width: 10px;">S</th><th style="width: 10px;">I</th><th style="width: 10px;">A</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($siswaMap as $siswa): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($siswa['nis']) ?></td>
        <td class="name"><?= $siswa['nama'] ?></td>
        <?php for ($i = 1; $i <= 31; $i++): ?>
  <?php
    $tgl = sprintf("%04d-%02d-%02d", $tahun, bulanIndoKeAngka($bulan), $i);
    $val = $siswa['presensi'][$tgl] ?? '';
  ?>
  <td><?= $val ?></td>
<?php endfor; ?>
        <td><?= ($siswa['jumlah']['S'] > 0) ? $siswa['jumlah']['S'] : '' ?></td>
        <td><?= ($siswa['jumlah']['I'] > 0) ? $siswa['jumlah']['I'] : '' ?></td>
        <td><?= ($siswa['jumlah']['A'] > 0) ? $siswa['jumlah']['A'] : '' ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php
function formatTanggalIndo($tgl) {
  setlocale(LC_TIME, 'id_ID.UTF-8');
  return strftime('%e %B %Y', strtotime($tgl));
}
?>
<table style="width:100%; border:none; text-align:center; margin-top:15px;">
  <tr>
    <td style="border:none;">
      Mengetahui,<br>
      Kepala Sekolah<br><br><br><br><br><br>
      <strong><?= $ttdMap['Kepala Sekolah']['nama'] ?? '-' ?></strong><br>
      NIP. <?= $ttdMap['Kepala Sekolah']['nip'] ?? '-' ?>
    </td>
    <td style="border:none;">
      <?= 'Kab. Jember, ' . formatTanggalIndo(date('j F Y')) ?><br>
      Guru <?= $kelasRomawi ?><br><br><br><br><br><br>
      <strong><?= $ttdMap['Wali Kelas']['nama'] ?? '-' ?></strong><br>
      NIP. <?= $ttdMap['Wali Kelas']['nip'] ?? '-' ?>
    </td>
  </tr>
</table>
</body>
</html>
