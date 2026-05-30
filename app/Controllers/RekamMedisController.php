<?php

namespace App\Controllers;

use App\Models\RekamMedisModel;
use App\Models\PendaftaranModel;

class RekamMedisController extends BaseController
{
    protected $rekamMedisModel;
    protected $pendaftaranModel;

    public function __construct()
    {
        $this->rekamMedisModel = new RekamMedisModel();
        $this->pendaftaranModel = new PendaftaranModel();
    }

    public function index()
    {
        $data = [
            'rekam_medis' => $this->rekamMedisModel->getRekamMedis()
        ];
        return view('v_rekam_medis', $data);
    }

    public function input($no_rawat)
    {
        $db = \Config\Database::connect();
        $pendaftaran = $db->table('tbl_pendaftaran')
            ->join('tbl_pasien', 'tbl_pasien.no_rm = tbl_pendaftaran.no_rm')
            ->join('tbl_dokter', 'tbl_dokter.id_dokter = tbl_pendaftaran.id_dokter')
            ->join('tbl_poli', 'tbl_poli.id_poli = tbl_dokter.id_poli')
            ->where('no_rawat', $no_rawat)
            ->get()->getRowArray();

        if (!$pendaftaran) {
            return redirect()->to('/pendaftaran');
        }

        // Update status menjadi sedang diperiksa jika belum
        if ($pendaftaran['status_periksa'] == 'Belum Diperiksa') {
            $this->pendaftaranModel->save([
                'no_rawat' => $no_rawat,
                'status_periksa' => 'Sedang Diperiksa'
            ]);
        }

        $data = [
            'pendaftaran' => $pendaftaran
        ];
        return view('v_rekam_medis_input', $data);
    }

    public function simpandata()
    {
        $no_rawat = $this->request->getVar('no_rawat');
        
        $this->rekamMedisModel->save([
            'no_rawat' => $no_rawat,
            'tgl_periksa' => date('Y-m-d H:i:s'),
            'diagnosa' => $this->request->getVar('diagnosa'),
            'tindakan' => $this->request->getVar('tindakan'),
            'resep_obat' => $this->request->getVar('resep_obat')
        ]);

        // Update status pendaftaran menjadi Selesai
        $this->pendaftaranModel->save([
            'no_rawat' => $no_rawat,
            'status_periksa' => 'Selesai'
        ]);

        session()->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-check"></i> Success!</h5>Rekam Medis Berhasil Disimpan</div>');
        return redirect()->to('/rekammedis');
    }

    public function cetak()
    {
        $no_rawat = $this->request->getGet('no_rawat');
        $db = \Config\Database::connect();

        if ($no_rawat) {
            $rows = $db->table('tbl_rekam_medis rm')
                ->select('rm.id_rm, rm.no_rawat, rm.tgl_periksa, rm.diagnosa, rm.tindakan, rm.resep_obat,
                          p.no_rm, p.tgl_daftar, p.keluhan_awal, p.slot_waktu,
                          ps.nama_pasien, ps.nik, ps.tgl_lahir, ps.jk, ps.alamat, ps.no_bpjs,
                          d.nama_dokter, d.no_telp as telp_dokter,
                          po.nama_poli,
                          t.biaya_konsultasi, t.biaya_obat, t.biaya_kamar, t.total_biaya, t.pilihan_obat')
                ->join('tbl_pendaftaran p',  'p.no_rawat = rm.no_rawat')
                ->join('tbl_pasien ps',      'ps.no_rm = p.no_rm')
                ->join('tbl_dokter d',       'd.id_dokter = p.id_dokter')
                ->join('tbl_poli po',        'po.id_poli = d.id_poli')
                ->join('tbl_tagihan t',      't.no_rawat = rm.no_rawat', 'left')
                ->where('rm.no_rawat', $no_rawat)
                ->get()->getResultArray();
        } else {
            $rows = $db->table('tbl_rekam_medis rm')
                ->select('rm.id_rm, rm.no_rawat, rm.tgl_periksa, rm.diagnosa, rm.tindakan, rm.resep_obat,
                          p.no_rm, p.tgl_daftar, p.keluhan_awal, p.slot_waktu,
                          ps.nama_pasien, ps.nik, ps.tgl_lahir, ps.jk, ps.alamat, ps.no_bpjs,
                          d.nama_dokter, d.no_telp as telp_dokter,
                          po.nama_poli,
                          t.biaya_konsultasi, t.biaya_obat, t.biaya_kamar, t.total_biaya, t.pilihan_obat')
                ->join('tbl_pendaftaran p',  'p.no_rawat = rm.no_rawat')
                ->join('tbl_pasien ps',      'ps.no_rm = p.no_rm')
                ->join('tbl_dokter d',       'd.id_dokter = p.id_dokter')
                ->join('tbl_poli po',        'po.id_poli = d.id_poli')
                ->join('tbl_tagihan t',      't.no_rawat = rm.no_rawat', 'left')
                ->orderBy('rm.tgl_periksa', 'DESC')
                ->get()->getResultArray();
        }

        // Attach structured prescription items per rekam medis row
        foreach ($rows as &$row) {
            $row['resep_items'] = $db->table('tbl_resep rs')
                ->select('rs.dosis, rs.jumlah, rs.keterangan, o.nama_obat, o.satuan, o.harga')
                ->join('tbl_obat o', 'o.id_obat = rs.id_obat')
                ->where('rs.id_rm', $row['id_rm'])
                ->get()->getResultArray();
        }
        unset($row);

        echo view('v_rekam_medis_cetak', ['rekam_medis' => $rows]);
    }
}
