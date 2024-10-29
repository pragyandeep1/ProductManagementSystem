<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFacilityRequest;
use App\Http\Requests\UpdateFacilityRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\{AssetFiles, MeterReadings, AssetPartSuppliesLog, AssetGeneralInfo, AssetChargeDepartment, AssetAddress, AssetAccounts, Position, Facility, MeterReadUnits, AssetCategory, Country, State, City, Supplies, FacilityEquipmentRelation, FacilityRelation, FacilityToolsRelation, Order, Task, Project};
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MaintenanceController extends Controller
{
    /**
     * Instantiate a new MaintenanceController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:read-maintenance|create-maintenance|edit-maintenance|delete-maintenance', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-maintenance', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-maintenance', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-maintenance', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('maintenance.index', [
            // 'orders' => Order::all(),
            'maintenance' => 1,
            // 'categories' => Position::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['countries'] = Country::get(["name", "id"]);
        return view('maintenance.create', $data, [
            'roles' => Role::pluck('name')->all(),
            'positions' => Position::pluck('name', 'id')->all(),
            'orders' => Order::pluck('name', 'id')->all(),
            'maintenance' => Maintenance::pluck('name', 'id')->all(),
            'categories' => AssetCategory::where('type', 'facility')->where('status', '1')->pluck('name', 'id')->all(),
            'assets' => AssetFiles::where('asset_type', 'asset_id')->pluck('name', 'asset_id')->all(),
            'MeterReadUnits' =>  MeterReadUnits::select('id', 'name', 'symbol', 'unit_precision')->where('status', '1')->get()->toArray(),
            'accounts' =>  AssetAccounts::select('id', 'code', 'description')->get()->toArray(),
            'departments' =>  AssetChargeDepartment::select('id', 'code', 'description')->get()->toArray(),
            'supplies' =>  Supplies::select('id', 'code', 'description', 'name')->get()->toArray(),

        ]);
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
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
