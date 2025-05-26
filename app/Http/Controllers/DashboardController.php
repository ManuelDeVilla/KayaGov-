<?php


namespace App\Http\Controllers;
use App\Models\concerns;
use App\Models\city;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    
   public function index()
   {
        // Check user role and redirect to appropriate dashboard
        $user = Auth::user();
        
        if ($user->usertype === 'staff' || $user->usertype === 'admin') {
            return $this->staffDashboard();
        }
        
        return $this->citizenDashboard();
   }

   public function citizenDashboard()
   {
        // Fetch concerns using the concerns model for citizens - only user's own concerns
        $concerns = concerns::with(['concern_reports', 'concern_comments', 'concern_images'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Add city names to concerns
        foreach ($concerns as $concern) {
            $city = city::find($concern->city_id);
            $concern->city_name = $city ? $city->city : 'Unknown City';
        }

        return view('citizens.dashboard', compact('concerns'));
   }

   public function staffDashboard()
   {
        // Fetch data relevant for staff dashboard - all concerns
        $concerns = concerns::with(['concern_reports', 'concern_comments', 'concern_images', 'users'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Add city names to concerns
        foreach ($concerns as $concern) {
            $city = city::find($concern->city_id);
            $concern->city_name = $city ? $city->city : 'Unknown City';
        }

        // You might want different data for staff, like statistics
        $totalConcerns = concerns::count();
        $pendingConcerns = concerns::where('status', 'pending')->count();
        $resolvedConcerns = concerns::where('status', 'resolved')->count();

        return view('staff.dashboard', compact('concerns', 'totalConcerns', 'pendingConcerns', 'resolvedConcerns'));
   }
}