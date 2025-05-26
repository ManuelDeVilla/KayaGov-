<?php

namespace App\Http\Controllers;

use App\Models\city;
use App\Models\provinces;
use Illuminate\Http\Request;

class ProvincesController extends Controller
{
    public function listProvince(Request $request) {
        
        if ($request->input('city')) {
            $selected_city = $request->input('city');
            $find_city = city::where('id', $selected_city)->first();

            $province = provinces::where('id', $find_city->province_id)->first();
        } else {
            $province = provinces::orderBy('province', 'asc')->get();
        }
        return response()->json($province);
    }

    function searchListProvince(Request $request) {
        $search = $request->input('search');

        $province = provinces::where('province', 'like', $search . '%')->orderBy('province', 'asc')->get();

        return response()->json($province);
    }
}
