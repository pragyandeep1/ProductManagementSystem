<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $page = 'Currency';
    public function index(Request $request)
    {
        $data = Currency::orderBy('id', 'desc')->get();
        foreach ($data as $currency) {
            $currency->status = $currency->status == 1 ? '<input type="button" class="currency_status btn btn-success" value="Active">' : '<input type="button" class="currency_status btn btn-secondary" value="Disabled">';
        }
        // return $data;
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('status', function ($currency) {
                    return $currency->status;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = view('currency.button', ['item' => $row, 'route' => 'currency', 'page' => $this->page]);
                    return $actionBtn;
                })
                ->rawColumns(['status', 'action']) //To render HTML content in DataTables,
                ->make(true);
        }
        return view('currency.index');
    }

    /**
     * Show the form for creating a new resource.
     */

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' =>  'required|unique:currencies',
            'code' => 'required|unique:currencies',
            'symbol' => 'required|unique:currencies',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        } else {
            try {
                Currency::create($request->toarray());
                return response()->json([
                    'success' => 'Record Saved Successfully'
                ], 201);
            } catch (Exception $e) {
                return response()->json(['errors' => $e->getMessage()], false);
            }
        }
    }

    public function show($currencyid)
    {
        $currencydata = Currency::where('id', $currencyid)->first();
        return view('currency.show', compact('currencydata'));
    }

    public function edit($currencyid)
    {
        $currencydata = Currency::where('id', $currencyid)->first();
        return view('currency.edit', compact('currencydata'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $currencyid)
    {
        // $validate = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'type' => 'required',
        // ]);
        $validate = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('currencies')->ignore($currencyid),
            ],
            'code' => [
                'required',
                Rule::unique('currencies')->ignore($currencyid),
            ],
            'symbol' => [
                'required',
                Rule::unique('currencies')->ignore($currencyid),
            ],
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        } else {
            try {
                // Find the currency to edit
                $currencydata = Currency::where('id', $currencyid)->first();

                if ($currencydata) {
                    $currencydata->update($request->toarray());
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
    public function destroy($currencyid)
    {
        $currencydata = Currency::where('id', $currencyid)->first();
        $currencydata->delete();
        return response()->json(['success' => 'Record deleted successfully']);
    }
}
