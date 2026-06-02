<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DokterDashboardController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    private function checkDokterSession()
    {
        if (!session()->get('id_user') || session()->get('level_id') !== 'Dokter') {
            session()->setFlashdata('error', 'Silakan login sebagai Dokter.');
            return false;
        }
        return true;
    }

    private function getDokterData()
    {
        return $this->db->table('tbl_dokter d')
            ->select('d.*, p.nama_poli')
            ->join('tbl_poli p', 'd.id_poli = p.id_poli', 'left')
            ->where('d.id_user', session()->get('id_user'))
            ->get()
            ->getRowArray();
    }

    private function isAppointmentTime($pendaftaran, $dokter = null)
    {
        date_default_timezone_set('Asia/Jakarta');
        if (!$dokter) {
            $dokter = $this->getDokterData();
        }
        if (!$dokter) {
            return false;
        }

        $bookingDate = new \DateTime($pendaftaran['tgl_daftar'] . ' 00:00:00');
        $todayDate = new \DateTime(date('Y-m-d') . ' 00:00:00');

        if ($bookingDate > $todayDate) {
            return false;
        }

        $currentHourMin = date('H:i:s');
        $practiceStart = !empty($dokter['jam_mulai']) ? $dokter['jam_mulai'] : '00:00:00';

        return $currentHourMin >= $practiceStart;
    }

    /**
     * Dashboard Dokter
     */
    public function dashboard()
    {
        if (!$this->checkDokterSession()) {
            return redirect()->to(base_url('login'));
        }

        $dokter = $this->getDokterData();
        if (!$dokter) {
            session()->setFlashdata('error', 'Data dokter tidak ditemukan.');
            return redirect()->to(base_url('login'));
        }

        $jadwalHariIni = $this->db->table('tbl_pendaftaran p')
            ->select('p.no_rawat, p.no_rm, p.tgl_daftar, ps.nama_pasien, ps.tgl_lahir, ps.jk, p.jam_kunjungan, p.slot_waktu, p.keluhan_awal, p.status_periksa')
            ->join('tbl_pasien ps', 'p.no_rm = ps.no_rm')
            ->where('p.id_dokter', $dokter['id_dokter'])
            ->where('p.tgl_daftar', date('Y-m-d'))
            ->orderBy('p.slot_waktu', 'ASC')
            ->get()
            ->getResultArray();

        $totalHariIni = count($jadwalHariIni);
        $belumDiperiksa = 0;
        $selesai = 0;
        foreach ($jadwalHariIni as $j) {
            if ($j['status_periksa'] === 'Belum Diperiksa' || $j['status_periksa'] === 'Sedang Diperiksa') {
                $belumDiperiksa++;
            } elseif ($j['status_periksa'] === 'Selesai') {
                $selesai++;
            }
        }

        return view('dokter/dashboard', compact(
            'dokter', 'jadwalHariIni', 'totalHariIni', 'belumDiperiksa', 'selesai'
        ));
    }

    /**
     * Jadwal Saya (semua tanggal, filter opsional)
     */
    public function jadwal()
    {
        if (!$this->checkDokterSession()) {
            return redirect()->to(base_url('login'));
        }

        $dokter = $this->getDokterData();
        if (!$dokter) {
            return redirect()->to(base_url('login'));
        }

        $builder = $this->db->table('tbl_pendaftaran p')
            ->select('p.no_rawat, p.no_rm, p.tgl_daftar, p.jam_kunjungan, p.slot_waktu, p.keluhan_awal, p.status_periksa, ps.nama_pasien, ps.tgl_lahir, ps.jk, ps.alamat, ps.nik, ps.no_bpjs, po.nama_poli, rm.id_rm, rm.tgl_periksa, rm.diagnosa, rm.tindakan, rm.resep_obat')
            ->join('tbl_pasien ps', 'p.no_rm = ps.no_rm')
            ->join('tbl_dokter d', 'p.id_dokter = d.id_dokter')
            ->join('tbl_poli po', 'd.id_poli = po.id_poli')
            ->join('tbl_rekam_medis rm', 'rm.no_rawat = p.no_rawat', 'left')
            ->where('p.id_dokter', $dokter['id_dokter']);

        $tanggalFilter = $this->request->getGet('tanggal');
        if (!empty($tanggalFilter)) {
            $builder->where('p.tgl_daftar', $tanggalFilter);
        }

        $jadwal = $builder->orderBy('p.tgl_daftar', 'DESC')
            ->orderBy('p.slot_waktu', 'ASC')
            ->get()
            ->getResultArray();

        return view('dokter/jadwal', [
            'dokter' => $dokter,
            'jadwal' => $jadwal,
            'tanggalFilter' => $tanggalFilter,
        ]);
    }

    /**
     * Form Input Rekam Medis
     */
    public function inputRekamMedis($no_rawat = null)
    {
        if (!$this->checkDokterSession()) {
            return redirect()->to(base_url('login'));
        }

        $dokter = $this->getDokterData();
        if (!$dokter) {
            return redirect()->to(base_url('login'));
        }

        if (empty($no_rawat)) {
            session()->setFlashdata('error', 'No. Rawat tidak valid.');
            return redirect()->to(base_url('dokter/dashboard'));
        }

        $pendaftaran = $this->db->table('tbl_pendaftaran p')
            ->select('p.*, ps.nama_pasien, ps.nik, ps.tgl_lahir, ps.jk, ps.alamat, ps.no_bpjs, d.nama_dokter, po.nama_poli')
            ->join('tbl_pasien ps', 'p.no_rm = ps.no_rm')
            ->join('tbl_dokter d', 'p.id_dokter = d.id_dokter')
            ->join('tbl_poli po', 'd.id_poli = po.id_poli')
            ->where('p.no_rawat', $no_rawat)
            ->get()
            ->getRowArray();

        if (!$pendaftaran) {
            session()->setFlashdata('error', 'Data pendaftaran tidak ditemukan.');
            return redirect()->to(base_url('dokter/dashboard'));
        }

        // Pastikan dokter yang login adalah pemilik jadwal ini
        if ((int) $pendaftaran['id_dokter'] !== (int) $dokter['id_dokter']) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses ke data ini.');
            return redirect()->to(base_url('dokter/dashboard'));
        }

        // Cek apakah sudah waktunya periksa (tanggal hari ini/masa lalu dan jam praktik dokter)
        if (!$this->isAppointmentTime($pendaftaran, $dokter)) {
            $tglJanji = date('d M Y', strtotime($pendaftaran['tgl_daftar']));
            $waktuMulai = !empty($dokter['jam_mulai']) ? substr($dokter['jam_mulai'], 0, 5) : '08:00';
            
            $bookingDate = new \DateTime($pendaftaran['tgl_daftar'] . ' 00:00:00');
            $todayDate = new \DateTime(date('Y-m-d') . ' 00:00:00');
            
            if ($bookingDate > $todayDate) {
                session()->setFlashdata('error', 'Belum memasuki tanggal janji temu (Mulai tanggal ' . $tglJanji . ').');
            } else {
                session()->setFlashdata('error', 'Belum memasuki jam praktik dokter hari ini (Jam praktik mulai pukul ' . $waktuMulai . ' WIB).');
            }
            return redirect()->to(base_url('dokter/dashboard'));
        }

        // Auto-update status ke Sedang Diperiksa
        if ($pendaftaran['status_periksa'] === 'Belum Diperiksa') {
            $this->db->table('tbl_pendaftaran')
                ->where('no_rawat', $no_rawat)
                ->update(['status_periksa' => 'Sedang Diperiksa']);
            $pendaftaran['status_periksa'] = 'Sedang Diperiksa';
        }

        $obat = $this->db->table('tbl_obat')->orderBy('nama_obat', 'ASC')->get()->getResultArray();

        return view('dokter/input_rekam_medis', [
            'dokter' => $dokter,
            'data' => $pendaftaran,
            'obat' => $obat,
        ]);
    }

    /**
     * Simpan Rekam Medis (POST)
     */
    public function simpanRekamMedis()
    {
        if (!$this->checkDokterSession()) {
            return redirect()->to(base_url('login'));
        }

        $no_rawat   = $this->request->getPost('no_rawat');
        $diagnosa   = $this->request->getPost('diagnosa');
        $tindakan   = $this->request->getPost('tindakan');

        // Structured prescription arrays
        $resep_obat_ids = $this->request->getPost('resep_obat_ids');
        $resep_dosis    = $this->request->getPost('resep_dosis');
        $resep_jumlah   = $this->request->getPost('resep_jumlah');
        $resep_keterangan = $this->request->getPost('resep_keterangan');

        if (empty($no_rawat) || empty($diagnosa)) {
            session()->setFlashdata('error', 'No. Rawat dan Diagnosa wajib diisi.');
            return redirect()->to(base_url('dokter/rekam-medis/' . $no_rawat));
        }

        // 1. Cek kecukupan stok obat terlebih dahulu (Fail-Fast)
        if (!empty($resep_obat_ids) && is_array($resep_obat_ids)) {
            foreach ($resep_obat_ids as $index => $idObat) {
                if (empty($idObat)) continue;

                $jumlah = (int)($resep_jumlah[$index] ?? 0);
                $obatDetail = $this->db->table('tbl_obat')->where('id_obat', $idObat)->get()->getRowArray();
                
                if (!$obatDetail) {
                    session()->setFlashdata('error', 'Gagal: Data obat tidak ditemukan di database.');
                    return redirect()->to(base_url('dokter/rekam-medis/' . $no_rawat));
                }

                if ($obatDetail['stok'] < $jumlah) {
                    session()->setFlashdata('error', 'Gagal: Stok obat "' . esc($obatDetail['nama_obat']) . '" tidak mencukupi (Tersedia: ' . $obatDetail['stok'] . ', Dibutuhkan: ' . $jumlah . ').');
                    return redirect()->to(base_url('dokter/rekam-medis/' . $no_rawat));
                }
            }
        }

        $this->db->transStart();

        // 1. Compile resep_obat text for tbl_rekam_medis (backward compatibility)
        $compiledResepText = '';
        $prescriptionItems = [];

        if (!empty($resep_obat_ids) && is_array($resep_obat_ids)) {
            foreach ($resep_obat_ids as $index => $idObat) {
                if (empty($idObat)) continue;

                $obatDetail = $this->db->table('tbl_obat')->where('id_obat', $idObat)->get()->getRowArray();
                if ($obatDetail) {
                    $dosis = $resep_dosis[$index] ?? '';
                    $jumlah = (int)($resep_jumlah[$index] ?? 0);
                    $keterangan = $resep_keterangan[$index] ?? '';

                    $itemText = esc($obatDetail['nama_obat']) . " — Dosis: " . esc($dosis) . " — Jumlah: " . $jumlah . " " . esc($obatDetail['satuan'] ?? 'pcs');
                    if (!empty($keterangan)) {
                        $itemText .= " (" . esc($keterangan) . ")";
                    }
                    $prescriptionItems[] = $itemText;
                }
            }
        }
        $compiledResepText = implode("\n", $prescriptionItems);

        // Append legacy text if provided (e.g. Catatan resep tambahan)
        $catatanTambahan = $this->request->getPost('catatan_resep_tambahan');
        if (!empty($catatanTambahan)) {
            if (!empty($compiledResepText)) {
                $compiledResepText .= "\n\nCatatan Tambahan:\n" . $catatanTambahan;
            } else {
                $compiledResepText = "Catatan Tambahan:\n" . $catatanTambahan;
            }
        }

        // 2. INSERT rekam medis
        $this->db->table('tbl_rekam_medis')->insert([
            'no_rawat'    => $no_rawat,
            'tgl_periksa' => date('Y-m-d H:i:s'),
            'diagnosa'    => $diagnosa,
            'tindakan'    => $tindakan,
            'resep_obat'  => $compiledResepText ?: null,
        ]);

        $id_rm = $this->db->insertID();

        // 3. INSERT into tbl_resep & UPDATE tbl_obat stocks
        if (!empty($resep_obat_ids) && is_array($resep_obat_ids)) {
            foreach ($resep_obat_ids as $index => $idObat) {
                if (empty($idObat)) continue;

                $dosis = $resep_dosis[$index] ?? '';
                $jumlah = (int)($resep_jumlah[$index] ?? 0);
                $keterangan = $resep_keterangan[$index] ?? '';

                // Insert structured prescription record
                $this->db->table('tbl_resep')->insert([
                    'id_rm'      => $id_rm,
                    'id_obat'    => $idObat,
                    'dosis'      => $dosis,
                    'jumlah'     => $jumlah,
                    'keterangan' => $keterangan ?: null
                ]);

                // Update stock in tbl_obat
                $this->db->query("UPDATE tbl_obat SET stok = stok - ? WHERE id_obat = ?", [$jumlah, $idObat]);
            }
        }

        // 4. UPDATE status pendaftaran
        $is_rawat_inap = $this->request->getPost('is_rawat_inap');
        $new_status = ((int)$is_rawat_inap === 1) ? 'Rawat Inap' : 'Selesai';

        $this->db->table('tbl_pendaftaran')
            ->where('no_rawat', $no_rawat)
            ->update(['status_periksa' => $new_status]);

        // 5. Hitung total biaya & INSERT otomatis ke tbl_tagihan
        $totalBiaya = 0;
        if (!empty($resep_obat_ids) && is_array($resep_obat_ids)) {
            foreach ($resep_obat_ids as $index => $idObat) {
                if (empty($idObat)) continue;
                $jumlah = (int)($resep_jumlah[$index] ?? 0);
                $obatPrice = $this->db->table('tbl_obat')
                    ->select('harga')
                    ->where('id_obat', $idObat)
                    ->get()->getRowArray();
                if ($obatPrice) {
                    $totalBiaya += (float)$obatPrice['harga'] * $jumlah;
                }
            }
        }

        // Cek apakah tagihan untuk no_rawat ini sudah ada (dari dokter simpan ulang)
        $existingTagihan = $this->db->table('tbl_tagihan')
            ->where('no_rawat', $no_rawat)
            ->countAllResults();

        // Ambil tarif konsultasi berdasarkan poli dokter
        $dokterInfo = $this->db->table('tbl_dokter')->where('id_user', session()->get('id_user'))->get()->getRowArray();
        $biayaKonsultasi = 0;
        if ($dokterInfo) {
            $tarif = $this->db->table('tbl_tarif_konsultasi')
                ->where('id_poli', $dokterInfo['id_poli'])
                ->where('is_active', 1)
                ->limit(1)
                ->get()->getRowArray();
            if ($tarif) {
                $biayaKonsultasi = (float)$tarif['harga'];
            }
        }

        if ($existingTagihan === 0) {
            $this->db->table('tbl_tagihan')->insert([
                'no_rawat'          => $no_rawat,
                'biaya_konsultasi'  => $biayaKonsultasi,
                'biaya_obat'        => $totalBiaya,
                'biaya_kamar'       => 0,
                'total_biaya'       => $biayaKonsultasi + $totalBiaya,
                'jenis_kunjungan'   => 'Rawat Jalan',
                'jenis_bayar'       => 'Umum',
                'status_bayar'      => 'Belum Lunas',
                'tgl_bayar'         => null,
            ]);
        } else {
            // Update biaya_konsultasi pada tagihan yang sudah ada
            $existingTagihanRow = $this->db->table('tbl_tagihan')->where('no_rawat', $no_rawat)->get()->getRowArray();
            if ($existingTagihanRow && $biayaKonsultasi > 0) {
                $this->db->table('tbl_tagihan')->where('no_rawat', $no_rawat)->update([
                    'biaya_konsultasi' => $biayaKonsultasi,
                    'total_biaya'      => $biayaKonsultasi + (float)$existingTagihanRow['biaya_obat'] + (float)$existingTagihanRow['biaya_kamar'],
                ]);
            }
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal menyimpan rekam medis.');
            return redirect()->to(base_url('dokter/rekam-medis/' . $no_rawat));
        }

        if ($new_status === 'Rawat Inap') {
            session()->setFlashdata('success', 'Pasien No. Rawat: ' . $no_rawat . ' berhasil direkomendasikan rawat inap dan rekam medis telah disimpan.');
            return redirect()->to(base_url('dokter/antrian'));
        } else {
            session()->setFlashdata('success', 'Rekam medis dan resep berhasil disimpan untuk No. Rawat: ' . $no_rawat);
            return redirect()->to(base_url('dokter/dashboard'));
        }
    }

    /**
     * Rekomendasikan Rawat Inap - ubah status_periksa menjadi 'Rawat Inap'
     */
    public function rekomendasiRawatInap($no_rawat = null)
    {
        if (!$this->checkDokterSession()) {
            return redirect()->to(base_url('login'));
        }

        if (empty($no_rawat)) {
            session()->setFlashdata('error', 'No. Rawat tidak valid.');
            return redirect()->back();
        }

        $dokter = $this->getDokterData();
        $pendaftaran = $this->db->table('tbl_pendaftaran')->where('no_rawat', $no_rawat)->get()->getRowArray();

        if (!$pendaftaran || (int)$pendaftaran['id_dokter'] !== (int)$dokter['id_dokter']) {
            session()->setFlashdata('error', 'Akses ditolak atau data tidak ditemukan.');
            return redirect()->back();
        }

        if (in_array($pendaftaran['status_periksa'], ['Selesai', 'Batal', 'Rawat Inap'])) {
            session()->setFlashdata('error', 'Status tidak dapat diubah.');
            return redirect()->back();
        }

        $this->db->table('tbl_pendaftaran')
            ->where('no_rawat', $no_rawat)
            ->update(['status_periksa' => 'Rawat Inap']);

        session()->setFlashdata('success', 'Pasien ' . esc($no_rawat) . ' direkomendasikan untuk rawat inap.');
        return redirect()->to(base_url('dokter/antrian'));
    }
    public function antrian()
    {
        if (!$this->checkDokterSession()) {
            return redirect()->to(base_url('login'));
        }

        $dokter = $this->getDokterData();
        if (!$dokter) {
            session()->setFlashdata('error', 'Data dokter tidak ditemukan.');
            return redirect()->to(base_url('login'));
        }

        // Fetch active queue for today (Belum Diperiksa & Sedang Diperiksa)
        $antrian = $this->db->table('tbl_pendaftaran p')
            ->select('p.no_rawat, p.no_rm, p.tgl_daftar, ps.nama_pasien, ps.tgl_lahir, ps.jk, p.jam_kunjungan, p.slot_waktu, p.keluhan_awal, p.status_periksa')
            ->join('tbl_pasien ps', 'p.no_rm = ps.no_rm')
            ->where('p.id_dokter', $dokter['id_dokter'])
            ->where('p.tgl_daftar', date('Y-m-d'))
            ->whereIn('p.status_periksa', ['Belum Diperiksa', 'Sedang Diperiksa'])
            ->orderBy('p.slot_waktu', 'ASC')
            ->get()
            ->getResultArray();

        $totalHariIni = count($antrian);

        return view('dokter/antrian', compact('dokter', 'antrian', 'totalHariIni'));
    }

    /**
     * Panggil Pasien - Hanya mengubah status menjadi 'Sedang Diperiksa'
     */
    public function panggilPasien($no_rawat = null)
    {
        if (!$this->checkDokterSession()) {
            return redirect()->to(base_url('login'));
        }

        $dokter = $this->getDokterData();
        if (!$dokter) {
            return redirect()->to(base_url('login'));
        }

        if (empty($no_rawat)) {
            session()->setFlashdata('error', 'No. Rawat tidak valid.');
            return redirect()->back();
        }

        // Pastikan pendaftaran ini memang milik dokter yang login
        $pendaftaran = $this->db->table('tbl_pendaftaran')
            ->where('no_rawat', $no_rawat)
            ->get()
            ->getRowArray();

        if (!$pendaftaran || (int)$pendaftaran['id_dokter'] !== (int)$dokter['id_dokter']) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses ke data ini.');
            return redirect()->back();
        }

        // Cek apakah sudah waktunya periksa (tanggal hari ini/masa lalu dan jam praktik dokter)
        if (!$this->isAppointmentTime($pendaftaran, $dokter)) {
            $tglJanji = date('d M Y', strtotime($pendaftaran['tgl_daftar']));
            $waktuMulai = !empty($dokter['jam_mulai']) ? substr($dokter['jam_mulai'], 0, 5) : '08:00';
            
            $bookingDate = new \DateTime($pendaftaran['tgl_daftar'] . ' 00:00:00');
            $todayDate = new \DateTime(date('Y-m-d') . ' 00:00:00');
            
            if ($bookingDate > $todayDate) {
                session()->setFlashdata('error', 'Belum memasuki tanggal janji temu (Mulai tanggal ' . $tglJanji . ').');
            } else {
                session()->setFlashdata('error', 'Belum memasuki jam praktik dokter hari ini (Jam praktik mulai pukul ' . $waktuMulai . ' WIB).');
            }
            return redirect()->back();
        }

        // Ubah status menjadi 'Sedang Diperiksa'
        $this->db->table('tbl_pendaftaran')
            ->where('no_rawat', $no_rawat)
            ->update(['status_periksa' => 'Sedang Diperiksa']);

        session()->setFlashdata('success', 'Pasien berhasil dipanggil.');
        return redirect()->back();
    }

    /**
     * Pasien Tidak Hadir - Mengubah status menjadi 'Tidak Hadir'
     */
    public function tidakHadirPasien($no_rawat = null)
    {
        if (!$this->checkDokterSession()) {
            return redirect()->to(base_url('login'));
        }

        $dokter = $this->getDokterData();
        if (!$dokter) {
            return redirect()->to(base_url('login'));
        }

        if (empty($no_rawat)) {
            session()->setFlashdata('error', 'No. Rawat tidak valid.');
            return redirect()->back();
        }

        // Pastikan pendaftaran ini memang milik dokter yang login
        $pendaftaran = $this->db->table('tbl_pendaftaran')
            ->where('no_rawat', $no_rawat)
            ->get()
            ->getRowArray();

        if (!$pendaftaran || (int)$pendaftaran['id_dokter'] !== (int)$dokter['id_dokter']) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses ke data ini.');
            return redirect()->back();
        }

        // Ubah status menjadi 'Tidak Hadir'
        $this->db->table('tbl_pendaftaran')
            ->where('no_rawat', $no_rawat)
            ->update(['status_periksa' => 'Tidak Hadir']);

        session()->setFlashdata('success', 'Pasien berhasil ditandai sebagai Tidak Hadir.');
        return redirect()->back();
    }

    /**
     * Halaman Pengaturan Akun Dokter
     */
    public function settings()
    {
        if (!$this->checkDokterSession()) {
            return redirect()->to(base_url('login'));
        }

        $dokter = $this->getDokterData();
        if (!$dokter) {
            session()->setFlashdata('error', 'Data dokter tidak ditemukan.');
            return redirect()->to(base_url('login'));
        }

        $user = $this->db->table('tbl_user')
            ->where('id_user', session()->get('id_user'))
            ->get()
            ->getRowArray();

        return view('dokter/settings', compact('dokter', 'user'));
    }

    /**
     * AJAX: Update Pengaturan Dokter (termasuk jam praktik)
     */
    public function updateSettings()
    {
        if (!$this->checkDokterSession()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Sesi berakhir, silakan login kembali.']);
        }

        $id_user = session()->get('id_user');
        $nama_dokter = $this->request->getPost('nama_dokter');
        $no_telp = $this->request->getPost('no_telp');
        $jam_mulai = $this->request->getPost('jam_mulai');
        $jam_selesai = $this->request->getPost('jam_selesai');
        $password = $this->request->getPost('password');

        if (empty($nama_dokter)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Nama lengkap dokter wajib diisi.']);
        }
        if (empty($jam_mulai) || empty($jam_selesai)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Jam mulai dan jam selesai praktik wajib diisi.']);
        }

        $this->db->transStart();

        // 1. Update tbl_dokter
        $this->db->table('tbl_dokter')
            ->where('id_user', $id_user)
            ->update([
                'nama_dokter' => $nama_dokter,
                'no_telp' => $no_telp,
                'jam_mulai' => $jam_mulai,
                'jam_selesai' => $jam_selesai
            ]);

        // 2. Update tbl_user
        $userUpdate = ['nama_lengkap' => $nama_dokter];
        if (!empty($password)) {
            $userUpdate['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->db->table('tbl_user')
            ->where('id_user', $id_user)
            ->update($userUpdate);

        $this->db->transComplete();

        if ($this->db->transStatus() === FALSE) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menyimpan perubahan.']);
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Pengaturan berhasil disimpan.']);
    }
}
