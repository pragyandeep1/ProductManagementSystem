<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BusinessClassification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BusinessClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $page = 'Classification';
    public function index(Request $request)
    {
        $data = BusinessClassification::orderBy('id', 'desc')->get();
        foreach ($data as $classification) {
            $classification->status = $classification->status == 1 ? '<input type="button" class="classification_status btn btn-success" value="Active">' : '<input type="button" class="classification_status btn btn-secondary" value="Disabled">';
        }
        // return $data;
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('status', function ($classification) {
                    return $classification->status;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = view('businessClassification.button', ['item' => $row, 'route' => 'businessclassification', 'page' => $this->page]);
                    return $actionBtn;
                })
                ->rawColumns(['status', 'action']) //To render HTML content in DataTables,
                ->make(true);
        }
        return view('businessClassification.index');
    }

    /**
     * Show the form for creating a new resource.
     */

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' =>  'required|unique:business_classification'
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        } else {
            try {
                BusinessClassification::create($request->toarray());
                return response()->json([
                    'success' => 'Record Saved Successfully'
                ], 201);
            } catch (Exception $e) {
                return response()->json(['errors' => $e->getMessage()], false);
            }
        }
    }

    public function show($businessClassificationID)
    {
        $businessClassificationdata = BusinessClassification::where('id', $businessClassificationID)->first();
        return view('businessClassification.show', compact('businessClassificationdata'));
    }

    public function edit($businessClassificationID)
    {
        $businessClassificationdata = BusinessClassification::where('id', $businessClassificationID)->first();
        return view('businessClassification.edit', compact('businessClassificationdata'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $businessClassificationID)
    {
        $validate = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('business_classification')->ignore($businessClassificationID),
            ],
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        } else {
            try {
                // Find the Business Classification to edit
                $businessClassificationdata = BusinessClassification::where('id', $businessClassificationID)->first();

                if ($businessClassificationdata) {
                    $businessClassificationdata->update($request->toarray());
                    return response()->json(['data' => $request->all(), 'success' => "Record Updated successfully."]);
                    exit;
                }
            } catch (Exception $e) {
                return response()->json(['errors' => $e->getMessage()], 500);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($businessClassificationID)
    {
        $businessClassificationdata = BusinessClassification::where('id', $businessClassificationID)->first();
        $businessClassificationdata->delete();
        return response()->json(['success' => 'Record deleted successfully']);
    }
}
