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
        $concerns = concerns::with(['concern_reports', 'concern_comments', 'concern_images', 'city'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Add city names to concerns using the relationship
        foreach ($concerns as $concern) {
            $concern->city_name = $concern->city ? $concern->city->city : 'Unknown City';
        }

        return view('citizens.dashboard', compact('concerns'));
   }

   public function staffDashboard()
   {
        // Fetch data relevant for staff dashboard - all concerns
        $concerns = concerns::with(['concern_reports', 'concern_comments', 'concern_images', 'users', 'city'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Add city names to concerns using the relationship
        foreach ($concerns as $concern) {
            $concern->city_name = $concern->city ? $concern->city->city : 'Unknown City';
        }

          // Statistics for staff dashboard
        $totalConcerns = concerns::count();
        $pendingConcerns = concerns::where('status', 'pending')->count();
        $inProgressConcerns = concerns::where('status', 'in_progress')->count();
        $resolvedConcerns = concerns::where('status', 'resolved')->count();

        return view('staffs.dashboard', compact(
            'concerns', 
            'totalConcerns', 
            'pendingConcerns', 
            'inProgressConcerns',
            'resolvedConcerns'
        ));
   }
}