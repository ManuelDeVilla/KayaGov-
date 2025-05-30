<?php

namespace App\Http\Controllers;

use App\Models\concerns_comments;
use Illuminate\Http\Request;
use App\Models\concerns;
use Illuminate\Support\Facades\Auth;

class ConcernsCommentsController extends Controller
{
    // Other methods ...

    /**
     * Store a newly created resource in storage.
     * Add Concern $concern as parameter to get the specific concern
     */
    public function store(Request $request, concerns $concern)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        // Use the Concern model instance to create comment
        $concern->comments()->create([
            'user_id' => Auth::id(),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->back()->with('success', 'Comment added!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $concerns = concerns::with('comments.user')->findOrFail($id);

        return view('citizens.concerns.details', compact('concerns'));
    }

    // Other methods ...
}
