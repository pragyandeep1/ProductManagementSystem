<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\AssetAccounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $page = 'Account';
    public function index(Request $request)
    {
        $data = AssetAccounts::orderBy('id', 'desc')->get();
        foreach ($data as $account) {
            $account->status = $account->status == 1 ? '<input type="button" class="account_status btn btn-success" value="Active">' : '<input type="button" class="account_status btn btn-secondary" value="Disabled">';
        }
        // return $data;
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('status', function ($account) {
                    return $account->status;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = view('account.button', ['item' => $row, 'route' => 'account', 'page' => $this->page]);
                    return $actionBtn;
                })
                ->rawColumns(['status', 'action']) //To render HTML content in DataTables,
                ->make(true);
        }
        return view('account.index');
    }

    /**
     * Show the form for creating a new resource.
     */

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'description' =>  'required|unique:asset_account',
            'code' => 'required|unique:asset_account',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        } else {
            try {
                AssetAccounts::create($request->toarray());
                return response()->json([
                    'success' => 'Account Saved Successfully'
                ], 201);
            } catch (Exception $e) {
                return response()->json(['errors' => $e->getMessage()], false);
            }
        }
    }

    public function show($accountid)
    {

        $accountdata = AssetAccounts::where('id', $accountid)->first();
        return view('account.show', compact('accountdata'));
    }

    public function edit($accountid)
    {

        $accountdata = AssetAccounts::where('id', $accountid)->first();
        return view('account.edit', compact('accountdata'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $accountid)
    {
        // $validate = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'type' => 'required',
        // ]);
        $validate = Validator::make($request->all(), [
            'description' => [
                'required',
                Rule::unique('asset_account')->ignore($accountid),
            ],
            'code' => [
                'required',
                Rule::unique('asset_account')->ignore($accountid),
            ],
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        } else {
            try {
                // Find the account to edit
                $accountdata = AssetAccounts::where('id', $accountid)->first();

                if ($accountdata) {
                    $accountdata->update($request->toarray());
                    return response()->json(['data' => $request->all(), 'success' => "Account Updated successfully."]);
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
    public function destroy($accountid)
    {
        $accountdata = AssetAccounts::where('id', $accountid)->first();
        $accountdata->delete();
        return response()->json(['success' => 'Record deleted successfully']);
    }
}
