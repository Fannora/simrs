<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class PasienController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    /**
     * Helper: Cek apakah user sudah login sebagai Pasien
     */
    private function checkPasienSession()
    {
        if (!session()->get('id_user') || session()->get('level_id') !== 'Pasien') {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu.');
            return false;
        }
        return true;
    }

    /**
     * 1. Dashboard Pasien
     */
    public function dashboard()
    {
        if (!$this->checkPasienSession()) {
            return redirect()->to(base_url('login'));
        }

        $id_user = session()->get('id_user');

        // Ambil data pasien
        $pasien = $this->db->table('tbl_pasien')
            ->where('id_user', $id_user)
            ->get()
            ->getRowArray();

        if (!$pasien) {
            session()->setFlashdata('error', 'Data pasien tidak ditemukan.');
            return redirect()->to(base_url('login'));
        }

        $no_rm = $pasien['no_rm'];

        // Simpan no_rm ke session jika belum ada
        if (!session()->get('no_rm')) {
            session()->set('no_rm', $no_rm);
        }
        if (!session()->get('nama_lengkap')) {
            session()->set('nama_lengkap', $pasien['nama_pasien']);
        }

        // Total kunjungan
        $totalKunjungan = $this->db->table('tbl_pendaftaran')
            ->where('no_rm', $no_rm)
            ->countAllResults();

        // Kunjungan aktif (belum/sedang diperiksa)
        $kunjunganAktif = $this->db->table('tbl_pendaftaran')
            ->where('no_rm', $no_rm)
            ->whereIn('status_periksa', ['Belum Diperiksa', 'Sedang Diperiksa'])
            ->countAllResults();

        // Rekam medis tersedia
        $rekamMedisTersedia = $this->db->table('tbl_rekam_medis rm')
            ->join('tbl_pendaftaran p', 'rm.no_rawat = p.no_rawat')
            ->where('p.no_rm', $no_rm)
            ->countAllResults();

        // Kunjungan terakhir
        $kunjunganTerakhir = $this->db->table('tbl_pendaftaran p')
            ->select('p.*, d.nama_dokter, po.nama_poli')
            ->join('tbl_dokter d', 'p.id_dokter = d.id_dokter')
            ->join('tbl_poli po', 'd.id_poli = po.id_poli')
            ->where('p.no_rm', $no_rm)
            ->orderBy('p.tgl_daftar', 'DESC')
            ->orderBy('p.jam_kunjungan', 'DESC')
            ->limit(1)
            ->get()
            ->getRowArray();

        return view('pasien/dashboard', compact(
            'pasien',
            'totalKunjungan',
            'kunjunganAktif',
            'rekamMedisTersedia',
            'kunjunganTerakhir'
        ));
    }

    /**
     * 2. Halaman Booking
     */
    public function booking()
    {
        if (!$this->checkPasienSession()) {
            return redirect()->to(base_url('login'));
        }

        $poli = $this->db->table('tbl_poli')
            ->orderBy('nama_poli', 'ASC')
            ->get()
            ->getResultArray();

        return view('pasien/booking', ['poli' => $poli]);
    }

    /**
     * 3. AJAX: Get Dokter by Poli
     */
    public function getDokterByPoli()
    {
        $id_poli = $this->request->getGet('id_poli');

        $dokter = $this->db->table('tbl_dokter d')
            ->select('d.id_dokter, d.nama_dokter, d.jam_mulai, d.jam_selesai, d.kuota_per_slot, p.nama_poli')
            ->join('tbl_poli p', 'd.id_poli = p.id_poli')
            ->where('d.id_poli', $id_poli)
            ->get()
            ->getResultArray();

        return $this->response->setJSON($dokter);
    }

    /**
     * 4. AJAX: Get Slot Waktu
     */
    public function getSlotWaktu()
    {
        $id_dokter = $this->request->getGet('id_dokter');
        $tanggal   = $this->request->getGet('tanggal');

        // Validasi tanggal
        $dateObj = new \DateTime($tanggal);
        $today   = new \DateTime('today');

        if ($dateObj <= $today) {
            return $this->response->setJSON(['error' => 'Tanggal harus minimal besok.']);
        }
        if ((int) $dateObj->format('w') === 0) {
            return $this->response->setJSON(['error' => 'Booking tidak tersedia pada hari Minggu.']);
        }

        // Ambil data dokter
        $dokter = $this->db->table('tbl_dokter')
            ->where('id_dokter', $id_dokter)
            ->get()
            ->getRowArray();

        if (!$dokter) {
            return $this->response->setJSON(['error' => 'Dokter tidak ditemukan.']);
        }

        $jamMulai     = (int) substr($dokter['jam_mulai'], 0, 2);
        $jamSelesai   = (int) substr($dokter['jam_selesai'], 0, 2);
        $kuotaPerSlot = (int) ($dokter['kuota_per_slot'] ?? 10);

        // Generate slot per jam
        $slots = [];
        for ($h = $jamMulai; $h <= $jamSelesai; $h++) {
            $slotLabel = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00';

            // Cek jumlah terisi dari tbl_slot_booking
            $slotData = $this->db->table('tbl_slot_booking')
                ->where('id_dokter', $id_dokter)
                ->where('tgl_booking', $tanggal)
                ->where('slot_waktu', $slotLabel)
                ->get()
                ->getRowArray();

            $jumlahTerisi = $slotData ? (int) $slotData['jumlah_terisi'] : 0;
            $sisa         = $kuotaPerSlot - $jumlahTerisi;

            $status      = 'tersedia';
            $hampirPenuh = false;

            if ($jumlahTerisi >= $kuotaPerSlot) {
                $status = 'penuh';
                $sisa   = 0;
            } else {
                if ($sisa <= 2) {
                    $hampirPenuh = true;
                }
            }

            $slots[] = [
                'slot'         => $slotLabel,
                'status'       => $status,
                'sisa'         => $sisa,
                'hampir_penuh' => $hampirPenuh,
            ];
        }

        return $this->response->setJSON($slots);
    }

    /**
     * 5. Simpan Booking (POST)
     */
    public function storeBooking()
    {
        if (!$this->checkPasienSession()) {
            return redirect()->to(base_url('login'));
        }

        $no_rm        = session()->get('no_rm');
        $id_dokter    = $this->request->getPost('id_dokter');
        $id_poli      = $this->request->getPost('id_poli');
        $tgl_daftar   = $this->request->getPost('tgl_daftar');
        $slot_waktu   = $this->request->getPost('slot_waktu');
        $keluhan_awal = $this->request->getPost('keluhan_awal');

        // Validasi input wajib
        if (empty($id_dokter) || empty($id_poli) || empty($tgl_daftar) || empty($slot_waktu) || empty($keluhan_awal)) {
            session()->setFlashdata('error', 'Semua field wajib diisi.');
            return redirect()->to(base_url('pasien/booking'));
        }

        // Validasi tanggal
        $dateObj = new \DateTime($tgl_daftar);
        $today   = new \DateTime('today');

        if ($dateObj <= $today) {
            session()->setFlashdata('error', 'Tanggal booking harus minimal besok.');
            return redirect()->to(base_url('pasien/booking'));
        }
        if ((int) $dateObj->format('w') === 0) {
            session()->setFlashdata('error', 'Booking tidak tersedia pada hari Minggu.');
            return redirect()->to(base_url('pasien/booking'));
        }

        // Maksimal 30 hari ke depan
        $maxDate = new \DateTime('+30 days');
        if ($dateObj > $maxDate) {
            session()->setFlashdata('error', 'Booking maksimal 30 hari ke depan.');
            return redirect()->to(base_url('pasien/booking'));
        }

        // Ambil kuota dokter
        $dokter = $this->db->table('tbl_dokter')
            ->where('id_dokter', $id_dokter)
            ->get()
            ->getRowArray();

        if (!$dokter) {
            session()->setFlashdata('error', 'Dokter tidak ditemukan.');
            return redirect()->to(base_url('pasien/booking'));
        }

        $kuotaPerSlot = (int) ($dokter['kuota_per_slot'] ?? 10);

        // ============================
        // TRANSAKSI DATABASE
        // ============================
        $this->db->transStart();

        // Cek apakah pasien sudah punya booking aktif di tanggal yang sama
        $existingBooking = $this->db->table('tbl_pendaftaran')
            ->where('no_rm', $no_rm)
            ->where('tgl_daftar', $tgl_daftar)
            ->where('status_periksa !=', 'Batal')
            ->countAllResults(false);

        if ($existingBooking > 0) {
            $this->db->transRollback();
            session()->setFlashdata('error', 'Anda sudah memiliki booking pada tanggal tersebut.');
            return redirect()->to(base_url('pasien/booking'));
        }

        // Cek slot masih tersedia (SELECT FOR UPDATE)
        $slotData = $this->db->query(
            "SELECT jumlah_terisi FROM tbl_slot_booking WHERE id_dokter = ? AND tgl_booking = ? AND slot_waktu = ? FOR UPDATE",
            [$id_dokter, $tgl_daftar, $slot_waktu]
        )->getRowArray();

        $jumlahTerisi = $slotData ? (int) $slotData['jumlah_terisi'] : 0;

        if ($jumlahTerisi >= $kuotaPerSlot) {
            $this->db->transRollback();
            session()->setFlashdata('error', 'Slot waktu ini sudah penuh, silakan pilih slot lain.');
            return redirect()->to(base_url('pasien/booking'));
        }

        // Generate no_rawat: RW-YYYYMMDD-XXX menggunakan MAX()
        $tglFormatted = str_replace('-', '', $tgl_daftar);
        $prefix = 'RW-' . $tglFormatted . '-';
        
        $latestBooking = $this->db->table('tbl_pendaftaran')
            ->selectMax('no_rawat')
            ->like('no_rawat', $prefix, 'after')
            ->get()
            ->getRowArray();

        $nextNum = 1;
        if ($latestBooking && !empty($latestBooking['no_rawat'])) {
            $num = (int) str_replace($prefix, '', $latestBooking['no_rawat']);
            $nextNum = $num + 1;
        }
        $noUrut  = str_pad($nextNum, 3, '0', STR_PAD_LEFT);
        $noRawat = $prefix . $noUrut;

        // INSERT pendaftaran
        $this->db->table('tbl_pendaftaran')->insert([
            'no_rawat'       => $noRawat,
            'no_rm'          => $no_rm,
            'id_dokter'      => $id_dokter,
            'tgl_daftar'     => $tgl_daftar,
            'jam_kunjungan'  => $slot_waktu . ':00',
            'keluhan_awal'   => $keluhan_awal,
            'slot_waktu'     => $slot_waktu,
            'status_periksa' => 'Belum Diperiksa',
        ]);

        // INSERT / UPDATE slot booking
        $this->db->query(
            "INSERT INTO tbl_slot_booking (id_dokter, tgl_booking, slot_waktu, jumlah_terisi)
             VALUES (?, ?, ?, 1)
             ON DUPLICATE KEY UPDATE jumlah_terisi = jumlah_terisi + 1",
            [$id_dokter, $tgl_daftar, $slot_waktu]
        );

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            session()->setFlashdata('error', 'Terjadi kesalahan saat menyimpan booking. Silakan coba lagi.');
            return redirect()->to(base_url('pasien/booking'));
        }

        session()->setFlashdata('success', 'Booking berhasil! No. Rawat: ' . $noRawat);
        return redirect()->to(base_url('pasien/riwayat'));
    }

    /**
     * 6. Riwayat Kunjungan
     */
    public function riwayat()
    {
        if (!$this->checkPasienSession()) {
            return redirect()->to(base_url('login'));
        }

        $no_rm = session()->get('no_rm');

        $kunjungan = $this->db->table('tbl_pendaftaran p')
            ->select('p.*, d.nama_dokter, po.nama_poli, po.gedung')
            ->join('tbl_dokter d', 'p.id_dokter = d.id_dokter')
            ->join('tbl_poli po', 'd.id_poli = po.id_poli')
            ->where('p.no_rm', $no_rm)
            ->orderBy('p.tgl_daftar', 'DESC')
            ->orderBy('p.slot_waktu', 'DESC')
            ->get()
            ->getResultArray();

        $rekamMedis = $this->db->table('tbl_rekam_medis rm')
            ->select('rm.*, p.tgl_daftar, d.nama_dokter, po.nama_poli')
            ->join('tbl_pendaftaran p', 'rm.no_rawat = p.no_rawat')
            ->join('tbl_dokter d', 'p.id_dokter = d.id_dokter')
            ->join('tbl_poli po', 'd.id_poli = po.id_poli')
            ->where('p.no_rm', $no_rm)
            ->orderBy('rm.tgl_periksa', 'DESC')
            ->get()
            ->getResultArray();

        return view('pasien/riwayat', [
            'kunjungan' => $kunjungan,
            'rekamMedis' => $rekamMedis
        ]);
    }



    /**
     * 8. Batalkan Booking
     */
    public function batalBooking($no_rawat = null)
    {
        if (!$this->checkPasienSession()) {
            return redirect()->to(base_url('login'));
        }

        $no_rm = session()->get('no_rm');

        if (empty($no_rawat)) {
            session()->setFlashdata('error', 'No. Rawat tidak valid.');
            return redirect()->to(base_url('pasien/riwayat'));
        }

        // Verifikasi booking milik pasien ini
        $booking = $this->db->table('tbl_pendaftaran')
            ->where('no_rawat', $no_rawat)
            ->where('no_rm', $no_rm)
            ->get()
            ->getRowArray();

        if (!$booking) {
            session()->setFlashdata('error', 'Booking tidak ditemukan.');
            return redirect()->to(base_url('pasien/riwayat'));
        }

        // Cek status harus Belum Diperiksa
        if ($booking['status_periksa'] !== 'Belum Diperiksa') {
            session()->setFlashdata('error', 'Hanya booking dengan status "Belum Diperiksa" yang dapat dibatalkan.');
            return redirect()->to(base_url('pasien/riwayat'));
        }

        // Update status jadi Batal
        $this->db->table('tbl_pendaftaran')
            ->where('no_rawat', $no_rawat)
            ->update(['status_periksa' => 'Batal']);

        // Kurangi jumlah slot terisi
        $slotWaktu = $booking['slot_waktu'] ?? substr($booking['jam_kunjungan'], 0, 5);
        $this->db->query(
            "UPDATE tbl_slot_booking SET jumlah_terisi = GREATEST(0, jumlah_terisi - 1)
             WHERE id_dokter = ? AND tgl_booking = ? AND slot_waktu = ?",
            [$booking['id_dokter'], $booking['tgl_daftar'], $slotWaktu]
        );

        session()->setFlashdata('success', 'Booking ' . $no_rawat . ' berhasil dibatalkan.');
        return redirect()->to(base_url('pasien/riwayat'));
    }

    /**
     * 9. Halaman Pengaturan
     */
    public function settings()
    {
        if (!$this->checkPasienSession()) {
            return redirect()->to(base_url('login'));
        }

        $id_user = session()->get('id_user');
        $pasien = $this->db->table('tbl_pasien')
            ->where('id_user', $id_user)
            ->get()
            ->getRowArray();

        $user = $this->db->table('tbl_user')
            ->where('id_user', $id_user)
            ->get()
            ->getRowArray();

        return view('pasien/settings', compact('pasien', 'user'));
    }

    /**
     * 10. Update Pengaturan (AJAX)
     */
    public function updateSettings()
    {
        if (!$this->checkPasienSession()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Session expired.']);
        }

        $id_user = session()->get('id_user');
        $nama_lengkap = $this->request->getPost('nama_lengkap');
        $password = $this->request->getPost('password');

        if (empty($nama_lengkap)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Nama lengkap wajib diisi.']);
        }

        $this->db->transStart();

        // Update tbl_pasien
        $this->db->table('tbl_pasien')
            ->where('id_user', $id_user)
            ->update(['nama_pasien' => $nama_lengkap]);

        // Update tbl_user
        $userUpdate = ['nama_lengkap' => $nama_lengkap];
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

        // Update session values
        session()->set('nama_lengkap', $nama_lengkap);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Pengaturan berhasil disimpan.']);
    }
}

