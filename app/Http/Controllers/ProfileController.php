<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfileUser;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $userId = Auth::id();
        $profile = ProfileUser::where('user_id', $userId)->first();
        return view('citizens.profile', compact('profile'));
    }
    
    public function update(Request $request)
    {
        $userId = Auth::id();

        // Find or create the user's profile record
        $profile = ProfileUser::firstOrCreate(
            ['user_id' => $userId],
            ['first_name' => '', 'last_name' => '', 'email' => '', 'phone' => '']
        );

        // Update profile fields with validated inputs
        $profile->first_name = $request->input('firstName');
        $profile->last_name = $request->input('lastName');
        $profile->email = $request->input('email');
        $profile->phone = $request->input('phone');
        $profile->update();

        return back()->with('success', 'Profile updated!');
    }
}
