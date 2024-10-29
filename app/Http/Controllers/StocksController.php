<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\{Facility, Stock, Supplies};
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class StocksController extends Controller
{

    /**
     * Instantiate a new StocksController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:read-stock|create-stock|edit-stock|delete-stock', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-stock', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-stock', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-stock', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('stocks.index', [
            'facilities' => Facility::pluck('name', 'id')->all(),
            'supplies' => Supplies::pluck('name', 'id')->all(),
            'stocks' => Stock::latest()->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('stocks.create',  [
            'facilities' => Facility::pluck('name', 'id')->all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStockRequest $request): RedirectResponse
    {

        $input = $request->all();
        $stock = new Stock;
        $stock->asset_type = 'stock';
        // $stock->asset_id = $request->name;
        $stock->parent_id = $request->stocks_parent_facility;
        $stock->location = json_encode($input['st_loc']);
        $stock->quantity = json_encode($input['st_qty']);

        $stock->save();

        $stockId = $stock->id;
        $stockName = $stock->name;

        return redirect()->route('stocks.edit', $stockId)
            ->withSuccess('New stock is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock): View
    {
        return view('stocks.show', [
            'facilities' => Facility::pluck('name', 'id')->all(),
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock): View
    {
        return view('businesses.edit', [
            'facilities' => Facility::pluck('name', 'id')->all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStockRequest $request, Stock $stock): RedirectResponse
    {

        $input = $request->all();
        $business = Stock::where('id', $stock->id)->first();
        $stock->asset_type = 'stock';
        // $stock->asset_id = $request->name;
        $stock->parent_id = $request->stocks_parent_facility;
        $stock->location = json_encode($input['st_loc']);
        $stock->quantity = json_encode($input['st_qty']);
        $stock->save();

        $stockId = $stock->id;
        $stockName = $stock->name;

        return redirect()->back()->withSuccess('Stock is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock): RedirectResponse
    {
        $stock->delete();
        return redirect()->route('stocks.index')
            ->withSuccess('Stock is deleted successfully.');
    }
}
