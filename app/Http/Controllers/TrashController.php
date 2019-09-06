<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Auth;

class TrashController extends Controller
{

    /**
     * Validates a given model name and returns it's relation by user
     *
     * @param  String  $resource
     * @return Model
     */
    private function getRelation($resource) {
        $models = ['customer', 'invoice', 'payment'];

        if (! in_array( $resource, $models, true )) {
            abort(403, 'This model does not exist');
        }

        $relation = $resource . 's';
        return Auth::user()->{$relation}()->onlyTrashed();
    }


    /**
     * Restores the specified resource from trash.
     *
     * @param  String  $resource
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($resource, $id)
    {
        $trashed = $this->getRelation($resource)->findOrFail($id);
        $trashed->restore();
        return response()->json();
    }

    /**
     * Delete the specified resource from trash.
     *
     * @param  String  $resource
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($resource, $id)
    {
        $trashed = $this->getRelation($resource)->findOrFail($id);
        $trashed->forceDelete();
        return response()->json();
    }
}
