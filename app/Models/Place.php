<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = [
        'name',
        'description',
        'address',
        'longitude',
        'latitude'
    ];
    public function images()
    {
        return $this->hasMany('App\Models\Image')->orderBy('created_at', 'DESC');
    }

    public function getCover()
    {
        return Image::where(['place_id' => $this->id, 'is_cover' => 1])->first();
    }

    public function getUrlCover()
    {
        return asset(env('PLACE_IMAGE_PATH').Image::where(['place_id' => $this->id,'is_cover' => 1])->first()['image']);
    }

    public function getUrlImages()
    {
        $data = [];
        $images = Image::where(['place_id' => $this->id])->get();
        foreach($images as $image){
            $data[]['url'] = asset(env('PLACE_IMAGE_PATH').$image->image);
        }
        return $data;
    }
}
