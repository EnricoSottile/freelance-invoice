<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \Auth;

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
        return response()->json(['uploads' => $resource->uploads()->get()]);
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
        $resource->uploads()->create([
            'user_id' => Auth::user()->id,
            'path' => $path,
        ]);

        return response()->json(['uploads' => $resource->uploads()->get()]);
    }


    // /**
    //  * Restores the specified resource from trash.
    //  *
    //  * @param  mixed  $resource
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($uploadId){

    // }


}
