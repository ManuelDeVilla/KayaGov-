<?php

namespace App\Http\Controllers;

use App\Models\concern_priorities;
use Illuminate\Http\Request;

class ConcernPrioritiesController extends Controller
{
    
    public function addPriority (Request $request) {
        $concern_id = $request->input('concern_id');
        $user_id = $request->input('user_id');

        $checker = concern_priorities::where('user_id', $user_id)->where('concern_id', $concern_id)->get();

        if ($checker->isEmpty()) {
            concern_priorities::create([
                'concern_id' => $concern_id,
                'user_id' => $user_id
            ]);
        } else {
            concern_priorities::where('user_id', $user_id)->where('concern_id', $concern_id)->delete();
        }

        $count_prioritize = concern_priorities::where('concern_id', $concern_id)->count();

        return response()->json($count_prioritize);
    }
}
