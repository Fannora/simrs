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
        if ($no_rawat) {
            $db = \Config\Database::connect();
            $data = [
                'rekam_medis' => $db->table('tbl_rekam_medis')
                    ->join('tbl_pendaftaran', 'tbl_pendaftaran.no_rawat = tbl_rekam_medis.no_rawat')
                    ->join('tbl_pasien', 'tbl_pasien.no_rm = tbl_pendaftaran.no_rm')
                    ->join('tbl_dokter', 'tbl_dokter.id_dokter = tbl_pendaftaran.id_dokter')
                    ->join('tbl_poli', 'tbl_poli.id_poli = tbl_dokter.id_poli')
                    ->where('tbl_rekam_medis.no_rawat', $no_rawat)
                    ->get()->getResultArray()
            ];
        } else {
            $data = [
                'rekam_medis' => $this->rekamMedisModel->getRekamMedis()
            ];
        }
        // Tampilkan view khusus cetak
        echo view('v_rekam_medis_cetak', $data);
    }
}
