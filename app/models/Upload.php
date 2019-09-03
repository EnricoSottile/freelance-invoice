<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    //

    protected $fillable = [
        'name', 'path', 'user_id'
    ];

    public function uploadable()
    {
        return $this->morphTo();
    }


}
