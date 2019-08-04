<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use phpDocumentor\Reflection\Types\Boolean;

class Invoice extends Model
{
    use SoftDeletes;


    
    public function isRegistered() : bool {
        return ! is_null($this->registered_date);
    }
}
