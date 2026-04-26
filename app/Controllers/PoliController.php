<?php

namespace App\Controllers;

use App\Models\PoliModel;

class PoliController extends BaseController
{
    protected $poliModel;

    public function __construct()
    {
        $this->poliModel = new PoliModel();
    }

    public function index()
    {
        $data = [
            'poli' => $this->poliModel->findAll()
        ];
        return view('v_poli', $data);
    }

    public function simpandata()
    {
        $this->poliModel->save([
            'nama_poli' => $this->request->getVar('nama_poli'),
            'gedung' => $this->request->getVar('gedung')
        ]);
        session()->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-check"></i> Success!</h5>Data Berhasil Disimpan</div>');
        return redirect()->to('/poli');
    }

    public function editdata()
    {
        $this->poliModel->save([
            'id_poli' => $this->request->getVar('id_poli'),
            'nama_poli' => $this->request->getVar('nama_poli'),
            'gedung' => $this->request->getVar('gedung')
        ]);
        session()->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-check"></i> Success!</h5>Data Berhasil Diubah</div>');
        return redirect()->to('/poli');
    }

    public function hapusdata($id)
    {
        $this->poliModel->delete($id);
        session()->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-check"></i> Success!</h5>Data Berhasil Dihapus</div>');
        return redirect()->to('/poli');
    }
}
