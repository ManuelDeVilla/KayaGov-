<?php

namespace App\Http\Controllers;

use App\Models\city;
use App\Models\concern_priorities;
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
        $search = $request->input('search');
        $concerns = $this->buildConcernsQuery($request, null, $search);
        $city = city::all();
        $result_count = $concerns->count();

        // If request came from ajax return json
        if (request()->ajax()) {
            return response()->json([
                'concerns' => $concerns,
                'cities' => $city,
            ]);
            // Else if it came as an http request return the view
        } else {
            return view('citizens.concerns.index', [
                'concerns' => $concerns,
                'concerns_count' => $result_count,
                'page' => 'reported'
            ]);
        }
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
            'city_id' => 'required',
            'file.*' => 'image'
        ]);

        $validate_concern['user_id'] = Auth::id();
        $validate_concern['status'] = 'pending';
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
        $concerns = concerns::with('concern_images')->findOrFail($id);
        $imageCount = optional($concerns->concern_images)->count();
        return view('citizens.concerns.details', [
            'concerns' => $concerns,
            'image_count' => $imageCount
            ]);  
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
    public function search(Request $request)
    {
        $search = $request->input('search');
        $concerns = $this->buildConcernsQuery($request, null, $search);
        $city = city::all();

        return response()->json([
            'concerns' => $concerns,
            'cities' => $city
        ]);
    }

    //For sort in concern-list can be used whenever there is filter button for concern as long as the divs has same id's and classes 
    public function sort(Request $request)
    {
        $search = $request->input('search');
        $concerns = $this->buildConcernsQuery($request, null, $search);
        $city = city::all();

        return response()->json([
            'concerns' => $concerns,
            'cities' => $city
        ]);
    }

    public function updateStatus(Request $request, concerns $concern)
    {
        $request->validate([
            'status' => 'required|in:pending,in progress,resolved,rejected',
        ]);

        $concern->status = $request->input('status');
        $concern->save();

        // Recalculate counts after status update
        $inProgressConcerns = concerns::where('status', 'in progress')->count();
        $resolvedConcerns = concerns::where('status', 'resolved')->count();

        if ($concern->status === 'in progress') {
        return redirect()
            ->route('staffs.inprogress')
            ->with([
                'success' => 'Concern accepted and now in progress!',
                'inProgressConcerns' => $inProgressConcerns,
                'resolvedConcerns' => $resolvedConcerns,
            ]);
                } elseif ($concern->status === 'resolved') {
                    return redirect()
                        ->route('concern-list') // optional: create this route if needed
                        ->with([
                            'success' => 'Concern marked as resolved!',
                            'inProgressConcerns' => $inProgressConcerns,
                            'resolvedConcerns' => $resolvedConcerns,
                        ]);
                } elseif ($concern->status === 'rejected') {
                    return redirect()
                        ->route('concern-list') // if you have a pending route
                        ->with([
                            'success' => 'Concern has been rejected.',
                        ]);
                }  
                else {
                    return redirect()->back()->with('error', 'Unknown status update.');
                }

        
    }


    public function showInProgress(Request $request)
    {
        $search = $request->input('search');
        $concerns = $this->buildConcernsQuery($request, 'in progress', $search);
        $city = city::all();

        if (request()->ajax()) {
            return response()->json([
                'concerns' => $concerns,
                'cities' => $city,
            ]);
        }

        return view('citizens.concerns.index', [
            'concerns' => $concerns,
            'page' => 'in progress',
            'concerns_count' => $concerns->count(),
        ]);
    }

    public function showResolved(Request $request)
    {
        // Get concerns where status is 'resolved'
        $search = $request->input('search');
        $concerns = $this->buildConcernsQuery($request, 'resolved', $search);
        $city = city::all();

        if (request()->ajax()) {
            return response()->json([
                'concerns' => $concerns,
                'cities' => $city,
            ]);
        }

        // Return the view and pass the data
        return view('citizens.concerns.index', [
            'concerns' => $concerns,
            'page' => 'resolved',
            'concerns_count' => $concerns->count(),
        ]);
    }

    // Delete concern for admin
    public function deleteConcern ($id) {
        concerns::destroy($id);

        return redirect()->route('concern-list');
    }

    private function buildConcernsQuery(Request $request, ?string $locked_status = null, ?string $search = null)
    {
        $query = concerns::query();
        $isPrioritize = false;

        // Lock status if this page requires it example for in-progress and resolved
        if ($locked_status) {
            $query->where('status', $locked_status);
        }

        if ($search) {
            $query->where('title', 'like', $search . '%');
        }

        if ($request->input('sort')) {
            $sort = $request->input('sort');

            if (!$locked_status) {
                // Only the general concern-list page can pick its own status
                foreach ($sort['status'] as $key => $value) {
                    if ($value == 'true') {
                        if ($key == 'prioritize') {
                            $isPrioritize = true;
                        } else {
                            $status = str_replace('_', ' ', $key);
                            $query->where('status', $status);
                        }
                        break;
                    }
                }
            } else {
                // Locked pages can still toggle 'prioritize' as a SORT, not a status filter
                if (isset($sort['status']['prioritize']) && $sort['status']['prioritize'] == 'true') {
                    $isPrioritize = true;
                }
            }

            if (!empty($sort['province'])) {
                $get_city_id = city::where('province_id', $sort['province'])->pluck('id');
                $query->whereIn('city_id', $get_city_id);
            }

            if (!empty($sort['city'])) {
                $query->where('city_id', $sort['city']);
            }
        }

        if (Auth::check() && Auth::user()->usertype == 'staff') {
            $query->where('city_id', Auth::user()->city_id);
        }

        if ($isPrioritize) {
            $query->withCount('priority')
            ->orderBy('priority_count', 'desc')
            ->orderBy('id', 'desc');
        } else {
            $query->withCount('priority')->orderBy('id', 'desc');
        }

        $concerns = $query->get();

        if (Auth::check()) {
            $user_id = Auth::id();
            $prioritized_ids = concern_priorities::where('user_id', $user_id)
                ->whereIn('concern_id', $concerns->pluck('id')) 
                ->pluck('concern_id')
                ->toArray();

            $concerns->each(function ($concern) use ($prioritized_ids) {
                $concern->is_prioritized = in_array($concern->id, $prioritized_ids);
            });
        } else {
            $concerns->each(function ($concern) {
                $concern->is_prioritized = false;
            });
        }

        return $concerns;
    }
}
