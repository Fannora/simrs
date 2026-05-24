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
            ->select('d.*, p.nama_poli, u.username')
            ->join('tbl_poli p', 'd.id_poli = p.id_poli')
            ->join('tbl_user u', 'd.id_user = u.id_user', 'left')
            ->orderBy('d.nama_dokter', 'ASC')
            ->get()->getResultArray();

        $poli = $this->db->table('tbl_poli')->orderBy('nama_poli')->get()->getResultArray();

        return view('admin/kelola_dokter', ['dokter' => $dokter, 'poli' => $poli]);
    }

    public function simpanDokter()
    {
        return $this->storeDokter();
    }

    public function storeDokter()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $namaDokter = $this->request->getPost('nama_dokter');
        $id_poli = $this->request->getPost('id_poli');
        $no_telp = $this->request->getPost('no_telp');
        $jam_mulai = $this->request->getPost('jam_mulai');
        $jam_selesai = $this->request->getPost('jam_selesai');
        $kuota_per_slot = $this->request->getPost('kuota_per_slot') ?: 5;
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Validasi input
        if (empty($namaDokter) || empty($id_poli) || empty($username) || empty($password)) {
            session()->setFlashdata('error', 'Semua field bertanda bintang (*) termasuk Username dan Password wajib diisi.');
            return redirect()->to(base_url('admin/dokter'))->withInput();
        }

        // Validasi username unik
        $existingUser = $this->db->table('tbl_user')->where('username', $username)->countAllResults();
        if ($existingUser > 0) {
            session()->setFlashdata('error', 'Username sudah terdaftar. Silakan gunakan username lain.');
            return redirect()->to(base_url('admin/dokter'))->withInput();
        }

        // Mulai transaksi
        $this->db->transStart();

        // 1. Insert ke tbl_user
        $this->db->table('tbl_user')->insert([
            'nama_lengkap' => $namaDokter,
            'username'     => $username,
            'password'     => password_hash($password, PASSWORD_DEFAULT),
            'level_id'     => 'Dokter'
        ]);

        $id_user = $this->db->insertID();

        // 2. Insert ke tbl_dokter dengan foreign key id_user
        $this->db->table('tbl_dokter')->insert([
            'nama_dokter'    => $namaDokter,
            'id_poli'        => $id_poli,
            'no_telp'        => $no_telp ?: null,
            'id_user'        => $id_user,
            'jam_mulai'      => $jam_mulai,
            'jam_selesai'    => $jam_selesai,
            'kuota_per_slot' => $kuota_per_slot
        ]);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal menambahkan data dokter.');
            return redirect()->to(base_url('admin/dokter'))->withInput();
        }

        session()->setFlashdata('success', 'Data dokter dan akun pengguna berhasil disimpan.');
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

    // ============================
    // KELOLA OBAT
    // ============================
    public function kelolaObat()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $obat = $this->db->table('tbl_obat')->orderBy('nama_obat', 'ASC')->get()->getResultArray();
        return view('admin/kelola_obat', ['obat' => $obat]);
    }

    public function simpanObat()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $this->db->table('tbl_obat')->insert([
            'nama_obat' => $this->request->getPost('nama_obat'),
            'satuan'    => $this->request->getPost('satuan'),
            'stok'      => $this->request->getPost('stok') ?: 0,
            'harga'     => $this->request->getPost('harga') ?: 0,
        ]);

        session()->setFlashdata('success', 'Obat baru berhasil ditambahkan.');
        return redirect()->to(base_url('admin/obat'));
    }

    public function editObat()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $this->db->table('tbl_obat')
            ->where('id_obat', $this->request->getPost('id_obat'))
            ->update([
                'nama_obat' => $this->request->getPost('nama_obat'),
                'satuan'    => $this->request->getPost('satuan'),
                'stok'      => $this->request->getPost('stok') ?: 0,
                'harga'     => $this->request->getPost('harga') ?: 0,
            ]);

        session()->setFlashdata('success', 'Data obat berhasil diubah.');
        return redirect()->to(base_url('admin/obat'));
    }

    public function hapusObat($id = null)
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $this->db->table('tbl_obat')->where('id_obat', $id)->delete();
        session()->setFlashdata('success', 'Data obat berhasil dihapus.');
        return redirect()->to(base_url('admin/obat'));
    }

    // ============================
    // KELOLA TAGIHAN
    // ============================
    public function kelolaTagihan()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        // Ambil semua tagihan
        $tagihan = $this->db->table('tbl_tagihan t')
            ->select('t.*, p.no_rm, p.tgl_daftar, ps.nama_pasien, d.nama_dokter, po.nama_poli')
            ->join('tbl_pendaftaran p', 't.no_rawat = p.no_rawat')
            ->join('tbl_pasien ps', 'p.no_rm = ps.no_rm')
            ->join('tbl_dokter d', 'p.id_dokter = d.id_dokter')
            ->join('tbl_poli po', 'd.id_poli = po.id_poli')
            ->orderBy('t.id_tagihan', 'DESC')
            ->get()->getResultArray();

        // Ambil kunjungan yang belum ada tagihannya untuk modal tambah
        $pendaftaranTanpaTagihan = $this->db->table('tbl_pendaftaran p')
            ->select('p.no_rawat, p.no_rm, p.tgl_daftar, ps.nama_pasien')
            ->join('tbl_pasien ps', 'p.no_rm = ps.no_rm')
            ->join('tbl_tagihan t', 'p.no_rawat = t.no_rawat', 'left')
            ->where('t.id_tagihan IS NULL')
            ->orderBy('p.tgl_daftar', 'DESC')
            ->get()->getResultArray();

        return view('admin/kelola_tagihan', [
            'tagihan' => $tagihan,
            'pendaftaranTanpaTagihan' => $pendaftaranTanpaTagihan
        ]);
    }

    public function simpanTagihan()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $status = $this->request->getPost('status_bayar');
        $tgl_bayar = $status === 'Lunas' ? date('Y-m-d H:i:s') : null;

        $this->db->table('tbl_tagihan')->insert([
            'no_rawat'     => $this->request->getPost('no_rawat'),
            'total_biaya'  => $this->request->getPost('total_biaya') ?: 0,
            'jenis_bayar'  => $this->request->getPost('jenis_bayar') ?: 'Umum',
            'status_bayar' => $status ?: 'Belum Lunas',
            'tgl_bayar'    => $tgl_bayar
        ]);

        session()->setFlashdata('success', 'Tagihan baru berhasil dibuat.');
        return redirect()->to(base_url('admin/tagihan'));
    }

    public function editTagihan()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $id = $this->request->getPost('id_tagihan');
        $status = $this->request->getPost('status_bayar');
        
        // Fetch current tagihan to see if status changed
        $current = $this->db->table('tbl_tagihan')->where('id_tagihan', $id)->get()->getRowArray();
        $tgl_bayar = $current['tgl_bayar'] ?? null;
        if ($status === 'Lunas' && ($current['status_bayar'] ?? '') !== 'Lunas') {
            $tgl_bayar = date('Y-m-d H:i:s');
        } elseif ($status === 'Belum Lunas') {
            $tgl_bayar = null;
        }

        $this->db->table('tbl_tagihan')
            ->where('id_tagihan', $id)
            ->update([
                'total_biaya'  => $this->request->getPost('total_biaya') ?: 0,
                'jenis_bayar'  => $this->request->getPost('jenis_bayar') ?: 'Umum',
                'status_bayar' => $status ?: 'Belum Lunas',
                'tgl_bayar'    => $tgl_bayar
            ]);

        session()->setFlashdata('success', 'Data tagihan berhasil diubah.');
        return redirect()->to(base_url('admin/tagihan'));
    }

    public function updateStatusTagihan()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $id = $this->request->getPost('id_tagihan');
        $current = $this->db->table('tbl_tagihan')->where('id_tagihan', $id)->get()->getRowArray();

        if ($current) {
            $newStatus = $current['status_bayar'] === 'Lunas' ? 'Belum Lunas' : 'Lunas';
            $tgl_bayar = $newStatus === 'Lunas' ? date('Y-m-d H:i:s') : null;

            $this->db->table('tbl_tagihan')
                ->where('id_tagihan', $id)
                ->update([
                    'status_bayar' => $newStatus,
                    'tgl_bayar'    => $tgl_bayar
                ]);

            session()->setFlashdata('success', 'Status pembayaran tagihan berhasil diubah menjadi ' . $newStatus . '.');
        } else {
            session()->setFlashdata('error', 'Data tagihan tidak ditemukan.');
        }

        return redirect()->to(base_url('admin/tagihan'));
    }

    public function hapusTagihan($id = null)
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $this->db->table('tbl_tagihan')->where('id_tagihan', $id)->delete();
        session()->setFlashdata('success', 'Data tagihan berhasil dihapus.');
        return redirect()->to(base_url('admin/tagihan'));
    }
}
