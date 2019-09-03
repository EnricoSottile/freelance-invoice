<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class TrashController extends Controller
{

    /**
     * Validates a given model name and returns it
     *
     * @param  String  $resource
     * @return Model
     */
    private function getModel($resource) {
        $models = ['Customer', 'Invoice', 'Payment'];

        if (! in_array( $resource, $models, true )) {
            abort(403, 'This model does not exist');
        }

        return 'App\Models\\' .  $resource;
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
        $model = $this->getModel( ucfirst($resource) );
        $trashed = $model::withTrashed()->findOrFail($id);
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
        $model = $this->getModel( ucfirst($resource) );
        $trashed = $model::withTrashed()->findOrFail($id);
        $trashed->forceDelete();
        return response()->json();
    }
}
