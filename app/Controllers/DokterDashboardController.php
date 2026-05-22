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
        return $this->db->table('tbl_dokter')
            ->where('id_user', session()->get('id_user'))
            ->get()
            ->getRowArray();
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
            ->select('p.no_rawat, p.no_rm, ps.nama_pasien, p.jam_kunjungan, p.slot_waktu, p.keluhan_awal, p.status_periksa')
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
            ->select('p.*, ps.nama_pasien, po.nama_poli')
            ->join('tbl_pasien ps', 'p.no_rm = ps.no_rm')
            ->join('tbl_dokter d', 'p.id_dokter = d.id_dokter')
            ->join('tbl_poli po', 'd.id_poli = po.id_poli')
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

        // Auto-update status ke Sedang Diperiksa
        if ($pendaftaran['status_periksa'] === 'Belum Diperiksa') {
            $this->db->table('tbl_pendaftaran')
                ->where('no_rawat', $no_rawat)
                ->update(['status_periksa' => 'Sedang Diperiksa']);
            $pendaftaran['status_periksa'] = 'Sedang Diperiksa';
        }

        return view('dokter/input_rekam_medis', [
            'dokter' => $dokter,
            'data' => $pendaftaran,
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
        $resep_obat = $this->request->getPost('resep_obat');

        if (empty($no_rawat) || empty($diagnosa)) {
            session()->setFlashdata('error', 'No. Rawat dan Diagnosa wajib diisi.');
            return redirect()->to(base_url('dokter/rekam-medis/' . $no_rawat));
        }

        $this->db->transStart();

        // INSERT rekam medis
        $this->db->table('tbl_rekam_medis')->insert([
            'no_rawat'    => $no_rawat,
            'tgl_periksa' => date('Y-m-d H:i:s'),
            'diagnosa'    => $diagnosa,
            'tindakan'    => $tindakan,
            'resep_obat'  => $resep_obat,
        ]);

        // UPDATE status pendaftaran
        $this->db->table('tbl_pendaftaran')
            ->where('no_rawat', $no_rawat)
            ->update(['status_periksa' => 'Selesai']);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal menyimpan rekam medis.');
            return redirect()->to(base_url('dokter/rekam-medis/' . $no_rawat));
        }

        session()->setFlashdata('success', 'Rekam medis berhasil disimpan untuk No. Rawat: ' . $no_rawat);
        return redirect()->to(base_url('dokter/dashboard'));
    }
}
