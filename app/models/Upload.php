<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    //

    protected $fillable = [
        'name', 'path'
    ];

    public function uploadable()
    {
        return $this->morphTo();
    }


}
