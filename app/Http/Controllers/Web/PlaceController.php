<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlaceController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function showFormLogin()
    {
        return view('login');
    }
}
