<?php

namespace App\Http\Controllers;

use App\Models\city;
use App\Models\concerns;
use App\Models\concerns_comments;
use App\Models\concerns_image;
use App\Models\provinces;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConcernsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query_concerns = concerns::query();

        // If the sort exists and the search is empty
        if ($request->input('sort')) {
            $sort = $request->input('sort');

            foreach ($sort['status'] as $key => $value) {
                if ($value == 'true') {
                    $query_concerns->where('status', $key);
                    break;
                }
            }

            if ($sort['province'] != null) {
                $get_city_id = city::where('province_id', $sort['province'])->pluck('id');

                $query_concerns->whereIn('city_id', $get_city_id);
            }

            if ($sort['city'] != null) {
                $query_concerns->where('city_id', $sort['city']);
            }
        }

        if (Auth::check()) {
            if (Auth::user()->usertype == 'staff') {
                $user_city = Auth::user()->city_id;
                $query_concerns->where('city_id', $user_city);

            } else {
                $user_city = Auth::user()->city_id;
                $query_concerns->orderByRaw('city_id = ? DESC', [$user_city])->orderBy('id', 'desc');
            }
        }

        $concerns = $query_concerns->get();
        $city = city::all();

        // If request came from ajax return json
        if (request()->ajax()) {
            return response()->json([
                'concerns' => $concerns,
                'cities' => $city
            ]);

            // Else if it came as an http request return the view
        } else {
            return view('citizens.concerns.index', ['concerns' => $concerns]);
        }

        // Hindi ko sure kung kanino to pero, patry nalang gamiten yung code sa taas, since complete na siya with working js
    // Query concerns with filters
        // $provinces = Provinces::all();
        // $concerns = concerns::query()
        //     ->when($request->search, function($query, $search) {
        //         $query->where(function($q) use ($search) {
        //             $q->where('title', 'like', "%{$search}%")
        //               ->orWhere('description', 'like', "%{$search}%");
        //         });
        //     })
        //     ->when($request->status, function($query, $status) {
        //         $query->whereIn('status', $status);
        //     })
        //     ->when($request->province, function($query, $province) {
        //         $query->whereIn('province_id', $province);
        //     })
        //     ->latest()
        //     ->paginate(15);

        // return view('citizens.concerns.index', compact('concerns', 'provinces'));
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
            'city_id' => 'required'
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

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $concerns = concerns::findOrFail($id);
        return view('citizens.concerns.details', ['concerns' => $concerns]);          
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

    //For search in concern-list can be used whenever there is filter button for concern as long as the divs has same id's and classes 
    public function search (Request $request) {
        $search = $request->input('search');
        $query_concerns = concerns::query();

        if (Auth::check()) {
            $city = Auth::user()->city;

            $query_concerns->where('title', 'like', $search . '%')->orderByRaw('city_id = ? desc', [$city]);
        } else {
            $query_concerns->where('title', 'like', $search . '%');
        }

        if ($request->input('sort')) {
            $sort = $request->input('sort');

            foreach ($sort['status'] as $key => $value) {
                if ($value == 'true') {
                    $query_concerns->where('status', $key);
                    break;
                }
            }

            if ($sort['province'] != null) {
                $get_city_id = city::where('province_id', $sort['province'])->pluck('id');

                $query_concerns->whereIn('city_id', $get_city_id);
            }

            if ($sort['city'] != null) {
                $query_concerns->where('city_id', $sort['city']);
            }
        }


        $concerns = $query_concerns->orderBy('id', 'desc')->get();
        $city = city::all();

        return response()->json([
            'concerns' => $concerns,
            'cities' => $city
        ]);
    }

    //For sort in concern-list can be used whenever there is filter button for concern as long as the divs has same id's and classes 
    public function sort (Request $request) {
        // Create an object of concerns model
        $query = concerns::query();

        // Checks if sort key exists
        if ($request->input('sort')) {
            $sort = $request->input('sort');

            foreach ($sort['status'] as $key => $value) {
                if ($value == 'true') {
                    $query->where('status', $key);
                    break;
                }
            }

            if ($sort['province'] != null) {
                $get_city_id = city::where('province_id', $sort['province'])->pluck('id');

                $query->whereIn('city_id', $get_city_id);
            }

            if ($sort['city'] != null) {
                $query->where('city_id', $sort['city']);
            }
        }

        if ($request->input('search')) {
            $search_value = $request->input('search');

            $query->where('title', 'like', $search_value . '%');
        }

        if (Auth::check()) {
            $city_id = Auth::user()->city_id;

            $query->orderByRaw('city_id = ? desc', [$city_id]);
        }

        $concerns = $query->orderBy('id', 'desc')->get();
        $city = city::all();

        return response()->json([
            'concerns' => $concerns,
            'cities' => $city
        ]);
    }
}
