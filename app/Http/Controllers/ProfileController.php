<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfileUser;
use App\Models\city;
use App\Models\provinces;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $user = User::with(['city.province'])->find(Auth::id());
        
        $provinces = provinces::all();
        $cities = city::all();
        
        return view('citizens.profile', compact('user', 'provinces', 'cities'));
    }
    
    public function update(Request $request)
            {
                $user = User::find(Auth::id());

                $request->validate([
                    'username' => 'required|string|max:255|unique:users,username,' . $user->id,
                    'email' => 'email|unique:users,email,' . $user->id,
                    'password' => 'nullable|min:8|confirmed',
                    'province_id' => 'exists:provinces,id',
                    'city_id' => 'exists:cities,id',
                ]);

                $user->username = $request->username;
                $user->email = $request->email;

                // Get province name from provinces table by id
                $province = provinces::find($request->province)->province;
                $city = City::find($request->city_id);

                $user->province = $province ? $province->province : null; // save province name
                $user->city = $city ? $city->city : null;                // save city name

                if ($request->password) {
                    $user->password = Hash::make($request->password);
                }

                $user->save();

                return redirect()->back()->with('success', 'Profile updated successfully!');
            }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'min:6|max:20',
            
        ]);

        $user = User::find(Auth::id());

        // Only update the password explicitly
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }


}
