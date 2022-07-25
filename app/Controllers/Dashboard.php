<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        //
        $data = [
            'title' => 'Dashboard',
            "count_surat" => $this->SuratModel->countAll(),
            "count_surat_type_0" => $this->SuratModel->where('status', 0)->countAllResults(),
            "count_surat_type_1" => $this->SuratModel->where('status', 1)->countAllResults(),
            "count_surat_type_2" => $this->SuratModel->where('status', 2)->countAllResults(),
            "count_surat_type_3" => $this->SuratModel->where('status', 3)->countAllResults(),
            "count_surat_type_4" => $this->SuratModel->where('status', 4)->countAllResults(),
            'count_user' => $this->UserModel->countAll(),
        ];
        return view('dashboard/index', $data);
    }
}
