<?php

namespace App\Controllers;

class RawatInapController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    private function checkAdmin()
    {
        if (!session()->get('id_user') || session()->get('level_id') !== 'Admin') {
            session()->setFlashdata('error', 'Akses ditolak.');
            return false;
        }
        return true;
    }

    public function index()
    {
        if (!$this->checkAdmin()) return redirect()->to(base_url('login'));

        $cari = $this->request->getGet('cari');

        // Tab 1: Pasien berstatus "Rawat Inap" belum ada di tbl_rawat_inap
        $builderPerlu = $this->db->table('tbl_pendaftaran p')
            ->select('p.no_rawat, p.no_rm, p.tgl_daftar, ps.nama_pasien, d.nama_dokter, po.nama_poli')
            ->join('tbl_pasien ps', 'p.no_rm = ps.no_rm')
            ->join('tbl_dokter d', 'p.id_dokter = d.id_dokter')
            ->join('tbl_poli po', 'd.id_poli = po.id_poli')
            ->join('tbl_rawat_inap ri', 'ri.no_rawat = p.no_rawat', 'left')
            ->where('p.status_periksa', 'Rawat Inap')
            ->where('ri.id_rawatinap IS NULL');

        if (!empty($cari)) {
            $builderPerlu->like('ps.nama_pasien', $cari);
        }

        $perluMasuk = $builderPerlu->orderBy('p.tgl_daftar', 'DESC')
            ->get()->getResultArray();

        // Tab 2: Sedang Dirawat
        $builderDirawat = $this->db->table('tbl_rawat_inap ri')
            ->select('ri.*, p.no_rm, p.tgl_daftar, ps.nama_pasien, d.nama_dokter, po.nama_poli, k.nama_kamar, k.kelas, k.harga_per_malam, DATEDIFF(CURDATE(), ri.tgl_masuk) as hari_dirawat')
            ->join('tbl_pendaftaran p', 'ri.no_rawat = p.no_rawat')
            ->join('tbl_pasien ps', 'p.no_rm = ps.no_rm')
            ->join('tbl_dokter d', 'p.id_dokter = d.id_dokter')
            ->join('tbl_poli po', 'd.id_poli = po.id_poli')
            ->join('tbl_kamar k', 'ri.id_kamar = k.id_kamar')
            ->where('ri.status_inap', 'Dirawat');

        if (!empty($cari)) {
            $builderDirawat->like('ps.nama_pasien', $cari);
        }

        $sedangDirawat = $builderDirawat->orderBy('ri.tgl_masuk', 'ASC')
            ->get()->getResultArray();

        // Tab 3: Riwayat (sudah pulang)
        $builderRiwayat = $this->db->table('tbl_rawat_inap ri')
            ->select('ri.*, p.no_rm, p.tgl_daftar, ps.nama_pasien, d.nama_dokter, k.nama_kamar, k.kelas, t.total_biaya, t.biaya_kamar')
            ->join('tbl_pendaftaran p', 'ri.no_rawat = p.no_rawat')
            ->join('tbl_pasien ps', 'p.no_rm = ps.no_rm')
            ->join('tbl_dokter d', 'p.id_dokter = d.id_dokter')
            ->join('tbl_kamar k', 'ri.id_kamar = k.id_kamar')
            ->join('tbl_tagihan t', 't.no_rawat = ri.no_rawat', 'left')
            ->where('ri.status_inap', 'Sudah Pulang');

        if (!empty($cari)) {
            $builderRiwayat->like('ps.nama_pasien', $cari);
        }

        $riwayat = $builderRiwayat->orderBy('ri.tgl_keluar', 'DESC')
            ->get()->getResultArray();

        // Kamar tersedia (untuk dropdown)
        $kamarTersedia = $this->db->table('tbl_kamar')
            ->where('status', 'Tersedia')
            ->orderBy('kelas', 'ASC')
            ->get()->getResultArray();

        return view('admin/kelola_rawat_inap', compact(
            'perluMasuk', 'sedangDirawat', 'riwayat', 'kamarTersedia', 'cari'
        ));
    }

    public function masuk()
    {
        if (!$this->checkAdmin()) return redirect()->to(base_url('login'));

        $no_rawat = $this->request->getPost('no_rawat');
        $id_kamar = $this->request->getPost('id_kamar');
        $catatan  = $this->request->getPost('catatan');

        if (empty($no_rawat) || empty($id_kamar)) {
            session()->setFlashdata('error', 'Data tidak lengkap.');
            return redirect()->to(base_url('admin/rawat-inap'));
        }

        // Validasi kamar masih tersedia
        $kamar = $this->db->table('tbl_kamar')->where('id_kamar', $id_kamar)->get()->getRowArray();
        if (!$kamar || $kamar['status'] !== 'Tersedia') {
            session()->setFlashdata('error', 'Kamar tidak tersedia atau sudah terisi.');
            return redirect()->to(base_url('admin/rawat-inap'));
        }

        $this->db->transStart();

        // Insert tbl_rawat_inap
        $this->db->table('tbl_rawat_inap')->insert([
            'no_rawat'   => $no_rawat,
            'id_kamar'   => $id_kamar,
            'tgl_masuk'  => date('Y-m-d'),
            'status_inap'=> 'Dirawat',
            'catatan'    => $catatan ?: null,
        ]);

        // Update status kamar jadi Terisi
        $this->db->table('tbl_kamar')->where('id_kamar', $id_kamar)->update(['status' => 'Terisi']);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal memproses rawat inap.');
        } else {
            session()->setFlashdata('success', 'Pasien berhasil dimasukkan ke kamar rawat inap.');
        }

        return redirect()->to(base_url('admin/rawat-inap'));
    }

    public function pulang($id = null)
    {
        if (!$this->checkAdmin()) return redirect()->to(base_url('login'));

        $tgl_keluar = $this->request->getPost('tgl_keluar') ?: date('Y-m-d');

        $rawat = $this->db->table('tbl_rawat_inap')->where('id_rawatinap', $id)->get()->getRowArray();
        if (!$rawat || $rawat['status_inap'] !== 'Dirawat') {
            session()->setFlashdata('error', 'Data rawat inap tidak valid.');
            return redirect()->to(base_url('admin/rawat-inap'));
        }

        $kamar = $this->db->table('tbl_kamar')->where('id_kamar', $rawat['id_kamar'])->get()->getRowArray();
        $total_hari   = max(1, (int)((strtotime($tgl_keluar) - strtotime($rawat['tgl_masuk'])) / 86400));
        $biaya_kamar  = $total_hari * (float)$kamar['harga_per_malam'];

        $this->db->transStart();

        // Update tbl_rawat_inap
        $this->db->table('tbl_rawat_inap')->where('id_rawatinap', $id)->update([
            'tgl_keluar'  => $tgl_keluar,
            'total_hari'  => $total_hari,
            'status_inap' => 'Sudah Pulang',
        ]);

        // Update status kamar jadi Tersedia
        $this->db->table('tbl_kamar')->where('id_kamar', $rawat['id_kamar'])->update(['status' => 'Tersedia']);

        // Create or update separate tbl_tagihan for Inpatient (Rawat Inap)
        $outpatientTagihan = $this->db->table('tbl_tagihan')
            ->where('no_rawat', $rawat['no_rawat'])
            ->where('jenis_kunjungan', 'Rawat Jalan')
            ->get()->getRowArray();
            
        $jenisBayar = $outpatientTagihan ? $outpatientTagihan['jenis_bayar'] : 'Umum';

        $inpatientTagihan = $this->db->table('tbl_tagihan')
            ->where('no_rawat', $rawat['no_rawat'])
            ->where('jenis_kunjungan', 'Rawat Inap')
            ->get()->getRowArray();

        if ($inpatientTagihan) {
            // Update existing inpatient bill if discharged again
            $this->db->table('tbl_tagihan')
                ->where('id_tagihan', $inpatientTagihan['id_tagihan'])
                ->update([
                    'biaya_kamar' => $biaya_kamar,
                    'total_biaya' => $biaya_kamar,
                ]);
        } else {
            // Insert new separate inpatient bill in tbl_tagihan
            $this->db->table('tbl_tagihan')->insert([
                'no_rawat'         => $rawat['no_rawat'],
                'biaya_konsultasi' => 0.00,
                'biaya_obat'       => 0.00,
                'biaya_kamar'      => $biaya_kamar,
                'jenis_kunjungan'  => 'Rawat Inap',
                'total_biaya'      => $biaya_kamar,
                'jenis_bayar'      => $jenisBayar,
                'pilihan_obat'     => null,
                'tgl_pilih_obat'   => null,
                'status_bayar'     => 'Belum Lunas',
                'tgl_bayar'        => null
            ]);
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal memproses kepulangan pasien.');
        } else {
            session()->setFlashdata('success', "Pasien pulang berhasil dicatat. Biaya kamar: Rp " . number_format($biaya_kamar, 0, ',', '.'));
        }

        return redirect()->to(base_url('admin/rawat-inap'));
    }

    public function batal($no_rawat = null)
    {
        if (!$this->checkAdmin()) return redirect()->to(base_url('login'));

        if (empty($no_rawat)) {
            session()->setFlashdata('error', 'No. Rawat tidak valid.');
            return redirect()->to(base_url('admin/rawat-inap'));
        }

        // Cek data pendaftaran
        $pendaftaran = $this->db->table('tbl_pendaftaran')->where('no_rawat', $no_rawat)->get()->getRowArray();
        if (!$pendaftaran || $pendaftaran['status_periksa'] !== 'Rawat Inap') {
            session()->setFlashdata('error', 'Pasien tidak ditemukan atau status tidak valid.');
            return redirect()->to(base_url('admin/rawat-inap'));
        }

        $this->db->transStart();

        // Kembalikan status periksa ke Selesai
        $this->db->table('tbl_pendaftaran')
            ->where('no_rawat', $no_rawat)
            ->update(['status_periksa' => 'Selesai']);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            session()->setFlashdata('error', 'Gagal membatalkan rawat inap.');
        } else {
            session()->setFlashdata('success', 'Rekomendasi rawat inap berhasil dibatalkan. Pasien dikembalikan ke Rawat Jalan.');
        }

        return redirect()->to(base_url('admin/rawat-inap'));
    }
}

