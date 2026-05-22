<?php

namespace App\Controllers;

class PasienDashboardController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard Pasien',
        ];
        return view('pasien/dashboard', $data);
    }
}
