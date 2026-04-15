<?php

namespace App\Controllers;
use App\Models\ModelUser;

class Home extends BaseController
{
    public function index()
    {
        if(session()->get('isLoggedIn') == true){
            return redirect()->to(base_url('jurusan'));
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
        $password = md5($this->request->getVar('password'));

        $userModel= New ModelUser();
        $user= $userModel->where('username', $username)->first();

        if (!$user) {
            session()->setFlashdata('pesan', '<div class="alert alert-danger text-center"><h5>Username/Password Salah!</h5></div>');
            return redirect()->to(base_url('login'));
        }

        if ($username === $user['username'] && $password == $user['password']) {
            session()->set([
                'isLoggedIn' => true,
                'username' => $username
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