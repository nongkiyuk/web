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
}
