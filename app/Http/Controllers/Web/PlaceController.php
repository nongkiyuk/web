<?php

namespace App\Http\Controllers\Web;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Image;
use File;
class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $places = Place::orderBy('created_at', 'DESC')->paginate(5);
        return view('web.place.index', [ 'places' => $places ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web.place.form');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function image($id)
    {
        $place = Place::find($id);
        return view('web.place.image',['id' => $id, 'place' => $place]);
    }

    /**
     * Create the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadImage(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'image',
        ]);
        $place = Place::find($id);
        if($place->count() > 0 && (!$validator->fails())){
            $image = $request->file('file');
            $name = $image->hashName();
            if($image = $image->move(env('PLACE_IMAGE_PATH'), $name)){
                $newImage = new Image();
                $newImage->place_id = $place->id;
                $newImage->image = $name;
                if(Image::where(['place_id' => $id])->count() == 0){
                    $newImage->is_cover = '1';    
                }else{
                    $newImage->is_cover = '0';
                }
                if($newImage->save()){
                    return response()->json([
                            'data' => [
                                'id' => $newImage->id,
                                'cover' => $newImage->is_cover,
                                'url' => asset(env('PLACE_IMAGE_PATH').$name),
                            ],
                            'message' => 'Success Added Image',
                            200
                        ], 200);
                }
            }
        }
        //Error Response 500
        return response()->json([
            'Something went wrongs'
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyImage($placeId, $imageId)
    {
        $image = Image::where(['place_id' => $placeId,'id' => $imageId])->first();
        if($image->is_cover == 1){
            return response()->json([
                'Something went wrongs '
            ], 500);
        }
        if(File::delete(env('PLACE_IMAGE_PATH').$image->image)){
            if($image->delete()){
                return response()->json([
                    'Success Deleted Image'
                ], 200);
            }
        }
        return response()->json([
            'Something went wrongs '
        ], 500);
    }

    /**
     * Update the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function coverImage($placeId, $imageId)
    {
        $image = Image::where(['place_id' => $placeId])->update(['is_cover' => '0']);
        $image = Image::where(['place_id' => $placeId,'id' => $imageId])->update(['is_cover' => '1']);
        if($image){
            return redirect()->route('place.images', $placeId)->with('success', 'Cover Image has been change');
        }else{
            return redirect()->route('place.images', $placeId)->with('danger', 'Something went wrong');
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required',
            'address' => 'required|max:255',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);
        
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $place = new Place();
        $place->fill($request->input());
        if($place->save()){
             return redirect()->route('place.images', $place->id)->with('success', 'New place has been added, plase add some images');
        }else{
            return back()->withErrors(['msg' => 'Something went wrongs'])->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $place = Place::find($id);
        return view('web.place.form',['place' => $place]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required',
            'address' => 'required|max:255',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);
        
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $place = Place::find($id);
        $place->fill($request->input());
        if($place->save()){
             return redirect()->route('index')->with('success', 'The place has been updated');
        }else{
            return back()->withErrors(['msg' => 'Something went wrongs'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $images = Image::where(['place_id' => $id]);
        foreach ($images->get() as $image) {
            File::delete(env('PLACE_IMAGE_PATH').$image->image);
        }
        $images->delete();
        if(Place::where(['id' => $id])->delete()){
            return redirect()->route('index')->with('success', 'The place has been delete');
        }else{
            return redirect()->route('index')->with('danger', 'Something went wrong!');
        }
    }
}
