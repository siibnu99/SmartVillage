<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Log extends BaseController
{
    public function index()
    {
        $data = ['title' => "Log Activity", 'list' => directory_map(WRITEPATH . 'logs')];
        return view('log/index', $data);
    }
    public function detail($fileName = null)
    {
        $data = ['title' => "Log Activity", 'data' => file_get_contents(WRITEPATH . 'logs/' . $fileName . '.log')];
        log_message('info', 'Testing saja');
        return view('log/detail', $data);
    }
}
