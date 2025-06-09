<?php


namespace App\Http\Controllers;
use App\Models\concerns;
use App\Models\city;
use App\Models\User;
use App\Models\user_verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    
   public function index()
   {
        // Check user role and redirect to appropriate dashboard
        $user = Auth::user();
        
        if ($user->usertype === 'admin') {
            return $this->adminDashboard();
        } else if ($user->usertype === 'staff') {
            return $this->staffDashboard();
        }
        
        return $this->citizenDashboard();
   }

   public function citizenDashboard()
   {
        // Fetch concerns using the concerns model for citizens - only user's own concerns
        $concerns = concerns::with(['concern_reports', 'comments', 'concern_images', 'city'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Add city names to concerns using the relationship
        foreach ($concerns as $concern) {
            $concern->city_name = $concern->city ? $concern->city->city : 'Unknown City';
        }
         // Count each status type
        $totalConcerns = concerns::count();
        $pendingConcerns = concerns::where('status', 'pending')->count();
        $inProgressConcerns = concerns::where('status', 'in progress')->count();
        $resolvedConcerns = concerns::where('status', 'resolved')->count();

        return view('citizens.dashboard', compact(
            'concerns', 
            'totalConcerns', 
            'pendingConcerns', 
            'inProgressConcerns',
            'resolvedConcerns'
        ));
   }

   public function staffDashboard()
   {
        // Fetch data relevant for staff dashboard - all concerns
        $concerns = concerns::with(['concern_reports', 'comments', 'concern_images', 'users', 'city'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Add city names to concerns using the relationship
        foreach ($concerns as $concern) {
            $concern->city_name = $concern->city ? $concern->city->city : 'Unknown City';
        }

        // Count each status type
    $totalConcerns = concerns::count();
    $pendingConcerns = concerns::where('status', 'pending')->count();
    $inProgressConcerns = concerns::where('status', 'in progress')->count();
    $resolvedConcerns = concerns::where('status', 'resolved')->count();

    return view('staffs.dashboard', compact(
        'concerns', 
        'totalConcerns', 
        'pendingConcerns', 
        'inProgressConcerns',
        'resolvedConcerns'
    ));
}

   public function adminDashboard()
   {
        // Get all statistics for admin (simplified without is_verified)
        $totalVerifications = user_verification::count();
        $totalStaff = User::where('usertype', 'staff')->count();
        $totalCitizens = User::where('usertype', 'citizen')->count();
        $totalConcerns = concerns::count();
        $pendingConcerns = concerns::where('status', 'pending')->count();

        // Get all staff members
        $staffMembers = User::where('usertype', 'staff')->get();

        // Get all concerns for admin to manage
        $allConcerns = concerns::with(['users', 'city'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Add city names to concerns
        foreach ($allConcerns as $concern) {
            $concern->city_name = $concern->city ? $concern->city->city : 'Unknown City';
        }

        return view('admin.dashboard', compact(
            'totalVerifications',
            'totalStaff',
            'totalCitizens',
            'totalConcerns',
            'pendingConcerns',
            'staffMembers',
            'allConcerns'
        ));
   }
}