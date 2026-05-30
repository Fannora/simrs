<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table = 'tbl_tagihan';
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    /**
     * Query laporan keuangan dengan filter dinamis.
     * $filter berisi: tgl_dari, tgl_sampai, id_poli, id_dokter, jenis_bayar[], status_bayar, jenis_kunjungan
     */
    public function getLaporan(array $filter = []): array
    {
        $builder = $this->db->table('tbl_tagihan t')
            ->select('t.*, p.tgl_daftar, p.no_rm, ps.nama_pasien, d.nama_dokter, po.nama_poli, po.id_poli, d.id_dokter')
            ->join('tbl_pendaftaran p', 't.no_rawat = p.no_rawat')
            ->join('tbl_pasien ps', 'p.no_rm = ps.no_rm')
            ->join('tbl_dokter d', 'p.id_dokter = d.id_dokter')
            ->join('tbl_poli po', 'p.id_poli = po.id_poli');

        // Filter tanggal bayar
        if (!empty($filter['tgl_dari'])) {
            $builder->where('DATE(t.tgl_bayar) >=', $filter['tgl_dari']);
        }
        if (!empty($filter['tgl_sampai'])) {
            $builder->where('DATE(t.tgl_bayar) <=', $filter['tgl_sampai']);
        }

        // Filter poli
        if (!empty($filter['id_poli'])) {
            $builder->where('po.id_poli', $filter['id_poli']);
        }

        // Filter dokter
        if (!empty($filter['id_dokter'])) {
            $builder->where('d.id_dokter', $filter['id_dokter']);
        }

        // Filter jenis bayar (bisa multiple)
        if (!empty($filter['jenis_bayar']) && is_array($filter['jenis_bayar'])) {
            $builder->whereIn('t.jenis_bayar', $filter['jenis_bayar']);
        }

        // Filter status bayar
        if (!empty($filter['status_bayar']) && $filter['status_bayar'] !== 'Semua') {
            $builder->where('t.status_bayar', $filter['status_bayar']);
        }

        // Filter jenis kunjungan
        if (!empty($filter['jenis_kunjungan']) && $filter['jenis_kunjungan'] !== 'Semua') {
            $builder->where('t.jenis_kunjungan', $filter['jenis_kunjungan']);
        }

        return $builder->orderBy('t.id_tagihan', 'DESC')->get()->getResultArray();
    }

    public function getTotalPendapatanBulanIni(): float
    {
        $result = $this->db->query(
            "SELECT SUM(total_biaya) as total FROM tbl_tagihan
             WHERE status_bayar = 'Lunas'
             AND MONTH(tgl_bayar) = MONTH(CURDATE())
             AND YEAR(tgl_bayar) = YEAR(CURDATE())"
        )->getRowArray();
        return (float)($result['total'] ?? 0);
    }

    public function getPasienDilayani(): int
    {
        $result = $this->db->query(
            "SELECT COUNT(*) as total FROM tbl_tagihan
             WHERE status_bayar = 'Lunas'
             AND MONTH(tgl_bayar) = MONTH(CURDATE())
             AND YEAR(tgl_bayar) = YEAR(CURDATE())"
        )->getRowArray();
        return (int)($result['total'] ?? 0);
    }

    public function getTunggakan(): int
    {
        $result = $this->db->table('tbl_tagihan')
            ->where('status_bayar', 'Belum Lunas')
            ->countAllResults();
        return (int)$result;
    }
}
