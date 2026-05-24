<?php

namespace App\Controllers;

use App\Models\PendaftaranModel;
use App\Models\PasienModel;

class PendaftaranController extends BaseController
{
    protected $pendaftaranModel;
    protected $pasienModel;

    public function __construct()
    {
        $this->pendaftaranModel = new PendaftaranModel();
        $this->pasienModel = new PasienModel();
    }

    public function index()
    {
        $data = [
            'pendaftaran' => $this->pendaftaranModel->getPendaftaran(),
            'pasien' => $this->pasienModel->findAll()
        ];
        return view('v_pendaftaran', $data);
    }

    public function simpandata()
    {
        $no_rm = $this->request->getVar('no_rm');
        $keluhan = strtolower($this->request->getVar('keluhan_awal'));
        $tgl_daftar = date('Y-m-d');
        
        $db = \Config\Database::connect();
        
        // 1. Analisis teks keluhan untuk menentukan Poli
        // Default Poli Umum jika tidak ada yang cocok
        $id_poli = null;
        $poliList = $db->table('tbl_poli')->get()->getResultArray();
        
        $keyword_map = [
            'gigi' => 'Gigi',
            'demam' => 'Umum',
            'pusing' => 'Umum',
            'batuk' => 'Umum',
            'anak' => 'Anak',
            'kandungan' => 'Kandungan',
            'hamil' => 'Kandungan',
            'mata' => 'Mata',
            'buram' => 'Mata'
        ];

        $target_poli_nama = 'Umum'; // Default
        foreach($keyword_map as $kw => $poli_nama) {
            if (strpos($keluhan, $kw) !== false) {
                $target_poli_nama = $poli_nama;
                break;
            }
        }

        // Cari ID Poli berdasarkan nama (LIKE)
        foreach($poliList as $p) {
            if (stripos($p['nama_poli'], $target_poli_nama) !== false) {
                $id_poli = $p['id_poli'];
                break;
            }
        }
        
        // Jika tidak ketemu Poli, ambil poli pertama saja sebagai fallback
        if (!$id_poli && count($poliList) > 0) {
            $id_poli = $poliList[0]['id_poli'];
        }

        // 2. Assign ID Dokter otomatis (ambil 1 dokter dari poli tersebut)
        $dokter = $db->table('tbl_dokter')->where('id_poli', $id_poli)->get()->getRowArray();
        if (!$dokter) {
            session()->setFlashdata('pesan', '<div class="alert alert-danger">Gagal: Tidak ada dokter yang tersedia di Poli tujuan.</div>');
            return redirect()->to('/pendaftaran');
        }
        $id_dokter = $dokter['id_dokter'];

        // 3. Kalkulasi jam kunjungan (+15 menit dari jadwal terakhir)
        $last_jadwal = $db->table('tbl_pendaftaran')
                          ->where('id_dokter', $id_dokter)
                          ->where('tgl_daftar', $tgl_daftar)
                          ->selectMax('jam_kunjungan')
                          ->get()->getRowArray();

        if ($last_jadwal && $last_jadwal['jam_kunjungan']) {
            $waktu = strtotime($last_jadwal['jam_kunjungan']);
            $jam_kunjungan = date('H:i:s', strtotime('+15 minutes', $waktu));
        } else {
            $jam_kunjungan = '08:00:00'; // Default jam mulai praktek
        }

        // Generate No Rawat (misal: RWT-20231024-001)
        $count_today = $db->table('tbl_pendaftaran')->where('tgl_daftar', $tgl_daftar)->countAllResults();
        $no_rawat = 'RWT-' . date('Ymd') . '-' . str_pad($count_today + 1, 3, '0', STR_PAD_LEFT);

        $this->pendaftaranModel->insert([
            'no_rawat' => $no_rawat,
            'no_rm' => $no_rm,
            'id_dokter' => $id_dokter,
            'tgl_daftar' => $tgl_daftar,
            'jam_kunjungan' => $jam_kunjungan,
            'keluhan_awal' => $this->request->getVar('keluhan_awal'),
            'status_periksa' => 'Belum Diperiksa'
        ]);

        session()->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-check"></i> Success!</h5>Pendaftaran Berhasil! Dokter: '.$dokter['nama_dokter'].', Jam: '.$jam_kunjungan.'</div>');
        return redirect()->to('/pendaftaran');
    }

    public function hapusdata($no_rawat = null)
    {
        if ($no_rawat) {
            $this->pendaftaranModel->where('no_rawat', $no_rawat)->delete();
        }
        session()->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-check"></i> Success!</h5>Data Berhasil Dihapus</div>');
        return redirect()->to('/pendaftaran');
    }
}
