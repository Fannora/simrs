<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rekam Medis — <?= isset($rekam_medis[0]) ? esc($rekam_medis[0]['nama_pasien']) . ' / ' . esc($rekam_medis[0]['no_rawat']) : 'Cetak' ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --navy:        #0D2B5E;
      --navy-mid:    #163A7A;
      --blue:        #1A5CB8;
      --teal:        #0A7566;
      --red:         #B91C1C;
      --amber:       #B45309;
      --border:      #CBD5E1;
      --border-lt:   #E8EDF5;
      --bg-section:  #F1F5FB;
      --bg-warn:     #FFFBEB;
      --bg-diag:     #FFF5F5;
      --text:        #0F172A;
      --text-mid:    #334155;
      --text-muted:  #64748B;
      --text-label:  #475569;
      --white:       #FFFFFF;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Inter', sans-serif;
      background: #DCE3EF;
      color: var(--text);
      font-size: 12.5px;
      line-height: 1.55;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    /* ─── PRINT CONTROLS (screen only) ─── */
    .print-bar {
      background: var(--navy);
      padding: 12px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
    }
    .print-bar-title {
      color: rgba(255,255,255,0.75);
      font-size: 13px;
      letter-spacing: 0.03em;
    }
    .btn-print {
      background: #fff;
      color: var(--navy);
      border: none;
      border-radius: 6px;
      padding: 9px 28px;
      font-size: 13.5px;
      font-weight: 700;
      cursor: pointer;
      letter-spacing: 0.02em;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: opacity .15s;
    }
    .btn-print:hover { opacity: .88; }

    /* ─── PAGE WRAPPER ─── */
    .page-wrapper {
      width: 820px;
      margin: 20px auto;
      background: var(--white);
      box-shadow: 0 6px 40px rgba(0,0,0,.22);
    }

    /* ─── LETTERHEAD ─── */
    .letterhead {
      display: flex;
      align-items: center;
      padding: 18px 28px 14px;
      border-bottom: 3px solid var(--navy);
      gap: 20px;
    }
    .lh-logo {
      flex-shrink: 0;
    }
    .lh-logo img {
      height: 62px;
      width: auto;
      display: block;
      object-fit: contain;
    }
    .lh-divider {
      width: 2px;
      height: 56px;
      background: var(--border);
      flex-shrink: 0;
    }
    .lh-info {
      flex: 1;
    }
    .lh-rs-name {
      font-family: 'Playfair Display', serif;
      font-size: 21px;
      font-weight: 700;
      color: var(--navy);
      letter-spacing: 0.01em;
      line-height: 1.2;
    }
    .lh-rs-sub {
      font-size: 10.5px;
      color: var(--text-muted);
      letter-spacing: 0.06em;
      text-transform: uppercase;
      margin-top: 3px;
    }
    .lh-rs-addr {
      font-size: 11px;
      color: var(--text-muted);
      margin-top: 5px;
    }
    .lh-doctype {
      text-align: right;
      flex-shrink: 0;
    }
    .lh-doc-label {
      font-size: 9px;
      text-transform: uppercase;
      letter-spacing: 0.14em;
      color: var(--text-muted);
      margin-bottom: 4px;
    }
    .lh-doc-title {
      font-family: 'Playfair Display', serif;
      font-size: 16px;
      font-weight: 700;
      color: var(--navy);
      line-height: 1.25;
    }
    .lh-doc-no {
      font-size: 11px;
      color: var(--blue);
      font-weight: 600;
      margin-top: 5px;
      font-family: 'Inter', monospace;
    }

    /* colour accent stripe */
    .accent-stripe {
      height: 5px;
      background: linear-gradient(90deg, var(--navy) 0%, var(--blue) 50%, #06B6D4 100%);
    }

    /* ─── PATIENT IDENTITY BANNER ─── */
    .id-banner {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      background: var(--bg-section);
      border-bottom: 1px solid var(--border);
    }
    .id-cell {
      padding: 11px 16px;
      border-right: 1px solid var(--border);
    }
    .id-cell:last-child { border-right: none; }
    .id-label {
      font-size: 9px;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: var(--text-muted);
      margin-bottom: 3px;
      font-weight: 600;
    }
    .id-value {
      font-size: 13px;
      font-weight: 700;
      color: var(--navy);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .id-value.mono {
      font-family: 'Inter', monospace;
      color: var(--blue);
      font-size: 12px;
    }
    .id-value.normal { font-weight: 500; color: var(--text); font-size: 12px; }

    /* ─── VISIT META ROW ─── */
    .visit-meta {
      display: grid;
      grid-template-columns: repeat(6, 1fr);
      border-bottom: 1px solid var(--border);
    }
    .vm-cell {
      padding: 9px 14px;
      border-right: 1px solid var(--border-lt);
    }
    .vm-cell:last-child { border-right: none; }
    .vm-label {
      font-size: 8.5px;
      text-transform: uppercase;
      letter-spacing: 0.09em;
      color: var(--text-muted);
      margin-bottom: 3px;
    }
    .vm-value {
      font-size: 12px;
      font-weight: 600;
      color: var(--text-mid);
    }
    .vm-value.blue { color: var(--blue); }
    .vm-value.teal { color: var(--teal); }

    /* ─── BODY ─── */
    .doc-body {
      padding: 18px 24px;
    }

    /* section card */
    .sec {
      margin-bottom: 14px;
      border: 1px solid var(--border);
      border-radius: 7px;
      overflow: hidden;
    }
    .sec-head {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 7px 14px;
      background: var(--navy-mid);
      color: var(--white);
    }
    .sec-head.teal-bg   { background: var(--teal); }
    .sec-head.red-bg    { background: var(--red); }
    .sec-head.amber-bg  { background: var(--amber); }
    .sec-icon {
      width: 15px;
      height: 15px;
      flex-shrink: 0;
      opacity: .85;
    }
    .sec-title {
      font-size: 9.5px;
      text-transform: uppercase;
      letter-spacing: 0.13em;
      font-weight: 700;
    }
    .sec-body {
      padding: 12px 16px;
      background: var(--white);
      font-size: 12.5px;
      color: var(--text);
      line-height: 1.7;
      white-space: pre-wrap;
      min-height: 42px;
    }
    .sec-body.keluhan {
      background: var(--bg-warn);
      border-top: 2px solid #FCD34D;
      font-style: italic;
      color: #78350F;
    }
    .sec-body.diagnosa {
      background: var(--bg-diag);
      font-weight: 600;
      font-size: 13.5px;
      color: var(--red);
    }

    /* ─── PRESCRIPTION TABLE ─── */
    .rx-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 12px;
    }
    .rx-table thead tr {
      background: #E8EDF5;
    }
    .rx-table th {
      padding: 7px 12px;
      text-align: left;
      font-size: 9px;
      text-transform: uppercase;
      letter-spacing: 0.09em;
      color: var(--text-label);
      font-weight: 700;
      border-bottom: 1px solid var(--border);
    }
    .rx-table th.center, .rx-table td.center { text-align: center; }
    .rx-table th.right, .rx-table td.right   { text-align: right; }
    .rx-table td {
      padding: 8px 12px;
      border-bottom: 1px solid var(--border-lt);
      vertical-align: middle;
    }
    .rx-table tbody tr:last-child td { border-bottom: none; }
    .rx-table tbody tr:nth-child(even) { background: #F8FAFC; }
    .rx-num    { font-weight: 700; color: var(--navy); width: 30px; font-size: 11px; }
    .rx-name   { font-weight: 600; color: var(--text); }
    .rx-satuan { color: var(--text-muted); font-size: 11px; }
    .rx-dosis  { color: var(--blue); font-weight: 500; }
    .rx-qty    { font-weight: 700; color: var(--navy); }
    .rx-note   { color: var(--text-muted); font-style: italic; font-size: 11.5px; }
    .rx-price  { color: var(--teal); font-weight: 600; }
    .rx-total-row td {
      background: #EEF3FB !important;
      font-weight: 700;
      border-top: 2px solid var(--border) !important;
      color: var(--navy);
    }
    .no-rx {
      padding: 14px 16px;
      color: var(--text-muted);
      font-style: italic;
      font-size: 12px;
    }

    /* ─── SIGNATURE + INFO ROW ─── */
    .sig-row {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 16px;
      margin-top: 20px;
    }
    .sig-box {
      border: 1px solid var(--border);
      border-radius: 7px;
      padding: 12px 14px;
      text-align: center;
    }
    .sig-label {
      font-size: 9.5px;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: var(--text-muted);
      margin-bottom: 52px;
    }
    .sig-line {
      border-top: 1px solid var(--text-mid);
      margin: 0 16px 6px;
    }
    .sig-name  { font-size: 12px; font-weight: 700; color: var(--navy); }
    .sig-role  { font-size: 11px; color: var(--text-muted); }

    .info-box {
      border: 1px solid var(--border);
      border-radius: 7px;
      padding: 12px 14px;
      grid-column: span 1;
    }
    .info-box-title {
      font-size: 9.5px;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: var(--text-muted);
      font-weight: 700;
      margin-bottom: 8px;
    }
    .info-box-row {
      display: flex;
      justify-content: space-between;
      font-size: 11.5px;
      margin-bottom: 4px;
    }
    .info-box-row span:first-child { color: var(--text-muted); }
    .info-box-row span:last-child  { font-weight: 600; color: var(--text); }
    .info-total-row span:last-child { color: var(--teal); font-size: 13px; font-weight: 700; }

    /* barcode visual */
    .barcode-wrap {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-end;
    }
    .barcode-bars {
      display: flex;
      gap: 2px;
      align-items: flex-end;
      margin-bottom: 4px;
    }
    .barcode-bars span {
      display: block;
      background: var(--navy);
    }
    .barcode-no {
      font-size: 9px;
      font-family: monospace;
      color: var(--text-muted);
      letter-spacing: 0.14em;
    }
    .confidential {
      display: inline-block;
      border: 1px solid var(--red);
      color: var(--red);
      font-size: 8.5px;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      padding: 2px 8px;
      border-radius: 3px;
      margin-top: 8px;
    }

    /* ─── DOC FOOTER ─── */
    .doc-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 24px;
      background: var(--bg-section);
      border-top: 1px solid var(--border);
      margin-top: 18px;
    }
    .df-left {
      font-size: 9.5px;
      color: var(--text-muted);
    }
    .df-right {
      font-size: 9px;
      color: var(--text-muted);
      text-align: right;
    }

    /* ─── PAGE BREAK ─── */
    .page-break-wrapper {
      page-break-before: always;
      break-before: page;
    }
    .page-break-rule {
      border: none;
      border-top: 2px dashed var(--border);
      margin: 32px 0;
    }

    /* ─── PRINT ─── */
    @media print {
      body { background: #fff; }
      .print-bar { display: none !important; }
      .page-wrapper {
        width: 100%;
        margin: 0;
        box-shadow: none;
      }
      .page-break-wrapper {
        margin: 0;
      }
      .page-break-rule { display: none; }
      @page { size: A4; margin: 10mm 12mm; }
    }
  </style>
</head>
<body>

<!-- ── Print Bar (screen only) ── -->
<div class="print-bar no-print">
  <span class="print-bar-title">Pratinjau Rekam Medis — RS MiraCare</span>
  <button class="btn-print" onclick="window.print()">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
      <polyline points="6 9 6 2 18 2 18 9"/>
      <path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/>
      <rect x="6" y="14" width="12" height="8"/>
    </svg>
    Cetak / Simpan PDF
  </button>
</div>

<?php $first = true; foreach ($rekam_medis as $rm): ?>

<?php if (!$first): ?>
<div class="page-break-wrapper">
  <hr class="page-break-rule">
</div>
<?php endif; $first = false; ?>

<?php
  // Hitung total tagihan dari resep items
  $grandTotal = 0;
  if (!empty($rm['resep_items'])) {
      foreach ($rm['resep_items'] as $ri) {
          $grandTotal += (float)$ri['harga'] * (int)$ri['jumlah'];
      }
  }
  // Hitung umur
  $umur = '';
  if (!empty($rm['tgl_lahir'])) {
      $umur = (int)date_diff(date_create($rm['tgl_lahir']), date_create('today'))->y . ' tahun';
  }
  $jkLabel = ($rm['jk'] ?? '') === 'P' ? 'Perempuan' : (($rm['jk'] ?? '') === 'L' ? 'Laki-laki' : '-');
?>

<div class="page-wrapper">

  <!-- ══ LETTERHEAD ══ -->
  <div class="letterhead">
    <div class="lh-logo">
      <img src="<?= base_url('assets/img/MiraCareLogo.png') ?>" alt="MiraCare Logo">
    </div>
    <div class="lh-divider"></div>
    <div class="lh-info">
      <div class="lh-rs-name">RS MiraCare</div>
      <div class="lh-rs-sub">Sistem Informasi Manajemen Rumah Sakit</div>
      <div class="lh-rs-addr">Jl. Kesehatan No. 1, Indonesia &nbsp;·&nbsp; (021) 000-0000 &nbsp;·&nbsp; simrs@miracare.id</div>
    </div>
    <div class="lh-doctype">
      <div class="lh-doc-label">Dokumen Resmi</div>
      <div class="lh-doc-title">Rekam Medis<br>Rawat Jalan</div>
      <div class="lh-doc-no"><?= esc($rm['no_rawat']) ?></div>
    </div>
  </div>
  <div class="accent-stripe"></div>

  <!-- ══ PATIENT IDENTITY BANNER ══ -->
  <div class="id-banner">
    <div class="id-cell">
      <div class="id-label">No. Rekam Medis</div>
      <div class="id-value mono"><?= esc($rm['no_rm']) ?></div>
    </div>
    <div class="id-cell">
      <div class="id-label">Nama Pasien</div>
      <div class="id-value"><?= esc($rm['nama_pasien']) ?></div>
    </div>
    <div class="id-cell">
      <div class="id-label">Jenis Kelamin &amp; Umur</div>
      <div class="id-value normal"><?= $jkLabel ?><?= $umur ? ' · ' . $umur : '' ?></div>
    </div>
    <div class="id-cell">
      <div class="id-label">NIK</div>
      <div class="id-value mono"><?= $rm['nik'] ? esc($rm['nik']) : '—' ?></div>
    </div>
  </div>

  <!-- ══ VISIT META ══ -->
  <div class="visit-meta">
    <div class="vm-cell">
      <div class="vm-label">Tanggal Periksa</div>
      <div class="vm-value"><?= date('d M Y', strtotime($rm['tgl_periksa'])) ?></div>
    </div>
    <div class="vm-cell">
      <div class="vm-label">Jam Periksa</div>
      <div class="vm-value blue"><?= date('H:i', strtotime($rm['tgl_periksa'])) ?> WIB</div>
    </div>
    <div class="vm-cell">
      <div class="vm-label">Tgl. Pendaftaran</div>
      <div class="vm-value"><?= $rm['tgl_daftar'] ? date('d M Y', strtotime($rm['tgl_daftar'])) : '—' ?></div>
    </div>
    <div class="vm-cell">
      <div class="vm-label">Dokter Pemeriksa</div>
      <div class="vm-value teal">dr. <?= esc($rm['nama_dokter']) ?></div>
    </div>
    <div class="vm-cell">
      <div class="vm-label">Poliklinik</div>
      <div class="vm-value"><?= esc($rm['nama_poli']) ?></div>
    </div>
    <div class="vm-cell">
      <div class="vm-label">No. BPJS</div>
      <div class="vm-value"><?= $rm['no_bpjs'] ? esc($rm['no_bpjs']) : '—' ?></div>
    </div>
  </div>

  <!-- ══ BODY ══ -->
  <div class="doc-body">

    <!-- Keluhan Utama -->
    <div class="sec">
      <div class="sec-head amber-bg">
        <svg class="sec-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
        </svg>
        <span class="sec-title">Keluhan Utama Pasien</span>
      </div>
      <div class="sec-body keluhan"><?= esc($rm['keluhan_awal'] ?? '—') ?></div>
    </div>

    <!-- Diagnosa -->
    <div class="sec">
      <div class="sec-head red-bg">
        <svg class="sec-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/>
          <line x1="12" y1="8" x2="12" y2="12"/>
          <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <span class="sec-title">Diagnosa</span>
      </div>
      <div class="sec-body diagnosa"><?= nl2br(esc($rm['diagnosa'])) ?></div>
    </div>

    <!-- Tindakan Medis -->
    <div class="sec">
      <div class="sec-head teal-bg">
        <svg class="sec-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M14.5 4h-5L7 7H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2h-3L14.5 4z"/>
          <circle cx="12" cy="13" r="3"/>
        </svg>
        <span class="sec-title">Tindakan Medis</span>
      </div>
      <div class="sec-body"><?= $rm['tindakan'] ? nl2br(esc($rm['tindakan'])) : '<em style="color:#94a3b8;">—</em>' ?></div>
    </div>

    <!-- Resep Obat -->
    <div class="sec">
      <div class="sec-head">
        <svg class="sec-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2z"/>
          <line x1="9" y1="9" x2="15" y2="9"/>
          <line x1="9" y1="13" x2="15" y2="13"/>
          <line x1="9" y1="17" x2="12" y2="17"/>
        </svg>
        <span class="sec-title">Resep Obat &amp; Instruksi</span>
      </div>
      <?php if (!empty($rm['resep_items'])): ?>
      <table class="rx-table">
        <thead>
          <tr>
            <th style="width:30px;">No</th>
            <th>Nama Obat</th>
            <th>Satuan</th>
            <th>Dosis / Aturan</th>
            <th class="center">Jml</th>
            <th class="right">Harga Satuan</th>
            <th class="right">Subtotal</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <?php $rn = 1; $runningTotal = 0; foreach ($rm['resep_items'] as $ri):
            $subtotal = (float)$ri['harga'] * (int)$ri['jumlah'];
            $runningTotal += $subtotal;
          ?>
          <tr>
            <td class="rx-num"><?= $rn++ ?></td>
            <td class="rx-name"><?= esc($ri['nama_obat']) ?></td>
            <td class="rx-satuan"><?= esc($ri['satuan'] ?? '—') ?></td>
            <td class="rx-dosis"><?= esc($ri['dosis'] ?: '—') ?></td>
            <td class="rx-qty center"><?= (int)$ri['jumlah'] ?></td>
            <td class="rx-price right">Rp <?= number_format((float)$ri['harga'], 0, ',', '.') ?></td>
            <td class="rx-price right">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
            <td class="rx-note"><?= esc($ri['keterangan'] ?? '—') ?></td>
          </tr>
          <?php endforeach; ?>
          <tr class="rx-total-row">
            <td colspan="6" style="text-align:right; padding-right:14px; font-size:11px; letter-spacing:.06em; text-transform:uppercase;">Total Biaya Obat</td>
            <td class="right" style="color:var(--teal); font-size:13.5px;">Rp <?= number_format($runningTotal, 0, ',', '.') ?></td>
            <td></td>
          </tr>
        </tbody>
      </table>
      <?php elseif (!empty(trim($rm['resep_obat'] ?? ''))): ?>
        <?php
          // Fallback: render plain-text resep
          $lines = array_filter(explode("\n", trim($rm['resep_obat'])));
        ?>
        <table class="rx-table">
          <thead>
            <tr>
              <th style="width:30px;">No</th>
              <th>Obat / Instruksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $rn2 = 1; foreach ($lines as $line): $line = trim($line); if(!$line) continue; ?>
            <tr>
              <td class="rx-num"><?= $rn2++ ?></td>
              <td><?= esc($line) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <div class="no-rx"><em>Tidak ada resep obat yang diberikan.</em></div>
      <?php endif; ?>
    </div>

    <!-- Signature Row -->
    <div class="sig-row">
      <!-- Tanda tangan dokter -->
      <div class="sig-box">
        <div class="sig-label">Dokter Pemeriksa</div>
        <div class="sig-line"></div>
        <div class="sig-name">dr. <?= esc($rm['nama_dokter']) ?></div>
        <div class="sig-role"><?= esc($rm['nama_poli']) ?></div>
      </div>

      <!-- Tanda tangan pasien -->
      <div class="sig-box">
        <div class="sig-label">Tanda Tangan Pasien / Wali</div>
        <div class="sig-line"></div>
        <div class="sig-name"><?= esc($rm['nama_pasien']) ?></div>
        <div class="sig-role">Pasien / Wali</div>
      </div>

      <!-- Info ringkas + barcode -->
      <div class="info-box">
        <div class="info-box-title">Ringkasan Kunjungan</div>
        <div class="info-box-row">
          <span>No. Rawat</span>
          <span style="color:var(--blue); font-family:monospace;"><?= esc($rm['no_rawat']) ?></span>
        </div>
        <div class="info-box-row">
          <span>Kelas Layanan</span>
          <span>Rawat Jalan</span>
        </div>
        <div class="info-box-row info-total-row">
          <span>Est. Total Biaya</span>
          <span>Rp <?= number_format($grandTotal, 0, ',', '.') ?></span>
        </div>
        <!-- Pseudo-barcode -->
        <div class="barcode-wrap" style="margin-top:10px;">
          <div class="barcode-bars">
            <?php
              $bw = [2,1,3,1,2,1,1,3,2,1,3,1,2,1,1,3,2,1,3,2,1,2,3,1,2,1,3];
              $bh = [26,34,26,38,34,26,38,34,26,34,30,38,34,26,34,38,26,34,30,38,26,34,38,26,34,30,26];
              foreach($bw as $bi => $bwv): ?>
              <span style="width:<?= $bwv ?>px; height:<?= $bh[$bi] ?>px;"></span>
            <?php endforeach; ?>
          </div>
          <div class="barcode-no"><?= esc($rm['no_rawat']) ?></div>
          <div class="confidential">Dokumen Rahasia Medis</div>
        </div>
      </div>
    </div>

  </div><!-- /doc-body -->

  <!-- ══ DOC FOOTER ══ -->
  <div class="doc-footer">
    <div class="df-left">
      RS MiraCare &nbsp;·&nbsp; SIMRS v1.0 &nbsp;·&nbsp; Dokumen ini merupakan arsip resmi rumah sakit yang dilindungi kerahasiaan medis
    </div>
    <div class="df-right">
      Dicetak: <?= date('d/m/Y H:i') ?> WIB &nbsp;·&nbsp; Oleh: Sistem
    </div>
  </div>

</div><!-- /page-wrapper -->

<?php endforeach; ?>

</body>
</html>