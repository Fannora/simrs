<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class LoginController extends BaseController
{
    public function index()
    {
        return view('frm_login');
    }

    public function savelogin(){
        $rules = [
            'fusername' => 'required|min_length[10]',
            'fpassword' => 'required|min_length[10]',
            'fpasswordagain' => 'required|min_length[10]|matches[fpassword]'
        ];

        $data = $this->request->getPost(array_keys($rules));

        if (!$this->validateData($data, $rules)) {
            return view('frm_login');
        }

        echo 'Data Login';
        echo '<br>';
        echo 'Username : '.$this->request->getVar('fusername');
        echo '<br>';
        echo 'Password : '.$this->request->getVar('fpassword');
        echo '<br>';
        echo 'Confirm Password : '.$this->request->getVar('fpasswordagain');
    }
}