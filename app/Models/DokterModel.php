<?php

namespace App\Models;

use CodeIgniter\Model;

class DokterModel extends Model
{
    protected $table            = 'tbl_dokter';
    protected $primaryKey       = 'id_dokter';
    protected $allowedFields    = ['nama_dokter', 'id_poli', 'no_telp', 'id_user'];

    public function getDokter()
    {
        return $this->db->table('tbl_dokter')
            ->join('tbl_poli', 'tbl_poli.id_poli = tbl_dokter.id_poli', 'left')
            ->join('tbl_user', 'tbl_user.id_user = tbl_dokter.id_user', 'left')
            ->get()->getResultArray();
    }
}
