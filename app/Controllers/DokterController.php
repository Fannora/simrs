<?php

namespace App\Controllers;

use App\Models\DokterModel;
use App\Models\PoliModel;

class DokterController extends BaseController
{
    protected $dokterModel;
    protected $poliModel;

    public function __construct()
    {
        $this->dokterModel = new DokterModel();
        $this->poliModel = new PoliModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $users_dokter = $db->table('tbl_user')->where('level_id', 2)->get()->getResultArray();

        $data = [
            'dokter' => $this->dokterModel->getDokter(),
            'poli' => $this->poliModel->findAll(),
            'users' => $users_dokter
        ];
        return view('v_dokter', $data);
    }

    public function simpandata()
    {
        $this->dokterModel->save([
            'nama_dokter' => $this->request->getVar('nama_dokter'),
            'id_poli' => $this->request->getVar('id_poli'),
            'no_telp' => $this->request->getVar('no_telp'),
            'id_user' => $this->request->getVar('id_user') ?: null
        ]);
        session()->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-check"></i> Success!</h5>Data Berhasil Disimpan</div>');
        return redirect()->to('/dokter');
    }

    public function editdata()
    {
        $this->dokterModel->save([
            'id_dokter' => $this->request->getVar('id_dokter'),
            'nama_dokter' => $this->request->getVar('nama_dokter'),
            'id_poli' => $this->request->getVar('id_poli'),
            'no_telp' => $this->request->getVar('no_telp'),
            'id_user' => $this->request->getVar('id_user') ?: null
        ]);
        session()->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-check"></i> Success!</h5>Data Berhasil Diubah</div>');
        return redirect()->to('/dokter');
    }

    public function hapusdata($id)
    {
        $this->dokterModel->delete($id);
        session()->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-check"></i> Success!</h5>Data Berhasil Dihapus</div>');
        return redirect()->to('/dokter');
    }
}
