<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

use \Auth;

trait DestroyAndRestore
{



    /**
     * Restores the specified resource from trash.
     *
     * @param Mixed $model
     * @return \Illuminate\Http\Response
     */
    public function restore($trashed)
    {
        $trashed->restore();

        return response()->json([]);

    }


    /**
     * Completely deletes the specified resource.
     *
     * @param Mixed $model
     * @return \Illuminate\Http\Response
     */
    public function destroy($trashed)
    {
        $trashed->forceDelete();
        return response()->json([]);
    }

}
