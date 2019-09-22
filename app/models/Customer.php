<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Upload;

use App\Helpers\CustomerStatus;


class Customer extends Model
{
    use SoftDeletes;


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

    public function deleteUnregisteredInvoices(){
        $this->unregistered_invoices()->each(function($inv) {
            $inv->delete();
        });
    }


    public function trashed_invoices() {
        return $this->invoices()->onlyTrashed()->get();
    }

    public function restoreTrashedInvoices(){
        $this->trashed_invoices()->each(function($inv) {
            $inv->restore();
        });
    }



    public function payments(){
        return $this->hasManyThrough(Payment::class, Invoice::class);
    }

    public function payed_payments(){
        return $this->payments()->get()->filter(function($p) {
            return $p->isPayed();
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


    /**
     * Returns a bool indicating the destroyable status of the customer
     *
     * @return String
     */
    public function getIsDestroyableAttribute() : bool
    {
        $status = new CustomerStatus($this);
        return $status->canBeDeleted();
    }


    /**
     * Returns a bool indicating the destroyable status of the customer
     *
     * @return String
     */
    public function getIsEditableAttribute() : bool
    {
        $status = new CustomerStatus($this);
        return $status->canBeUpdated();
    }
    
}
