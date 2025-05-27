<?php

namespace App\Http\Controllers;

use App\Models\system_feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SystemFeedbackController extends Controller
{
    /**
     * Display a listing of the resource (Admin view).
     */
   
    public function index(Request $request)
    {
    // Check if user is admin
    if (Auth::user()->usertype !== 'admin') {
        return redirect()->route('dashboard')->with('error', 'Unauthorized access');
    }

    $query = system_feedback::with('user'); // Eager load user relationship

    // Filter by feedback source (citizen or government)
    if ($request->has('filter') && $request->filter !== 'all' && $request->filter !== null) {
        if ($request->filter === 'government') {
            $query->where(function($q) {
                // Check via user relationship
                $q->whereHas('user', function($userQuery) {
                    $userQuery->whereIn('usertype', ['admin', 'staff']);
                })
                // OR check via username lookup for records without user_id
                ->orWhereIn('username', function($subquery) {
                    $subquery->select('username')
                             ->from('users')
                             ->whereIn('usertype', ['admin', 'staff']);
                });
            });
        } else if ($request->filter === 'citizen') {
            $query->where(function($q) {
                // Check via user relationship
                $q->whereHas('user', function($userQuery) {
                    $userQuery->where('usertype', 'citizen');
                })
                // OR check via username lookup for records without user_id
                ->orWhereIn('username', function($subquery) {
                    $subquery->select('username')
                             ->from('users')
                             ->where('usertype', 'citizen');
                })
                // OR records with no user relationship and not in government usernames
                ->orWhere(function($q2) {
                    $q2->whereNull('user_id')
                       ->whereNotIn('username', function($subquery) {
                           $subquery->select('username')
                                    ->from('users')
                                    ->whereIn('usertype', ['admin', 'staff']);
                       });
                });
            });
        }
    }

    // Filter by status
    if ($request->has('status') && $request->status !== 'all' && $request->status !== null) {
        $query->where('status', $request->status);
    }

    // Filter by type
    if ($request->has('type') && $request->type !== 'all' && $request->type !== null) {
        $query->where('type', $request->type);
    }

    // Filter by rating
    if ($request->has('rating') && $request->rating !== 'all' && $request->rating !== null) {
        $query->where('rating', $request->rating);
    }

    $feedbacks = $query->orderBy('created_at', 'desc')->paginate(10);

    // Get statistics - more efficient queries
    $totalFeedbacks = system_feedback::count();
    
    // Count government feedbacks
    $governmentCount = system_feedback::where(function($q) {
        $q->whereHas('user', function($userQuery) {
            $userQuery->whereIn('usertype', ['admin', 'staff']);
        })
        ->orWhereIn('username', function($subquery) {
            $subquery->select('username')
                     ->from('users')
                     ->whereIn('usertype', ['admin', 'staff']);
        });
    })->count();
    
    // Count citizen feedbacks
    $citizenCount = $totalFeedbacks - $governmentCount;
    
    $pendingCount = system_feedback::where('status', 'pending')->count();

    $stats = [
        'total' => $totalFeedbacks,
        'citizen' => $citizenCount,
        'government' => $governmentCount,
        'pending' => $pendingCount,
    ];

    return view('admin.system_feedbacks.index', compact('feedbacks', 'stats'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('feedback.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'required|string',
            'type' => 'required|in:bug_report,feature_request,general_feedback,complaint',
            'priority' => 'required|in:low,medium,high'
        ]);

        system_feedback::create([
            'user_id' => Auth::id(),
            'username' => Auth::user()->username,
            'title' => $request->title,
            'rating' => $request->rating,
            'feedback' => $request->feedback,
            'type' => $request->type,
            'priority' => $request->priority
        ]);

        return redirect()->route('dashboard')->with('success', 'Feedback submitted successfully!');
    }

    /**
     * Update feedback status (admin only)
     */
    public function updateStatus(Request $request, system_feedback $feedback)
    {
        if (Auth::user()->usertype !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Unauthorized access');
        }

        $request->validate([
            'status' => 'required|in:pending,reviewed,resolved'
        ]);

        $feedback->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Feedback status updated successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(system_feedback $system_feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(system_feedback $system_feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, system_feedback $system_feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(system_feedback $system_feedback)
    {
        //
    }
}