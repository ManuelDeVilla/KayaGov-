<?php

namespace App\Http\Controllers;

use App\Models\concerns;
use App\Models\concerns_image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConcernsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('citizens.create-concern');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate_concern = $request->validate([
            'title' => 'string|required',
            'description' => 'required',
            'category' => 'required',
            'city' => 'required'
        ]);

        $validate_concern['user_id'] = Auth::id();
        $validate_concern['status'] = 'pending';
        $validate_concern['priority'] = 0;
        $object_concern = concerns::create($validate_concern);

        $validate_images = $request->file('file');
        if ($validate_images) {
            foreach ($validate_images as $validate_image) {
                $image_path = $validate_image->store('image-concern', 'public');

                concerns_image::create([
                    'concerns_id' => $object_concern->id,
                    'image_path' => $image_path
                ]);
            }
        }

        return redirect()->route('homepage');
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
