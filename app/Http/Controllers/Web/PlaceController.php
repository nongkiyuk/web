<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Place;

class PlaceController extends Controller
{
    public function index()
    {
        $places = Place::paginate(5);
        return view('web.place.index', [ 'places' => $places ]);
    }
}
