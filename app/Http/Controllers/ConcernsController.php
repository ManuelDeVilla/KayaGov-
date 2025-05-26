<?php

namespace App\Http\Controllers;

use App\Models\concerns;
use App\Models\concerns_comments;
use App\Models\concerns_image;
use App\Models\Provinces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ConcernsController extends Controller
{
    public function index(Request $request)
{

    
    // Query concerns with filters
        $provinces = Provinces::all();
        $concerns = concerns::query()
            ->when($request->search, function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($request->status, function($query, $status) {
                $query->whereIn('status', $status);
            })
            ->when($request->province, function($query, $province) {
                $query->whereIn('province_id', $province);
            })
            ->latest()
            ->paginate(15);

        return view('citizens.concerns.index', compact('concerns', 'provinces'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('citizens.concerns.create-concern');
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
    public function show($id)
    {
        $concerns = concerns::findOrFail($id);
        return view('citizens.concerns.details', compact('concern'));    
    }
        

     public function addComment(Request $request, concerns_comments $concern)
    {
        // $validated = $request->validate([
        //     'comment' => 'required|max:1000'
        // ]);

        // $concern->comments()->create([
        //     'user_id' => auth()->id(),
        //     'content' => $validated['comments']
        // ]);

        // return redirect()->back()->with('success', 'Comment added successfully!');
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
