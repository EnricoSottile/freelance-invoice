<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Payment;
use App\Models\Upload;

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


    public function payed_payments() {
        return $this->payments()->get()->filter(function($p) {
            return $p->isPayed();
        });
    }


    public function unpayed_payments() {
        return $this->payments()->get()->filter(function($p) {
            return ! $p->isPayed();
        });
    }

    public function trashed_payments() {
        return $this->payments()->onlyTrashed()->get();
    }

    public function uploads()
    {
        return $this->morphMany(Upload::class, 'uploadable');
    }
}
