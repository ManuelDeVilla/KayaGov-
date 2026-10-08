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
            'username'          => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'             => 'email|unique:users,email,' . $user->id,
            'current_password'  => 'required_with:password|nullable',
            'password'          => 'nullable|min:8|confirmed',
            'province'          => 'required|exists:provinces,id',
            'city_id'           => 'required|exists:cities,id',
            'avatar'            => 'nullable|image|max:2048'
        ]);

        $user = Auth::user();

        // If the user is trying to set a new password, verify the current one first
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()
                    ->withErrors(['current_password' => 'Your current password is incorrect.'])
                    ->withInput();
            }

            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            $image_path = $request->file('avatar')->store('profile', 'public');
            $user->image_path = '/storage/' . $image_path;
        }

        $province = Provinces::find($request->province);
        $city = City::find($request->city_id);

        $user->username = $request->username;
        $user->email = $request->email;
        $user->province_id = $province ? $province->id : null;
        $user->city_id = $city ? $city->id : null;

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
