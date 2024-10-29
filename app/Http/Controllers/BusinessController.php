<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBusinessRequest;
use App\Http\Requests\UpdateBusinessRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\{AssetChargeDepartment, AssetAccounts, AssetAddress, Business, Facility, Equipment, Tool, Businesses, Position, MeterReadUnits, AssetCategory, AssetFiles, AssetUser, BusinessClassification, Country, State, City, Currency, Supplies, User};
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BusinessController extends Controller
{

    /**
     * Instantiate a new SuppliesController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:read-business|create-business|edit-business|delete-business', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-business', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-business', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-business', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $businesses = Business::with([
            'assetFiles',
            'assetUser'
        ])->latest()->paginate();
        $data['countries'] = Country::get(["name", "id"]);
        $data['states'] = State::get(["name", "id"]);
        $data['cities'] = City::get(["name", "id"]);

        return view('businesses.index', $data, [
            'businesses' => $businesses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $data['countries'] = Country::get(["name", "id"]);
        return view('businesses.create', $data, [
            'users' => User::pluck('name', 'id')->all(),
            'MeterReadUnits' =>  MeterReadUnits::select('id', 'name', 'symbol', 'unit_precision')->get()->toArray(),
            'businessClassification' => BusinessClassification::pluck('name', 'id')->all(),
            'currencies' => Currency::pluck('name', 'id')->all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBusinessRequest $request): RedirectResponse
    {

        $input = $request->all();
        $business = new Business;
        $business->name = $request->name;
        $business->code = $request->code;
        $business->contact = json_encode($input['contact']);
        $business->location = json_encode($input['location']);
        $business->currency = $request->currency;
        $business->business_classification = json_encode($request->business_classification);
        $business->description = $request->description;
        $business->status = $request->status;
        $business->save();

        $businessId = $business->id;
        $businessName = $business->name;

        //saving User
        if ($request->personnel) {
            $supplyUser = new AssetUser;
            $supplyUser->asset_type = 'business';
            $supplyUser->asset_id = $businessId;
            $supplyUser->user_id = $request->personnel;
            $supplyUser->save();
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
                $destinationPath = public_path('Business/BusinessId_' . $businessId);

                // Move the file to the destination
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }
                $file->move($destinationPath, $fileNameToStore);

                // Create a Certification record
                $create_doc = new AssetFiles;
                $create_doc->asset_type  = 'business';
                $create_doc->asset_id    = $businessId;
                $create_doc->name = $fileNameToStore;
                $create_doc->url = ('public/Business/BusinessId_' . $businessId . '/' . $fileNameToStore);

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
        return redirect()->route('businesses.edit', $businessId)
            ->withSuccess('New business is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Business $business): View
    {
        $business->load([
            'assetFiles',
            'assetUser'
        ]);
        $data['countries'] = Country::get(["name", "id"]);
        $data['states'] = State::get(["name", "id"]);
        $data['cities'] = City::get(["name", "id"]);
        return view('businesses.show', $data, [
            'users' => User::pluck('name', 'id')->all(),
            'MeterReadUnits' =>  MeterReadUnits::select('id', 'name', 'symbol', 'unit_precision')->get()->toArray(),
            'businessClassification' => BusinessClassification::pluck('name', 'id')->all(),
            'currencies' => Currency::pluck('name', 'id')->all(),
            'business' => $business
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Business $business): View
    {
        // Eager load related data
        $business->load([
            'assetFiles',
            'assetUser'
        ]);
        $data['countries'] = Country::get(["name", "id"]);
        return view('businesses.edit', $data, [
            'users' => User::pluck('name', 'id')->all(),
            'businesses' => Business::pluck('name', 'id')->all(),
            'MeterReadUnits' =>  MeterReadUnits::select('id', 'name', 'symbol', 'unit_precision')->get()->toArray(),
            'businesses' =>  Business::select('id', 'code', 'description', 'name')->get()->toArray(),
            'businessClassification' => BusinessClassification::pluck('name', 'id')->all(),
            'currencies' => Currency::pluck('name', 'id')->all(),
            'business' => $business
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBusinessRequest $request, Business $business): RedirectResponse
    {
        // $business->update($request->all());
        $input = $request->all();
        $business = Business::where('id', $business->id)->first();
        $business->name = $request->name;
        $business->code = $request->code;
        $business->contact = json_encode($input['contact']);
        $business->location = json_encode($input['location']);
        $business->currency = $request->currency;
        $business->business_classification = json_encode($request->business_classification);
        $business->description = $request->description;
        $business->status = $request->status;
        $business->save();

        $businessId = $business->id;
        $businessName = $business->name;

        // Handle file uploads
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
                $destinationPath = public_path('Business/BusinessId_' . $businessId);

                // Move the file to the destination
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }
                $file->move($destinationPath, $fileNameToStore);

                // Create a Certification record
                $create_doc = new AssetFiles;
                $create_doc->asset_type  = 'business';
                $create_doc->asset_id    = $businessId;
                $create_doc->name = $fileNameToStore;
                $create_doc->url = ('public/Business/BusinessId_' . $businessId . '/' . $fileNameToStore);

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
        return redirect()->back()->withSuccess('Business is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Business $business): RedirectResponse
    {
        $business->delete();
        return redirect()->route('businesses.index')
            ->withSuccess('Businesses is deleted successfully.');
    }
    public function saveUsers(Request $request)
    {
        // Validate the request data
        $request->validate([
            'personnel' => 'required',
            'business_id' => 'required',
        ]);

        // Check if the user already exists for the given asset
        $assetType = 'business';
        $assetId = $request->input('business_id');
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
    public function busidocs(Request $request)
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
        $businessDocsUpdate = AssetFiles::where('af_id', $log_id);
        if (empty($docsName)) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => 'Please fix the following errors',
                'errors' => [
                    'docsName' => ['The name field is required.'],
                ]
            ], 422);
        }
        $businessDocsUpdate->update([
            'name' => $docsName,
            'description' => $docsDescription,
            'submitted_by' => auth()->user()->id,
        ]);
        // Return success response
        return response()->json(['success' => 'Records saved successfully']);
    }
    public function destroybusidocs($busidocsID)
    {
        $busidocsIDdata = AssetFiles::where('af_id', $busidocsID)->first();
        $busidocsIDdata->delete();
        return response()->json(['success' => 'Record deleted successfully']);
    }
}
