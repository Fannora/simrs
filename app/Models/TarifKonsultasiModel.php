<?php

namespace App\Models;

use CodeIgniter\Model;

class TarifKonsultasiModel extends Model
{
    protected $table      = 'tbl_tarif_konsultasi';
    protected $primaryKey = 'id_tarif';
    protected $allowedFields = ['id_poli', 'nama_tarif', 'harga', 'is_active'];
    protected $useTimestamps = false;
}
