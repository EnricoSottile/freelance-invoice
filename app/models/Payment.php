<?php

namespace App\models;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Helpers\PaymentStatus;

class Payment extends Model
{
    use SoftDeletes;


    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }

    /**
     * 
     * @return bool
     */
    public function isPayed() : bool {
        return ! is_null($this->payed_date);
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
     * Returns a bool indicating the destroyable status of the payment
     *
     * @return String
     */
    public function getIsDestroyableAttribute() : bool
    {
        $status = new PaymentStatus($this);
        return $status->canBeDeleted();
    }


    /**
     * Returns a bool indicating the destroyable status of the payment
     *
     * @return String
     */
    public function getIsEditableAttribute() : bool
    {
        $status = new PaymentStatus($this);
        return $status->canBeUpdated();
    }
}
