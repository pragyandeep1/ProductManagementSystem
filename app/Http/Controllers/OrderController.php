<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\{AssetFiles, Asset, MeterReadings, AssetPartSuppliesLog, AssetGeneralInfo, AssetChargeDepartment, AssetAddress, AssetAccounts, Position, Facility, MeterReadUnits, AssetCategory, Country, State, City, Equipment, EquipmentRelation, EquipmentToolsRelation, FacilityEquipmentRelation, FacilityRelation, FacilityToolsRelation, Supplies, Tool};
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:read-order|create-order|edit-order|delete-order', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-order', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-order', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-order', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /*$orderRelations = [];
        $orders = Order::leftjoin('order_relation', 'orders.id', '=', 'order_relation.child_id')
            ->select('orders.*', 'order_relation.parent_id', 'order_relation.child_id')
            ->get()->toArray();
        foreach ($orders as $order) {
            $id = $order['id'];
            $uid = !empty($order['parent_id']) ? $id : 0;
            $results = DB::table('stocks as st')
                ->join('supplies as s', 'st.asset_id', '=', 's.id')
                ->where('st.parent_id', $id)
                ->get()
                ->toArray();

            $results = array_map(function ($result) {
                return (array) $result;
            }, $results);

            // Push results into orderRelations array
            $results = array_map(function ($result) use ($uid) {
                $result['keyName'] = $uid;
                return $result;
            }, $results);

            $orderRelations[] = $results;
        }
        $singleArrayForCategory = array_reduce($orderRelations, 'array_merge', array());

        $supplyrelation = array_merge($orders, $singleArrayForCategory);*/
        return view('orders.index', [
            // 'orders' => Order::all(),
            // 'orderRelations' => $supplyrelation,
            // 'categories' => Position::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $data['countries'] = Country::get(["name", "id"]);
        return view('orders.create', $data, [
            'roles' => Role::pluck('name')->all(),
            'positions' => Position::pluck('name', 'id')->all(),
            'orders' => Order::pluck('name', 'id')->all(),
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
    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $input = $request->all();
        $order = Order::create($input);
        $orderId = $order->id;
        $orderName = $order->name;

        $create_location = new AssetAddress;
        $create_location->asset_type  = 'facility';
        $create_location->asset_id    = $facilityId;
        $create_location->has_parent = $request->faci_chkbox;
        $create_location->parent_id = $request->parent_id;
        if ($request->faci_chkbox == 1) {
            if ($request->parent_id != '') {

                //save in relation table
                $facility_relation = new FacilityRelation;
                $facility_relation->parent_id = $request->parent_id;
                $facility_relation->child_id = $facilityId;
                $facility_relation->save();

                $parent_address = AssetAddress::where('asset_type', 'facility')->where('asset_id', $request->parent_id)->latest()->first();
                if ($parent_address) {
                    $create_location->address = $parent_address->address;
                } else {
                    $create_location->address = json_encode($request->add_address);
                }
            } else {
                $create_location->address = json_encode($input['contact']);
            }
        } else {
            $create_location->address = json_encode($input['contact']);
        }
        $create_location->save();


        $create_genInfo = new AssetGeneralInfo;
        $create_genInfo->asset_type  = 'facility';
        $create_genInfo->asset_id    = $facilityId;
        $create_genInfo->accounts_id = $request->account;
        $create_genInfo->barcode = $request->barcode;
        $create_genInfo->charge_department_id = $request->department;
        $create_genInfo->notes = $request->notes;
        $create_genInfo->save();
        if ($request->supplies || $request->quantity) {
            $create_supplieslog = new AssetPartSuppliesLog;
            $create_supplieslog->asset_type  = 'facility';
            $create_supplieslog->asset_id    = $facilityId;
            $create_supplieslog->part_supply_id = $request->supplies;
            $create_supplieslog->quantity = $request->quantity;
            $create_supplieslog->submitted_by = auth()->user()->id;
            $create_supplieslog->save();
        }
        if ($request->meter_reading) {
            $create_meterRead = new MeterReadings;
            $create_meterRead->asset_type  = 'facility';
            $create_meterRead->asset_id    = $facilityId;
            $create_meterRead->reading_value = $request->meter_reading;
            $create_meterRead->meter_units_id = $request->meter_read_units;
            $create_meterRead->submitted_by = auth()->user()->id;
            $create_meterRead->save();
        }
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
                $destinationPath = public_path('Facility/FacilityId_' . $facilityId);

                // Move the file to the destination
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }
                $file->move($destinationPath, $fileNameToStore);

                // Create a Certification record
                $create_doc = new AssetFiles;
                $create_doc->asset_type  = 'facility';
                $create_doc->asset_id    = $facilityId;
                $create_doc->name = $fileNameToStore;
                $create_doc->url = ('public/Facility/FacilityId_' . $facilityId . '/' . $fileNameToStore);

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
        return redirect()->route('orders.edit', $orderId)->withSuccess('success', 'New Order is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): View
    {
        $facility->load([
            'assetAddress',
            'assetGeneralInfo',
            'assetPartSuppliesLog',
            'meterReadings',
            'assetFiles'
        ]);
        $data['countries'] = Country::get(["name", "id"]);
        $data['states'] = State::get(["name", "id"]);
        $data['cities'] = City::get(["name", "id"]);
        return view('orders.show', $data, [
            'roles' => Role::pluck('name')->all(),
            'positions' => Position::pluck('name', 'id')->all(),
            'facilities' => Facility::pluck('name', 'id')->all(),
            'categories' => AssetCategory::where('type', 'facility')->where('status', '1')->pluck('name', 'id')->all(),
            'MeterReadUnits' =>  MeterReadUnits::select('id', 'name', 'symbol', 'unit_precision')->where('status', '1')->get()->toArray(),
            'accounts' =>  AssetAccounts::select('id', 'code', 'description')->get()->toArray(),
            'departments' =>  AssetChargeDepartment::select('id', 'code', 'description')->get()->toArray(),
            'supplies' =>  Supplies::select('id', 'code', 'description', 'name')->get()->toArray(),
            'order' => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order): View
    {
        // Eager load related data
        $order->load([
            'assetAddress',
            'assetGeneralInfo',
            'assetPartSuppliesLog',
            'meterReadings',
            'assetFiles'
        ]);
        $data['countries'] = Country::get(["name", "id"]);
        return view('orders.edit', $data, [
            'roles' => Role::pluck('name')->all(),
            'positions' => Position::pluck('name', 'id')->all(),
            'facilities' => Facility::pluck('name', 'id')->all(),
            'categories' => AssetCategory::where('type', 'facility')->where('status', '1')->pluck('name', 'id')->all(),
            'MeterReadUnits' =>  MeterReadUnits::select('id', 'name', 'symbol', 'unit_precision')->where('status', '1')->get()->toArray(),
            'accounts' =>  AssetAccounts::select('id', 'code', 'description')->get()->toArray(),
            'departments' =>  AssetChargeDepartment::select('id', 'code', 'description')->get()->toArray(),
            'supplies' =>  Supplies::select('id', 'code', 'description', 'name')->get()->toArray(),
            'order' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order): RedirectResponse
    {
        $input = $request->all();
        $order->update($request->all());
        $orderId = $order->id;
        $orderName = $order->name;
        // Update order address
        $orderAddress = AssetAddress::where('asset_type', 'order')->where('asset_id', $order->id)->first();

        if ($orderAddress) {
            $orderAddress->has_parent = $request->faci_chkbox;
            $orderAddress->parent_id = $request->parent_id;
            if ($request->faci_chkbox == 1) {
                if ($request->parent_id != '') {

                    /*//update in relation table
                    $facility_relation =  FacilityRelation::where('child_id', $facilityId)->first();
                    if ($facility_relation) {
                        $facility_relation->parent_id = $request->parent_id;
                        // $facility_relation->child_id = $facilityId;
                        $facility_relation->save();
                    } else {
                        $facility_relation = new FacilityRelation;
                        $facility_relation->parent_id = $request->parent_id;
                        $facility_relation->child_id = $facilityId;
                        $facility_relation->save();
                    }*/


                    $parentAddress = AssetAddress::where('asset_type', 'order')->where('asset_id', $request->parent_id)->latest()->first();
                    if ($parentAddress) {
                        $orderAddress->address = $parentAddress->address;
                    } else {
                        $orderAddress->address = json_encode($request->add_address);
                    }
                } else {
                    //update in relation table
                    /*$facility_relation =  FacilityRelation::where('child_id', $facilityId)->first();
                    if ($facility_relation) {
                        $facility_relation->parent_id = $request->parent_id;
                        // $facility_relation->child_id = $facilityId;
                        $facility_relation->save();
                    } else {
                        $facility_relation = new FacilityRelation;
                        $facility_relation->parent_id = $request->parent_id;
                        $facility_relation->child_id = $facilityId;
                        $facility_relation->save();
                    }*/
                    $orderAddress->address = json_encode($request->add_address);
                }
            } else {
                //update in relation table
               /* if ($request->parent_id) {
                    $facility_relation =  FacilityRelation::where('child_id', $facilityId)->first();
                    $facility_relation->parent_id = $request->parent_id;
                    $facility_relation->save();
                    $orderAddress->address = json_encode($request->contact);
                }*/
                $orderAddress->address = json_encode($input['contact']);
            }
            $orderAddress->save();
        } else {
            $create_location = new AssetAddress;
            $create_location->asset_type  = 'facility';
            $create_location->asset_id    = $facilityId;
            $create_location->has_parent = $request->faci_chkbox;
            $create_location->parent_id = $request->parent_id;
            /*if ($request->faci_chkbox == 1) {
                if ($request->parent_id != '') {

                    //save in relation table
                    $facility_relation = new FacilityRelation;
                    $facility_relation->parent_id = $request->parent_id;
                    $facility_relation->child_id = $facilityId;
                    $facility_relation->save();

                    $parent_address = AssetAddress::where('asset_type', 'facility')->where('asset_id', $request->parent_id)->latest()->first();
                    if ($parent_address) {
                        $create_location->address = $parent_address->address;
                    } else {
                        $create_location->address = json_encode($request->add_address);
                    }
                } else {
                    $create_location->address = json_encode($input['contact']);
                }
            } else {
                $create_location->address = json_encode($input['contact']);
            }*/
        }

        return redirect()->back()->withSuccess('success', 'Order is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
