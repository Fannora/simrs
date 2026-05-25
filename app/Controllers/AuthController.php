<?php

namespace App\Controllers;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Validasi input
        if (empty($username) || empty($password)) {
            session()->setFlashdata('error', 'Username dan password wajib diisi.');
            return redirect()->to(base_url('login'));
        }

        // Query user dari database
        $db   = \Config\Database::connect();
        $user = $db->table('tbl_user')
            ->where('username', $username)
            ->get()
            ->getRowArray();

        if (!$user) {
            session()->setFlashdata('error', 'Username tidak ditemukan.');
            return redirect()->to(base_url('login'));
        }

        // Verifikasi password
        if (!password_verify($password, $user['password'])) {
            session()->setFlashdata('error', 'Password salah.');
            return redirect()->to(base_url('login'));
        }

        // Set session data
        session()->set([
            'id_user'  => $user['id_user'],
            'username' => $user['username'],
            'level_id' => $user['level_id'],
            'logged_in' => true,
        ]);

        // Jika Pasien, ambil nama dari tbl_pasien
        if ($user['level_id'] === 'Pasien') {
            $pasien = $db->table('tbl_pasien')
                ->where('id_user', $user['id_user'])
                ->get()
                ->getRowArray();

            if ($pasien) {
                session()->set([
                    'nama_lengkap' => $pasien['nama_pasien'],
                    'no_rm'        => $pasien['no_rm'],
                ]);
            }

            session()->setFlashdata('success', 'Login berhasil!');
            return redirect()->to(base_url('pasien/dashboard'));
        }

        // Jika Dokter, ambil nama dari tbl_dokter
        if ($user['level_id'] === 'Dokter') {
            $dokter = $db->table('tbl_dokter')
                ->where('id_user', $user['id_user'])
                ->get()
                ->getRowArray();

            if ($dokter) {
                session()->set('nama_lengkap', $dokter['nama_dokter']);
            } else {
                session()->set('nama_lengkap', $user['username']);
            }

            session()->setFlashdata('success', 'Login berhasil!');
            return redirect()->to(base_url('dokter/dashboard'));
        }

        // Admin → dashboard admin
        session()->set('nama_lengkap', $user['username']);
        session()->setFlashdata('success', 'Login berhasil!');
        return redirect()->to(base_url('admin/dashboard'));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }

    public function register()
    {
        return view('auth/register');
    }

    public function attemptRegister()
    {
        $data = $this->request->getPost();

        // Validasi input minimal
        if (empty($data['nama_lengkap']) || empty($data['username']) || empty($data['password']) || empty($data['nik']) || empty($data['tgl_lahir'])) {
            session()->setFlashdata('error', 'Semua field wajib harus diisi.');
            return redirect()->to(base_url('register'));
        }

        if ($data['password'] !== $data['konfirmasi_password']) {
            session()->setFlashdata('error', 'Password dan konfirmasi password tidak cocok.');
            return redirect()->to(base_url('register'));
        }

        $db = \Config\Database::connect();

        // Cek username unik
        $existingUser = $db->table('tbl_user')->where('username', $data['username'])->countAllResults();
        if ($existingUser > 0) {
            session()->setFlashdata('error', 'Username sudah terdaftar. Silakan pilih username lain.');
            return redirect()->to(base_url('register'));
        }

        // Cek NIK unik
        $existingNik = $db->table('tbl_pasien')->where('nik', $data['nik'])->countAllResults();
        if ($existingNik > 0) {
            session()->setFlashdata('error', 'NIK sudah terdaftar di sistem kami.');
            return redirect()->to(base_url('register'));
        }

        $db->transStart();

        // 1. Simpan ke tbl_user
        $db->table('tbl_user')->insert([
            'username'     => $data['username'],
            'password'     => password_hash($data['password'], PASSWORD_DEFAULT),
            'level_id'     => 'Pasien',
            'nama_lengkap' => $data['nama_lengkap']
        ]);
        
        $id_user = $db->insertID();

        // 2. Generate Nomor Rekam Medis (no_rm) menggunakan MAX()
        // Format: RM-00001
        $latestPasien = $db->table('tbl_pasien')->selectMax('no_rm')->get()->getRowArray();
        $nextNum = 1;
        if ($latestPasien && !empty($latestPasien['no_rm'])) {
            $num = (int) str_replace('RM-', '', $latestPasien['no_rm']);
            $nextNum = $num + 1;
        }
        $no_rm = 'RM-' . str_pad($nextNum, 5, '0', STR_PAD_LEFT);

        // 3. Simpan ke tbl_pasien
        $db->table('tbl_pasien')->insert([
            'id_user'     => $id_user,
            'no_rm'       => $no_rm,
            'nik'         => $data['nik'],
            'nama_pasien' => $data['nama_lengkap'],
            'tgl_lahir'   => $data['tgl_lahir'],
            'jk'          => $data['jk'],
            'alamat'      => $data['alamat'],
            'no_bpjs'     => empty($data['no_bpjs']) ? null : $data['no_bpjs']
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            session()->setFlashdata('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
            return redirect()->to(base_url('register'));
        }

        session()->setFlashdata('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
        return redirect()->to(base_url('login'));
    }

    public function forgotPassword()
    {
        return view('auth/forgot_password');
    }

    public function attemptForgotPassword()
    {
        $username = $this->request->getPost('username');
        $nik = $this->request->getPost('nik');
        $password = $this->request->getPost('password');
        $konfirmasi_password = $this->request->getPost('konfirmasi_password');

        if (empty($username) || empty($nik) || empty($password) || empty($konfirmasi_password)) {
            session()->setFlashdata('error', 'Semua field wajib harus diisi.');
            return redirect()->back();
        }

        if ($password !== $konfirmasi_password) {
            session()->setFlashdata('error', 'Kata sandi baru dan konfirmasi tidak cocok.');
            return redirect()->back();
        }

        $db = \Config\Database::connect();
        $user = $db->table('tbl_user')->where('username', $username)->get()->getRowArray();
        
        if (!$user) {
            session()->setFlashdata('error', 'Username tidak ditemukan.');
            return redirect()->back();
        }

        // Batasi hanya untuk Pasien
        if ($user['level_id'] !== 'Pasien') {
            session()->setFlashdata('error', 'Fitur atur ulang kata sandi mandiri hanya berlaku untuk Pasien. Bagi Dokter dan Admin, silakan hubungi pihak IT Support.');
            return redirect()->back();
        }

        // Verifikasi NIK Pasien
        $pasien = $db->table('tbl_pasien')
            ->where('id_user', $user['id_user'])
            ->where('nik', $nik)
            ->get()
            ->getRowArray();

        if ($pasien) {
            $db->table('tbl_user')
                ->where('id_user', $user['id_user'])
                ->update(['password' => password_hash($password, PASSWORD_DEFAULT)]);

            session()->setFlashdata('success', 'Kata sandi berhasil diatur ulang! Silakan masuk.');
            return redirect()->to(base_url('login'));
        } else {
            session()->setFlashdata('error', 'Verifikasi gagal: Nomor NIK salah.');
        }

        return redirect()->back();
    }
}
