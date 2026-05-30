<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rekam Medis — <?= isset($rekam_medis[0]) ? esc($rekam_medis[0]['nama_pasien']) . ' / ' . esc($rekam_medis[0]['no_rawat']) : 'Cetak' ?></title>
  <style>
    /* CSS Standard Reset & Base Settings */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    
    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 14px; /* Diperbesar dari 12px */
      line-height: 1.5;
      color: #000;     /* Hitam pekat untuk cetakan */
      background: #f4f4f4;
    }

    /* Print Bar (Hanya tampil di layar) */
    .print-bar {
      background-color: #333;
      color: #fff;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-family: Arial, sans-serif;
    }
    .btn-print {
      background: #fff;
      color: #333;
      border: 1px solid #ccc;
      padding: 6px 16px;
      font-size: 13px;
      font-weight: bold;
      cursor: pointer;
      border-radius: 4px;
    }
    .btn-print:hover { background: #eee; }

    /* Page Wrapper */
    .page-wrapper {
      width: 210mm; /* Standar A4 */
      min-height: 297mm;
      margin: 20px auto;
      background: #fff;
      padding: 15mm 15mm;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    /* Kop Surat Resmi */
    .kop-surat {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
    }
    .kop-logo {
      width: 70px;
      margin-right: 20px;
    }
    .kop-logo img {
      width: 100%;
      height: auto;
    }
    .kop-teks {
      flex: 1;
      text-align: center;
    }
    .kop-teks h1 {
      font-size: 20px; /* Diperbesar dari 18px */
      font-weight: bold;
      margin-bottom: 2px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    .kop-teks h2 {
      font-size: 14px; /* Diperbesar dari 12px */
      font-weight: normal;
      margin-bottom: 2px;
      text-transform: uppercase;
    }
    .kop-teks p {
      font-size: 12px; /* Diperbesar dari 11px */
      color: #333;
    }
    
    /* Garis Ganda Kop Surat */
    .garis-kop {
      border-top: 2px solid #000;
      border-bottom: 1px solid #000;
      height: 2px;
      margin-bottom: 15px;
    }

    /* Judul Dokumen */
    .doc-title {
      text-align: center;
      font-size: 16px; /* Diperbesar dari 14px */
      font-weight: bold;
      text-transform: uppercase;
      text-decoration: underline;
      margin-bottom: 2px;
    }
    .doc-subtitle {
      text-align: center;
      font-size: 13px; /* Diperbesar dari 11px */
      margin-bottom: 20px;
    }

    /* Tabel Informasi Pasien & Kunjungan (Layout Formal) */
    .table-info {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
      font-size: 13px; /* Diperbesar dari 11px */
    }
    .table-info td {
      padding: 4px 6px; /* Ditambah sedikit padding */
      vertical-align: top;
    }
    .table-info td:nth-child(2),
    .table-info td:nth-child(5) {
      width: 10px; /* Lebar titik dua (:) */
      text-align: center;
    }
    .table-info .lbl {
      font-weight: bold;
      width: 18%; /* Disesuaikan agar muat */
    }
    .table-info .val {
      width: 32%;
    }

    /* Bagian Data Klinis (SOAP) */
    .section-title {
      font-weight: bold;
      font-size: 14px; /* Diperbesar dari 12px */
      background-color: #eee;
      padding: 6px 10px;
      border: 1px solid #000;
      margin-top: 15px;
      text-transform: uppercase;
    }
    .section-body {
      border: 1px solid #000;
      border-top: none;
      padding: 12px 10px;
      min-height: 45px;
      font-size: 13.5px; /* Diperbesar */
      text-align: left; /* Perataan Kiri untuk SOAP A, B, C */
      white-space: pre-wrap; /* Mempertahankan baris baru dari textarea */
    }

    /* Tabel Formal (Resep & Tagihan) */
    .table-data {
      width: 100%;
      border-collapse: collapse;
      margin-top: -1px; /* Gabung dengan border atasnya */
      font-size: 13px; /* Diperbesar dari 11px */
    }
    .table-data th, .table-data td {
      border: 1px solid #000;
      padding: 8px 10px; /* Ditambah padding */
    }
    .table-data th {
      background-color: #f9f9f9;
      text-align: left;
      font-weight: bold;
    }
    .text-center { text-align: center !important; }
    .text-right { text-align: right !important; }
    .text-bold { font-weight: bold; }

    /* Area Tanda Tangan */
    .signature-area {
      display: flex;
      justify-content: space-between;
      margin-top: 50px;
      font-size: 13.5px; /* Diperbesar */
    }
    .sig-box {
      width: 45%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      min-height: 140px; /* Tinggi konstan agar area tanda tangan sama */
      text-align: center;
    }
    .sig-header {
      height: 40px; /* Tinggi header konstan agar teks sejajar */
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
    }
    .sig-footer {
      /* Bagian bawah untuk nama */
    }
    .sig-name {
      font-weight: bold;
      text-decoration: underline;
      margin-bottom: 3px;
    }

    /* Page Break untuk Multiple Pages */
    .page-break {
      page-break-before: always;
      break-before: page;
    }
    .page-divider {
      border-top: 1px dashed #999;
      margin: 20px 0;
    }

    /* Konfigurasi Cetak (Print) */
    @media print {
      body { background: #fff; }
      .print-bar { display: none !important; }
      .page-wrapper {
        margin: 0;
        padding: 0;
        width: 100%;
        box-shadow: none;
      }
      .page-divider { display: none; }
      @page { 
        size: A4 portrait;
        margin: 10mm 15mm; 
      }
    }
  </style>
</head>
<body>

<!-- Print Control (Hanya di layar) -->
<div class="print-bar no-print">
  <div>
    <strong>Rekam Medis (Versi Cetak Formal)</strong>
  </div>
  <button class="btn-print" onclick="window.print()">Cetak Dokumen</button>
</div>

<?php
if (!function_exists('formatTanggalIndo')) {
    function formatTanggalIndo($dateStr) {
        $timestamp = strtotime($dateStr);
        $hari_arr = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        $bulan_arr = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];
        
        $hari_inggris = date('l', $timestamp);
        $hari_indo = $hari_arr[$hari_inggris] ?? $hari_inggris;
        $tgl = date('d', $timestamp);
        $bulan_inggris = date('F', $timestamp);
        $bulan_indo = $bulan_arr[$bulan_inggris] ?? $bulan_inggris;
        $tahun = date('Y', $timestamp);
        
        return "$hari_indo, $tgl $bulan_indo $tahun";
    }
}

if (!function_exists('formatBulanIndo')) {
    function formatBulanIndo($dateStr) {
        $timestamp = strtotime($dateStr);
        $bulan_arr = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];
        $tgl = date('d', $timestamp);
        $bulan_inggris = date('F', $timestamp);
        $bulan_indo = $bulan_arr[$bulan_inggris] ?? $bulan_inggris;
        $tahun = date('Y', $timestamp);
        return "$tgl $bulan_indo $tahun";
    }
}
?>

<?php $first = true; foreach ($rekam_medis as $rm): ?>

<?php if (!$first): ?>
<div class="page-break"></div>
<hr class="page-divider no-print">
<?php endif; $first = false; ?>

<?php
  // Perhitungan Data Pendukung
  $grandTotal = 0;
  if (!empty($rm['resep_items'])) {
      foreach ($rm['resep_items'] as $ri) {
          $grandTotal += (float)$ri['harga'] * (int)$ri['jumlah'];
      }
  }
  
  $umur = '';
  if (!empty($rm['tgl_lahir'])) {
      $umur = (int)date_diff(date_create($rm['tgl_lahir']), date_create('today'))->y . ' Tahun';
  }
  $jkLabel = ($rm['jk'] ?? '') === 'P' ? 'Perempuan' : (($rm['jk'] ?? '') === 'L' ? 'Laki-laki' : '-');
?>

<div class="page-wrapper">

  <!-- 1. KOP SURAT -->
  <div class="kop-surat">
    <div class="kop-teks">
      <h2>SISTEM INFORMASI MANAJEMEN RUMAH SAKIT</h2>
      <h1>RUMAH SAKIT MIRACARE</h1>
      <p>Jl. Selambo IV No. 4a, Amplas, Medan, Sumatera Utara</p>
      <p>Telp: (+62) 813-9688-4263 | Email: info@miracare.id</p>
    </div>
  </div>
  <div class="garis-kop"></div>

  <!-- 2. JUDUL DOKUMEN -->
  <div class="doc-title">REKAM MEDIS RAWAT JALAN</div>
  <div class="doc-subtitle">No. Registrasi: <?= esc($rm['no_rawat']) ?></div>

  <!-- 3. IDENTITAS PASIEN & KUNJUNGAN (Format Tabel Padat) -->
  <table class="table-info">
    <tr>
      <td class="lbl">No. Rekam Medis</td><td>:</td><td class="val"><?= esc($rm['no_rm']) ?></td>
      <td class="lbl">Tanggal Periksa</td><td>:</td><td class="val"><?= formatTanggalIndo($rm['tgl_periksa']) ?></td>
    </tr>
    <tr>
      <td class="lbl">Nama Pasien</td><td>:</td><td class="val"><strong><?= esc($rm['nama_pasien']) ?></strong></td>
      <td class="lbl">Dokter Pemeriksa</td><td>:</td><td class="val">dr. <?= esc($rm['nama_dokter']) ?></td>
    </tr>
    <tr>
      <td class="lbl">Jenis Kelamin / Umur</td><td>:</td><td class="val"><?= $jkLabel ?> / <?= $umur ?: '-' ?></td>
      <td class="lbl">Poliklinik Tujuan</td><td>:</td><td class="val"><?= esc($rm['nama_poli']) ?></td>
    </tr>
    <tr>
      <td class="lbl">NIK / Identitas</td><td>:</td><td class="val"><?= $rm['nik'] ? esc($rm['nik']) : '-' ?></td>
      <td class="lbl">Tipe Layanan / BPJS</td><td>:</td><td class="val">Rawat Jalan / <?= $rm['no_bpjs'] ? esc($rm['no_bpjs']) : '-' ?></td>
    </tr>
  </table>

  <!-- 4. PENCATATAN KLINIS (S.O.A.P) -->
  <div class="section-title">A. Keluhan Utama (Subjektif)</div>
  <div class="section-body">
<?= esc($rm['keluhan_awal'] ?? '-') ?>
  </div>

  <div class="section-title">B. Diagnosa (Assessment)</div>
  <div class="section-body text-bold">
<?= esc($rm['diagnosa'] ?? '-') ?>
  </div>

  <div class="section-title">C. Tindakan Medis (Planning/Prosedur)</div>
  <div class="section-body">
<?= $rm['tindakan'] ? esc($rm['tindakan']) : '-' ?>
  </div>

  <!-- 5. RESEP OBAT -->
  <div class="section-title">D. Resep Obat</div>
  <?php if (!empty($rm['resep_items'])): ?>
    <table class="table-data">
      <thead>
        <tr>
          <th width="5%" class="text-center">No</th>
          <th width="30%" class="text-center">Nama Obat</th>
          <th width="20%" class="text-center">Dosis / Aturan Pakai</th>
          <th width="15%" class="text-center">Jumlah</th>
          <th width="15%" class="text-center">Harga Satuan</th>
          <th width="15%" class="text-center">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $rn = 1; 
          $runningTotal = 0; 
          foreach ($rm['resep_items'] as $ri):
            $isBeliLuar = ($rm['pilihan_obat'] ?? '') !== 'Apotek RS';
            $subtotal = $isBeliLuar ? 0 : (float)$ri['harga'] * (int)$ri['jumlah'];
            $runningTotal += $subtotal;
        ?>
        <tr>
          <td class="text-center"><?= $rn++ ?></td>
          <td class="text-bold"><?= esc($ri['nama_obat']) ?></td>
          <td><?= esc($ri['dosis'] ?: '-') ?></td>
          <td class="text-center"><?= (int)$ri['jumlah'] ?> <?= esc($ri['satuan'] ?? '') ?></td>
          <td class="text-right">
            <?= $isBeliLuar ? '-' : 'Rp ' . number_format((float)$ri['harga'], 0, ',', '.') ?>
          </td>
          <td class="text-right">
            <?= $isBeliLuar ? '-' : 'Rp ' . number_format($subtotal, 0, ',', '.') ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php elseif (!empty(trim($rm['resep_obat'] ?? ''))): ?>
    <!-- Fallback Text Area Resep -->
    <div class="section-body">
<?= esc($rm['resep_obat']) ?>
    </div>
  <?php else: ?>
    <div class="section-body" style="font-style: italic; color: #555;">
      Tidak ada resep obat.
    </div>
  <?php endif; ?>

  <!-- 6. RINCIAN BIAYA & TOTAL TAGIHAN -->
  <div class="section-title">E. Rincian Biaya & Total Tagihan</div>
  <table class="table-data">
    <tbody>
      <tr>
        <td>Biaya Konsultasi & Layanan Medis (<?= esc($rm['nama_poli']) ?>)</td>
        <td class="text-right">
          Rp <?= number_format((float)($rm['biaya_konsultasi'] ?? 0), 0, ',', '.') ?>
        </td>
      </tr>
      <?php if ((float)($rm['biaya_kamar'] ?? 0) > 0): ?>
      <tr>
        <td>Biaya Kamar / Akomodasi (Rawat Inap)</td>
        <td class="text-right">
          Rp <?= number_format((float)($rm['biaya_kamar'] ?? 0), 0, ',', '.') ?>
        </td>
      </tr>
      <?php endif; ?>
      <tr>
        <td>
          Total Biaya Obat 
          <?php if (($rm['pilihan_obat'] ?? '') === 'Apotek RS'): ?>
            <strong>(Apotek RS)</strong>
          <?php else: ?>
            <strong style="color: #666;">(Beli di Luar RS)</strong>
          <?php endif; ?>
        </td>
        <td class="text-right">
          <?php if (($rm['pilihan_obat'] ?? '') === 'Apotek RS'): ?>
            Rp <?= number_format((float)($rm['biaya_obat'] ?? $runningTotal), 0, ',', '.') ?>
          <?php else: ?>
            Rp 0
          <?php endif; ?>
        </td>
      </tr>
      <tr style="background-color: #f2f2f2;">
        <td class="text-bold" style="font-size: 14px;">TOTAL TAGIHAN</td>
        <td class="text-right text-bold" style="font-size: 15px;">
          Rp <?= number_format((float)($rm['total_biaya'] ?? (($rm['biaya_konsultasi'] ?? 0) + ($rm['biaya_kamar'] ?? 0) + $runningTotal)), 0, ',', '.') ?>
        </td>
      </tr>
    </tbody>
  </table>

  <!-- 7. TANDA TANGAN (Authentikasi) -->
  <div class="signature-area">
    <div class="sig-box">
      <div class="sig-header">
        <div>Pasien / Keluarga Pasien,</div>
      </div>
      <div class="sig-footer">
        <div class="sig-name"><?= esc($rm['nama_pasien']) ?></div>
        <div style="font-size: 12px; visibility: hidden;">&nbsp;</div>
      </div>
    </div>
    <div class="sig-box">
      <div class="sig-header">
        <div>Medan, <?= formatBulanIndo($rm['tgl_periksa']) ?></div>
        <div>Dokter Pemeriksa,</div>
      </div>
      <div class="sig-footer">
        <div class="sig-name">dr. <?= esc($rm['nama_dokter']) ?></div>
        <div style="font-size: 12px; color: #333;">SIP. / Poli: <?= esc($rm['nama_poli']) ?></div>
      </div>
    </div>
  </div>

</div><!-- /page-wrapper -->

<?php endforeach; ?>

</body>
</html>