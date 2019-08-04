<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    /**
     * 
     * @return bool
     */
    public function isPayed() : bool {
        return ! is_null($this->payed_date);
    }
}
