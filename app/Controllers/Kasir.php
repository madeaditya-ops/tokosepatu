<?php

namespace App\Controllers;

class Kasir extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home'
        ];
        return view('kasir/dashboard', $data);
    }
}

