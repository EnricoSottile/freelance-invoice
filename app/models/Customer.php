<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Invoice;
use App\Models\Payment;

class Customer extends Model
{
    use SoftDeletes;

    public function canBeDestroyed(){
        $invoices = $this->registered_invoices()->count();
        $payments = $this->payed_payments()->count();
        return $invoices === 0 && $payments === 0;
    }


    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

    public function registered_invoices(){
        return $this->invoices()->get()->filter(function($inv) {
            return $inv->isRegistered();
        });
    }


    public function unregistered_invoices(){
        return $this->invoices()->get()->filter(function($inv) {
            return ! $inv->isRegistered();
        });
    }


    public function trashed_invoices() {
        return $this->invoices()->onlyTrashed()->get();
    }



    public function payments(){
        return $this->hasManyThrough(Payment::class, Invoice::class);
    }

    public function payed_payments(){
        return $this->payments()->get()->filter(function($p) {
            return $p->isPayed();
        });
    }

    
}
