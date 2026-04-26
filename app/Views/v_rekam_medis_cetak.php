<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Cetak Data Rekam Medis</title>
  <style>
    body { font-family: sans-serif; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #000; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
    .text-center { text-align: center; }
  </style>
</head>
<body onload="window.print();">

  <div class="text-center">
    <h2>Sistem Informasi Rumah Sakit</h2>
    <h3>Laporan Data Rekam Medis Keseluruhan</h3>
  </div>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>No Rawat</th>
        <th>Tgl Periksa</th>
        <th>Pasien</th>
        <th>Dokter</th>
        <th>Diagnosa</th>
        <th>Tindakan</th>
        <th>Resep Obat</th>
      </tr>
    </thead>
    <tbody>
      <?php $no=1; foreach ($rekam_medis as $row) : ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $row['no_rawat'] ?></td>
        <td><?= date('d-m-Y H:i', strtotime($row['tgl_periksa'])) ?></td>
        <td><?= $row['no_rm'] ?> - <?= $row['nama_pasien'] ?></td>
        <td><?= $row['nama_dokter'] ?></td>
        <td><?= $row['diagnosa'] ?></td>
        <td><?= $row['tindakan'] ?></td>
        <td><?= $row['resep_obat'] ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</body>
</html>
