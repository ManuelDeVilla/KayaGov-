<?php

namespace App\Http\Controllers;

use App\Models\system_feedback;
use Illuminate\Http\Request;

class SystemFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        'username' => 'required|string|max:255',
        'rating' => 'required|integer|min:1|max:5',
        'feedback' => 'required|string',
    ]);

    \App\Models\system_feedback::create([
        'username' => $request->username,
        'rating' => $request->rating,
        'feedback' => $request->feedback,
    ]);

    return redirect()->route('dashboard')->with('success', 'Feedback submitted!');
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
