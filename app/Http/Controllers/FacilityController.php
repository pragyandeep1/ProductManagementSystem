<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreFacilityRequest;
use App\Http\Requests\UpdateFacilityRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\{AssetFiles, MeterReadings, AssetPartSuppliesLog, AssetGeneralInfo, AssetChargeDepartment, AssetAddress, AssetAccounts, Position, Facility, MeterReadUnits, AssetCategory, Country, State, City, Supplies, FacilityEquipmentRelation, FacilityRelation, FacilityToolsRelation};
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FacilityController extends Controller
{

    /**
     * Instantiate a new FacilityController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:read-facility|create-facility|edit-facility|delete-facility', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-facility', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-facility', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-facility', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $facilities = Facility::leftjoin('facility_relation', 'facilities.id', '=', 'facility_relation.child_id')
            ->select('facilities.*', 'facility_relation.parent_id', 'facility_relation.child_id')
            ->get()->toArray();
        $facilityRelations = [];
        foreach ($facilities as $facility) {
            $id = $facility['id'];
            $uid = !empty($facility['parent_id']) ? $id : 0;
            $results = DB::table('stocks as st')
                ->join('supplies as s', 'st.asset_id', '=', 's.id')
                ->where('st.parent_id', $id)
                ->get()
                ->toArray();

            $results = array_map(function ($result) {
                return (array) $result;
            }, $results);

            // Push results into facilityRelations array
            $results = array_map(function ($result) use ($uid) {
                $result['keyName'] = $uid;
                return $result;
            }, $results);

            $facilityRelations[] = [
                'id' => $facility['id'],
                'parent_id' => $facility['parent_id'],
                'name' => $facility['name'],
                'status' => $facility['status'],
                'type' => $facility['type'], // Ensure type is included
            ];

            foreach ($results as $result) {
                $facilityRelations[] = $result;
            }
        }
        return view('facilities.index', [
            'facilities' => Facility::all(),
            'facilityRelations' => $facilityRelations,
            'categories' => Position::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $data['countries'] = Country::get(["name", "id"]);
        return view('facilities.create', $data, [
            'roles' => Role::pluck('name')->all(),
            'positions' => Position::pluck('name', 'id')->all(),
            'facilities' => Facility::pluck('name', 'id')->all(),
            'categories' => AssetCategory::where('type', 'facility')->where('status', '1')->pluck('name', 'id')->all(),
            'MeterReadUnits' =>  MeterReadUnits::select('id', 'name', 'symbol', 'unit_precision')->where('status', '1')->get()->toArray(),
            'accounts' =>  AssetAccounts::select('id', 'code', 'description')->get()->toArray(),
            'departments' =>  AssetChargeDepartment::select('id', 'code', 'description')->get()->toArray(),
            'supplies' =>  Supplies::select('id', 'code', 'description', 'name')->get()->toArray(),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFacilityRequest $request): RedirectResponse
    {
        $input = $request->all();
        $facility = Facility::create($input);
        $facilityId = $facility->id;
        $facilityName = $facility->name;
        // AssetAddress::create($request->all()); saturday work from here......

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
                // Validate file
                // $this->validate($request, [
                //     'files.*' => 'mimes:doc,docx,xlsx,xls,ppt,pptx,txt,pdf,jpg,jpeg,png,gif|max:2048',
                // ]);
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
        return redirect()->route('facilities.edit', $facilityId)
            ->withSuccess('New facility is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Facility $facility): View
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
        return view('facilities.show', $data, [
            'roles' => Role::pluck('name')->all(),
            'positions' => Position::pluck('name', 'id')->all(),
            'facilities' => Facility::pluck('name', 'id')->all(),
            'categories' => AssetCategory::where('type', 'facility')->where('status', '1')->pluck('name', 'id')->all(),
            'MeterReadUnits' =>  MeterReadUnits::select('id', 'name', 'symbol', 'unit_precision')->where('status', '1')->get()->toArray(),
            'accounts' =>  AssetAccounts::select('id', 'code', 'description')->get()->toArray(),
            'departments' =>  AssetChargeDepartment::select('id', 'code', 'description')->get()->toArray(),
            'supplies' =>  Supplies::select('id', 'code', 'description', 'name')->get()->toArray(),
            'facility' => $facility
        ]);
        // return view('facilities.show', [
        //     'facility' => $facility
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facility $facility): View
    {
        // Eager load related data
        $facility->load([
            'assetAddress',
            'assetGeneralInfo',
            'assetPartSuppliesLog',
            'meterReadings',
            'assetFiles'
        ]);
        $data['countries'] = Country::get(["name", "id"]);
        return view('facilities.edit', $data, [
            'roles' => Role::pluck('name')->all(),
            'positions' => Position::pluck('name', 'id')->all(),
            'facilities' => Facility::pluck('name', 'id')->all(),
            'categories' => AssetCategory::where('type', 'facility')->where('status', '1')->pluck('name', 'id')->all(),
            'MeterReadUnits' =>  MeterReadUnits::select('id', 'name', 'symbol', 'unit_precision')->where('status', '1')->get()->toArray(),
            'accounts' =>  AssetAccounts::select('id', 'code', 'description')->get()->toArray(),
            'departments' =>  AssetChargeDepartment::select('id', 'code', 'description')->get()->toArray(),
            'supplies' =>  Supplies::select('id', 'code', 'description', 'name')->get()->toArray(),
            'facility' => $facility
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFacilityRequest $request, Facility $facility): RedirectResponse
    {
        // echo 'hi dilip= ' . auth()->user()->id;
        // exit();
        // Update facility details
        $input = $request->all();
        $facility->update($request->all());
        $facilityId = $facility->id;
        $facilityName = $facility->name;
        // Update facility address
        $facilityAddress = AssetAddress::where('asset_type', 'facility')->where('asset_id', $facility->id)->first();
        if ($facilityAddress) {
            $facilityAddress->has_parent = $request->faci_chkbox;
            $facilityAddress->parent_id = $request->parent_id;
            if ($request->faci_chkbox == 1) {
                if ($request->parent_id != '') {

                    //update in relation table
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
                    }


                    $parentAddress = AssetAddress::where('asset_type', 'facility')->where('asset_id', $request->parent_id)->latest()->first();
                    if ($parentAddress) {
                        $facilityAddress->address = $parentAddress->address;
                    } else {
                        $facilityAddress->address = json_encode($request->add_address);
                    }
                } else {
                    //update in relation table
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
                    }
                    $facilityAddress->address = json_encode($request->add_address);
                }
            } else {
                //update in relation table
                if ($request->parent_id) {
                    $facility_relation =  FacilityRelation::where('child_id', $facilityId)->first();
                    $facility_relation->parent_id = $request->parent_id;
                    $facility_relation->save();
                    $facilityAddress->address = json_encode($request->contact);
                }
                $facilityAddress->address = json_encode($input['contact']);
            }
            $facilityAddress->save();
        } else {
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
        }
        // Update general information
        $facilityGeneralInfo = AssetGeneralInfo::where('asset_type', 'facility')->where('asset_id', $facility->id)->first();
        if ($facilityGeneralInfo) {
            $facilityGeneralInfo->accounts_id = $request->account;
            $facilityGeneralInfo->barcode = $request->barcode;
            $facilityGeneralInfo->charge_department_id = $request->department;
            $facilityGeneralInfo->notes = $request->notes;
            $facilityGeneralInfo->save();
        }

        // Update part supplies log
        if ($request->supplies || $request->quantity) {
            AssetPartSuppliesLog::create([
                'asset_type' => 'facility',
                'asset_id' => $facility->id,
                'part_supply_id' => $request->supplies,
                'quantity' => $request->quantity,
                'submitted_by' => auth()->user()->id
            ]);
        }

        // Update meter readings if provided
        if ($request->meter_reading) {
            MeterReadings::create([
                'asset_type' => 'facility',
                'asset_id' => $facility->id,
                'reading_value' => $request->meter_reading,
                'meter_units_id' => $request->meter_read_units,
                'submitted_by' => auth()->user()->id
            ]);
        }

        // Handle file uploads
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                // Validate file
                // $this->validate($request, [
                //     'files.*' => 'mimes:doc,docx,xlsx,xls,ppt,pptx,txt,pdf,jpg,jpeg,png,gif|max:2048',
                // ]);
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

        return redirect()->back()->withSuccess('Facility is updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $facility): RedirectResponse
    {
        FacilityRelation::where('child_id', $facility->id)->delete();
        $facility->delete();
        return redirect()->route('facilities.index')
            ->withSuccess('Facility is deleted successfully.');
    }
    public function getParentAddress($id)
    {
        // Find the parent facility by its ID
        $parentFacility = Facility::find($id);

        if (!$parentFacility) {
            // If the parent facility does not exist, return an empty response
            return response()->json(['error' => 'Parent facility not found'], 404);
        }

        // Retrieve the latest address associated with the parent facility
        $latestAddress = AssetAddress::where('asset_type', 'facility')
            ->where('asset_id', $id)
            ->latest()
            ->first();

        if ($latestAddress) {
            // Decode the JSON address data
            $addressData = json_decode($latestAddress->address, true);
            // If decoding is successful and 'address' key exists
            if ($addressData && isset($addressData['address'])) {
                // Retrieve the names of the country, state, and city
                $countryName = $addressData['country'] ? Country::find($addressData['country'])->name : null;
                $stateName = $addressData['state'] ? State::find($addressData['state'])->name : null;
                $cityName = $addressData['city'] ? City::find($addressData['city'])->name : null;

                // Return all necessary data including address, country, state, and city names
                return response()->json([
                    'address' => $addressData['address'],
                    'country' => $countryName,
                    'state' => $stateName,
                    'city' => $cityName,
                    'postcode' => $addressData['postcode'] ?? null,
                ]);
            }
        }
        // If no address is found or address data is invalid, return an empty response
        return response()->json(['address' => null]);
    }
    public function savefaciparts(Request $request)
    {
        // Validate the request data
        $request->validate([
            'supplies_id' => 'required',
            'quantity' => 'nullable|numeric|min:0',
        ]);
        // Extract the request data
        $log_id = $request->input('log_id');
        $supplies_id = $request->input('supplies_id');
        $quantity = $request->input('quantity');
        // Update part supplies log
        $facilityPartsUpdate = AssetPartSuppliesLog::where('id', $log_id);
        if (empty($supplies_id) || empty($quantity)) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => 'Please fix the following errors',
                'errors' => [
                    'supplies_id' => ['The supplies  field is required.'],
                    'quantity.min' => ['The quantity field must be a positive number.']
                ]
            ], 422);
        }
        // Check if supplies_id and quantity are not empty or null
        $facilityPartsUpdate->update([
            'part_supply_id' => $supplies_id,
            'quantity' => $quantity,
            'submitted_by' => auth()->user()->id,
        ]);
        // Return success response
        return response()->json(['success' => 'Records saved successfully']);
    }
    public function destroyfaciparts($facipartsID)
    {
        $facipartsIDdata = AssetPartSuppliesLog::where('id', $facipartsID)->first();
        $facipartsIDdata->delete();
        return response()->json(['success' => 'Record deleted successfully']);
    }
    public function savefacimeter(Request $request)
    {

        // print_r($request->input());
        // exit();
        // Validate the request data
        $request->validate([
            'meterunit_id' => 'required',
            'meterreading' => 'nullable|numeric|min:0',
        ]);
        // Extract the request data
        $log_id = $request->input('log_id');
        $meterunit_id = $request->input('meterunit_id');
        $meterreading = $request->input('meterreading');
        // Update part supplies log
        $facilityMetersUpdate = MeterReadings::where('id', $log_id);
        if (empty($meterunit_id) || empty($meterreading)) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => 'Please fix the following errors',
                'errors' => [
                    'meterunit_id' => ['The Unit field is required.'],
                    'meterreading.min' => ['The reading field must be a positive number.']
                ]
            ], 422);
        }
        // Check if supplies_id and quantity are not empty or null
        $facilityMetersUpdate->update([
            'meter_units_id' => $meterunit_id,
            'reading_value' => $meterreading,
            'submitted_by' => auth()->user()->id,
        ]);
        // Return success response
        return response()->json(['success' => 'Records saved successfully']);
    }
    public function destroyfacimeter($facimeterID)
    {
        $facimeterIDdata = MeterReadings::where('id', $facimeterID)->first();
        $facimeterIDdata->delete();
        return response()->json(['success' => 'Record deleted successfully']);
    }
    public function facidocs(Request $request)
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
        $facilityDocsUpdate = AssetFiles::where('af_id', $log_id);
        if (empty($docsName)) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => 'Please fix the following errors',
                'errors' => [
                    'docsName' => ['The name field is required.'],
                ]
            ], 422);
        }
        $facilityDocsUpdate->update([
            'name' => $docsName,
            'description' => $docsDescription,
            'submitted_by' => auth()->user()->id,
        ]);
        // Return success response
        return response()->json(['success' => 'Records saved successfully']);
    }
    public function destroyfacidocs($facidocsID)
    {
        $faciDocsdata = AssetFiles::where('af_id', $facidocsID)->first();
        $faciDocsdata->delete();
        return response()->json(['success' => 'Record deleted successfully']);
    }

    public function toggleStatus(Request $request)
    {
        $facility = Facility::find($request->id);

        if ($facility) {
            $facility->status = $facility->status == 'active' ? 'inactive' : 'active';
            $facility->save();
            
            return response()->json(['status' => 'success', 'newStatus' => $facility->status]);
        }

        return response()->json(['status' => 'error', 'message' => 'Facility not found'], 404);
    }
}
