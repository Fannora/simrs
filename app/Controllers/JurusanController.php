<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\JurusanModel;

class JurusanController extends BaseController
{
    public function index()
    {
        if(session()->get('isLoggedIn') == true){
            $jurusanMdl = new JurusanModel();
            $jurusan = $jurusanMdl->findAll();

            $data = [
                'judul'   => 'Daftar Jurusan',
                'jurusan' => $jurusan
            ];

            return view('v_jurusan', $data);
        }else{
            return redirect()->to(base_url('login'));
        }
    }

    public function simpandata()
    {
        $dataJurusan = new JurusanModel();

        $data = [
            'kode_jur' => $this ->request->getVar('kode_jur'),
            'jurusan'  => $this ->request->getVar('jurusan')
        ];

        $rules = [
            'kode_jur' => 'required|is_unique[tbl_jurusan.kode_jur]|max_length[3]',
            'jurusan' => 'required'
        ];
        $data= $this->request->getPost(array_keys($rules));
        if (!$this->validateData($data,$rules)) {
            return redirect()->to(base_url('/jurusan'))->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataJurusan = new JurusanModel();
        $dataJurusan->insert($data);
        if ($dataJurusan) {
            session()->setFlashdata(
                'pesan',
                '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Data Jurusan Berhasil Disimpan!</h5>
                </div>'
            );
        }
        return redirect()->to(base_url('/jurusan'));
    }

    public function editdata()
    {
        $dataJurusan = new JurusanModel();

        $data = [
            'jurusan'  => $this->request->getVar('jurusan')
        ];

        $rules = [
            'jurusan' => 'required'
        ];

        $data1 = $this->request->getPost(array_keys($rules));

        if (! $this->validateData($data1, $rules)) {
            return redirect()->to(base_url('/jurusan'))->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $dataJurusan = new JurusanModel();
        $kode_jur = $this->request->getVar('kode_jur');
        $update = $dataJurusan->update($kode_jur, $data);

        if ($update) {
            session()->setFlashdata(
                'pesan',
                '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Data Jurusan Berhasil Diedit!</h5>
                </div>'
            );
        }

        return redirect()->to(base_url('/jurusan'));
    }

    public function hapusdata($kode_jur = null)
    {
        $dataJurusan = new JurusanModel();
        $hapus = $dataJurusan->delete($kode_jur);

        if ($hapus) {
            session()->setFlashdata(
                'pesan',
                '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Data Jurusan Berhasil Dihapus!</h5>
                </div>'
            );
        }

        return redirect()->to(base_url('/jurusan'));
    }
}