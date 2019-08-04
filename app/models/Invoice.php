<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    /**
     * 
     * @return bool
     */
    public function isRegistered() : bool {
        return ! is_null($this->registered_date);
    }
}
