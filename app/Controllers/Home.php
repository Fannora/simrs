<?php

namespace App\Controllers;

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
        $password = $this->request->getVar('password');

        if ($username == 'admin' && $password == 'admin123') {
            session()->set([
                'isLoggedIn' => true,
                'username' => $username
            ]);
            return redirect()->to(base_url('jurusan'));
        } else {
            return redirect()->to(base_url('login'))->with('error', 'Username atau password salah');
        }        
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}

?>