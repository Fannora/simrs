<?php

namespace App\Models;

use CodeIgniter\Model;

class KamarModel extends Model
{
    protected $table      = 'tbl_kamar';
    protected $primaryKey = 'id_kamar';
    protected $allowedFields = ['nama_kamar', 'kelas', 'harga_per_malam', 'status'];
    protected $useTimestamps = false;
}
