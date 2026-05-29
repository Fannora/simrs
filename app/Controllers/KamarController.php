<?php

namespace App\Controllers;

class KamarController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    private function checkAdmin()
    {
        if (!session()->get('id_user') || session()->get('level_id') !== 'Admin') {
            session()->setFlashdata('error', 'Akses ditolak.');
            return false;
        }
        return true;
    }

    public function index()
    {
        if (!$this->checkAdmin()) return redirect()->to(base_url('login'));

        $kamar = $this->db->table('tbl_kamar')
            ->orderBy('kelas', 'ASC')
            ->orderBy('nama_kamar', 'ASC')
            ->get()->getResultArray();

        return view('admin/kelola_kamar', ['kamar' => $kamar]);
    }

    public function store()
    {
        if (!$this->checkAdmin()) return redirect()->to(base_url('login'));

        $nama_kamar      = $this->request->getPost('nama_kamar');
        $kelas           = $this->request->getPost('kelas');
        $harga_per_malam = $this->request->getPost('harga_per_malam');

        if (empty($nama_kamar) || empty($kelas) || $harga_per_malam === null) {
            session()->setFlashdata('error', 'Semua field wajib diisi.');
            return redirect()->to(base_url('admin/kamar'));
        }

        $this->db->table('tbl_kamar')->insert([
            'nama_kamar'      => $nama_kamar,
            'kelas'           => $kelas,
            'harga_per_malam' => (float)$harga_per_malam,
            'status'          => 'Tersedia',
        ]);

        session()->setFlashdata('success', 'Kamar berhasil ditambahkan.');
        return redirect()->to(base_url('admin/kamar'));
    }

    public function update($id = null)
    {
        if (!$this->checkAdmin()) return redirect()->to(base_url('login'));

        $kamar = $this->db->table('tbl_kamar')->where('id_kamar', $id)->get()->getRowArray();
        if (!$kamar || $kamar['status'] === 'Terisi') {
            session()->setFlashdata('error', 'Kamar sedang terisi, tidak dapat diedit.');
            return redirect()->to(base_url('admin/kamar'));
        }

        $this->db->table('tbl_kamar')
            ->where('id_kamar', $id)
            ->update([
                'nama_kamar'      => $this->request->getPost('nama_kamar'),
                'kelas'           => $this->request->getPost('kelas'),
                'harga_per_malam' => (float)$this->request->getPost('harga_per_malam'),
            ]);

        session()->setFlashdata('success', 'Data kamar berhasil diubah.');
        return redirect()->to(base_url('admin/kamar'));
    }
}
