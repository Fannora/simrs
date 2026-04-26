<?php

namespace App\Models;

use CodeIgniter\Model;

class PasienModel extends Model
{
    protected $table            = 'tbl_pasien';
    protected $primaryKey       = 'no_rm';
    protected $allowedFields    = ['no_rm', 'nik', 'nama_pasien', 'tgl_lahir', 'jk', 'alamat', 'no_bpjs'];
}
