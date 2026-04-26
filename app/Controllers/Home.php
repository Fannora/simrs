<?php

namespace App\Controllers;
use App\Models\ModelUser;

class Home extends BaseController
{
    public function index()
    {
        if(session()->get('isLoggedIn') == true){
            return view('template/konten');
        }else {
            return redirect()->to(base_url('login'));
        }
    }

    public function login()
    {
        return view('login');
    }

    public function ceklogin()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $userModel= New ModelUser();
        $user= $userModel->where('username', $username)->first();

        if (!$user) {
            session()->setFlashdata('pesan', '<div class="alert alert-danger text-center"><h5>Username/Password Salah!</h5></div>');
            return redirect()->to(base_url('login'));
        }

        if (password_verify($password, $user['password'])) {
            session()->set([
                'isLoggedIn' => true,
                'nama' => $user['nama_lengkap'],
                'username' => $user['username'],
                'level_id' => $user['level_id']
            ]);
            return redirect()->to(base_url());
        } else {
            session()->setFlashdata('pesan', '<div class="alert alert-danger text-center"><h5>Username/Password Salah!</h5></div>');
            return redirect()->to(base_url('login'));
        }        
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}

?>