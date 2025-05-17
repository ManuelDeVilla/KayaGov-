<?php

namespace App\Http\Controllers;

use App\Models\concerns;
use Illuminate\Http\Request;

class ConcernsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $concerns = \App\Models\concerns::all();
    return view('concerns.index', compact('concerns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(concerns $concerns)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(concerns $concerns)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, concerns $concerns)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(concerns $concerns)
    {
        //
    }
}
