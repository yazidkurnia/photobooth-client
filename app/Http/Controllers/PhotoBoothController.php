<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotoBoothController extends Controller
{
    public function index()
    {
        return view('photobooth');
    }
}
