<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


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

    protected $appends = ['encoded_image'];
    public function getEncodedImageAttribute()
    {
        if (! Storage::disk('')->exists( $this->path )) {
            return '';
        }

        $file = Storage::disk('')->get( $this->path );
        return base64_encode($file);
    }

}
