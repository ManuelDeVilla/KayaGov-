<?php

namespace App\Http\Controllers;

use App\Models\city;
use App\Models\provinces;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function show () {
        $province = provinces::all();
        $cities = city::orderBy('city', 'asc')->get();

        return response()->json(['city' => $cities, 'province' => $province]);
    }

    public function search (Request $request) {
        $province = provinces::all();
        $search_value = $request->input('search');
        $search_city = city::where('city', 'like', "%{$search_value}%")->orderBy('city', 'asc')->get();

        return response()->json(['city' => $search_city, 'province' => $province]);
    }
}
