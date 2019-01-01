<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $tableName = 'images';
    public function place()
    {
        return $this->belongsTo('App\Models\Place');
    }
}
