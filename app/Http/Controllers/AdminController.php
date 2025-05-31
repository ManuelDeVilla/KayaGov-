<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\concerns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function staffList()
    {
        $staffMembers = User::where('usertype', 'staff')->get();
        return view('admin.staff_lists.index', compact('staffMembers'));
    }
}