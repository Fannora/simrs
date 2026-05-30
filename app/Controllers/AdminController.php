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

        $kamarTersedia = $this->db->table('tbl_kamar')
            ->where('status', 'Tersedia')
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
            ->join('tbl_poli po', 'p.id_poli = po.id_poli')
            ->where('p.tgl_daftar', date('Y-m-d'))
            ->orderBy('p.slot_waktu', 'ASC')
            ->limit(10)
            ->get()
            ->getResultArray();

        return view('admin/dashboard', compact(
            'totalDokter', 'totalPasien', 'totalPoli',
            'kamarTersedia', 'pendaftaranBulanIni',
            'rekamMedisTerbaru', 'jadwalHariIni'
        ));
    }

    // ============================
    // KELOLA DOKTER
    // ============================
    public function kelolaDokter()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $cari = $this->request->getGet('cari');

        $builder = $this->db->table('tbl_dokter d')
            ->select('d.*, p.nama_poli, u.username')
            ->join('tbl_poli p', 'd.id_poli = p.id_poli')
            ->join('tbl_user u', 'd.id_user = u.id_user', 'left');

        if (!empty($cari)) {
            $builder->like('d.nama_dokter', $cari);
        }

        $dokter = $builder->orderBy('d.nama_dokter', 'ASC')
            ->get()->getResultArray();

        $poli = $this->db->table('tbl_poli')->orderBy('nama_poli')->get()->getResultArray();

        return view('admin/kelola_dokter', [
            'dokter' => $dokter,
            'poli' => $poli,
            'cari' => $cari
        ]);
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

        // Ambil data dokter untuk mendapatkan id_user terkait
        $dokter = $this->db->table('tbl_dokter')->where('id_dokter', $id)->get()->getRowArray();
        
        if (!$dokter) {
            session()->setFlashdata('error', 'Data dokter tidak ditemukan.');
            return redirect()->to(base_url('admin/dokter'));
        }

        $this->db->transStart();

        // 1. Hapus data dokter (Memicu ON DELETE CASCADE pada tbl_pendaftaran, tbl_rekam_medis, tbl_resep, tbl_tagihan, tbl_rawat_inap)
        $this->db->table('tbl_dokter')->where('id_dokter', $id)->delete();

        // 2. Hapus akun pengguna (tbl_user) jika ada
        if (!empty($dokter['id_user'])) {
            $this->db->table('tbl_user')->where('id_user', $dokter['id_user'])->delete();
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal menghapus data dokter.');
        } else {
            session()->setFlashdata('success', 'Data dokter dan akun pengguna berhasil dihapus.');
        }

        return redirect()->to(base_url('admin/dokter'));
    }

    // ============================
    // KELOLA POLI
    // ============================
    public function kelolaPoli()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $cari = $this->request->getGet('cari');

        if (!empty($cari)) {
            $poli = $this->db->query(
                "SELECT p.*, (SELECT COUNT(*) FROM tbl_dokter d WHERE d.id_poli = p.id_poli) as jumlah_dokter FROM tbl_poli p WHERE p.nama_poli LIKE ? ORDER BY p.nama_poli",
                ['%' . $cari . '%']
            )->getResultArray();
        } else {
            $poli = $this->db->query(
                "SELECT p.*, (SELECT COUNT(*) FROM tbl_dokter d WHERE d.id_poli = p.id_poli) as jumlah_dokter FROM tbl_poli p ORDER BY p.nama_poli"
            )->getResultArray();
        }

        return view('admin/kelola_poli', [
            'poli' => $poli,
            'cari' => $cari
        ]);
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

        $cari = $this->request->getGet('cari');

        $builder = $this->db->table('tbl_pasien ps')
            ->select('ps.*, u.username')
            ->join('tbl_user u', 'ps.id_user = u.id_user', 'left');

        if (!empty($cari)) {
            $builder->like('ps.nama_pasien', $cari);
        }

        $pasien = $builder->orderBy('ps.nama_pasien', 'ASC')
            ->get()->getResultArray();

        return view('admin/kelola_pasien', [
            'pasien' => $pasien,
            'cari' => $cari
        ]);
    }

    public function simpanPasien()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $no_bpjs = $this->request->getPost('no_bpjs');
        if (!empty($no_bpjs)) {
            if (strlen($no_bpjs) > 13 || !ctype_digit($no_bpjs)) {
                session()->setFlashdata('error', 'Nomor BPJS harus berupa angka dan maksimal 13 digit.');
                return redirect()->to(base_url('admin/pasien'));
            }
        }

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
            'no_bpjs'     => $no_bpjs ?: null,
        ]);

        session()->setFlashdata('success', 'Pasien berhasil ditambahkan. No. RM: ' . $no_rm);
        return redirect()->to(base_url('admin/pasien'));
    }

    public function editPasien()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $no_bpjs = $this->request->getPost('no_bpjs');
        if (!empty($no_bpjs)) {
            if (strlen($no_bpjs) > 13 || !ctype_digit($no_bpjs)) {
                session()->setFlashdata('error', 'Nomor BPJS harus berupa angka dan maksimal 13 digit.');
                return redirect()->to(base_url('admin/pasien'));
            }
        }

        $this->db->table('tbl_pasien')
            ->where('no_rm', $this->request->getPost('no_rm'))
            ->update([
                'nik'         => $this->request->getPost('nik'),
                'nama_pasien' => $this->request->getPost('nama_pasien'),
                'tgl_lahir'   => $this->request->getPost('tgl_lahir'),
                'jk'          => $this->request->getPost('jk'),
                'alamat'      => $this->request->getPost('alamat'),
                'no_bpjs'     => $no_bpjs ?: null,
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
    // LAPORAN KEUANGAN
    // ============================
    public function laporan()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        // Build filter from GET params
        $filter = [
            'tgl_dari'        => $this->request->getGet('tgl_dari'),
            'tgl_sampai'      => $this->request->getGet('tgl_sampai'),
            'id_poli'         => $this->request->getGet('id_poli'),
            'id_dokter'       => $this->request->getGet('id_dokter'),
            'jenis_bayar'     => $this->request->getGet('jenis_bayar') ?: ['Umum', 'BPJS', 'Asuransi'],
            'status_bayar'    => $this->request->getGet('status_bayar') ?: 'Semua',
            'jenis_kunjungan' => $this->request->getGet('jenis_kunjungan') ?: 'Semua',
        ];

        // Laporan keuangan dengan filter
        $laporanModel = new \App\Models\LaporanModel();
        $dataLaporan  = $laporanModel->getLaporan($filter);

        // Ringkasan statistik (always current month, tidak difilter)
        $totalPendapatanBulanIni = $laporanModel->getTotalPendapatanBulanIni();
        $pasienDilayani          = $laporanModel->getPasienDilayani();
        $tunggakan               = $laporanModel->getTunggakan();

        // Per-poli dari data yang terfilter
        $perPoliMap = [];
        foreach ($dataLaporan as $row) {
            $key = $row['nama_poli'];
            if (!isset($perPoliMap[$key])) {
                $perPoliMap[$key] = 0;
            }
            if ($row['status_bayar'] === 'Lunas') {
                $perPoliMap[$key] += (float)$row['total_biaya'];
            }
        }
        arsort($perPoliMap);
        $laporanPerPoli = array_map(fn($k, $v) => ['nama_poli' => $k, 'total_pendapatan' => $v], array_keys($perPoliMap), $perPoliMap);

        // Per jenis bayar
        $perJenisBayarMap = [];
        foreach ($dataLaporan as $row) {
            if ($row['status_bayar'] !== 'Lunas') continue;
            $jb = $row['jenis_bayar'];
            $perJenisBayarMap[$jb] = ($perJenisBayarMap[$jb] ?? 0) + (float)$row['total_biaya'];
        }

        // Dropdown poli & dokter
        $poli   = $this->db->table('tbl_poli')->orderBy('nama_poli')->get()->getResultArray();
        $dokter = $this->db->table('tbl_dokter d')
            ->select('d.id_dokter, d.nama_dokter, p.nama_poli, d.id_poli')
            ->join('tbl_poli p', 'd.id_poli = p.id_poli')
            ->orderBy('d.nama_dokter')->get()->getResultArray();

        return view('admin/laporan', compact(
            'dataLaporan', 'filter',
            'totalPendapatanBulanIni', 'pasienDilayani', 'tunggakan',
            'laporanPerPoli', 'perJenisBayarMap',
            'poli', 'dokter'
        ));
    }

    public function exportLaporan()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $filter = [
            'tgl_dari'        => $this->request->getGet('tgl_dari'),
            'tgl_sampai'      => $this->request->getGet('tgl_sampai'),
            'id_poli'         => $this->request->getGet('id_poli'),
            'id_dokter'       => $this->request->getGet('id_dokter'),
            'jenis_bayar'     => $this->request->getGet('jenis_bayar') ?: ['Umum', 'BPJS', 'Asuransi'],
            'status_bayar'    => $this->request->getGet('status_bayar') ?: 'Semua',
            'jenis_kunjungan' => $this->request->getGet('jenis_kunjungan') ?: 'Semua',
        ];

        $laporanModel = new \App\Models\LaporanModel();
        $data = $laporanModel->getLaporan($filter);

        $filename = 'laporan_keuangan_' . date('Ymd_His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        // BOM for Excel
        fwrite($output, "\xEF\xBB\xBF");

        fputcsv($output, ['No', 'No. Rawat', 'Nama Pasien', 'Dokter', 'Poli', 'Jenis Kunjungan',
            'Biaya Konsultasi', 'Biaya Obat', 'Biaya Kamar', 'Total Biaya',
            'Jenis Bayar', 'Status Bayar', 'Tanggal Bayar']);

        foreach ($data as $i => $row) {
            fputcsv($output, [
                $i + 1,
                $row['no_rawat'],
                $row['nama_pasien'],
                $row['nama_dokter'],
                $row['nama_poli'],
                $row['jenis_kunjungan'] ?? 'Rawat Jalan',
                $row['biaya_konsultasi'] ?? 0,
                $row['biaya_obat'] ?? 0,
                $row['biaya_kamar'] ?? 0,
                $row['total_biaya'],
                $row['jenis_bayar'],
                $row['status_bayar'],
                $row['tgl_bayar'] ? date('d/m/Y H:i', strtotime($row['tgl_bayar'])) : '-',
            ]);
        }

        fclose($output);
        exit;
    }

    // ============================
    // KELOLA OBAT
    // ============================
    public function kelolaObat()
    {
        if (!$this->checkAdminSession()) return redirect()->to(base_url('login'));

        $cari = $this->request->getGet('cari');

        $builder = $this->db->table('tbl_obat');

        if (!empty($cari)) {
            $builder->like('nama_obat', $cari);
        }

        $obat = $builder->orderBy('nama_obat', 'ASC')->get()->getResultArray();

        return view('admin/kelola_obat', [
            'obat' => $obat,
            'cari' => $cari
        ]);
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

        $cari = $this->request->getGet('cari');

        // Ambil semua tagihan
        $builder = $this->db->table('tbl_tagihan t')
            ->select('t.*, p.no_rm, p.tgl_daftar, ps.nama_pasien, d.nama_dokter, po.nama_poli')
            ->join('tbl_pendaftaran p', 't.no_rawat = p.no_rawat')
            ->join('tbl_pasien ps', 'p.no_rm = ps.no_rm')
            ->join('tbl_dokter d', 'p.id_dokter = d.id_dokter')
            ->join('tbl_poli po', 'p.id_poli = po.id_poli');

        if (!empty($cari)) {
            $builder->like('ps.nama_pasien', $cari);
        }

        $tagihan = $builder->orderBy('t.id_tagihan', 'DESC')
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
            'pendaftaranTanpaTagihan' => $pendaftaranTanpaTagihan,
            'cari' => $cari
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
        $pilihan_obat = $this->request->getPost('pilihan_obat'); // 'Apotek RS', 'Beli di Luar', or ''
        
        // Fetch current tagihan to see if status changed
        $current = $this->db->table('tbl_tagihan')->where('id_tagihan', $id)->get()->getRowArray();
        if (!$current) {
            session()->setFlashdata('error', 'Data tagihan tidak ditemukan.');
            return redirect()->to(base_url('admin/tagihan'));
        }

        $tgl_bayar = $current['tgl_bayar'] ?? null;
        if ($status === 'Lunas' && ($current['status_bayar'] ?? '') !== 'Lunas') {
            $tgl_bayar = date('Y-m-d H:i:s');
        } elseif ($status === 'Belum Lunas') {
            $tgl_bayar = null;
        }

        $biayaObat = 0;
        $db_pilihan_obat = null;
        $tgl_pilih_obat = $current['tgl_pilih_obat'] ?? null;

        if ($pilihan_obat === 'Apotek RS') {
            $db_pilihan_obat = 'Apotek RS';
            if ($current['pilihan_obat'] !== 'Apotek RS') {
                $tgl_pilih_obat = date('Y-m-d H:i:s');
            }
            // Hitung biaya obat dari tbl_resep
            $rekamMedis = $this->db->table('tbl_rekam_medis')
                ->where('no_rawat', $current['no_rawat'])
                ->orderBy('tgl_periksa', 'DESC')
                ->limit(1)
                ->get()->getRowArray();

            if ($rekamMedis) {
                $reseps = $this->db->table('tbl_resep r')
                    ->select('r.jumlah, o.harga')
                    ->join('tbl_obat o', 'r.id_obat = o.id_obat')
                    ->where('r.id_rm', $rekamMedis['id_rm'])
                    ->get()->getResultArray();

                foreach ($reseps as $r) {
                    $biayaObat += (float)$r['harga'] * (int)$r['jumlah'];
                }
            }
        } elseif ($pilihan_obat === 'Beli di Luar') {
            $db_pilihan_obat = 'Beli di Luar';
            if ($current['pilihan_obat'] !== 'Beli di Luar') {
                $tgl_pilih_obat = date('Y-m-d H:i:s');
            }
            $biayaObat = 0;
        } else {
            $db_pilihan_obat = null;
            $tgl_pilih_obat = null;
            $biayaObat = 0;
        }

        // Ambil input total_biaya dari post. Jika tidak ada/kosong, hitung otomatis.
        $inputTotal = $this->request->getPost('total_biaya');
        if ($inputTotal === null || $inputTotal === '') {
            $totalBiaya = (float)$current['biaya_konsultasi'] + $biayaObat + (float)$current['biaya_kamar'];
        } else {
            $totalBiaya = (float)$inputTotal;
        }

        $this->db->table('tbl_tagihan')
            ->where('id_tagihan', $id)
            ->update([
                'pilihan_obat'   => $db_pilihan_obat,
                'tgl_pilih_obat' => $tgl_pilih_obat,
                'biaya_obat'     => $biayaObat,
                'total_biaya'    => $totalBiaya,
                'jenis_bayar'    => $this->request->getPost('jenis_bayar') ?: 'Umum',
                'status_bayar'   => $status ?: 'Belum Lunas',
                'tgl_bayar'      => $tgl_bayar
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
