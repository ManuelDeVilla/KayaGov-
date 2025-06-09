<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfileUser;
use App\Models\City;
use App\Models\Provinces;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $user = User::with(['city.province'])->find(Auth::id());
        
        $provinces = Provinces::all();
        $cities = City::all();
        
        return view('citizens.profile', compact('user', 'provinces', 'cities'));
    }
    
    public function update(Request $request)
    {
        $user = User::find(Auth::id());


        $request->validate([
            'username'    => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'       => 'email|unique:users,email,' . $user->id,
            'password'    => 'nullable|min:8|confirmed',
            'province'    => 'required|exists:provinces,id',
            'city_id'     => 'required|exists:cities,id',
        ]);

        $province = Provinces::find($request->province);
        $city = City::find($request->city_id);

        $user->username = $request->username;
        $user->email = $request->email;
        $user->province_id = $province ? $province->id : null;
        $user->city_id = $city ? $city->id : null;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|max:20|confirmed',
        ]);

        $user = User::find(Auth::id());
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }
}
