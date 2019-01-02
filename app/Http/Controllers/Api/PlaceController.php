<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Place as PlaceResource;
use App\Http\Resources\PlaceCollection;
use App\Models\Place;
use App\Models\Image;
use App\Models\Favorite;


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

    public function addToFavorite(Request $request, $id)
    {

        $user = $request->user();
        $place = Place::find($id);
        $favorite = Favorite::where(['place_id' => $place->id, 'user_id' => $user->id]);
        if($favorite->count() != 0){
            return response()->json([
                'status' => 500,
                'data' => [
                    'msg' => 'Failed, Place has been added before'
                ]
            ], 201);
        }else if($favorite->count() == 0){
            $favorite = new Favorite();
            $favorite->user_id = $user->id;
            $favorite->place_id = $place->id;
            if($favorite->save()){
                return response()->json([
                    'status' => 200,
                    'data' => [
                        'msg' => 'Place added to Favorite'
                    ]
                ], 201);
            }
        }else{
            return response()->json([
                'status' => 500,
                'data' => [
                    'msg' => 'Something went wrong'
                ]
            ], 201);
        }

    }

    public function getListFavorite(Request $request)
    {
        $places = [];
        $user = $request->user();
        $favorites = Favorite::where(['user_id' => $user->id])->get();
        $favorites = [];
        foreach($favorites as $index => $favorite){
            $place = Place::find($favorite->place_id);
            $places['data'][$index] = $place;
            $places['data'][$index]['cover'] = ['url' => $place->getUrlCover()];
            $places['data'][$index]['images'] = $place->getUrlImages();
            $places['meta'] = ['total' => count($places['data'])];
        }
        if(count($places) == 0) {
            $places = [
                'data' => ['msg' => 'No Favorite Place'],
                'meta' => ['total' => '0']
            ];
        }
        return response()->json($places);
    }
}
