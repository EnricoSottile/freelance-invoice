<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \Auth;
use Illuminate\Support\Facades\Storage;


class UploadController extends Controller
{

    /**
     * Validates a given model name and returns it
     *
     * @param  String  $resource
     * @return Model
     */
    private function getModel($resource) {
        $models = ['Invoice'];

        if (! in_array( $resource, $models, true )) {
            abort(403, 'This model does not exist');
        }

        return 'App\Models\\' .  $resource;
    }


    /**
     * Returns a listing of the resource
     *
     * @param  String  $resource
     * @param  int  $resourceId
     * @return \Illuminate\Http\Response
     */
    public function index($resource, $resourceId){
        $model = $this->getModel( ucfirst($resource) );
        $resource = $model::findOrFail($resourceId);

        
        $uploads = $resource->uploads()->get();
        return response()->json(['uploads' => $uploads]);
    }




    /**
     * Uploads and stores a file in storage
     *
     * @param  String  $resource
     * @param  int  $resourceId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $resource, $resourceId){
        $model = $this->getModel( ucfirst($resource) );
        $resource = $model::findOrFail($resourceId);

        $path = $request->file('image')->store('private');

        try{
            
            $upload = $resource->uploads()->create([
                'path' => $path,
                'user_id' => Auth::user()->id,
            ]);

        } catch(\Illuminate\Database\QueryException $e) {
            Storage::delete($path);
            abort(403, $e->getMessage());
        }



        return response()->json(['upload' => $upload]);
    }

}
