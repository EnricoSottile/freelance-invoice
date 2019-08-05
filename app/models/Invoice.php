<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Payment;

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

    public function payments(){
        return $this->hasMany(Payment::class);
    }


    public function received_payments() {
        return $this->payments()->get()->filter(function($p) {
            return $p->isPayed();
        });
        
    }
}
