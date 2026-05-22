<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AdminController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    private function checkAdminSession()
    {
        if (!session()->get('id_user') || session()->get('level_id') !== 'Admin') {
            session()->setFlashdata('error', 'Silakan login sebagai Admin.');
            return false;
        }
        return true;
    }

    // ============================
    // DASHBOARD
    // ============================
    public function dashboard()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $totalDokter = $this->db->table('tbl_dokter')->countAllResults();
        $totalPasien = $this->db->table('tbl_pasien')->countAllResults();
        $totalPoli   = $this->db->table('tbl_poli')->countAllResults();

        $pendaftaranHariIni = $this->db->table('tbl_pendaftaran')
            ->where('tgl_daftar', date('Y-m-d'))
            ->countAllResults();

        $pendaftaranBulanIni = $this->db->table('tbl_pendaftaran')
            ->where('MONTH(tgl_daftar)', date('m'))
            ->where('YEAR(tgl_daftar)', date('Y'))
            ->countAllResults();

        $rekamMedisTerbaru = $this->db->table('tbl_rekam_medis rm')
            ->select('rm.*, p.no_rm, p.tgl_daftar, ps.nama_pasien, d.nama_dokter')
            ->join('tbl_pendaftaran p', 'rm.no_rawat = p.no_rawat')
            ->join('tbl_pasien ps', 'p.no_rm = ps.no_rm')
            ->join('tbl_dokter d', 'p.id_dokter = d.id_dokter')
            ->orderBy('rm.tgl_periksa', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $jadwalHariIni = $this->db->table('tbl_pendaftaran p')
            ->select('p.*, ps.nama_pasien, d.nama_dokter, po.nama_poli')
            ->join('tbl_pasien ps', 'p.no_rm = ps.no_rm')
            ->join('tbl_dokter d', 'p.id_dokter = d.id_dokter')
            ->join('tbl_poli po', 'd.id_poli = po.id_poli')
            ->where('p.tgl_daftar', date('Y-m-d'))
            ->orderBy('p.slot_waktu', 'ASC')
            ->limit(10)
            ->get()
            ->getResultArray();

        return view('admin/dashboard', compact(
            'totalDokter', 'totalPasien', 'totalPoli',
            'pendaftaranHariIni', 'pendaftaranBulanIni',
            'rekamMedisTerbaru', 'jadwalHariIni'
        ));
    }

    // ============================
    // KELOLA DOKTER
    // ============================
    public function kelolaDokter()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $dokter = $this->db->table('tbl_dokter d')
            ->select('d.*, p.nama_poli')
            ->join('tbl_poli p', 'd.id_poli = p.id_poli')
            ->orderBy('d.nama_dokter', 'ASC')
            ->get()->getResultArray();

        $poli = $this->db->table('tbl_poli')->orderBy('nama_poli')->get()->getResultArray();

        return view('admin/kelola_dokter', ['dokter' => $dokter, 'poli' => $poli]);
    }

    public function simpanDokter()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $this->db->table('tbl_dokter')->insert([
            'nama_dokter'   => $this->request->getPost('nama_dokter'),
            'id_poli'       => $this->request->getPost('id_poli'),
            'no_telp'       => $this->request->getPost('no_telp'),
            'jam_mulai'     => $this->request->getPost('jam_mulai'),
            'jam_selesai'   => $this->request->getPost('jam_selesai'),
            'kuota_per_slot' => $this->request->getPost('kuota_per_slot') ?: 5,
        ]);

        session()->setFlashdata('success', 'Data dokter berhasil ditambahkan.');
        return redirect()->to(base_url('admin/dokter'));
    }

    public function editDokter()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $this->db->table('tbl_dokter')
            ->where('id_dokter', $this->request->getPost('id_dokter'))
            ->update([
                'nama_dokter'   => $this->request->getPost('nama_dokter'),
                'id_poli'       => $this->request->getPost('id_poli'),
                'no_telp'       => $this->request->getPost('no_telp'),
                'jam_mulai'     => $this->request->getPost('jam_mulai'),
                'jam_selesai'   => $this->request->getPost('jam_selesai'),
                'kuota_per_slot' => $this->request->getPost('kuota_per_slot') ?: 5,
            ]);

        session()->setFlashdata('success', 'Data dokter berhasil diubah.');
        return redirect()->to(base_url('admin/dokter'));
    }

    public function hapusDokter($id = null)
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $this->db->table('tbl_dokter')->where('id_dokter', $id)->delete();
        session()->setFlashdata('success', 'Data dokter berhasil dihapus.');
        return redirect()->to(base_url('admin/dokter'));
    }

    // ============================
    // KELOLA POLI
    // ============================
    public function kelolaPoli()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $poli = $this->db->query(
            "SELECT p.*, (SELECT COUNT(*) FROM tbl_dokter d WHERE d.id_poli = p.id_poli) as jumlah_dokter FROM tbl_poli p ORDER BY p.nama_poli"
        )->getResultArray();

        return view('admin/kelola_poli', ['poli' => $poli]);
    }

    public function simpanPoli()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $this->db->table('tbl_poli')->insert([
            'nama_poli' => $this->request->getPost('nama_poli'),
            'gedung'    => $this->request->getPost('gedung'),
        ]);

        session()->setFlashdata('success', 'Data poli berhasil ditambahkan.');
        return redirect()->to(base_url('admin/poli'));
    }

    public function editPoli()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $this->db->table('tbl_poli')
            ->where('id_poli', $this->request->getPost('id_poli'))
            ->update([
                'nama_poli' => $this->request->getPost('nama_poli'),
                'gedung'    => $this->request->getPost('gedung'),
            ]);

        session()->setFlashdata('success', 'Data poli berhasil diubah.');
        return redirect()->to(base_url('admin/poli'));
    }

    public function hapusPoli($id = null)
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $this->db->table('tbl_poli')->where('id_poli', $id)->delete();
        session()->setFlashdata('success', 'Data poli berhasil dihapus.');
        return redirect()->to(base_url('admin/poli'));
    }

    // ============================
    // KELOLA PASIEN
    // ============================
    public function kelolaPasien()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $pasien = $this->db->table('tbl_pasien ps')
            ->select('ps.*, u.username')
            ->join('tbl_user u', 'ps.id_user = u.id_user', 'left')
            ->orderBy('ps.nama_pasien', 'ASC')
            ->get()->getResultArray();

        return view('admin/kelola_pasien', ['pasien' => $pasien]);
    }

    public function simpanPasien()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        // Generate No. RM
        $lastRm = $this->db->query("SELECT no_rm FROM tbl_pasien ORDER BY no_rm DESC LIMIT 1")->getRowArray();
        $noUrut = $lastRm ? (int) substr($lastRm['no_rm'], 3) + 1 : 1;
        $no_rm = 'RM-' . str_pad($noUrut, 5, '0', STR_PAD_LEFT);

        $this->db->table('tbl_pasien')->insert([
            'no_rm'       => $no_rm,
            'nik'         => $this->request->getPost('nik'),
            'nama_pasien' => $this->request->getPost('nama_pasien'),
            'tgl_lahir'   => $this->request->getPost('tgl_lahir'),
            'jk'          => $this->request->getPost('jk'),
            'alamat'      => $this->request->getPost('alamat'),
            'no_bpjs'     => $this->request->getPost('no_bpjs') ?: null,
        ]);

        session()->setFlashdata('success', 'Pasien berhasil ditambahkan. No. RM: ' . $no_rm);
        return redirect()->to(base_url('admin/pasien'));
    }

    public function editPasien()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $this->db->table('tbl_pasien')
            ->where('no_rm', $this->request->getPost('no_rm'))
            ->update([
                'nik'         => $this->request->getPost('nik'),
                'nama_pasien' => $this->request->getPost('nama_pasien'),
                'tgl_lahir'   => $this->request->getPost('tgl_lahir'),
                'jk'          => $this->request->getPost('jk'),
                'alamat'      => $this->request->getPost('alamat'),
                'no_bpjs'     => $this->request->getPost('no_bpjs') ?: null,
            ]);

        session()->setFlashdata('success', 'Data pasien berhasil diubah.');
        return redirect()->to(base_url('admin/pasien'));
    }

    public function hapusPasien($no_rm = null)
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $this->db->table('tbl_pasien')->where('no_rm', $no_rm)->delete();
        session()->setFlashdata('success', 'Data pasien berhasil dihapus.');
        return redirect()->to(base_url('admin/pasien'));
    }

    // ============================
    // LAPORAN
    // ============================
    public function laporan()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $laporanBulanan = $this->db->query(
            "SELECT MONTH(tgl_daftar) as bulan, COUNT(*) as total
             FROM tbl_pendaftaran
             WHERE YEAR(tgl_daftar) = YEAR(CURDATE())
             GROUP BY MONTH(tgl_daftar)
             ORDER BY bulan"
        )->getResultArray();

        $laporanPerPoli = $this->db->query(
            "SELECT po.nama_poli, COUNT(p.no_rawat) as total
             FROM tbl_pendaftaran p
             JOIN tbl_dokter d ON p.id_dokter = d.id_dokter
             JOIN tbl_poli po ON d.id_poli = po.id_poli
             GROUP BY po.id_poli, po.nama_poli
             ORDER BY total DESC"
        )->getResultArray();

        $laporanPerDokter = $this->db->query(
            "SELECT d.nama_dokter, po.nama_poli, COUNT(p.no_rawat) as total
             FROM tbl_pendaftaran p
             JOIN tbl_dokter d ON p.id_dokter = d.id_dokter
             JOIN tbl_poli po ON d.id_poli = po.id_poli
             GROUP BY d.id_dokter, d.nama_dokter, po.nama_poli
             ORDER BY total DESC"
        )->getResultArray();

        $pendaftaranBulanIni = $this->db->table('tbl_pendaftaran')
            ->where('MONTH(tgl_daftar)', date('m'))
            ->where('YEAR(tgl_daftar)', date('Y'))
            ->countAllResults();

        $pendaftaranBulanLalu = $this->db->table('tbl_pendaftaran')
            ->where('MONTH(tgl_daftar)', date('m', strtotime('-1 month')))
            ->where('YEAR(tgl_daftar)', date('Y', strtotime('-1 month')))
            ->countAllResults();

        return view('admin/laporan', compact(
            'laporanBulanan', 'laporanPerPoli', 'laporanPerDokter',
            'pendaftaranBulanIni', 'pendaftaranBulanLalu'
        ));
    }
}
