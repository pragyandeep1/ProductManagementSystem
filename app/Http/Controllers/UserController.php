<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use App\Models\User;
use App\Models\Position;
use App\Models\UserInfo;
use App\Models\CareerHistory;
use Illuminate\Http\Request;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Validator;
use Response;
use Redirect;
use App\Models\{Country, State, City};

class UserController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:read-user|create-user|edit-user|delete-user', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-user', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $userDetails = User::with(['userInfo', 'certifications'])->latest('id')->paginate();
        return view('users.index', [
            'users' => $userDetails
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $data['countries'] = Country::get(["name", "id"]);
        return view('users.create', $data, [
            'roles' => Role::pluck('name')->all(),
            'positions' => Position::pluck('name', 'id')->all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->password);

        $user = User::create($input);
        $user->assignRole($request->roles);
        $user->emp_id = 'emp' . $user->id . Carbon::now()->format('dmy');
        $user->save();

        $create_user = new UserInfo;
        $create_user->user_id = $user->id;
        $create_user->contact_details = json_encode($input['contact']);
        $create_user->status = $request->status;
        $create_user->job_title = $request->positions;
        $create_user->effective_date = $request->effective_date;
        $create_user->save();


        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                // Validate file
                // $this->validate($request, [
                //     'files.*' => 'mimes:doc,docx,xlsx,xls,ppt,pptx,txt,pdf,jpg,jpeg,png,gif|max:2048',
                // ]);
                $this->validate($request, [
                    'files.*' => 'mimes:doc,docx,xlsx,xls,ppt,pptx,txt,pdf,jpg,jpeg,png,gif|max:2048|not_in:invalid_file',
                ], [
                    'files.*.not_in' => 'Invalid file type. Please upload files with allowed extensions.',
                ]);

                // Generate a unique file name
                $fileNameToStore = uniqid() . '_' . $file->getClientOriginalName();

                // Define the destination path
                $destinationPath = public_path('documents/' . $user->id);

                // Move the file to the destination
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }
                $file->move($destinationPath, $fileNameToStore);

                // Create a Certification record
                $create_doc = new Certification;
                $create_doc->user_id = $user->id;
                $create_doc->name = $fileNameToStore;
                $create_doc->url = ('public/documents/' . $user->id . '/' . $fileNameToStore);

                // Determine file type
                $extension = $file->getClientOriginalExtension();
                if ($extension == 'mp4') {
                    $create_doc->type = "video";
                } elseif (in_array($extension, ['pdf', 'jpeg', 'png', 'gif'])) {
                    $create_doc->type = $extension;
                } else {
                    $create_doc->type = "other";
                }

                $create_doc->save();
            }
        }

        // Create a career history record for the initial position

        $initialCareerHistory = new CareerHistory;
        $initialCareerHistory->user_id = $user->id;
        $initialCareerHistory->prev_position = 0; // Set the initial position as null or some default value
        $initialCareerHistory->curr_position = $request->positions;
        $initialCareerHistory->ch_notes = 'Initial Position'; // Set an appropriate note
        $initialCareerHistory->effective_date = $request->effective_date;
        // $initialCareerHistory->modified_on = Carbon::now();
        $initialCareerHistory->modified_by = auth()->user()->id; // Assuming the currently logged-in user is modifying
        $initialCareerHistory->save();

        return redirect()->route('users.index')
            ->withSuccess('New user is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        // return view('users.show', [
        //     'user' => $user,
        //     'UserInfo' => UserInfo::pluck()->all()
        // ]);

        $userDetails = User::with(['userInfo', 'certifications'])->find($user->id);
        $data['countries'] = Country::get(["name", "id"]);
        $data['states'] = State::get(["name", "id"]);
        $data['cities'] = City::get(["name", "id"]);
        return view('users.show', $data, [
            'user' => $userDetails,
            'positions' => Position::pluck('name', 'id')->all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        // Check Only Super Admin can update his own Profile
        if ($user->hasRole('Super Admin')) {
            if ($user->id != auth()->user()->id) {
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }
        $data['countries'] = Country::get(["name", "id"]);
        $userDetails = User::with(['userInfo', 'certifications', 'CareerHistory'])->find($user->id);
        // $careerHistory = User::with(['userInfo', 'certifications'])->find($user->id);
        return view('users.edit', $data, [
            'user' => $user,
            'roles' => Role::pluck('name')->all(),
            'positions' => Position::pluck('name', 'id')->all(),
            'userRoles' => $user->roles->pluck('name')->all(),
            'UserInfo' => $userDetails
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $input = $request->all();

        if (!empty($request->password)) {
            $input['password'] = Hash::make($request->password);
        } else {
            $input = $request->except('password');
        }
        // $edit_user = UserInfo::where('user_id', $user->id)->first();
        //print_r($user); echo $user->id; echo $edit_user; echo json_encode($input['contact']); exit;


        $edit_user = UserInfo::where('user_id', $user->id)->first();
        // echo $edit_user;

        //   echo $sql=  UserInfo::where('user_id', $user->id)->toSql(); exit;

        $edit_user->contact_details = json_encode($input['contact']);
        $edit_user->status = $request->status;
        $edit_user->job_title = $request->positions;
        $edit_user->effective_date = $request->effective_date;
        // $edit_user->effective_date = $request->end_date;
        $edit_user->save();


        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                // Validate file
                // $this->validate($request, [
                //     'files.*' => 'mimes:doc,docx,xlsx,xls,ppt,pptx,txt,pdf,jpg,jpeg,png,gif|max:2048',
                // ]);
                $this->validate($request, [
                    'files.*' => 'mimes:doc,docx,xlsx,xls,ppt,pptx,txt,pdf,jpg,jpeg,png,webp,gif|not_in:invalid_file',
                ], [
                    'files.*.not_in' => 'Invalid file type. Please upload files with allowed extensions.',
                ]);

                // Generate a unique file name
                $fileNameToStore = uniqid() . '_' . $file->getClientOriginalName();

                // Define the destination path
                $destinationPath = public_path('documents/' . $user->id);

                // Move the file to the destination
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }
                $file->move($destinationPath, $fileNameToStore);

                // Create a Certification record
                $create_doc = new Certification;
                $create_doc->user_id = $user->id;
                $create_doc->name = $fileNameToStore;
                $create_doc->url = ('public/documents/' . $user->id . '/' . $fileNameToStore);

                // Determine file type
                $extension = $file->getClientOriginalExtension();
                if ($extension == 'mp4') {
                    $create_doc->type = "video";
                } elseif (in_array($extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif'])) {
                    $create_doc->type = $extension;
                } else {
                    $create_doc->type = "other";
                }

                $create_doc->save();
            }
        }
        $user->update($input);

        $user->syncRoles($request->roles);
        // Get the old positions from the hidden input
        $prevPosition = $request->old_positions;
        // Insert into CareerHistory only if prev_position and curr_position are not equal
        if ($prevPosition != $request->positions) {
            // $lastcareerHistory = CareerHistory::where('user_id', $user->id)->first();
            $lastcareerHistory = CareerHistory::where('user_id', $user->id)->latest()->first();
            // echo $lastcareerHistory;
            // exit;
            if ($lastcareerHistory) {
                $lastcareerHistory->end_date = $request->effective_date;
                $lastcareerHistory->save();
            }
            $careerHistory = new CareerHistory;
            $careerHistory->user_id = $user->id;
            $careerHistory->prev_position = $prevPosition;
            $careerHistory->curr_position = $request->positions;
            $careerHistory->ch_notes = 'Position Update'; // Set an appropriate note
            $careerHistory->effective_date = $request->effective_date;
            $careerHistory->modified_by = auth()->user()->id;
            $careerHistory->save();
        }
        return redirect()->back()
            ->withSuccess('User is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // About if user is Super Admin or User ID belongs to Auth User
        if ($user->hasRole('Super Admin') || $user->id == auth()->user()->id) {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }

        $user->syncRoles([]);
        $user->delete();
        return redirect()->route('users.index')
            ->withSuccess('User is deleted successfully.');
    }
    public function cert_update(Request $request, $id)
    {
        try {
            $edit_certificate = Certification::where('cf_id', $id)->firstOrFail();
            $edit_certificate->name =  $request->input('name');
            $edit_certificate->description =  $request->input('description');
            $edit_certificate->save();
            return response()->json(['success' => true, 'message' => 'Details saved succesfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the field.'], 500);
        }
    }
    public function status_update(Request $request, $id)
    {
        try {
            $edit_status = UserInfo::where('user_id', $id)->firstOrFail();
            $edit_status->status =  $request->input('status');
            $edit_status->save();
            if ($request->input('status') == 0) {
                $status_name = 'disabled';
                $value = 'Disabled';
            } else {
                $status_name = 'activated';
                $value = 'Active';
            }

            return response()->json(['success' => true, 'value' => $value, 'message' => 'User is ' . $status_name . ' successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the status.'], 500);
        }
    }
    public function cert_delete($id)
    {
        try {
            $certificate =  Certification::where('cf_id', $id)->firstOrFail();
            $certificate->delete();
            return response()->json(['success' => true, 'message' => 'Document deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the document.'], 500);
        }
    }
}
