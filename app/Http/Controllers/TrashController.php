<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class TrashController extends Controller
{
    /**
     * Restores the specified resource from trash.
     *
     * @param  mixed  $resource
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($resource, $id)
    {
        $model = 'App\Models\\' .  ucfirst($resource);
        $trashed = $model::withTrashed()->findOrFail($id);
        $trashed->restore();
        return response()->json();
    }

    /**
     * Delete the specified resource from trash.
     *
     * @param  mixed  $resource
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($resource, $id)
    {
        $model = 'App\Models\\' .  ucfirst($resource);
        $trashed = $model::withTrashed()->findOrFail($id);
        $trashed->forceDelete();
        return response()->json();
    }
}
