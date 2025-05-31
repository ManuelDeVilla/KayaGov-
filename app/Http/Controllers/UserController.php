<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\provinces;
use App\Models\region;
use App\Models\city;
use App\Models\user_verification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class UserController extends Controller
{

    // For Register showing the search result of province city
    public function getSearchSelector (Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('selector_type');

        switch ($type) {
            case 'province':
                if ($request->input('province_id')) {
                    $province_id = $request->input('province_id');

                    $selected_provinces = provinces::where('province', 'like',  $search . '%')->where('id', $province_id)->orderBy('province', 'asc')->get();
                    $provinces = provinces::orderBy('province', 'asc')->get();
                    $cities = city::orderBy('city', 'asc')->get();

                    return response()->json(['provinces' => $selected_provinces, 'cities' => ['city' =>$cities, 'province' => $provinces]]);

                } else {
                    $province = provinces::where('province', 'like',  $search . '%')->orderBy('province', 'asc')->get();

                    return response()->json($province);
                }

            case 'city':

                if ($request->input('city_id')) {
                    $city_id = $request->input('city_id');

                    $provinces = provinces::orderBy('province', 'asc')->get();

                    $cities = city::where('province_id', $city_id)->where('city', 'like',  $search . '%')->orderBy('city', 'asc')->get();

                    return response()->json(['provinces' => $provinces, 'cities' => ['city' => $cities, 'province' => $provinces]]);

                } else {
                    $provinces = provinces::orderBy('province', 'asc')->get();
                    $city = city::where('city', 'like',  $search . '%')->orderBy('city', 'asc')->get();

                    return response()->json(['cities' => ['city' =>$city, 'province' => $provinces]]);

                }
        }
    }

    // For Register showing all of province city
    public function getShowSelector (Request $request) {
        // If there are province selected only select city that are in that province
        if ($request->input('province_id') && !$request->input('city_id')) {
            $province_id = $request->input('province_id');

            $selected_provinces = provinces::where('id', $province_id)->orderBy('province', 'asc')->get();
            $provinces = provinces::orderBy('province', 'asc')->get();
            $cities = city::orderBy('city', 'asc')->get();

            return response()->json(['provinces' => $selected_provinces, 'cities' => ['city' =>$cities, 'province' => $provinces]]);

            // Else if there are city selected, only select that province in that city
        } else if ($request->input('city_id') && !$request->input('province_id')) {
            $city_id = $request->input('city_id');

            $provinces = provinces::orderBy('province', 'asc')->get();
            $cities = city::where('province_id', $city_id)->orderBy('city', 'asc')->get();

            return response()->json(['provinces' => $provinces, 'cities' => ['city' => $cities, 'province' => $provinces]]);

        } else if ($request->has('city_id') && $request->has('province_id')) {
            $province_id = $request->input('province_id');

            $provinces = provinces::orderBy('province', 'asc')->get();
            $cities = city::where('province_id', $province_id)->orderBy('city', 'asc')->get();

            return response()->json(['provinces' => $provinces, 'cities' => ['city' => $cities, 'province' => $provinces]]);

        }
         else {
            $provinces = provinces::orderBy('province', 'asc')->get();
            $cities = city::orderBy('city', 'asc')->get();

            return response()->json(['provinces' => $provinces, 'cities' => ['city' =>$cities, 'province' => $provinces]]);
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
        // If route name is register then process its contents
        if (request()->routeIs('register')) {
            $validated = $request->validate([
            'username' => 'required|string|min:3|max:16|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required|in:Male,Female',
            'usertype' => 'required',
            'password' => 'required|min:6|max:20|confirmed'
            ]);

            if ($validated['gender'] == 'Male') {
                $image_path = '/storage/public/default-male.png';
            } else {
                $image_path = '/storage/public/default-female.png';
            }
            $validated['image_path'] = $image_path;

            session(['registering_user' => $validated]);
            return redirect()->route('show.register.location');

            // else if the routename is register.location, process its contents
        } else if (request()->routeIs('register.location')) {
            $registering_user = session()->pull('registering_user');
            
            if ($registering_user) {
                $regestering_user_username = $registering_user['username'];

                // If usertype is government then make their username government + province + city
                if ($registering_user['usertype'] == 'government') {
                    $province_row = provinces::find($request->input('province'));
                    $province_name = $province_row->province;

                    $city = city::find($request->input('city'));
                    $city_name = $city->city;

                    $registering_user['username'] = 'GOVERNMENT OF ' . $province_name . ' ' . $city_name . ' - ' . $regestering_user_username;
                }

                $created_account = User::create([
                'username' => $registering_user['username'],
                'email' => $registering_user['email'],
                'gender' => $registering_user['gender'],
                'usertype' => $registering_user['usertype'],
                'password' => $registering_user['password'],
                'image_path' => $registering_user['image_path'],
                'province_id' => $request->input('province'),
                'city_id' => $request->input('city')
                ]);

                // If the user that created the account is admin
                if (Auth::user()->usertype == 'admin') {
                    return redirect()->route('concern-list');

                    // If the user created the account is just a citizen
                } else {
                    Auth::login($created_account);
                    return redirect()->route('concern-list');
                }
            }
        }
    }

    // To Show Location form for register
    public function locationRegisterShow () {
        return view('auth.save-location');
    }

    // For Staff Creation
    public function showRegisterStaff () {
        return view('auth.staff.create-staff-account');
    }

    public function registerStaff (Request $request) {
        // If route name is register then process its contents
        if (request()->routeIs('staff.register')) {
            $validated = $request->validate([
            'username' => 'required|string|min:3|max:16|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required|in:Male,Female',
            'password' => 'required|min:6|max:20|confirmed'
            ]);

            if ($validated['gender'] == 'Male') {
                $image_path = '/storage/public/default-male.png';
            } else {
                $image_path = '/storage/public/default-female.png';
            }
            $validated['image_path'] = $image_path;
            $validated['usertype'] = 'user';

            session(['registering_user' => $validated]);
            return redirect()->route('staff.show.register.location');

            // else if the routename is register.location, process its contents
        } else if (request()->routeIs('staff.register.location')) {
            $registering_user = session()->pull('registering_user');
            
            $registering_user['province_id'] = $request->input('province');
            $registering_user['city_id'] = $request->input('city');

            session(['registering_user' => $registering_user]);

            return redirect()->route('staff.show.register.coe');

        } else if (request()->routeIs('staff.register.coe')) {

            $request->validate([
                'file' => 'required|file|mimes:pdf'
            ]);

            $registering_user = session()->pull('registering_user');

            $user_created = User::create($registering_user);

            $file_path = $request->file('file')->store('coe', 'public');

            user_verification::create([
                'user_id' => $user_created->id,
                'coe_path' => $file_path
            ]);

            Auth::login($user_created);
            return redirect()->route('concern-list');
        }
    }

    // To Show Location form for register
    public function locationStaffRegisterShow () {
        return view('auth.staff.save-location-staff');
    }

    // Upload COE
    public function coeUpload () {
        return view('auth.staff.upload-coe');
    }

    // Staff Waiting Page
    public function staffWaitingPage () {
        return view('auth.staff.staff-wating');
    }

    public function showLogin ()
    {
        return view('auth.login');
    }

    // Shows the list of all the user to be verified as a staff
    public function listStaffVerification (Request $request) {
        $to_verify = User::has('verification')->get();
        $verify_details = user_verification::all();
        $count_verify = user_verification::count();

        if ($request->ajax()) {
             return response()->json(['to_verify' => $to_verify, 'verify_details' => $verify_details]);
             
        } else {
            return view('admin.staff-verification', ['count_verify' => $count_verify]);
        }
    }

    // Change their usertype to staffs/Verifies the account
    public function staffVerification (Request $request) {
        $user_id = $request->input('user_id');
        $submit_type = $request->input('submit');

        if ($submit_type == 'accept') {
            $user = User::find($user_id);
            $user->usertype = 'staff';
            $user->save();
        }

        user_verification::where('user_id', $user_id)->delete();

        return redirect()->route('list.staff-verification');
    }
    
    public function login (Request $request) 
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($validated)) {

            return redirect()->route('dashboard')->with('success', 'Welcome back, ' . Auth::user()->username . '!');
        } else {
            throw ValidationException::withMessages([
                'error' => 'Sorry, Incorrect Email or Password. Please Try Again. Nigg@'
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('homepage');
    }

    // For creating new ADMIN or STAFF accounts
    public function showAccountForm () {
        return view('auth.create-account');
    }

    public function createAccount (Request $request) {
        
    }
}