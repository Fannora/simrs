<?php

namespace App\Models;

use CodeIgniter\Model;

class RawatInapModel extends Model
{
    protected $table      = 'tbl_rawat_inap';
    protected $primaryKey = 'id_rawatinap';
    protected $allowedFields = ['no_rawat', 'id_kamar', 'tgl_masuk', 'tgl_keluar', 'total_hari', 'status_inap', 'catatan'];
    protected $useTimestamps = false;
}
