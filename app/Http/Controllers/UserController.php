<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\provinces;
use App\Models\region;
use App\Models\city;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    // For Register showing the search result of region province city
    public function getSearchSelector (Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('selector_type');
        $get_search = null;

        switch ($type) {
            case 'region':
                $get_search = region::where('regions', 'like',  "%{$search}%")->get();
                break;

            case 'province':
                $get_search = provinces::where('province', 'like',  "%{$search}%")->orderBy('province', 'asc')->get();
                break;

            case 'city':
                $get_search = city::where('city', 'like',  "%{$search}%")->orderBy('city', 'asc')->get();
                break;
        }

        if ($get_search) {
            return response()->json($get_search);
        } else {
            return response()->json([
                'message' => "No Results Found!"
            ]);
        }
    }

    // For Register showing all of region province city
    public function getShowSelector (Request $request) {
        $regions = region::all();
        $provinces = provinces::orderBy('province', 'asc')->get();
        $cities = city::orderBy('city', 'asc')->get();

        if ($regions && $provinces && $cities) {
            return response()->json(['provinces' => $provinces, 'regions' => $regions, 'cities' => ['city' =>$cities, 'province' => $provinces]]);
        } else {
            return response()->json("No Results Found");
        }
    }

    // Shows register form
    public function showRegister ()
    {
        return view('auth.register');
    }

    // Processes register form
    public function register (Request $request)
    {
        // dump($request->all());

        $validated = $request->validate([
            'username' => 'required|string|min:3|max:12|unique:users,username',
            'email' => 'required|email',
            'gender' => 'required|in:Male,Female',
            'usertype' => 'required',
            'region' => 'required|exists:regions,regions',
            'province' => 'required|exists:provinces,province',
            'city' => 'required',
            'password' => 'required|min:6|max:20|confirmed'
        ]);

        if ($validated['gender'] == 'Male') {
            $image_path = '/storage/public/default-male.png';
        } else {
            $image_path = '/storage/public/default-female.png';
        }

        $validated['image_path'] = $image_path;
        $created_user = User::create($validated);
        Auth::login($created_user);

        return redirect()->route('homepage');
    }

    public function showLogin ()
    {
        return view('auth.login');
    }
    
    public function login () 
    {

    }

}
