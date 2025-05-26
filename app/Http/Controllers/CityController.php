<?php

namespace App\Http\Controllers;

use App\Models\city;
use App\Models\provinces;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function show (Request $request) {
        $province = provinces::all();
        
        if ($request->input('province')) {
            $find_province = $request->input('province');
            $cities = city::where('province_id', $find_province)->orderBy('city', 'asc')->get();
        } else {
            $cities = city::orderBy('city', 'asc')->get();
        }

        return response()->json(['city' => $cities, 'province' => $province]);
    }

    public function search (Request $request) {
        $province = provinces::all();
        
        if ($request->input('province')) {
            $find_province = $request->input('province');
            $search_value = $request->input('search');

            $search_city = city::where('city', 'like', $search_value . '%')->where('province_id', $find_province)->orderBy('city', 'asc')->get();
        } else {
            $search_value = $request->input('search');
            $search_city = city::where('city', 'like', $search_value . '%')->orderBy('city', 'asc')->get();
        }

        return response()->json(['city' => $search_city, 'province' => $province]);
    }
}
