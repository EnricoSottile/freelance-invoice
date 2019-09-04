<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Upload extends Model
{
    //

    protected $fillable = [
        'name', 'path', 'user_id',
    ];

    public function uploadable()
    {
        return $this->morphTo();
    }

    /**
     * encoded_image attribute(s) appended to the json cast of the model
     *
     * @var array
     */
    protected $appends = ['encoded_image'];
    
    /**
     * Returns encoded_image attribute as a base64 representation of the image
     *
     * @return String
     */
    public function getEncodedImageAttribute() : String
    {
        if (! Storage::exists( $this->path )) {
            return '';
        }

        $file = Storage::get( $this->path );
        return base64_encode($file);
    }

}
