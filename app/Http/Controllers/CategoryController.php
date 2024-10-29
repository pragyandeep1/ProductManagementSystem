<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\AssetCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $page = 'Category';
    public function index(Request $request)
    {
        $data = AssetCategory::orderBy('id', 'desc')->get();
        foreach ($data as $category) {
            $category->status = $category->status == 1 ? '<input type="button" class="category_status btn btn-success" value="Active">' : '<input type="button" class="category_status btn btn-secondary" value="Disabled">';
        }
        // return $data;
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('status', function ($category) {
                    return $category->status;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = view('category.button', ['item' => $row, 'route' => 'category', 'page' => $this->page]);
                    return $actionBtn;
                })
                ->rawColumns(['status', 'action']) //To render HTML content in DataTables,
                ->make(true);
        }
        return view('category.index');
    }

    /**
     * Show the form for creating a new resource.
     */

    public function store(Request $request)
    {
        // $validate = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'type' => 'required',
        // ]);
        $validate = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('asset_categories')->where(function ($query) use ($request) {
                    return $query->where('type', $request->type);
                })
            ],
            'type' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        } else {
            try {
                AssetCategory::create($request->toarray());
                return response()->json([
                    'success' => 'Category Saved Successfully'
                ], 201);
            } catch (Exception $e) {
                return response()->json(['errors' => $e->getMessage()], false);
            }
        }
    }

    public function show($categoryid)
    {

        $categorydata = AssetCategory::where('id', $categoryid)->first();
        return view('category.show', compact('categorydata'));
    }

    public function edit($categoryid)
    {

        $categorydata = AssetCategory::where('id', $categoryid)->first();
        return view('category.edit', compact('categorydata'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $categoryid)
    {
        // $validate = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'type' => 'required',
        // ]);
        $validate = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('asset_categories')->where(function ($query) use ($request, $categoryid) {
                    return $query->where('type', $request->type)
                        ->where('id', '!=', $categoryid);
                })
            ],
            'type' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        } else {
            try {
                // Find the category to edit
                $categorydata = AssetCategory::where('id', $categoryid)->first();

                if ($categorydata) {
                    $categorydata->update($request->toarray());
                    return response()->json(['data' => $request->all(), 'success' => "Category Updated successfully."]);
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
    public function destroy($categoryid)
    {
        $categorydata = AssetCategory::where('id', $categoryid)->first();
        $categorydata->delete();
        return response()->json(['success' => 'Record deleted successfully']);
    }
}
