<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\concerns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\city;
use App\Models\provinces;

class AdminController extends Controller
{
    private function checkAdminAccess()
    {
        if (!Auth::check() || Auth::user()->usertype !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access');
        }
    }

    public function dashboard()
    {
        // Check if user is admin
        $this->checkAdminAccess();

        // Redirect to the main dashboard method which will handle admin routing
        return redirect()->route('dashboard');
    }

    public function verifyStaff($id)
    {
        $this->checkAdminAccess();

        $staff = User::findOrFail($id);
        $staff->is_verified = true;
        $staff->save();

        return redirect()->back()->with('success', 'Staff member verified successfully');
    }

    public function rejectStaff($id)
    {
        $this->checkAdminAccess();

        $staff = User::findOrFail($id);
        $staff->delete();

        return redirect()->back()->with('success', 'Staff application rejected');
    }

    public function deleteConcern($id)
    {
        $this->checkAdminAccess();

        $concern = concerns::findOrFail($id);
        $concern->delete();

        return redirect()->back()->with('success', 'Concern deleted successfully');
    }

    public function staffList(Request $request)
    {
        $search = $request->input('search');
        $province_id = $request->input('province');
        $city_id = $request->input('city');
        $usertype = $request->input('usertype');

        $query = User::query();

        // Only filter by usertype if one was actually selected — otherwise show all
        if ($usertype && in_array($usertype, ['staff', 'citizen', 'admin'])) {
            $query->where('usertype', $usertype);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', $search . '%')
                ->orWhere('email', 'like', $search . '%');
            });
        }

        if ($city_id) {
            $query->where('city_id', $city_id);
        } elseif ($province_id) {
            $city_ids = city::where('province_id', $province_id)->pluck('id');
            $query->whereIn('city_id', $city_ids);
        }

        $staffMembers = $query->orderBy('id', 'desc')->get();

        if ($request->ajax()) {
            return response()->json([
                'staff' => $staffMembers->map(function ($staff) {
                    return [
                        'id' => $staff->id,
                        'username' => $staff->username,
                        'email' => $staff->email,
                        'gender' => $staff->gender,
                        'usertype' => $staff->usertype,
                        'province' => $staff->province->province ?? '-',
                        'city' => $staff->city->city ?? '-',
                        'joined' => $staff->created_at ? $staff->created_at->format('M d, Y') : '-',
                    ];
                })
            ]);
        }

        return view('admin.staff_lists.index', [
            'staffMembers' => $staffMembers,
            'provinces' => provinces::orderBy('province', 'asc')->get(),
        ]);
    }

    public function deleteUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Prevent an admin from deleting their own account through this page
        if (Auth::id() == $user->id) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}