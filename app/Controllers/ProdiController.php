<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdiModel;
use App\Models\JurusanModel;

class ProdiController extends BaseController
{
    public function index()
    {
        if(session()->get('isLoggedIn') == true){
            $ProdiMdl = new ProdiModel();
            $JurusanMdl = new JurusanModel();
    
            $data = [
                'judul'   => 'Data Program Studi',
                'prodi'   => $ProdiMdl->select('tbl_prodi.*, tbl_jurusan.jurusan')->join('tbl_jurusan', 'tbl_jurusan.kode_jur = tbl_prodi.kode_jur', 'left')->findAll(),
                'jurusan' => $JurusanMdl->findAll()
            ];
            return view('v_prodi', $data);
        }else{
            return redirect()->to(base_url('login'));
        }
    }

    public function simpandata()
    {
        $dataProdi = new ProdiModel();

        $data = [
            'kode_prodi' => $this->request->getVar('kode_prodi'),
            'kode_jur'   => $this->request->getVar('kode_jur'),
            'prodi'      => $this->request->getVar('prodi')
        ];

        $rules = [
            'kode_prodi' => 'required|is_unique[tbl_prodi.kode_prodi]|max_length[5]',
            'kode_jur'   => 'required',
            'prodi'      => 'required'
        ];
        $data1 = $this->request->getPost(array_keys($rules));
        if (!$this->validateData($data1, $rules)) {
            return redirect()->to(base_url('/prodi'))->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataProdi->insert($data);
        if ($dataProdi) {
            session()->setFlashdata(
                'pesan',
                '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Data Prodi Berhasil Disimpan!</h5>
                </div>'
            );
        }
        return redirect()->to(base_url('/prodi'));
    }

    public function editdata()
    {
        $dataProdi = new ProdiModel();

        $data = [
            'kode_jur' => $this->request->getVar('kode_jur'),
            'prodi'    => $this->request->getVar('prodi')
        ];

        $rules = [
            'kode_jur' => 'required',
            'prodi'    => 'required'
        ];

        $data1 = $this->request->getPost(array_keys($rules));

        if (! $this->validateData($data1, $rules)) {
            return redirect()->to(base_url('/prodi'))->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $kode_prodi = $this->request->getVar('kode_prodi');
        $update = $dataProdi->update($kode_prodi, $data);

        if ($update) {
            session()->setFlashdata(
                'pesan',
                '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Data Prodi Berhasil Diupdate!</h5>
                </div>'
            );
        }

        return redirect()->to(base_url('/prodi'));
    }

    public function hapusdata($kode_prodi = null)
    {
        $dataProdi = new ProdiModel();
        $hapus = $dataProdi->delete($kode_prodi);

        if ($hapus) {
            session()->setFlashdata(
                'pesan',
                '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Data Prodi Berhasil Dihapus!</h5>
                </div>'
            );
        }

        return redirect()->to(base_url('/prodi'));
    }
}
