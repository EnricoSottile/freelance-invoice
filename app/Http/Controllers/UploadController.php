<?php

namespace App\Http\Controllers;

use \Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class UploadController extends Controller
{
    /**
     * Show the resource
     *
     * @param  int  $id
     * @return Customer
     */
    public function show($id)
    {
        $upload = Auth::user()->uploads()->findOrFail($id);
        return Storage::response($upload->path);
    }


    /**
     * Show the resource
     *
     * @param  int  $id
     * @return Customer
     */
    public function download($id)
    {
        $upload = Auth::user()->uploads()->findOrFail($id);
        return Storage::download($upload->path);
    }

}
