<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Place as PlaceResource;
use App\Http\Resources\PlaceCollection;
use App\Models\Place;
use App\Models\Image;

class PlaceController extends Controller
{
    public function index()
    {
        return new PlaceCollection(Place::paginate(5));
    }

    public function detail($id)
    {
        return new PlaceResource(Place::find($id));
    }
}
