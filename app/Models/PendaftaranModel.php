<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftaranModel extends Model
{
    protected $table            = 'tbl_pendaftaran';
    protected $primaryKey       = 'no_rawat';
    // $useAutoIncrement is true by default, but no_rawat is varchar.
    protected $useAutoIncrement = false;
    protected $allowedFields    = ['no_rawat', 'no_rm', 'id_dokter', 'tgl_daftar', 'jam_kunjungan', 'keluhan_awal', 'status_periksa', 'slot_waktu'];

    public function getPendaftaran()
    {
        return $this->db->table('tbl_pendaftaran')
            ->join('tbl_pasien', 'tbl_pasien.no_rm = tbl_pendaftaran.no_rm')
            ->join('tbl_dokter', 'tbl_dokter.id_dokter = tbl_pendaftaran.id_dokter')
            ->join('tbl_poli', 'tbl_poli.id_poli = tbl_dokter.id_poli')
            ->orderBy('tbl_pendaftaran.tgl_daftar', 'DESC')
            ->orderBy('tbl_pendaftaran.jam_kunjungan', 'ASC')
            ->get()->getResultArray();
    }
}
