<?php

namespace App\Models;

use CodeIgniter\Model;

class PoliModel extends Model
{
    protected $table            = 'tbl_poli';
    protected $primaryKey       = 'id_poli';
    protected $allowedFields    = ['nama_poli', 'gedung'];
}
