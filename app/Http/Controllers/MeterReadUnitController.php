<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MeterReadUnits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MeterReadUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $page = 'Meter';
    public function index(Request $request)
    {
        $data = MeterReadUnits::orderBy('id', 'desc')->get();
        foreach ($data as $charge) {
            $charge->status = $charge->status == 1 ? '<input type="button" class="meter_status btn btn-success" value="Active">' : '<input type="button" class="meter_status btn btn-secondary" value="Disabled">';
        }
        // return $data;
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('status', function ($charge) {
                    return $charge->status;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = view('meterunits.button', ['item' => $row, 'route' => 'charge', 'page' => $this->page]);
                    return $actionBtn;
                })
                ->rawColumns(['status', 'action']) //To render HTML content in DataTables,
                ->make(true);
        }
        return view('meterunits.index');
    }

    /**
     * Show the form for creating a new resource.
     */

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' =>  'required|unique:meter_read_units',
            'symbol' => 'required|unique:meter_read_units',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        } else {
            try {
                MeterReadUnits::create($request->toarray());
                return response()->json([
                    'success' => 'Record Saved Successfully'
                ], 201);
            } catch (Exception $e) {
                return response()->json(['errors' => $e->getMessage()], false);
            }
        }
    }

    public function show($meterid)
    {

        $meterdata = MeterReadUnits::where('id', $meterid)->first();
        return view('meterunits.show', compact('meterdata'));
    }

    public function edit($meterid)
    {

        $meterdata = MeterReadUnits::where('id', $meterid)->first();
        return view('meterunits.edit', compact('meterdata'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $meterid)
    {
        // $validate = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'type' => 'required',
        // ]);
        $validate = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('meter_read_units')->ignore($meterid),
            ],
            'symbol' => [
                'required',
                Rule::unique('meter_read_units')->ignore($meterid),
            ],
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        } else {
            try {
                // Find the charge to edit
                $meterdata = MeterReadUnits::where('id', $meterid)->first();

                if ($meterdata) {
                    $meterdata->update($request->toarray());
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
    public function destroy($meterid)
    {
        $meterdata = MeterReadUnits::where('id', $meterid)->first();
        $meterdata->delete();
        return response()->json(['success' => 'Record deleted successfully']);
    }
}
