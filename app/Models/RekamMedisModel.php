<?php

namespace App\Models;

use CodeIgniter\Model;

class RekamMedisModel extends Model
{
    protected $table            = 'tbl_rekam_medis';
    protected $primaryKey       = 'id_rm';
    protected $allowedFields    = ['no_rawat', 'tgl_periksa', 'diagnosa', 'tindakan', 'resep_obat'];

    public function getRekamMedis()
    {
        return $this->db->table('tbl_rekam_medis')
            ->join('tbl_pendaftaran', 'tbl_pendaftaran.no_rawat = tbl_rekam_medis.no_rawat')
            ->join('tbl_pasien', 'tbl_pasien.no_rm = tbl_pendaftaran.no_rm')
            ->join('tbl_dokter', 'tbl_dokter.id_dokter = tbl_pendaftaran.id_dokter')
            ->join('tbl_poli', 'tbl_poli.id_poli = tbl_dokter.id_poli')
            ->orderBy('tbl_rekam_medis.tgl_periksa', 'DESC')
            ->get()->getResultArray();
    }
}
