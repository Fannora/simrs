<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MahasiswaModel;
use App\Models\ProdiModel;
use App\Models\JurusanModel;

class MahasiswaController extends BaseController
{
    public function index()
    {
        if(session()->get('isLoggedIn') == true){
            $MahasiswaMdl = new MahasiswaModel();
            $ProdiMdl = new ProdiModel();
            $JurusanMdl = new JurusanModel();
    
            $data = [
                'judul'     => 'Data Mahasiswa',
                'mahasiswa' => $MahasiswaMdl->select('tbl_mahasiswa.*, tbl_prodi.prodi, tbl_jurusan.jurusan')
                                        ->join('tbl_prodi', 'tbl_prodi.kode_prodi = tbl_mahasiswa.kode_prodi', 'left')
                                        ->join('tbl_jurusan', 'tbl_jurusan.kode_jur = tbl_mahasiswa.kode_jur', 'left')
                                        ->findAll(),
                'prodi'     => $ProdiMdl->select('tbl_prodi.*, tbl_jurusan.jurusan')
                                    ->join('tbl_jurusan', 'tbl_jurusan.kode_jur = tbl_prodi.kode_jur', 'left')
                                    ->findAll(),
                'jurusan'   => $JurusanMdl->findAll()
            ];
            return view('v_mahasiswa', $data);
        }else{
            return redirect()->to(base_url('login'));
        }
    }

    public function simpandata()
    {
        $dataMahasiswa = new MahasiswaModel();

        $jurusan_prodi = $this->request->getVar('jurusan_prodi');
        $kodes = explode('-', (string)$jurusan_prodi);

        $data = [
            'nim'        => $this->request->getVar('nim'),
            'nama'       => $this->request->getVar('nama'),
            'alamat'     => $this->request->getVar('alamat'),
            'jk'         => $this->request->getVar('jk'),
            'kode_prodi' => $kodes[1] ?? '',
            'kode_jur'   => $kodes[0] ?? ''
        ];

        $rules = [
            'nim'           => 'required|is_unique[tbl_mahasiswa.nim]|max_length[12]',
            'nama'          => 'required',
            'alamat'        => 'required',
            'jk'            => 'required',
            'jurusan_prodi' => 'required'
        ];

        $inputPost = $this->request->getPost(array_keys($rules));
        if (!$this->validateData($inputPost, $rules)) {
            return redirect()->to(base_url('/mahasiswa'))->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataMahasiswa->insert($data);
        if ($dataMahasiswa) {
            session()->setFlashdata(
                'pesan',
                '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Data Mahasiswa Berhasil Disimpan!</h5>
                </div>'
            );
        }
        return redirect()->to(base_url('/mahasiswa'));
    }

    public function editdata()
    {
        $dataMahasiswa = new MahasiswaModel();

        $jurusan_prodi = $this->request->getVar('jurusan_prodi');
        $kodes = explode('-', (string)$jurusan_prodi);

        $data = [
            'nama'       => $this->request->getVar('nama'),
            'alamat'     => $this->request->getVar('alamat'),
            'jk'         => $this->request->getVar('jk'),
            'kode_prodi' => $kodes[1] ?? '',
            'kode_jur'   => $kodes[0] ?? ''
        ];

        $rules = [
            'nama'          => 'required',
            'alamat'        => 'required',
            'jk'            => 'required',
            'jurusan_prodi' => 'required'
        ];

        $inputPost = $this->request->getPost(array_keys($rules));

        if (! $this->validateData($inputPost, $rules)) {
            return redirect()->to(base_url('/mahasiswa'))->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $nim = $this->request->getVar('nim');
        $update = $dataMahasiswa->update($nim, $data);

        if ($update) {
            session()->setFlashdata(
                'pesan',
                '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Data Mahasiswa Berhasil Diupdate!</h5>
                </div>'
            );
        }

        return redirect()->to(base_url('/mahasiswa'));
    }

    public function hapusdata($nim = null)
    {
        $dataMahasiswa = new MahasiswaModel();
        $hapus = $dataMahasiswa->delete($nim);

        if ($hapus) {
            session()->setFlashdata(
                'pesan',
                '<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Data Mahasiswa Berhasil Dihapus!</h5>
                </div>'
            );
        }

        return redirect()->to(base_url('/mahasiswa'));
    }
}