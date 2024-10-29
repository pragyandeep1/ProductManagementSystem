<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use App\Models\Facility;
use App\Models\FacilityRelation;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PositionController extends Controller
{
    /**
     * Instantiate a new positionController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:read-position|create-position|edit-position|delete-position', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-position', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-position', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-position', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    // public function index(): View
    // {
    //     $facilities = Facility::leftjoin('facility_relation', 'facilities.id', '=', 'facility_relation.child_id')
    //         ->select('facilities.*', 'facility_relation.parent_id','facility_relation.child_id')
    //         ->get();
    //     return view('positions.index', [
    //         'facilities' => Facility::all(),
    //         'facilityRelations' => $facilities,
    //         'categories' => Position::all(),
    //     ]);
    // }
    public function index(): View
    {
        return view('positions.index', [
            'positions' => position::latest()->paginate(),
            'categories' => Position::where('parent_id', NULL)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('positions.create', [
            'positions' => Position::pluck('name', 'id')->all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePositionRequest $request): RedirectResponse
    {
        position::create($request->all());
        return redirect()->route('positions.index')
            ->withSuccess('New position is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(position $position): View
    {
        return view('positions.show', [
            'position' => $position,
            'positions' => Position::pluck('name', 'id')->all(),
            'parentCategories' => Position::where('parent_id', NULL)->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(position $position): View
    {
        return view('positions.edit', [
            'position' => $position,
            'Allpositions' => Position::pluck('name', 'id', 'description', 'parent_id')->all(),
            'allCategories' => Position::all(),
            'categories' => Position::where('parent_id', NULL)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePositionRequest $request, position $position): RedirectResponse
    {
        $position->update($request->all());
        return redirect()->back()
            ->withSuccess('position is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(position $position): RedirectResponse
    {
        $position->delete();
        return redirect()->route('positions.index')
            ->withSuccess('position is deleted successfully.');
    }
}
