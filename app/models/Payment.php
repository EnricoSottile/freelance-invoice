<?php

namespace App\models;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
