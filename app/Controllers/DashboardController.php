<?php

namespace App\Controllers;

use App\Models\PoliModel;
use App\Models\DokterModel;

class DashboardController extends BaseController
{
    public function index()
    {
        if (session()->get('isLoggedIn') != true) {
            return redirect()->to(base_url('login'));
        }

        $poliModel = new PoliModel();
        $dokterModel = new DokterModel();
        
        $data = [
            'poli' => $poliModel->findAll(),
            'dokter' => $dokterModel->getDokter()
        ];
        return view('v_dashboard', $data);
    }
}
