<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Payment;
use App\Models\Customer;
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
    
    public function customer(){
        return $this->belongsTo(Customer::class);
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

    public function deleteUnpayedPayments(){
        $this->unpayed_payments()->each(function($p) {
            $p->delete();
        });
    }

    public function trashed_payments() {
        return $this->payments()->onlyTrashed()->get();
    }

    public function restoreTrashedPayments(){
        $this->trashed_payments()->each(function($p) {
            $p->restore();
        });
    }

    public function uploads()
    {
        return $this->morphMany(Upload::class, 'uploadable');
    }

    public function deleteUploads(){
        $this->uploads()->each(function($upload){
            $upload->delete();
        });
    }
}
