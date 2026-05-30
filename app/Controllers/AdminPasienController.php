<?php

namespace App\Controllers;

use App\Models\PasienModel;

class AdminPasienController extends BaseController
{
    protected $pasienModel;

    public function __construct()
    {
        $this->pasienModel = new PasienModel();
    }

    public function index()
    {
        $data = [
            'pasien' => $this->pasienModel->findAll()
        ];
        return view('v_pasien', $data);
    }

    public function simpandata()
    {
        $no_bpjs = $this->request->getVar('no_bpjs');
        if (!empty($no_bpjs)) {
            if (strlen($no_bpjs) > 13 || !ctype_digit($no_bpjs)) {
                session()->setFlashdata('pesan', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-ban"></i> Error!</h5>Nomor BPJS harus berupa angka dan maksimal 13 digit.</div>');
                return redirect()->to('/pasien');
            }
        }

        $this->pasienModel->insert([
            'no_rm' => $this->request->getVar('no_rm'),
            'nik' => $this->request->getVar('nik'),
            'nama_pasien' => $this->request->getVar('nama_pasien'),
            'tgl_lahir' => $this->request->getVar('tgl_lahir'),
            'jk' => $this->request->getVar('jk'),
            'alamat' => $this->request->getVar('alamat'),
            'no_bpjs' => $no_bpjs
        ]);
        session()->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-check"></i> Success!</h5>Data Berhasil Disimpan</div>');
        return redirect()->to('/pasien');
    }

    public function editdata()
    {
        $no_bpjs = $this->request->getVar('no_bpjs');
        if (!empty($no_bpjs)) {
            if (strlen($no_bpjs) > 13 || !ctype_digit($no_bpjs)) {
                session()->setFlashdata('pesan', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-ban"></i> Error!</h5>Nomor BPJS harus berupa angka dan maksimal 13 digit.</div>');
                return redirect()->to('/pasien');
            }
        }

        $this->pasienModel->save([
            'no_rm' => $this->request->getVar('no_rm'),
            'nik' => $this->request->getVar('nik'),
            'nama_pasien' => $this->request->getVar('nama_pasien'),
            'tgl_lahir' => $this->request->getVar('tgl_lahir'),
            'jk' => $this->request->getVar('jk'),
            'alamat' => $this->request->getVar('alamat'),
            'no_bpjs' => $no_bpjs
        ]);
        session()->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-check"></i> Success!</h5>Data Berhasil Diubah</div>');
        return redirect()->to('/pasien');
    }

    public function hapusdata($id)
    {
        $this->pasienModel->delete($id);
        session()->setFlashdata('pesan', '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h5><i class="icon fas fa-check"></i> Success!</h5>Data Berhasil Dihapus</div>');
        return redirect()->to('/pasien');
    }
}
