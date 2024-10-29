<?php

namespace App\Http\Controllers;

use App\Models\{Equipment, Facility, Asset, Tool};
use Illuminate\Http\Request;
use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AssetController extends Controller
{
    /**
     * Instantiate a new AssetController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:read-asset|create-asset|edit-asset|delete-asset', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-asset', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-asset', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-asset', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $tools = Tool::leftJoin('facility_tools_relation', 'facility_tools_relation.tool_id', '=', 'tools.id')
            ->leftJoin('equipment_tools_relation', 'equipment_tools_relation.tool_id', '=', 'tools.id')
            ->select('tools.*', DB::raw('IF(equipment_tools_relation.equipment_id IS NOT NULL, equipment_tools_relation.equipment_id, facility_tools_relation.facility_id) AS parent_id'))
            ->get()->toArray();

        $equipments = Equipment::leftjoin('equipment_relation', 'equipments.id', '=', 'equipment_relation.child_id')
            ->leftjoin('facility_equipment_relation', 'facility_equipment_relation.equipment_id', '=', 'equipments.id')
            ->select('equipments.*',DB::raw('IF(equipment_relation.parent_id IS NOT NULL, equipment_relation.parent_id, facility_equipment_relation.facility_id) AS parent_id'), DB::raw('1 AS is_equipment'))
            ->get()->toArray();

        $facilities = Facility::leftjoin('facility_relation', 'facilities.id', '=', 'facility_relation.child_id')
            ->select('facilities.*','facility_relation.parent_id',DB::raw('1 AS is_facility'))
            ->get()->toArray();

        // Merge all data
        $outputs = array_merge($tools, $equipments, $facilities);

        return view('tools.index', [
            'toolRelations' => $outputs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('assets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssetRequest $request): RedirectResponse
    {
        Asset::create($request->all());
        return redirect()->route('assets.index')
            ->withSuccess('New asset is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset): View
    {
        return view('assets.show', [
            'asset' => $asset
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset): View
    {
        return view('assets.edit', [
            'asset' => $asset
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssetRequest $request, Asset $asset): RedirectResponse
    {
        $asset->update($request->all());
        return redirect()->back()
            ->withSuccess('Asset is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset): RedirectResponse
    {
        $asset->delete();
        return redirect()->route('assets.index')
            ->withSuccess('Asset is deleted successfully.');
    }
}
