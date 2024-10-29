<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\AssetChargeDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ChargeDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $page = 'Charge';
    public function index(Request $request)
    {
        $data = AssetChargeDepartment::orderBy('id', 'desc')->get();
        foreach ($data as $charge) {
            $charge->status = $charge->status == 1 ? '<input type="button" class="charge_status btn btn-success" value="Active">' : '<input type="button" class="charge_status btn btn-secondary" value="Disabled">';
        }
        // return $data;
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('status', function ($charge) {
                    return $charge->status;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = view('chargeDepartment.button', ['item' => $row, 'route' => 'charge', 'page' => $this->page]);
                    return $actionBtn;
                })
                ->rawColumns(['status', 'action']) //To render HTML content in DataTables,
                ->make(true);
        }
        return view('chargeDepartment.index');
    }

    /**
     * Show the form for creating a new resource.
     */

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'description' =>  'required|unique:asset_charge_department',
            'code' => 'required|unique:asset_charge_department',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        } else {
            try {
                AssetChargeDepartment::create($request->toarray());
                return response()->json([
                    'success' => 'Record Saved Successfully'
                ], 201);
            } catch (Exception $e) {
                return response()->json(['errors' => $e->getMessage()], false);
            }
        }
    }

    public function show($chargeid)
    {

        $chargedata = AssetChargeDepartment::where('id', $chargeid)->first();
        return view('chargeDepartment.show', compact('chargedata'));
    }

    public function edit($chargeid)
    {

        $chargedata = AssetChargeDepartment::where('id', $chargeid)->first();
        return view('chargeDepartment.edit', compact('chargedata'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $chargeid)
    {
        // $validate = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'type' => 'required',
        // ]);
        $validate = Validator::make($request->all(), [
            'description' => [
                'required',
                Rule::unique('asset_charge_department')->ignore($chargeid),
            ],
            'code' => [
                'required',
                Rule::unique('asset_charge_department')->ignore($chargeid),
            ],
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        } else {
            try {
                // Find the charge to edit
                $chargedata = AssetChargeDepartment::where('id', $chargeid)->first();

                if ($chargedata) {
                    $chargedata->update($request->toarray());
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
    public function destroy($chargeid)
    {
        $chargedata = AssetChargeDepartment::where('id', $chargeid)->first();
        $chargedata->delete();
        return response()->json(['success' => 'Record deleted successfully']);
    }
}
