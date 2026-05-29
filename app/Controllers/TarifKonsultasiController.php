<?php

namespace App\Controllers;

class TarifKonsultasiController extends BaseController
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

        $tarif = $this->db->table('tbl_tarif_konsultasi tk')
            ->select('tk.*, p.nama_poli')
            ->join('tbl_poli p', 'tk.id_poli = p.id_poli')
            ->orderBy('p.nama_poli', 'ASC')
            ->get()->getResultArray();

        $poli = $this->db->table('tbl_poli')->orderBy('nama_poli', 'ASC')->get()->getResultArray();

        return view('admin/kelola_tarif_konsultasi', [
            'tarif' => $tarif,
            'poli'  => $poli,
        ]);
    }

    public function store()
    {
        if (!$this->checkAdmin()) return redirect()->to(base_url('login'));

        $id_poli    = $this->request->getPost('id_poli');
        $nama_tarif = $this->request->getPost('nama_tarif');
        $harga      = $this->request->getPost('harga');

        if (empty($id_poli) || empty($nama_tarif) || $harga === null || $harga === '') {
            session()->setFlashdata('error', 'Semua field wajib diisi.');
            return redirect()->to(base_url('admin/tarif-konsultasi'));
        }

        $this->db->table('tbl_tarif_konsultasi')->insert([
            'id_poli'    => $id_poli,
            'nama_tarif' => $nama_tarif,
            'harga'      => (float)$harga,
            'is_active'  => 1,
        ]);

        session()->setFlashdata('success', 'Tarif konsultasi berhasil ditambahkan.');
        return redirect()->to(base_url('admin/tarif-konsultasi'));
    }

    public function update($id = null)
    {
        if (!$this->checkAdmin()) return redirect()->to(base_url('login'));

        $this->db->table('tbl_tarif_konsultasi')
            ->where('id_tarif', $id)
            ->update([
                'id_poli'    => $this->request->getPost('id_poli'),
                'nama_tarif' => $this->request->getPost('nama_tarif'),
                'harga'      => (float)$this->request->getPost('harga'),
            ]);

        session()->setFlashdata('success', 'Tarif konsultasi berhasil diubah.');
        return redirect()->to(base_url('admin/tarif-konsultasi'));
    }

    public function toggle($id = null)
    {
        if (!$this->checkAdmin()) return redirect()->to(base_url('login'));

        $current = $this->db->table('tbl_tarif_konsultasi')
            ->where('id_tarif', $id)->get()->getRowArray();

        if ($current) {
            $newStatus = $current['is_active'] ? 0 : 1;
            $this->db->table('tbl_tarif_konsultasi')
                ->where('id_tarif', $id)
                ->update(['is_active' => $newStatus]);
            $msg = $newStatus ? 'diaktifkan' : 'dinonaktifkan';
            session()->setFlashdata('success', "Tarif berhasil $msg.");
        }

        return redirect()->to(base_url('admin/tarif-konsultasi'));
    }
}
