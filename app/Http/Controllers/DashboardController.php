<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function citizen()
    {
        $concerns = [
            (object)[
                'title' => 'Flooded Street',
                'status' => 'Pending',
                'category' => 'Infrastructure',
                'city' => 'Santa Rosa',
                'description' => 'The main street is flooded after heavy rain.',
                'created_at' => now()->subDays(1),
            ],
            (object)[
                'title' => 'Broken Streetlight',
                'status' => 'In Progress',
                'category' => 'Utilities',
                'city' => 'Biñan',
                'description' => 'Streetlight on 5th Ave is not working.',
                'created_at' => now()->subDays(2),
            ],
            (object)[
                'title' => 'Garbage Collection Delay',
                'status' => 'Resolved',
                'category' => 'Sanitation',
                'city' => 'Calamba',
                'description' => 'Garbage has not been collected for a week.',
                'created_at' => now()->subDays(3),
            ],
            (object)[
                'title' => 'Noisy Construction',
                'status' => 'Pending',
                'category' => 'Community',
                'city' => 'San Pedro',
                'description' => 'Construction work is too loud at night.',
                'created_at' => now()->subDays(4),
            ],
        ];

        return view('dashboard.citizen', compact('concerns'));
    }
}
