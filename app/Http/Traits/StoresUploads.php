<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

use \Auth;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Database\QueryException;

trait StoresUploads
{


    
    /**
     * Uploads a file and updates db records
     *
     * @param Request $request
     * @param Mixed $model
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, $model) {
        $path = $request->file('image')->store('private');

        try{
            $upload = $model->uploads()->create([
                'path' => $path,
                'user_id' => Auth::user()->id,
            ]);
        } catch(QueryException $e) {
            Storage::delete($path);
            abort(403, $e->getMessage());
        }

        return response()->json(['upload' => $upload]);
    }





}
