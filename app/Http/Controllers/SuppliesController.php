<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreSuppliesRequest;
use App\Http\Requests\UpdateSuppliesRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\EquipmentRelation;
use App\Models\{AssetFiles, MeterReadings, AssetPartSuppliesLog, AssetGeneralInfo, AssetChargeDepartment, AssetAddress, AssetAccounts, Position, Facility, MeterReadUnits, AssetCategory, AssetInventory, AssetUser, AssetWarranty, Business, Country, State, City, Currency, Equipment, FacilityEquipmentRelation, FacilityRelation, Stock, Supplies, Tool, User};
use App\Rules\UniqueStockLocation;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SuppliesController extends Controller
{

    /**
     * Instantiate a new SuppliesController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:read-supply|create-supply|edit-supply|delete-supply', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-supply', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-supply', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-supply', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $supplies = Supplies::with([
            'assetAddress',
            'assetGeneralInfo',
            'assetPartSuppliesLog',
            'meterReadings',
            'assetFiles',
            'stocks',
            'inventories',
            'assetWarranty',
            'assetUser'

        ])->latest()->paginate();

        $suppliesrelation = DB::table('facilities')
            ->select(
                'facilities.id AS facility_id',
                'facilities.name AS facility_name',
                'supplies.id AS supplies_id',
                'supplies.name AS supplies_name',
                'stocks.parent_id AS stocks_parent_id',
                'stocks.asset_id AS stocks_asset_id'
            )
            ->leftJoin('facility_relation', 'facilities.id', '=', 'facility_relation.parent_id')
            ->leftJoin('stocks', 'facility_relation.child_id', '=', 'stocks.parent_id')
            ->leftJoin('supplies', 'stocks.asset_id', '=', 'supplies.id')
            ->whereNotNull('supplies.id')
            ->get();



        $data['countries'] = Country::get(["name", "id"]);

        return view('supplies.index', [
            // 'roles' => Role::pluck('name')->all(),
            // 'positions' => Position::pluck('name', 'id')->all(),
            // 'categories' => AssetCategory::where('type', 'facility')->where('status', '1')->pluck('name', 'id')->all(),
            // 'MeterReadUnits' =>  MeterReadUnits::select('id', 'name', 'symbol', 'unit_precision')->get()->toArray(),
            // 'accounts' =>  AssetAccounts::select('id', 'code', 'description')->get()->toArray(),
            // 'departments' =>  AssetChargeDepartment::select('id', 'code', 'description')->get()->toArray(),
            'facilities' => Facility::pluck('name', 'id')->all(),
            // 'supplies' =>  Supplies::select('id', 'code', 'description', 'name')->get()->toArray(),
            'supplies' => $supplies,
            'suppliesrelation' => $suppliesrelation,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $data['countries'] = Country::get(["name", "id"]);
        return view('supplies.create', $data, [
            'roles' => Role::pluck('name')->all(),
            'positions' => Position::pluck('name', 'id')->all(),
            'facilities' => Facility::pluck('name', 'id')->all(),
            'users' => User::pluck('name', 'id')->all(),
            'categories' => AssetCategory::where('type', 'supply')->where('status', '1')->pluck('name', 'id')->all(),
            'MeterReadUnits' =>  MeterReadUnits::select('id', 'name', 'symbol', 'unit_precision')->get()->toArray(),
            'accounts' =>  AssetAccounts::select('id', 'code', 'description')->get()->toArray(),
            'departments' =>  AssetChargeDepartment::select('id', 'code', 'description')->get()->toArray(),
            'supplies' =>  Supplies::select('id', 'code', 'description', 'name')->get()->toArray(),
            'currencies' => Currency::pluck('name', 'id')->all(),
            'businesses' => Business::pluck('name', 'id')->all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSuppliesRequest $request): RedirectResponse
    {
        $input = $request->all();
        $supply = Supplies::create($input);
        $supplyId = $supply->id;
        $supplyName = $supply->name;

        $create_genInfo = new AssetGeneralInfo;
        $create_genInfo->asset_type  = 'supply';
        $create_genInfo->asset_id    = $supplyId;
        $create_genInfo->accounts_id = $request->account;
        $create_genInfo->charge_department_id = $request->department;
        $create_genInfo->unspc_code = $request->unspc_code;
        $create_genInfo->barcode = $request->barcode;
        $create_genInfo->make = $request->make;
        $create_genInfo->model = $request->model;
        $create_genInfo->last_price = $request->last_price;
        $create_genInfo->total_stock = $request->total_stock;
        $create_genInfo->notes = $request->notes;
        $create_genInfo->save();

        //saving User
        if ($request->personnel) {
            $supplyUser = new AssetUser;
            $supplyUser->asset_type = 'supply';
            $supplyUser->asset_id = $supplyId;
            $supplyUser->user_id = $request->personnel;
            $supplyUser->save();
        }
        //saving Warranties
        if ($request->warranty_type) {
            $supplyWarranty = new AssetWarranty;
            $supplyWarranty->asset_type = 'supply';
            $supplyWarranty->asset_id = $supplyId;
            $supplyWarranty->warranty_type = $request->warranty_type;
            $supplyWarranty->provider = $request->provider;
            $supplyWarranty->warranty_usage_term_type = $request->warranty_usage_term_type;
            $supplyWarranty->expiry_date = $request->expiry_date;
            $supplyWarranty->meter_reading = $request->meter_reading;
            $supplyWarranty->meter_reading_units = $request->meter_read_units;
            $supplyWarranty->certificate_number = $request->certificate_number;
            $supplyWarranty->description = $request->warranty_description;
            $supplyWarranty->save();
        }
        //saving Stocks
        // if ($request->stocks_parent_facility) {
        //     $stock = new Stock;
        //     $stock->asset_type = 'supply';
        //     $stock->asset_id = $supplyId;
        //     $stock->parent_id = $request->stocks_parent_facility;
        //     $stock->stocks_aisle = $request->stocks_aisle;
        //     $stock->stocks_row = $request->stocks_row;
        //     $stock->stocks_bin = $request->stocks_bin;
        //     // $stock->location = json_encode($input['st_loc']);
        //     $stock->stocks_qty_on_hand = $request->stocks_qty_on_hand;
        //     $stock->stocks_min_qty = $request->stocks_min_qty;
        //     $stock->stocks_max_qty = $request->stocks_max_qty;
        //     $stock->save();
        // }
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {

                $this->validate($request, [
                    'files.*' => 'mimes:doc,docx,xlsx,xls,ppt,pptx,txt,pdf,jpg,jpeg,png,gif,webp|max:2048|not_in:invalid_file',
                ], [
                    'files.*.not_in' => 'Invalid file type. Please upload files with allowed extensions.',
                ]);

                // Generate a unique file name
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $fileNameToStore = Str::slug($fileName) . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // $fileNameToStore = uniqid() . '_' . $file->getClientOriginalName();

                // Define the destination path
                $destinationPath = public_path('Supply/SupplyId_' . $supplyId);

                // Move the file to the destination
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }
                $file->move($destinationPath, $fileNameToStore);

                // Create a Certification record
                $create_doc = new AssetFiles;
                $create_doc->asset_type  = 'supply';
                $create_doc->asset_id    = $supplyId;
                $create_doc->name = $fileNameToStore;
                $create_doc->url = ('public/Supply/SupplyId_' . $supplyId . '/' . $fileNameToStore);

                // Determine file type
                $extension = $file->getClientOriginalExtension();
                if ($extension == 'mp4') {
                    $create_doc->type = "video";
                } elseif (in_array($extension, ['pdf', 'jpeg', 'png', 'gif', 'webp'])) {
                    $create_doc->type = $extension;
                } else {
                    $create_doc->type = "other";
                }

                $create_doc->save();
            }
        }
        return redirect()->route('supplies.edit', $supplyId)
            ->withSuccess('New supply is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplies $supplies): View
    {
        $supplies->load([
            'assetAddress',
            'assetGeneralInfo',
            'assetPartSuppliesLog',
            'meterReadings',
            'assetFiles',
            'stocks',
            'inventories',
            'assetWarranty',
            'assetUser'
        ]);
        $data['countries'] = Country::get(["name", "id"]);
        $data['states'] = State::get(["name", "id"]);
        $data['cities'] = City::get(["name", "id"]);
        return view('supplies.show', $data, [
            'roles' => Role::pluck('name')->all(),
            'positions' => Position::pluck('name', 'id')->all(),
            'users' => User::pluck('name', 'id')->all(),
            'facilities' => Facility::pluck('name', 'id')->all(),
            'equipments' => Equipment::pluck('name', 'id')->all(),
            'categories' => AssetCategory::where('type', 'equipment')->where('status', '1')->pluck('name', 'id')->all(),
            'MeterReadUnits' =>  MeterReadUnits::select('id', 'name', 'symbol', 'unit_precision')->get()->toArray(),
            'accounts' =>  AssetAccounts::select('id', 'code', 'description')->get()->toArray(),
            'departments' =>  AssetChargeDepartment::select('id', 'code', 'description')->get()->toArray(),
            // 'supplies' =>  Supplies::select('id', 'code', 'description', 'name')->get()->toArray(),
            'supplies' => $supplies
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplies $supply): View
    {
        // Eager load related data
        $supply->load([
            'assetAddress',
            'assetGeneralInfo',
            'assetPartSuppliesLog',
            'meterReadings',
            'assetFiles',
            'stocks',
            'inventories',
            'assetWarranty',
            'assetUser'

        ]);
        $allfacilities = Facility::latest()->paginate();
        $allequipments = Equipment::latest()->paginate();
        $alltools = Tool::latest()->paginate();

        $stocks = Stock::where('asset_type', 'supply')->where('asset_id', $supply->id)->get();
        $totalStock = $stocks->sum('stocks_qty_on_hand');

        $data['countries'] = Country::get(["name", "id"]);
        return view('supplies.edit', $data, [
            'roles' => Role::pluck('name')->all(),
            'positions' => Position::pluck('name', 'id')->all(),
            'users' => User::pluck('name', 'id')->all(),
            'facilities' => Facility::pluck('name', 'id')->all(),
            'equipments' => Equipment::pluck('name', 'id')->all(),
            'categories' => AssetCategory::where('type', 'supply')->where('status', '1')->pluck('name', 'id')->all(),
            'MeterReadUnits' =>  MeterReadUnits::select('id', 'name', 'symbol', 'unit_precision')->get()->toArray(),
            'accounts' =>  AssetAccounts::select('id', 'code', 'description')->get()->toArray(),
            'supplies' =>  Supplies::select('id', 'code', 'description', 'name')->get()->toArray(),
            'currencies' => Currency::pluck('name', 'id')->all(),
            'businesses' => Business::pluck('name', 'id')->all(),
            'receivedTo' => Stock::where('asset_type', 'supply')->where('asset_id', $supply->id)->pluck('asset_id', 'id')->all(),
            'departments' =>  AssetChargeDepartment::select('id', 'code', 'description')->get()->toArray(),
            'totalStock' => $totalStock,
            'supply' => $supply,
            'allfacilities' => $allfacilities,
            'allequipments' => $allequipments,
            'alltools' => $alltools
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSuppliesRequest $request, Supplies $supply): RedirectResponse
    {
        $input = $request->all();
        $supply->update($request->all());
        $supplyId = $supply->id;
        $supplyName = $supply->name;

        $update_genInfo = AssetGeneralInfo::where('asset_type', 'supply')->where('asset_id', $supply->id)->first();
        $update_genInfo->accounts_id = $request->account;
        $update_genInfo->charge_department_id = $request->department;
        $update_genInfo->unspc_code = $request->unspc_code;
        $update_genInfo->barcode = $request->barcode;
        $update_genInfo->make = $request->make;
        $update_genInfo->model = $request->model;
        $update_genInfo->last_price = $request->last_price;
        $update_genInfo->total_stock = $request->total_stock;
        $update_genInfo->notes = $request->notes;
        $update_genInfo->save();

        //saving Inventories
        // if (isset($request->inventory_received_to) && !empty($request->inventory_received_to)) {
        //     $assetStock = Stock::where('id', $request->inventory_received_to)->first();
        //     $inventory_quantity_received = $request->inventory_quantity_received;
        //     $assetStock->stocks_qty_on_hand += $inventory_quantity_received; // this code need more customization to show history and logs as per Fixx website
        //     $assetStock->save();
        //     $supplyinventory = new AssetInventory;
        //     $supplyinventory->asset_type = 'supply';
        //     $supplyinventory->asset_id = $supplyId;
        //     $supplyinventory->purchased_from = $request->inventory_purchased_from;
        //     $supplyinventory->purchase_currency = $request->inventory_purchase_currency;
        //     $supplyinventory->date_ordered = $request->inventory_date_ordered;
        //     $supplyinventory->date_received = $request->inventory_date_received;
        //     $supplyinventory->parent_id = $request->inventory_received_to;
        //     $supplyinventory->quantity_received = $request->inventory_quantity_received;
        //     $supplyinventory->purchase_price_per_unit = $request->inventory_purchase_price_per_unit;
        //     $supplyinventory->purchase_price_total = $request->inventory_purchase_price_total;
        //     $supplyinventory->date_of_expiry = $request->inventory_date_of_expiry;
        //     $supplyinventory->save();
        // } else {
        //     $supplyinventory = new AssetInventory;
        //     $supplyinventory->asset_type = 'supply';
        //     $supplyinventory->asset_id = $supplyId;
        //     $supplyinventory->purchased_from = $request->inventory_purchased_from;
        //     $supplyinventory->purchase_currency = $request->inventory_purchase_currency;
        //     $supplyinventory->date_ordered = $request->inventory_date_ordered;
        //     $supplyinventory->date_received = $request->inventory_date_received;
        //     $supplyinventory->parent_id = $request->inventory_received_to;
        //     $supplyinventory->quantity_received = $request->inventory_quantity_received;
        //     $supplyinventory->purchase_price_per_unit = $request->inventory_purchase_price_per_unit;
        //     $supplyinventory->purchase_price_total = $request->inventory_purchase_price_total;
        //     $supplyinventory->date_of_expiry = $request->inventory_date_of_expiry;
        //     $supplyinventory->save();
        // }
        //saving Warranties
        // $supplyWarranty = AssetWarranty::where('asset_type', 'supply')->where('asset_id', $supply->id)->first();
        // $supplyWarranty->warranty_type = $request->warranty_type;
        // $supplyWarranty->provider = $request->provider;
        // $supplyWarranty->warranty_usage_term_type = $request->warranty_usage_term_type;
        // $supplyWarranty->expiry_date = $request->expiry_date;
        // $supplyWarranty->meter_reading = $request->meter_reading;
        // $supplyWarranty->meter_reading_units = $request->meter_read_units;
        // $supplyWarranty->certificate_number = $request->certificate_number;
        // $supplyWarranty->description = $request->warranty_description;
        // $supplyWarranty->save();

        //saving Stocks
        // if ($request->stocks_parent_facility) {
        //     $stock = new Stock;
        //     $stock->asset_type = 'supply';
        //     $stock->asset_id = $supplyId;
        //     $stock->parent_id = $request->stocks_parent_facility;
        //     $stock->stocks_aisle = $request->stocks_aisle;
        //     $stock->stocks_row = $request->stocks_row;
        //     $stock->stocks_bin = $request->stocks_bin;
        //     // $stock->location = json_encode($input['st_loc']);
        //     $stock->stocks_qty_on_hand = $request->stocks_qty_on_hand;
        //     $stock->stocks_min_qty = $request->stocks_min_qty;
        //     $stock->stocks_max_qty = $request->stocks_max_qty;
        //     $stock->save();
        // }
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {

                $this->validate($request, [
                    'files.*' => 'mimes:doc,docx,xlsx,xls,ppt,pptx,txt,pdf,jpg,jpeg,png,gif,webp|max:2048|not_in:invalid_file',
                ], [
                    'files.*.not_in' => 'Invalid file type. Please upload files with allowed extensions.',
                ]);

                // Generate a unique file name
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $fileNameToStore = Str::slug($fileName) . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // $fileNameToStore = uniqid() . '_' . $file->getClientOriginalName();

                // Define the destination path
                $destinationPath = public_path('Supply/SupplyId_' . $supplyId);

                // Move the file to the destination
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }
                $file->move($destinationPath, $fileNameToStore);

                // Create a Certification record
                $create_doc = new AssetFiles;
                $create_doc->asset_type  = 'supply';
                $create_doc->asset_id    = $supplyId;
                $create_doc->name = $fileNameToStore;
                $create_doc->url = ('public/Supply/SupplyId_' . $supplyId . '/' . $fileNameToStore);

                // Determine file type
                $extension = $file->getClientOriginalExtension();
                if ($extension == 'mp4') {
                    $create_doc->type = "video";
                } elseif (in_array($extension, ['pdf', 'jpeg', 'png', 'gif', 'webp'])) {
                    $create_doc->type = $extension;
                } else {
                    $create_doc->type = "other";
                }

                $create_doc->save();
            }
        }
        return redirect()->route('supplies.edit', $supplyId)
            ->withSuccess('Supply is updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplies $supply): RedirectResponse
    {
        //do not delete items permanently, instead update is_delete column
        $supply->delete();
        return redirect()->route('supplies.index')
            ->withSuccess('Supply is deleted successfully.');
    }
    public function saveStocks(Request $request)
    {
        // Validate the request data
        $request->validate([
            'stocks_parent_facility' => 'required',
            'stocks_qty_on_hand' => 'nullable|numeric|min:0',
            'stocks_min_qty' => 'nullable|numeric|min:0',
            'stocks_max_qty' => 'nullable|numeric|min:0',
            'initial_price' => 'nullable|numeric|min:0',

        ]);

        $assetType = 'supply';
        $assetId = $request->input('supply_id');
        $parent_id = $request->input('stocks_parent_facility');
        $initial_price = $request->input('initial_price');
        $stocks_aisle = $request->input('stocks_aisle');
        $stocks_row = $request->input('stocks_row');
        $stocks_bin = $request->input('stocks_bin');

        $parentFacilityName = Facility::find($parent_id)->name;

        $existingStockQuery = Stock::where('asset_type', $assetType)
            ->where('asset_id', $assetId)
            ->where('parent_id', $parent_id);

        if (!is_null($stocks_aisle)) {
            $existingStockQuery->where('stocks_aisle', $stocks_aisle);
        } else {
            $existingStockQuery->whereNull('stocks_aisle');
        }

        if (!is_null($stocks_row)) {
            $existingStockQuery->where('stocks_row', $stocks_row);
        } else {
            $existingStockQuery->whereNull('stocks_row');
        }

        if (!is_null($stocks_bin)) {
            $existingStockQuery->where('stocks_bin', $stocks_bin);
        } else {
            $existingStockQuery->whereNull('stocks_bin');
        }

        $existingStock = $existingStockQuery->exists();

        if ($existingStock) {
            return response()->json([
                'errors' => [
                    'stocks_parent_facility' => [
                        "You are attempting to save a stock location $parentFacilityName (aisle: $stocks_aisle, row: $stocks_row, bin: $stocks_bin) which already exists for this part. You may proceed as follows:<br>1) add a different aisle/row/bin to make this location distinct<br>2) choose a different location<br>3) close this form and update the original."
                    ]
                ]
            ], 422);
        }

        // Save stocks
        $stock = new Stock;
        $stock->asset_type = $assetType;
        $stock->asset_id = $request->input('supply_id');
        $stock->parent_id = $request->input('stocks_parent_facility');
        $stock->initial_price = $initial_price;
        $stock->stocks_aisle = $stocks_aisle;
        $stock->stocks_row = $stocks_row;
        $stock->stocks_bin = $stocks_bin;
        $stock->stocks_qty_on_hand = $request->input('stocks_qty_on_hand');
        $stock->stocks_min_qty = $request->input('stocks_min_qty');
        $stock->stocks_max_qty = $request->input('stocks_max_qty');
        $stock->save();

        // Return success response
        return response()->json(['message' => 'Stocks saved successfully']);
    }


    public function getSupplyName(Request $request)
    {
        $stockId = $request->stockId;
        $stock = Stock::find($stockId);

        if ($stock) {
            $location = Facility::find($stock->parent_id);
            $supply = Supplies::find($stock->asset_id);

            if ($location && $supply) {
                $locationName = $location->name;
                $supplyName = $supply->name;
                $supplyCode = $supply->code;
                $message = $supplyName . ' (' . $supplyCode . ') at ' . $locationName;

                return response()->json([
                    'supplyName' => $message
                ]);
                // return response()->json([
                //     'supplyName' => $supplyName,
                //     'supplyCode' => $supplyCode,
                //     'locationName' => $locationName
                // ]);
            } else {
                return response()->json(['error' => 'Location or supply not found'], 404);
            }
        } else {
            return response()->json(['error' => 'Stock not found'], 404);
        }
    }
    public function saveInventories(Request $request)
    {
        // Validate the request data
        $request->validate([
            'inventory_received_to' => 'required',
        ]);

        // Save inventory
        if (isset($request->inventory_received_to) && !empty($request->inventory_received_to)) {
            $assetStock = Stock::where('id', $request->inventory_received_to)->first();
            $inventory_quantity_received = $request->inventory_quantity_received;
            $assetStock->stocks_qty_on_hand += $inventory_quantity_received; // this code need more customization to show history and logs as per Fixx website
            $assetStock->save();
            $supplyinventory = new AssetInventory;
            $supplyinventory->asset_type = 'supply';
            $supplyinventory->asset_id = $request->input('supply_id');
            $supplyinventory->purchased_from = $request->inventory_purchased_from;
            $supplyinventory->purchase_currency = $request->inventory_purchase_currency;
            $supplyinventory->date_ordered = $request->inventory_date_ordered;
            $supplyinventory->date_received = $request->inventory_date_received;
            $supplyinventory->parent_id = $request->inventory_received_to;
            $supplyinventory->quantity_received = $request->inventory_quantity_received;
            $supplyinventory->purchase_price_per_unit = $request->inventory_purchase_price_per_unit;
            $supplyinventory->purchase_price_total = $request->inventory_purchase_price_total;
            $supplyinventory->date_of_expiry = $request->inventory_date_of_expiry;
            $supplyinventory->save();

            // Return success response
            return response()->json(['message' => 'Inventory saved successfully']);
        }
        // Return error response if necessary
        return response()->json(['error' => 'Failed to save inventory'], 500);
    }
    public function saveWarranties(Request $request)
    {
        // Save warranty
        $supplyWarranty = new AssetWarranty;
        $supplyWarranty->asset_type = 'supply';
        $supplyWarranty->asset_id = $request->input('supply_id');
        $supplyWarranty->warranty_type = $request->warranty_type;
        $supplyWarranty->provider = $request->provider;
        $supplyWarranty->warranty_usage_term_type = $request->warranty_usage_term_type;
        $supplyWarranty->expiry_date = $request->expiry_date;
        $supplyWarranty->meter_reading = $request->meter_reading;
        $supplyWarranty->meter_reading_units = $request->meter_read_units;
        $supplyWarranty->certificate_number = $request->certificate_number;
        $supplyWarranty->description = $request->warranty_description;
        $supplyWarranty->save();

        // Return success response
        return response()->json(['message' => 'Warranty Certificate saved successfully']);
    }
    public function saveUsers(Request $request)
    {
        // Validate the request data
        $request->validate([
            'personnel' => 'required',
            'supply_id' => 'required',
        ]);

        // Check if the user already exists for the given asset
        $assetType = 'supply';
        $assetId = $request->input('supply_id');
        $userId = $request->personnel;

        $userExists = AssetUser::where('asset_type', $assetType)
            ->where('asset_id', $assetId)
            ->where('user_id', $userId)
            ->exists();

        // if ($userExists) {
        //     return response()->json(['error' => 'The record with the given Asset and User already exists.'], 422);
        // }
        if ($userExists) {
            return response()->json(['errors' => ['personnel' => ['The record with the given Asset and User already exists.']]], 422);
        }

        // Save user
        if ($request->personnel) {
            $supplyUser = new AssetUser;
            $supplyUser->asset_type = $assetType;
            $supplyUser->asset_id = $assetId;
            $supplyUser->user_id = $userId;
            $supplyUser->save();

            // Return success response
            return response()->json(['message' => 'User saved successfully']);
        }
        return response()->json(['error' => 'Failed to save user'], 500);
    }
    public function getAssetName(Request $request)
    {
        $assetId = $request->bomId;
        $asset_type = $request->bomType;
        $asset = null;
        if ($asset_type == 'facility') {
            $asset = Facility::find($assetId);
        }
        if ($asset_type == 'equipment') {
            $asset = Equipment::find($assetId);
        }
        if ($asset_type == 'tools') {
            $asset = Tool::find($assetId);
        }

        if ($asset) {
            $assetName = $asset->name;
            $assetCode = $asset->code;

            $message = $assetName . ' (' . $assetCode . ') ';

            return response()->json([
                'assetName' => $message
            ]);
        } else {
            return response()->json(['error' => 'Asset not found'], 404);
        }
    }
    public function suppliesbom(Request $request)
    {
        // Validate the request data
        $request->validate([
            'asset' => 'required',
        ]);

        // Update part supplies log
        if ($request->asset) {
            AssetPartSuppliesLog::create([
                'asset_type' => $request->input('asset_type'),
                'asset_source' => 'supply',
                'asset_id' =>  $request->input('asset'),
                'part_supply_id' => $request->input('supply_id'),
                'quantity' => $request->quantity,
                'submitted_by' => auth()->user()->id
            ]);
            return response()->json(['message' => 'Data saved successfully']);
        }
    }
    public function supplydocs(Request $request)
    {

        // print_r($request->input());
        // exit();
        // Validate the request data
        $request->validate([
            'docsName' => 'required',
        ]);
        // Extract the request data
        $log_id = $request->input('log_id');
        $docsName = $request->input('docsName');
        $docsDescription = $request->input('docsDescription');
        $supplyDocsUpdate = AssetFiles::where('af_id', $log_id);
        if (empty($docsName)) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => 'Please fix the following errors',
                'errors' => [
                    'docsName' => ['The name field is required.'],
                ]
            ], 422);
        }
        $supplyDocsUpdate->update([
            'name' => $docsName,
            'description' => $docsDescription,
            'submitted_by' => auth()->user()->id,
        ]);
        // Return success response
        return response()->json(['success' => 'Records saved successfully']);
    }
    public function destroysupplydocs($supplydocsID)
    {
        $supplydocsdata = AssetFiles::where('af_id', $supplydocsID)->first();
        $supplydocsdata->delete();
        return response()->json(['success' => 'Record deleted successfully']);
    }
    public function supplywarranties(Request $request)
    {
        // print_r($request->input());
        // exit();

        // Extract the request data
        $log_id = $request->input('log_id');
        $warranty_type = $request->input('warranty_type');
        $provider = $request->input('provider');
        $warranty_usage_term_type = $request->input('warranty_usage_term_type');
        $expiry_date = $request->input('expiry_date');
        $meter_reading = $request->input('meter_reading');
        $meter_read_units = $request->input('meter_read_units');
        $certificate_number = $request->input('certificate_number');
        $warranty_description = $request->input('warranty_description');

        $supplywarrantyUpdate = AssetWarranty::where('id', $log_id);
        $supplywarrantyUpdate->update([
            'warranty_type' => $warranty_type,
            'provider' => $provider,
            'warranty_usage_term_type' => $warranty_usage_term_type,
            'expiry_date' => $expiry_date,
            'meter_reading' => $meter_reading,
            'meter_reading_units' => $meter_read_units,
            'certificate_number' => $certificate_number,
            'description' => $warranty_description,
            'submitted_by' => auth()->user()->id,
        ]);
        // Return success response
        return response()->json(['success' => 'Records saved successfully']);
    }
    public function destroysupplywarranties($supplywarrantiesID)
    {
        $supplywarrantiesdata = AssetWarranty::where('id', $supplywarrantiesID)->first();
        $supplywarrantiesdata->delete();
        return response()->json(['success' => 'Record deleted successfully']);
    }

    public function savesupplyparts(Request $request)
    {
        // print_r($request->input());
        // exit();
        // Validate the request data
        $request->validate([
            'asset' => 'required',
            'quantity' => 'nullable|numeric|min:0',
        ]);
        // Extract the request data
        $log_id = $request->input('log_id');
        $asset = $request->input('asset');
        $quantity = $request->input('quantity');
        $asset_type = $request->input('asset_type');

        $supplyassetUpdate = AssetPartSuppliesLog::where('id', $log_id);
        if (empty($asset)) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => 'Please fix the following errors',
                'errors' => [
                    'asset' => ['The asset field is required.'],
                    'quantity.min' => ['The quantity field must be a positive number.']
                ]
            ], 422);
        }
        // Update part supplies log
        $supplyassetUpdate->update([
            'asset_type' => $asset_type,
            'asset_source' => 'supply',
            'asset_id' => $asset,
            'quantity' => $quantity,
            'submitted_by' => auth()->user()->id,
        ]);
        // Return success response
        return response()->json(['success' => 'Records saved successfully']);
    }
    public function destroysupplyparts($supplysupplypartsID)
    {
        $supplypartsdata = AssetPartSuppliesLog::where('id', $supplysupplypartsID)->first();
        $supplypartsdata->delete();
        return response()->json(['success' => 'Record deleted successfully']);
    }
    public function savesupplystocks(Request $request)
    {
        // print_r($request->input());
        // exit();

        // Validate the request data
        $request->validate([
            'ParentFaciliy' => 'required',
            'stocks_qty_on_hand' => 'nullable|numeric|min:0',
            'stocks_min_qty' => 'nullable|numeric|min:0',
            'stocks_max_qty' => 'nullable|numeric|min:0',
            'initial_price' => 'nullable|numeric|min:0',
        ]);
        // Extract the request data
        $log_id = $request->input('log_id');
        $stocks_parent_facility = $request->input('ParentFaciliy');
        $stocks_aisle = $request->input('stocks_aisle');
        $initial_price = $request->input('initial_price');
        $stocks_row = $request->input('stocks_row');
        $stocks_bin = $request->input('stocks_bin');
        $stocks_qty_on_hand = $request->input('stocks_qty_on_hand');
        $stocks_min_qty = $request->input('stocks_min_qty');
        $stocks_max_qty = $request->input('stocks_max_qty');
        $assetType = 'supply';
        $assetId = $request->input('assetID');

        $parentFacilityName = Facility::find($stocks_parent_facility)->name;

        $existingStockQuery = Stock::where('asset_type', $assetType)
            ->where('asset_id', $assetId)
            ->where('parent_id', $stocks_parent_facility);

        if (!is_null($stocks_aisle)) {
            $existingStockQuery->where('stocks_aisle', $stocks_aisle);
        } else {
            $existingStockQuery->whereNull('stocks_aisle');
        }

        if (!is_null($stocks_row)) {
            $existingStockQuery->where('stocks_row', $stocks_row);
        } else {
            $existingStockQuery->whereNull('stocks_row');
        }

        if (!is_null($stocks_bin)) {
            $existingStockQuery->where('stocks_bin', $stocks_bin);
        } else {
            $existingStockQuery->whereNull('stocks_bin');
        }
        // Exclude the current row ID from the check
        if (!empty($log_id)) {
            $existingStockQuery->where('id', '!=', $log_id);
        }

        $existingStock = $existingStockQuery->exists();

        if ($existingStock) {
            return response()->json([
                'errors' => [
                    'stocks_parent_facility' => [
                        "You are attempting to save a stock location $parentFacilityName (aisle: $stocks_aisle, row: $stocks_row, bin: $stocks_bin) which already exists for this part. You may proceed as follows:<br>1) add a different aisle/row/bin to make this location distinct<br>2) choose a different location."
                    ]
                ]
            ], 422);
        }

        $supplystockUpdate = Stock::where('id', $log_id);
        if (empty($stocks_parent_facility)) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => 'Please fix the following errors',
                'errors' => [
                    'ParentFaciliy' => ['The asset field is required.'],
                    'stocks_qty_on_hand.min' => ['The quantity on hand field must be a positive number.'],
                    'stocks_min_qty.min' => ['The minimum quantity field must be a positive number.'],
                    'stocks_max_qty.min' => ['The maximum quantity field must be a positive number.'],
                    'initial_price.min' => ['The initial price field must be a positive number.'],
                ]
            ], 422);
        }
        // Update stocks supplies log
        $supplystockUpdate->update([
            'asset_type' => $assetType,
            'asset_id' => $assetId,
            'parent_id' => $stocks_parent_facility,
            'initial_price' => $initial_price,
            'stocks_aisle' => $stocks_aisle,
            'stocks_row' => $stocks_row,
            'stocks_bin' => $stocks_bin,
            'stocks_qty_on_hand' => $stocks_qty_on_hand,
            'stocks_min_qty' => $stocks_min_qty,
            'stocks_max_qty' => $stocks_max_qty,
            'submitted_by' => auth()->user()->id,
        ]);
        // Return success response
        return response()->json(['success' => 'Records saved successfully']);
    }
    public function destroysupplystocks($supplystocksID)
    {
        $supplystocksIDdata = Stock::where('id', $supplystocksID)->first();
        $supplystocksIDdata->delete();
        return response()->json(['success' => 'Record deleted successfully']);
    }
    public function savesupplyinventories(Request $request)
    {
        // print_r($request->input());
        // exit();
        // Validate the request data
        // inventory_received_to is actually stocks table id
        $request->validate([
            'inventory_received_to' => 'required',
            'inventory_quantity_received' => 'nullable|numeric|min:0',
            'inventory_purchase_price_per_unit' => 'nullable|numeric|min:0',
            'inventory_purchase_price_total' => 'nullable|numeric|min:0',
        ]);
        // Extract the request data
        $log_id = $request->input('log_id');
        $assetType = 'supply';
        $assetId = $request->input('assetID');

        $inventory_purchased_from = $request->input('inventory_purchased_from');
        $inventory_purchase_currency = $request->input('inventory_purchase_currency');
        $inventory_date_ordered = $request->input('inventory_date_ordered');
        $inventory_date_received = $request->input('inventory_date_received');
        $inventory_received_to = $request->input('inventory_received_to');
        $inventory_quantity_received = $request->input('inventory_quantity_received');
        $inventory_purchase_price_per_unit = $request->input('inventory_purchase_price_per_unit');
        $inventory_purchase_price_total = $request->input('inventory_purchase_price_total');
        $inventory_date_of_expiry = $request->input('inventory_date_of_expiry');

        $supplyinventoriesUpdate = AssetInventory::where('id', $log_id);
        if (empty($inventory_received_to)) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => 'Please fix the following errors',
                'errors' => [
                    'inventory_received_to' => ['The Received To field is required.'],
                    'inventory_quantity_received.min' => ['The Quantity Received must be a positive number.'],
                    'inventory_purchase_price_per_unit.min' => ['The Purchase Price Per Unit must be a positive number.'],
                    'inventory_purchase_price_total.min' => ['The Purchase Price Total must be a positive number.'],
                ]
            ], 422);
        }
        // Update stocks supplies log
        $supplyinventoriesUpdate->update([
            'asset_type' => $assetType,
            'asset_id' => $assetId,
            'purchased_from' => $inventory_purchased_from,
            'purchase_currency' => $inventory_purchase_currency,
            'date_ordered' => $inventory_date_ordered,
            'date_received' => $inventory_date_received,
            'parent_id' => $inventory_received_to,
            'quantity_received' => $inventory_quantity_received,
            'purchase_price_per_unit' => $inventory_purchase_price_per_unit,
            'purchase_price_total' => $inventory_purchase_price_total,
            'date_of_expiry' => $inventory_date_of_expiry,
            // 'submitted_by' => auth()->user()->id,
        ]);
        // Save in Stocks           
        $assetStock = Stock::where('id', $inventory_received_to)->first();
        $inventory_quantity_received = $inventory_quantity_received;
        $assetStock->stocks_qty_on_hand += $inventory_quantity_received; // this code need more customization to show history and logs as per Fixx website
        $assetStock->save();
        // Return success response
        return response()->json(['success' => 'Records saved successfully']);
    }
    public function destroysupplyinventories($supplyinventoriesID)
    {
        $supplyinventoriesIDdata = AssetInventory::where('id', $supplyinventoriesID)->first();
        $supplyinventoriesIDdata->delete();
        return response()->json(['success' => 'Record deleted successfully']);
    }
}
