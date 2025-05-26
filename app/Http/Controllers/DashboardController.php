<?php

namespace App\Http\Controllers;
use App\Models\concerns;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
   public function index()
{
        // Fetch concerns using the concerns model
        $concerns = concerns::with(['concern_reports', 'concern_comments', 'concern_images', 'users'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', compact('concerns'));
    }

    
    
}
