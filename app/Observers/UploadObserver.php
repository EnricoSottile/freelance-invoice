<?php

namespace App\Observers;

use Illuminate\Support\Facades\Storage;
use App\Models\Upload;

class UploadObserver
{
    //

    /**
     * Handle the upload "deleting" event.
     *
     * @param  \App\Models\Upload  $upload
     * @return void
     */
    public function deleting(Upload $upload)
    {        
        Storage::delete($upload->path);
    }
}
