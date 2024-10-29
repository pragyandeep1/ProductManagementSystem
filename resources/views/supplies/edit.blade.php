@extends('layouts.app')
@push('css')
    <style>
        .ShowtocksModal {
            z-index: 1070 !important;
        }

        .UploadStocksModal {
            z-index: 1080 !important;
        }

        .UploadSupBomModal {
            z-index: 1090 !important;
        }

        .ShowAssetsModal {
            z-index: 1100 !important;
        }

        .CreateAssetModal {
            z-index: 1110 !important;
        }
    </style>
@endpush
@section('content')
    @php
        $current_date_time = \Carbon\Carbon::now();
        if (isset($supply->assetGeneralInfo) && $supply->assetGeneralInfo != 'null') {
            $assetGeneralInfo = $supply->assetGeneralInfo;
        }
        if (isset($supply->assetFiles) && $supply->assetFiles != 'null') {
            $assetFiles = $supply->assetFiles;
        }
        if (isset($supply->stocks) && $supply->stocks != 'null') {
            $stocks = $supply->stocks;
        }
        if (isset($supply->inventories) && $supply->inventories != 'null') {
            $inventories = $supply->inventories;
        }
        if (isset($supply->assetWarranty) && $supply->assetWarranty != 'null') {
            $assetWarranty = $supply->assetWarranty;
        }
        if (isset($supply->assetUser) && $supply->assetUser != 'null') {
            $assetUser = $supply->assetUser;
        }
        if (isset($supply->assetPartSuppliesLog) && $supply->assetPartSuppliesLog != 'null') {
            $assetPartSuppliesLog = $supply->assetPartSuppliesLog;
        }

        // echo '<pre>';
        // print_r($stocks);
        // echo '</pre>';
        // print_r($assetAddress);
        // echo $address['address'];
        // print_r($supply->assetGeneralInfo);

    @endphp
    <!-- Begin Page Content -->
    <div class="page-content container">
        <form action="{{ route('supplies.update', $supply->id) }}" method="post" enctype="multipart/form-data"
            id="supplyUpdateForm">
            @csrf
            @method('PUT')
            <div class="wrapper">
                <div class="status_bar">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="page-header">
                                <h3> Edit Supply @if (!empty($supply->id))
                                        <span class="text-info"> <a href="javascript:void(0)"
                                                class="btn btn-info btn-sm">{{ $supply->name }}
                                                ({{ $supply->code }})</a><span>
                                    @endif
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="float-end">
                                <div class="status_area">
                                    <ul>
                                        <li>
                                            <h3>Status</h3>
                                        </li>
                                        <li>
                                            <select class="form-select" aria-label="Default select example" name="status">
                                                <option value="1" {{ $supply->status == 1 ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="0" {{ $supply->status == 0 ? 'selected' : '' }}>
                                                    Disable
                                                </option>
                                            </select>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa-solid fa-floppy-disk"></i> Publish
                                            </button>
                                        </li>
                                        <li>
                                            <a href="{{ route('supplies.index') }}" class="btn btn-primary float-end">
                                                <i class="fa-solid fa-list me-1"></i>All Supplies
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="{{ $supply->id }}" name="supply_id" id="AssetID">
                <div class="nav_tab_area">
                    <ul class="nav nav-tabs mb-3" id="myTabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" aria-current="page" href="#userBasic">Basic</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#userStock">Stock</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#userboms">BOMs</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#userPersonnel">Personnel</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#userWarranties">Warranties</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#userFiles">Files</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="userBasic">

                            <div class="whitebox mb-4">
                                <div class="page-header mb-2">
                                    <h3>Basic Details</h3>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name" class="col-form-label text-md-end text-start">Supply
                                            name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ $supply->name }}" autocomplete="off">
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label for="code" class="col-form-label text-md-end text-start">Code</label>
                                        <input type="text" class="form-control @error('code') is-invalid @enderror"
                                            id="code" name="code" value="{{ $supply->code }}">
                                        @if ($errors->has('code'))
                                            <span class="text-danger">{{ $errors->first('code') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="category_id" class="col-form-label text-md-end text-start">Category
                                        </label>
                                        <select class="form-control @error('category_id') is-invalid @enderror"
                                            aria-label="Category" id="category_id" name="category_id">
                                            @forelse ($categories as $id => $category)
                                                <option value="{{ $id }}"
                                                    {{ $supply->category_id == $id ? 'selected' : '' }}>
                                                    {{ $category }}
                                                </option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @if ($errors->has('category_id'))
                                            <span class="text-danger">{{ $errors->first('category_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label for="description"
                                            class="col-form-label text-md-end text-start">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                                            cols="48" rows="6">{{ $supply->description }}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="text-danger">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="userStock">
                            <ul class="nav nav-tabs" id="myTabs2">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" aria-current="page"
                                        href="#stockGeneral">General</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#stockStocks">Stock initialization</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#stockInventory">Stock purchase</a>
                                </li>
                            </ul>
                            <div class="item_name">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="stockGeneral">

                                        <div class="whitebox mb-4">
                                            <div class="page-header mb-2">
                                                <h3>General Details</h3>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="account"
                                                        class="col-form-label text-md-end text-start">Account
                                                    </label>
                                                    @php
                                                        // print_r($accounts);
                                                    @endphp
                                                    <select class="form-control @error('account') is-invalid @enderror"
                                                        aria-label="Account" id="account" name="account">
                                                        <option value="">--Select--</option>
                                                        @foreach ($accounts as $account)
                                                            <option value="{{ $account['id'] }}"
                                                                {{ $assetGeneralInfo->accounts_id == $account['id'] ? 'selected' : '' }}>
                                                                ({{ $account['code'] }})
                                                                {{ $account['description'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('account'))
                                                        <span class="text-danger">{{ $errors->first('account') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="department"
                                                        class="col-form-label text-md-end text-start">Charge
                                                        Departments
                                                    </label>
                                                    @php
                                                        // print_r($departments);
                                                    @endphp
                                                    <select class="form-control @error('department') is-invalid @enderror"
                                                        aria-label="Departments" id="department" name="department">
                                                        <option value="">--Select--</option>
                                                        @foreach ($departments as $department)
                                                            <option value="{{ $department['id'] }}"
                                                                {{ $assetGeneralInfo->charge_department_id == $department['id'] ? 'selected' : '' }}>
                                                                ({{ $department['code'] }})
                                                                {{ $department['description'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('department'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('department') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="unspc_code"
                                                        class="col-form-label text-md-end text-start">Unspc Code
                                                    </label>
                                                    <input type="text"
                                                        class="form-control @error('unspc_code') is-invalid @enderror"
                                                        id="unspc_code" name="unspc_code"
                                                        value="{{ $assetGeneralInfo->unspc_code ?? '' }}">
                                                    @if ($errors->has('unspc_code'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('unspc_code') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="barcode"
                                                        class="col-form-label text-md-end text-start">Barcode</label>
                                                    <input type="text"
                                                        class="form-control @error('barcode') is-invalid @enderror"
                                                        id="barcode" name="barcode"
                                                        value="{{ $assetGeneralInfo->barcode ?? '' }}">
                                                    @if ($errors->has('barcode'))
                                                        <span class="text-danger">{{ $errors->first('barcode') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="make"
                                                        class="col-form-label text-md-end text-start">Make
                                                    </label>
                                                    <input type="text"
                                                        class="form-control @error('make') is-invalid @enderror"
                                                        id="make" name="make"
                                                        value="{{ $assetGeneralInfo->make ?? '' }}">
                                                    @if ($errors->has('make'))
                                                        <span class="text-danger">{{ $errors->first('make') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="model"
                                                        class="col-form-label text-md-end text-start">Model</label>
                                                    <input type="text"
                                                        class="form-control @error('model') is-invalid @enderror"
                                                        id="model" name="model"
                                                        value="{{ $assetGeneralInfo->model ?? '' }}">
                                                    @if ($errors->has('model'))
                                                        <span class="text-danger">{{ $errors->first('model') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="last_price"
                                                        class="col-form-label text-md-end text-start">Last Price
                                                    </label>
                                                    <input type="text"
                                                        class="form-control @error('last_price') is-invalid @enderror"
                                                        id="last_price" name="last_price"
                                                        value="{{ $assetGeneralInfo->last_price ?? '' }}">
                                                    @if ($errors->has('last_price'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('last_price') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="total_stock"
                                                        class="col-form-label text-md-end text-start">Total Stock
                                                    </label>
                                                    <input type="text"
                                                        class="form-control @error('total_stock') is-invalid @enderror"
                                                        id="total_stock" name="total_stock"
                                                        value="{{ $totalStock ?? '' }}" readonly>
                                                    @if ($errors->has('total_stock'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('total_stock') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="notes"
                                                        class="col-form-label text-md-end text-start">Notes</label>
                                                    <textarea class="form-control @error('notes') is-invalid @enderror" name="notes" id="notes" cols="48"
                                                        rows="6">{{ $assetGeneralInfo->notes ?? '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="stockStocks">
                                        <div class="whitebox mb-4">
                                            <div class="page-header mb-2">
                                                <h3>Stocks Details</h3>
                                                <a data-bs-toggle="modal" data-bs-target="#UploadStocksModal"
                                                    class="btn btn-primary float-end" style="cursor:pointer"> <i
                                                        class="fa-solid fa-plus me-1"></i>Add new
                                                </a>
                                            </div>
                                            <div class="row">
                                                <div class="page-header">
                                                    <h3>Stock Levels Per Location</h3>
                                                    <hr>
                                                </div>
                                                <table class="display" id="StockList" width ="100%">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">S#</th>
                                                            <th scope="col">Location</th>
                                                            <th scope="col">Initial price</th>
                                                            <th scope="col">Aisle</th>
                                                            <th scope="col">Row</th>
                                                            <th scope="col">Bin</th>
                                                            <th scope="col">Qty on hand</th>
                                                            <th scope="col">Min qty</th>
                                                            <th scope="col">Max qty</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($stocks as $stock)
                                                            @php
                                                                // $stockLocation = json_decode($stock->location, true);
                                                            @endphp
                                                            <tr>
                                                                <th scope="row">{{ $loop->iteration }}</th>
                                                                <td>
                                                                    @if (isset($facilities[$stock->parent_id]))
                                                                        {{ $facilities[$stock->parent_id] }}
                                                                    @endif
                                                                </td>
                                                                <td>{{ $stock->initial_price }}</td>
                                                                <td>{{ $stock['stocks_aisle'] }}</td>
                                                                <td>{{ $stock['stocks_row'] }}</td>
                                                                <td>{{ $stock['stocks_bin'] }}</td>
                                                                <td>{{ $stock->stocks_qty_on_hand }}</td>
                                                                <td>{{ $stock->stocks_min_qty }}</td>
                                                                <td>{{ $stock->stocks_max_qty }}</td>
                                                                <td>
                                                                    <a data-bs-toggle="modal"
                                                                        data-bs-target="#UpdateStocksModal_{{ $stock->id }}"
                                                                        class="link-primary"><i
                                                                            class="fa-regular fa-pen-to-square"></i></a>
                                                                    <button type="button" class="link-danger"
                                                                        onclick="delete_stockdetails('{{ route('supplystocks.delete', $stock->id) }}')"
                                                                        data-id="{{ $stock->id }}">
                                                                        <i class="fa-solid fa-trash-can"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            {{-- modals fields below --}}
                                                            <div class="modal fade UpdateStocksModal"
                                                                id="UpdateStocksModal_{{ $stock->id }}" tabindex="-1"
                                                                role="dialog" aria-hidden="true"
                                                                data-bs-keyboard="false" data-bs-backdrop="static">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <!-- Modal body -->
                                                                        <div class="modal-body">
                                                                            <h6 class="modal-title">Stock</h6>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"><i
                                                                                    class="fa-solid fa-xmark"></i></button>
                                                                            <div class="whitebox mb-4">
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <label
                                                                                            for="stocks_parent_facility_{{ $stock->id }}"
                                                                                            class="col-form-label text-md-end text-start">Location</label>
                                                                                        <select
                                                                                            class="form-control @error('stocks_parent_facility') is-invalid @enderror"
                                                                                            aria-label="stocks_parent_facility"
                                                                                            id="stocks_parent_facility_{{ $stock->id }}"
                                                                                            name="stocks_parent_facility">
                                                                                            <option value="">--None--
                                                                                            </option>
                                                                                            @forelse ($facilities as $id => $facility)
                                                                                                <option
                                                                                                    value="{{ $id }}"
                                                                                                    {{ $stock->parent_id == $id ? 'selected' : '' }}>
                                                                                                    {{ $facility }}
                                                                                                </option>
                                                                                            @empty
                                                                                            @endforelse
                                                                                        </select>
                                                                                        @if ($errors->has('stocks_parent_facility'))
                                                                                            <span
                                                                                                id="stocks_parent_facility-error_{{ $stock->id }}"
                                                                                                class="text-danger">{{ $errors->first('stocks_parent_facility') }}</span>
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <label
                                                                                            for="initial_price_{{ $stock->id }}"
                                                                                            class="col-form-label text-md-end text-start">Initial
                                                                                            price
                                                                                        </label>
                                                                                        <input type="text"
                                                                                            class="form-control @error('initial_price') is-invalid @enderror"
                                                                                            id="initial_price_{{ $stock->id }}"
                                                                                            name="initial_price"
                                                                                            placeholder="0.00"
                                                                                            value="{{ $stock->initial_price }}">
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <label
                                                                                            for="stocks_aisle_{{ $stock->id }}"
                                                                                            class="col-form-label text-md-end text-start">Aisle
                                                                                        </label>
                                                                                        <input type="text"
                                                                                            class="form-control @error('stocks_aisle') is-invalid @enderror"
                                                                                            id="stocks_aisle_{{ $stock->id }}"
                                                                                            name="stocks_aisle"
                                                                                            value="{{ $stock->stocks_aisle }}">
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <label
                                                                                            for="stocks_row_{{ $stock->id }}"
                                                                                            class="col-form-label text-md-end text-start">Row
                                                                                        </label>
                                                                                        <input type="text"
                                                                                            class="form-control @error('stocks_row') is-invalid @enderror"
                                                                                            id="stocks_row_{{ $stock->id }}"
                                                                                            name="stocks_row"
                                                                                            value="{{ $stock->stocks_row }}">
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <label
                                                                                            for="stocks_bin_{{ $stock->id }}"
                                                                                            class="col-form-label text-md-end text-start">Bin
                                                                                        </label>
                                                                                        <input type="text"
                                                                                            class="form-control @error('stocks_bin') is-invalid @enderror"
                                                                                            id="stocks_bin_{{ $stock->id }}"
                                                                                            name="stocks_bin"
                                                                                            value="{{ $stock->stocks_bin }}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-4">
                                                                                        <label
                                                                                            for="stocks_qty_on_hand_{{ $stock->id }}"
                                                                                            class="col-form-label text-md-end text-start">Qty
                                                                                            on hand
                                                                                        </label>
                                                                                        <input type="text"
                                                                                            class="form-control @error('stocks_qty_on_hand') is-invalid @enderror"
                                                                                            id="stocks_qty_on_hand_{{ $stock->id }}"
                                                                                            name="stocks_qty_on_hand"
                                                                                            value="{{ $stock->stocks_qty_on_hand }}">
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <label
                                                                                            for="stocks_min_qty_{{ $stock->id }}"
                                                                                            class="col-form-label text-md-end text-start">Min
                                                                                            qty
                                                                                        </label>
                                                                                        <input type="text"
                                                                                            class="form-control @error('stocks_min_qty') is-invalid @enderror"
                                                                                            id="stocks_min_qty_{{ $stock->id }}"
                                                                                            name="stocks_min_qty"
                                                                                            value="{{ $stock->stocks_min_qty }}">
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <label
                                                                                            for="stocks_max_qty_{{ $stock->id }}"
                                                                                            class="col-form-label text-md-end text-start">Max
                                                                                            qty
                                                                                        </label>
                                                                                        <input type="text"
                                                                                            class="form-control @error('stocks_max_qty') is-invalid @enderror"
                                                                                            id="stocks_max_qty_{{ $stock->id }}"
                                                                                            name="stocks_max_qty"
                                                                                            value="{{ $stock->stocks_max_qty }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <button type="button"
                                                                                class="btn btn-primary mt-3 float-end save-stocks-btn"
                                                                                data-log-id="{{ $stock->id }}">Update</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- modals fields above --}}
                                                        @empty
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><span class="text-info"><strong>No Logs
                                                                        Found!</strong></span></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="stockInventory">

                                        <div class="whitebox mb-4">
                                            <div class="page-header mb-2">
                                                <h3>Inventory Details</h3>
                                                <a data-bs-toggle="modal" data-bs-target="#UploadInventoryModal"
                                                    class="btn btn-primary float-end" style="cursor:pointer"> <i
                                                        class="fa-solid fa-plus me-1"></i>Add new
                                                </a>
                                            </div>
                                            <div class="row">
                                                <div class="page-header">
                                                    <h3>Receipt Line Item</h3>
                                                    <hr>
                                                </div>
                                                <table class="display" id="InventoryList" width ="100%">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">S#</th>
                                                            <th scope="col">Qty</th>
                                                            <th scope="col">Purchased from</th>
                                                            <th scope="col">Received to</th>
                                                            <th scope="col">Date Received</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($inventories as $inventor)
                                                            @php

                                                            @endphp
                                                            <tr>
                                                                <th scope="row">{{ $loop->iteration }}</th>
                                                                <td>{{ $inventor['quantity_received'] }}</td>

                                                                <td>
                                                                    @if (isset($businesses[$inventor['purchased_from']]))
                                                                        {{ $businesses[$inventor['purchased_from']] }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @php
                                                                        $stock = $stocks
                                                                            ->where('id', $inventor['parent_id'])
                                                                            ->first();

                                                                        if ($stock) {
                                                                            $message =
                                                                                $supply->name .
                                                                                ' (' .
                                                                                $supply->code .
                                                                                ') at ' .
                                                                                $facilities[$stock->parent_id];
                                                                            echo $message;
                                                                        }
                                                                    @endphp
                                                                </td>

                                                                <td>{{ \Carbon\Carbon::parse($inventor['date_received'])->format('jS F, Y h:i A') }}
                                                                </td>
                                                                <td>
                                                                    <a data-bs-toggle="modal"
                                                                        data-bs-target="#UpdateInventoryModal_{{ $inventor->id }}"
                                                                        class="link-primary"><i
                                                                            class="fa-regular fa-pen-to-square"></i></a>
                                                                    <button type="button" class="link-danger"
                                                                        onclick="delete_inventoriesdetails('{{ route('supplyinventories.delete', $inventor->id) }}')"
                                                                        data-id="{{ $inventor->id }}">
                                                                        <i class="fa-solid fa-trash-can"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            {{-- modals fields below --}}
                                                            <div class="modal fade"
                                                                id="UpdateInventoryModal_{{ $inventor->id }}"
                                                                tabindex="-1" role="dialog" aria-hidden="true"
                                                                data-bs-keyboard="false" data-bs-backdrop="static">
                                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                    <div class="modal-content">
                                                                        <!-- Modal body -->
                                                                        <div class="modal-body">
                                                                            <h6 class="modal-title">Asset Purchase
                                                                                Information</h6>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"><i
                                                                                    class="fa-solid fa-xmark"></i></button>
                                                                            <div class=""
                                                                                id="ajaxInventorymsg_{{ $inventor->id }}">
                                                                            </div>
                                                                            <div class="whitebox mb-4">
                                                                                <div class="row">
                                                                                    <div class="col-md-6 item_name">
                                                                                        <label
                                                                                            for="inventory_purchased_from_{{ $inventor->id }}"
                                                                                            class="col-form-label text-md-end text-start">Purchased
                                                                                            From</label>
                                                                                        <select
                                                                                            class="form-control @error('inventory_purchased_from') is-invalid @enderror"
                                                                                            aria-label="inventory_purchased_from"
                                                                                            id="inventory_purchased_from_{{ $inventor->id }}"
                                                                                            name="inventory_purchased_from">
                                                                                            <option value="">--Select
                                                                                                Business--</option>
                                                                                            @forelse ($businesses as $id => $business)
                                                                                                <option
                                                                                                    value="{{ $id }}"
                                                                                                    {{ $inventor->purchased_from == $id ? 'selected' : '' }}>
                                                                                                    {{ $business }}
                                                                                                </option>
                                                                                            @empty
                                                                                            @endforelse
                                                                                        </select>
                                                                                        @if ($errors->has('inventory_purchased_from'))
                                                                                            <span
                                                                                                class="text-danger">{{ $errors->first('inventory_purchased_from') }}</span>
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="col-md-6 item_name">
                                                                                        <label
                                                                                            for="inventory_purchase_currency_{{ $inventor->id }}"
                                                                                            class="col-form-label text-md-end text-start">Purchase
                                                                                            Currency</label>
                                                                                        <select
                                                                                            class="form-control @error('inventory_purchase_currency') is-invalid @enderror"
                                                                                            aria-label="inventory_purchase_currency"
                                                                                            id="inventory_purchase_currency_{{ $inventor->id }}"
                                                                                            name="inventory_purchase_currency">
                                                                                            <option value="">--None--
                                                                                            </option>
                                                                                            @forelse ($currencies as $id => $currenci)
                                                                                                <option
                                                                                                    value="{{ $id }}"
                                                                                                    {{ $inventor->purchase_currency == $id ? 'selected' : '' }}>
                                                                                                    {{ $currenci }}
                                                                                                </option>
                                                                                            @empty
                                                                                            @endforelse
                                                                                        </select>
                                                                                        @if ($errors->has('inventory_purchase_currency'))
                                                                                            <span
                                                                                                class="text-danger">{{ $errors->first('inventory_purchase_currency') }}</span>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <label
                                                                                            for="inventory_date_ordered_{{ $inventor->id }}"
                                                                                            class="col-form-label text-md-end text-start">Date
                                                                                            Ordered
                                                                                        </label>
                                                                                        <input type="date"
                                                                                            class="form-control @error('inventory_date_ordered') is-invalid @enderror"
                                                                                            id="inventory_date_ordered_{{ $inventor->id }}"
                                                                                            name="inventory_date_ordered"
                                                                                            value="{{ $inventor->date_ordered }}"
                                                                                            min="{{ date('Y-m-d') }}">
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <label
                                                                                            for="inventory_date_received_{{ $inventor->id }}"
                                                                                            class="col-form-label text-md-end text-start">Date
                                                                                            Received
                                                                                        </label>
                                                                                        <input type="date"
                                                                                            class="form-control @error('inventory_date_received') is-invalid @enderror"
                                                                                            id="inventory_date_received_{{ $inventor->id }}"
                                                                                            name="inventory_date_received"
                                                                                            value="{{ $inventor->date_received }}"
                                                                                            min="{{ date('Y-m-d') }}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <label
                                                                                            for="inventory_received_to_msg_{{ $inventor->id }}"
                                                                                            class="col-form-label text-md-end text-start">Received
                                                                                            To
                                                                                        </label>
                                                                                        <div class="input-group">
                                                                                            <input type="hidden"
                                                                                                class="form-control"
                                                                                                name="inventory_received_to"
                                                                                                id="inventory_received_to_{{ $inventor->id }}"
                                                                                                value="{{ $inventor->parent_id }}">
                                                                                            <input type="text"
                                                                                                id="inventory_received_to_msg_{{ $inventor->id }}"
                                                                                                class="form-control @error('inventory_received_to') is-invalid @enderror"
                                                                                                value=" @php $stock = $stocks
                                                                                                    ->where('id', $inventor['parent_id'])
                                                                                                    ->first();
                                                                                                if ($stock) {
                                                                                                    $message =
                                                                                                        $supply->name .
                                                                                                        ' (' .
                                                                                                        $supply->code .
                                                                                                        ') at ' .
                                                                                                        $facilities[$stock->parent_id];
                                                                                                    echo $message;
                                                                                                } @endphp"
                                                                                                readonly>
                                                                                            <a data-bs-toggle="modal"
                                                                                                data-bs-target="#ShowtocksModal_{{ $inventor->id }}"
                                                                                                class="btn btn-primary float-end"
                                                                                                style="cursor:pointer"> <i
                                                                                                    class="fa-solid fa-plus me-1"></i>
                                                                                            </a>
                                                                                            @if ($errors->has('inventory_received_to'))
                                                                                                <span
                                                                                                    id="inventory_received_to-error_{{ $inventor->id }}"
                                                                                                    class="text-danger">{{ $errors->first('inventory_received_to') }}</span>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-6">
                                                                                        <label
                                                                                            for="inventory_quantity_received_{{ $inventor->id }}"
                                                                                            class="col-form-label text-md-end text-start">Quantity
                                                                                            Received
                                                                                        </label>
                                                                                        <input type="text"
                                                                                            class="form-control @error('inventory_quantity_received') is-invalid @enderror"
                                                                                            id="inventory_quantity_received_{{ $inventor->id }}"
                                                                                            name="inventory_quantity_received"
                                                                                            value="{{ $inventor->quantity_received ?? '0' }}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <label
                                                                                            for="inventory_purchase_price_per_unit_{{ $inventor->id }}"
                                                                                            class="col-form-label text-md-end text-start">Purchase
                                                                                            Price Per Unit
                                                                                        </label>
                                                                                        <input type="text"
                                                                                            class="form-control @error('inventory_purchase_price_per_unit') is-invalid @enderror"
                                                                                            id="inventory_purchase_price_per_unit_{{ $inventor->id }}"
                                                                                            name="inventory_purchase_price_per_unit"
                                                                                            value="{{ $inventor->purchase_price_per_unit ?? '0' }}">
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <label
                                                                                            for="inventory_purchase_price_total_{{ $inventor->id }}"
                                                                                            class="col-form-label text-md-end text-start">Purchase
                                                                                            Price
                                                                                            Total
                                                                                        </label>
                                                                                        <input type="text"
                                                                                            class="form-control @error('inventory_purchase_price_total') is-invalid @enderror"
                                                                                            id="inventory_purchase_price_total_{{ $inventor->id }}"
                                                                                            name="inventory_purchase_price_total"
                                                                                            value="{{ $inventor->purchase_price_total }}"
                                                                                            readonly>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <label
                                                                                            for="inventory_date_of_expiry_{{ $inventor->id }}"
                                                                                            class="col-form-label text-md-end text-start">Date
                                                                                            of Expiry
                                                                                        </label>
                                                                                        <input type="date"
                                                                                            class="form-control @error('inventory_date_of_expiry') is-invalid @enderror"
                                                                                            id="inventory_date_of_expiry_{{ $inventor->id }}"
                                                                                            name="inventory_date_of_expiry"
                                                                                            value="{{ $inventor->date_of_expiry }}"
                                                                                            min="{{ date('Y-m-d') }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <button type="button"
                                                                                class="btn btn-primary mt-3 float-end save-inventories-btn"
                                                                                data-log-id="{{ $inventor->id }}">Update</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- modals fields above --}}
                                                        @empty
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><span class="text-info"><strong>No Logs
                                                                        Found!</strong></span></td>
                                                            <td></td>
                                                            <td></td>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                                {{-- modals fields below --}}
                                                @forelse ($inventories as $inventor)
                                                    <div class="modal fade ShowtocksModal"
                                                        id="ShowtocksModal_{{ $inventor->id }}" tabindex="-1"
                                                        role="dialog" aria-hidden="true" data-bs-keyboard="false"
                                                        data-bs-backdrop="static">
                                                        <div class="modal-dialog  modal-dialog-centered modal-lg">
                                                            <div class="modal-content">
                                                                <!-- Modal body -->
                                                                <div class="modal-body">
                                                                    <h6 class="modal-title">Current Stock</h6>
                                                                    <a data-bs-toggle="modal"
                                                                        data-bs-target="#UploadStocksModal"
                                                                        class="btn btn-primary float-end mt-2 mb-2"
                                                                        style="cursor:pointer"> <i
                                                                            class="fa-solid fa-plus me-1"></i>Add new
                                                                    </a>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"><i
                                                                            class="fa-solid fa-xmark"></i></button>
                                                                    <table class="display table table-striped"
                                                                        id="" width ="100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col">S#</th>
                                                                                <th scope="col">Location</th>
                                                                                <th scope="col">Aisle</th>
                                                                                <th scope="col">Row</th>
                                                                                <th scope="col">Bin</th>
                                                                                <th scope="col">Qty on hand</th>
                                                                                <th scope="col">Min qty</th>
                                                                                <th scope="col">Max qty</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @forelse ($stocks as $stock)
                                                                                <tr class="inventories-row-modal"
                                                                                    data-id="{{ $stock->id }}"
                                                                                    data-tableid="{{ $inventor->id }}"
                                                                                    style="cursor: pointer">
                                                                                    <th scope="row">
                                                                                        {{ $loop->iteration }}</th>
                                                                                    <td>
                                                                                        @if (isset($facilities[$stock->parent_id]))
                                                                                            {{ $facilities[$stock->parent_id] }}
                                                                                        @endif
                                                                                    </td>
                                                                                    <td>{{ $stock['stocks_aisle'] }}</td>
                                                                                    <td>{{ $stock['stocks_row'] }}</td>
                                                                                    <td>{{ $stock['stocks_bin'] }}</td>
                                                                                    <td>{{ $stock->stocks_qty_on_hand }}
                                                                                    </td>
                                                                                    <td>{{ $stock->stocks_min_qty }}</td>
                                                                                    <td>{{ $stock->stocks_max_qty }}</td>
                                                                                </tr>
                                                                            @empty
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td><span class="text-info"><strong>No Logs
                                                                                            Found!</strong></span></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            @endforelse
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                {{-- modals fields above --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="userboms">
                            <div class="whitebox mb-4">
                                <div class="page-header mb-2">
                                    <h3>BOMs Details</h3>
                                    <a data-bs-toggle="modal" data-bs-target="#UploadSupBomModal"
                                        class="btn btn-primary float-end" style="cursor:pointer"> <i
                                            class="fa-solid fa-plus me-1"></i>Add new
                                    </a>
                                </div>
                                <div class="row">
                                    <div class="page-header">
                                        <h3>Asset Consuming Reference</h3>
                                        <hr>
                                    </div>
                                    <table class="display" id="SupplyBomList" width ="100%">
                                        <thead>
                                            <tr>
                                                <th width="3%">S#</th>
                                                <th width="13%">Asset</th>
                                                <th width="13%">Quantity</th>
                                                <th>Submitted By User</th>
                                                <th>Date Submitted</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($assetPartSuppliesLog as $suppliesLog)
                                                @php
                                                    if (
                                                        isset($suppliesLog->part_supply_id) &&
                                                        $suppliesLog->part_supply_id != 'NULL'
                                                    ) {
                                                        if ($suppliesLog->asset_type == 'facility') {
                                                            $supplyLog = \App\Models\Facility::find(
                                                                $suppliesLog->asset_id,
                                                            );
                                                            $href = route('facilities.edit', $suppliesLog->asset_id);
                                                        } elseif ($suppliesLog->asset_type == 'equipment') {
                                                            $supplyLog = \App\Models\Equipment::find(
                                                                $suppliesLog->asset_id,
                                                            );
                                                            $href = route('equipments.edit', $suppliesLog->asset_id);
                                                        } elseif ($suppliesLog->asset_type == 'tools') {
                                                            $supplyLog = \App\Models\Tool::find($suppliesLog->asset_id);
                                                            $href = route('tools.edit', $suppliesLog->asset_id);
                                                        }
                                                    } else {
                                                        $supplyLog = '';
                                                        $href = 'javascript:void(0)';
                                                    }
                                                    if (
                                                        isset($suppliesLog->submitted_by) &&
                                                        $suppliesLog->submitted_by != 'NULL'
                                                    ) {
                                                        $submitted_by = \App\Models\User::find(
                                                            $suppliesLog->submitted_by,
                                                        );
                                                    }
                                                @endphp
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td>
                                                        @if (isset($suppliesLog->part_supply_id) && $suppliesLog->part_supply_id != 'NULL')
                                                            <a href="{{ $href }}"
                                                                target="_blank">{{ $supplyLog->name ?? '' }}
                                                                ({{ $supplyLog->code ?? '' }})
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $suppliesLog->quantity ?? '' }}
                                                    </td>
                                                    <td>
                                                        @if (isset($suppliesLog->submitted_by) && $suppliesLog->submitted_by != 'NULL')
                                                            <a href="{{ route('users.show', $suppliesLog->submitted_by) }}"
                                                                class="">{{ $submitted_by->name ?? '' }}</a>
                                                        @endif
                                                    </td>
                                                    <td>{{ $suppliesLog->updated_at ? \Carbon\Carbon::parse($suppliesLog->updated_at)->format('jS F, Y h:i:s A') : '--' }}
                                                    </td>
                                                    <td>
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#EditBOMModal_{{ $suppliesLog->id }}"
                                                            class="link-primary"><i
                                                                class="fa-regular fa-pen-to-square"></i></a>
                                                        <button type="button" class="link-danger"
                                                            onclick="delete_supplyparts('{{ route('supplyparts.delete', $suppliesLog->id) }}')"
                                                            data-id="{{ $suppliesLog->id }}">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- modals fields below --}}
                                                <div class="modal fade EditpartsModal"
                                                    id="EditBOMModal_{{ $suppliesLog->id }}" data-bs-keyboard="false"
                                                    data-bs-backdrop="static">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                                <h6 class="modal-title">Part Supply Assets</h6>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"><i
                                                                        class="fa-solid fa-xmark"></i></button>
                                                                <div class="whitebox mb-4">
                                                                    <div class="mb-2">
                                                                        <label class="">Asset
                                                                        </label>
                                                                    </div>
                                                                    <div class="input-group mb-3">
                                                                        <input type="hidden" class="form-control"
                                                                            name="asset"
                                                                            id="asset_{{ $suppliesLog->id }}"
                                                                            value="">
                                                                        <input type="hidden" class="form-control"
                                                                            name="asset_type"
                                                                            id="asset_type_{{ $suppliesLog->id }}"
                                                                            value="">
                                                                        <input type="text"
                                                                            id="asset_msg_{{ $suppliesLog->id }}"
                                                                            class="form-control @error('asset') is-invalid @enderror"
                                                                            value="{{ $supplyLog->name ?? '' }}({{ $supplyLog->code ?? '' }})"
                                                                            readonly>
                                                                        @if ($errors->has('asset'))
                                                                            <span
                                                                                class="text-danger">{{ $errors->first('asset') }}</span>
                                                                        @endif
                                                                        <label for="asset_new_{{ $suppliesLog->id }}"
                                                                            class="col-form-label text-md-end text-start">
                                                                        </label>
                                                                        <a data-bs-toggle="modal"
                                                                            id="asset_new_{{ $suppliesLog->id }}"
                                                                            data-bs-target="#ShowAssetsModal_{{ $suppliesLog->id }}"
                                                                            class="btn btn-primary float-end"
                                                                            style="cursor:pointer"> <i
                                                                                class="fa-solid fa-plus me-1"></i>
                                                                        </a>
                                                                    </div>
                                                                    <div class="mb-2"> <label for="quantity"
                                                                            class="col-form-label text-md-end text-start">Qty</label>
                                                                        <input type="number"
                                                                            id="quantity_{{ $suppliesLog->id }}"
                                                                            name="quantity" class="form-control"
                                                                            value="{{ $suppliesLog->quantity }}">
                                                                        @if ($errors->has('quantity'))
                                                                            <span
                                                                                class="text-danger">{{ $errors->first('quantity') }}</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <button type="button"
                                                                    class="btn btn-primary mt-3 float-end save-parts-btn"
                                                                    data-log-id="{{ $suppliesLog->id }}">Update</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- modals fields above --}}
                                            @empty
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><span class="text-info"><strong>No Logs
                                                                Found!</strong></span></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    {{-- modals fields below --}}
                                    @foreach ($assetPartSuppliesLog as $suppliesLog)
                                        <div class="modal fade ShowAssetsModal"
                                            id="ShowAssetsModal_{{ $suppliesLog->id }}" tabindex="-1" role="dialog"
                                            aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <h6 class="modal-title">Assets</h6>
                                                        {{-- <a data-bs-toggle="modal"
                                                                    data-bs-target="#CreateAssetModal"
                                                                    class="btn btn-primary float-end mt-2 mb-2"
                                                                    style="cursor:pointer"> <i
                                                                        class="fa-solid fa-plus me-1"></i>Add new
                                                                </a> --}}
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"><i
                                                                class="fa-solid fa-xmark"></i></button>
                                                        <table class="display table table-striped" id=""
                                                            width ="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Name</th>
                                                                    <th scope="col">Code</th>
                                                                    <th scope="col">Status</th>
                                                                    <th scope="col">Location</th>
                                                                    <th scope="col">Type</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($allfacilities as $facility)
                                                                    <tr class="bom-row-modal" data-type="facility"
                                                                        data-id="{{ $facility->id }}"
                                                                        data-parttableid="{{ $suppliesLog->id }}"
                                                                        style="cursor: pointer">
                                                                        {{-- <td>Facility</td> --}}
                                                                        <td>{{ $facility->name }}</td>
                                                                        <td>{{ $facility->code }}</td>
                                                                        <td>{{ $facility->status == '1' ? 'Active' : 'Inactive' }}
                                                                        </td>
                                                                        <td>
                                                                            @if (
                                                                                $facility->assetAddress &&
                                                                                    $facility->assetAddress->parent_id &&
                                                                                    ($parentFacility = $allfacilities->where('id', $facility->assetAddress->parent_id)->first()))
                                                                                {{ $parentFacility->name }}
                                                                            @endif
                                                                        </td>
                                                                        <td style="color: brown">
                                                                            {{ 'Facility' }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                @foreach ($allequipments as $equipment)
                                                                    <tr class="bom-row-modal" data-type="equipment"
                                                                        data-id="{{ $equipment->id }}"
                                                                        data-parttableid="{{ $suppliesLog->id }}"
                                                                        style="cursor: pointer">
                                                                        <td>{{ $equipment->name }}</td>
                                                                        <td>{{ $equipment->code }}</td>
                                                                        <td>{{ $equipment->status == '1' ? 'Active' : 'Inactive' }}
                                                                        </td>
                                                                        <td>
                                                                            @if (
                                                                                $equipment->assetAddress &&
                                                                                    $equipment->assetAddress->parent_id &&
                                                                                    ($parentFacility = $allfacilities->where('id', $equipment->assetAddress->parent_id)->first()))
                                                                                {{ $parentFacility->name }}
                                                                            @endif
                                                                        </td>
                                                                        <td style="color: orange">
                                                                            {{ 'Equipment' }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                @foreach ($alltools as $tool)
                                                                    <tr class="bom-row-modal" data-type="tools"
                                                                        data-id="{{ $tool->id }}"
                                                                        data-parttableid="{{ $suppliesLog->id }}"
                                                                        style="cursor: pointer">
                                                                        <td>{{ $tool->name }}</td>
                                                                        <td>{{ $tool->code }}</td>
                                                                        <td>{{ $tool->status == '1' ? 'Active' : 'Inactive' }}
                                                                        </td>
                                                                        <td>
                                                                            @if (
                                                                                $tool->assetAddress &&
                                                                                    $tool->assetAddress->parent_id &&
                                                                                    ($parentFacility = $allfacilities->where('id', $tool->assetAddress->parent_id)->first()))
                                                                                {{ $parentFacility->name }}
                                                                            @endif
                                                                        </td>
                                                                        <td style="color: rgb(84, 9, 9)">
                                                                            {{ 'Tools' }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    {{-- modals fields above --}}
                                </div>
                            </div>

                        </div>
                        {{-- <div class="tab-pane fade" id="userPersonnel">
                                <div class="page-header">
                                    <h3>Personnel</h3>
                                    <a data-bs-toggle="modal" data-bs-target="#UploadUserModal"
                                        class="btn btn-primary float-end mt-4" style="cursor:pointer"> <i
                                            class="fa-solid fa-plus me-1"></i>Add new
                                    </a>
                                </div>
                                <div class="whitebox mb-4">
                                    <div class="row">
                                        <div class="page-header">
                                            <h3>Users </h3>
                                            <hr>
                                        </div>
                                        <table id="UsersList" class="display" width="100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col">S#</th>
                                                    <th scope="col">User</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($assetUser as $User)
                                                    <tr>
                                                        <th scope="row">{{ $loop->iteration }}</th>
                                                        <td>
                                                            @if (isset($users[$User['user_id']]))
                                                                {{ $users[$User['user_id']] }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <td></td>
                                                    <td><span class="text-info"><strong>No Logs
                                                                Found!</strong></span></td>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> --}}
                        <div class="tab-pane fade" id="userWarranties">
                            <div class="whitebox mb-4">
                                <div class="page-header mb-2">
                                    <h3>Warranty Details</h3>
                                    <a data-bs-toggle="modal" data-bs-target="#UploadWarrantyModal"
                                        class="btn btn-primary float-end" style="cursor:pointer"> <i
                                            class="fa-solid fa-plus me-1"></i>Add new
                                    </a>
                                </div>
                                <div class="row">
                                    <div class="page-header">
                                        <h3>Warranty Certificates </h3>
                                        <hr>
                                    </div>
                                    <table class="display" id="InventoryList" width ="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">S#</th>
                                                <th scope="col">Date Added</th>
                                                <th scope="col">Expiry Date</th>
                                                <th scope="col">Certificate Number</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($assetWarranty as $warranty)
                                                <tr>
                                                    <th scope="row" width="5%">{{ $loop->iteration }}</th>
                                                    <td width="35%">
                                                        {{ \Carbon\Carbon::parse($warranty['created_at'])->format('jS F, Y h:i A') }}
                                                    </td>
                                                    <td style="color: #990000" width="30%">
                                                        @if (isset($warranty['expiry_date']))
                                                            {{ \Carbon\Carbon::parse($warranty['expiry_date'])->format('jS F, Y') }}
                                                        @else
                                                        @endif
                                                    </td>
                                                    <td width="30%">
                                                        {{ $warranty['certificate_number'] ?? '' }}
                                                    </td>
                                                    <td>
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#EditwarrantyModal_{{ $warranty->id }}"
                                                            class="link-primary"><i
                                                                class="fa-regular fa-pen-to-square"></i></a>

                                                        <button type="button" class="link-danger"
                                                            onclick="delete_supplywarranties('{{ route('supplywarranties.delete', $warranty->id) }}')"
                                                            data-id="{{ $warranty->id }}">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    </td>
                                                </tr>

                                            @empty
                                                <td></td>
                                                <td></td>
                                                <td><span class="text-info"><strong>No Logs
                                                            Found!</strong></span></td>
                                                <td></td>
                                                <td></td>
                                            @endforelse

                                            {{-- modals fields below --}}
                                            @foreach ($assetWarranty as $warranty)
                                                <div class="modal fade EditwarrantyModal"
                                                    id="EditwarrantyModal_{{ $warranty->id }}" tabindex="-1"
                                                    role="dialog" aria-hidden="true" data-bs-keyboard="false"
                                                    data-bs-backdrop="static">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                                <h6 class="modal-title">Warranty Certificate</h6>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"><i
                                                                        class="fa-solid fa-xmark"></i></button>

                                                                <div class="item_name">
                                                                    <div class="whitebox mb-4">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <label
                                                                                    for="warranty_type_{{ $warranty->id }}"
                                                                                    class="col-form-label text-md-end text-start">Warranty
                                                                                    Type
                                                                                </label>
                                                                                <select
                                                                                    class="form-control @error('warranty_type') is-invalid @enderror"
                                                                                    aria-label="Warranty Type"
                                                                                    id="warranty_type_{{ $warranty->id }}"
                                                                                    name="warranty_type">
                                                                                    <option value="">--Select--
                                                                                    </option>
                                                                                    <option value="Basic"
                                                                                        {{ $warranty->warranty_type == 'Basic' ? 'selected' : '' }}>
                                                                                        Basic</option>
                                                                                    <option value="Extended"
                                                                                        {{ $warranty->warranty_type == 'Extended' ? 'selected' : '' }}>
                                                                                        Extended</option>
                                                                                </select>
                                                                                @if ($errors->has('warranty_type'))
                                                                                    <span
                                                                                        class="text-danger">{{ $errors->first('warranty_type') }}</span>
                                                                                @endif
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label for="provider_{{ $warranty->id }}"
                                                                                    class="col-form-label text-md-end text-start">Provider</label>
                                                                                <select
                                                                                    class="form-control @error('provider') is-invalid @enderror"
                                                                                    aria-label="provider"
                                                                                    id="provider_{{ $warranty->id }}"
                                                                                    name="provider">
                                                                                    <option value="">--Select
                                                                                        Business--</option>
                                                                                    @forelse ($businesses as $id => $business)
                                                                                        <option
                                                                                            value="{{ $id }}"
                                                                                            {{ $warranty->provider == $id ? 'selected' : '' }}>
                                                                                            {{ $business }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @if ($errors->has('provider'))
                                                                                    <span
                                                                                        class="text-danger">{{ $errors->first('provider') }}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">

                                                                            <div class="col-md-6">
                                                                                <label
                                                                                    for="warranty_usage_term_type2_{{ $warranty->id }}"
                                                                                    class="col-form-label text-md-end text-start">Warranty
                                                                                    Usage Term Type
                                                                                </label>
                                                                                <select
                                                                                    class="form-control @error('warranty_usage_term_type') is-invalid @enderror"
                                                                                    aria-label="warranty_usage_term_type"
                                                                                    id="warranty_usage_term_type2_{{ $warranty->id }}"
                                                                                    name="warranty_usage_term_type">
                                                                                    <option value="">--Select--
                                                                                    </option>
                                                                                    <option value="Date"
                                                                                        {{ $warranty->warranty_usage_term_type == 'Date' ? 'selected' : '' }}>
                                                                                        Date</option>
                                                                                    <option value="Meter"
                                                                                        {{ $warranty->warranty_usage_term_type == 'Meter' ? 'selected' : '' }}>
                                                                                        Meter reading</option>
                                                                                    <option value="Production"
                                                                                        {{ $warranty->warranty_usage_term_type == 'Production' ? 'selected' : '' }}>
                                                                                        Production time</option>
                                                                                </select>
                                                                                @if ($errors->has('warranty_usage_term_type'))
                                                                                    <span
                                                                                        class="text-danger">{{ $errors->first('warranty_usage_term_type') }}</span>
                                                                                @endif
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label
                                                                                    for="expiry_date_{{ $warranty->id }}"
                                                                                    class="col-form-label text-md-end text-start">Expiry
                                                                                    Date</label>
                                                                                <input type="date"
                                                                                    class="form-control @error('expiry_date') is-invalid @enderror"
                                                                                    id="expiry_date_{{ $warranty->id }}"
                                                                                    name="expiry_date"
                                                                                    value="{{ $warranty->expiry_date ?? '' }}">
                                                                                @if ($errors->has('expiry_date'))
                                                                                    <span
                                                                                        class="text-danger">{{ $errors->first('expiry_date') }}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="row"
                                                                            id="meter_reading_fields2_{{ $warranty->id }}">
                                                                            <div class="col-md-6">
                                                                                <label
                                                                                    for="meter_reading_{{ $warranty->id }}"
                                                                                    class="col-form-label text-md-end text-start">Meter
                                                                                    Reading Value Limit
                                                                                </label>
                                                                                <input type="text"
                                                                                    id="meter_reading_{{ $warranty->id }}"
                                                                                    name="meter_reading"
                                                                                    class="form-control @error('meter_reading') is-invalid @enderror"
                                                                                    placeholder="0.00"
                                                                                    value="{{ $warranty->meter_reading ?? '' }}">
                                                                                @if ($errors->has('meter_reading'))
                                                                                    <span
                                                                                        class="text-danger">{{ $errors->first('meter_reading') }}</span>
                                                                                @endif
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label
                                                                                    for="meter_read_units_{{ $warranty->id }}"
                                                                                    class="col-form-label text-md-end text-start">Meter
                                                                                    Reading Units
                                                                                </label>
                                                                                <select
                                                                                    class="form-control @error('meter_read_units') is-invalid @enderror"
                                                                                    aria-label="Meter read units"
                                                                                    id="meter_read_units_{{ $warranty->id }}"
                                                                                    name="meter_read_units">
                                                                                    <option value="">--Select--
                                                                                    </option>
                                                                                    @foreach ($MeterReadUnits as $meterReadUnit)
                                                                                        <option
                                                                                            value="{{ $meterReadUnit['id'] }}"
                                                                                            {{ $warranty->meter_reading_units == $meterReadUnit['id'] ? 'selected' : '' }}>
                                                                                            {{ $meterReadUnit['name'] }}
                                                                                            ({{ $meterReadUnit['symbol'] }})
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @if ($errors->has('meter_read_units'))
                                                                                    <span
                                                                                        class="text-danger">{{ $errors->first('meter_read_units') }}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <label
                                                                                    for="certificate_number_{{ $warranty->id }}"
                                                                                    class="col-form-label text-md-end text-start">Certificate
                                                                                    Number
                                                                                </label>
                                                                                <input type="text"
                                                                                    class="form-control @error('certificate_number') is-invalid @enderror"
                                                                                    id="certificate_number_{{ $warranty->id }}"
                                                                                    name="certificate_number"
                                                                                    value="{{ $warranty['certificate_number'] ?? '' }}">
                                                                                @if ($errors->has('certificate_number'))
                                                                                    <span
                                                                                        class="text-danger">{{ $errors->first('certificate_number') }}</span>
                                                                                @endif
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label
                                                                                    for="warranty_description_{{ $warranty->id }}"
                                                                                    class="col-form-label text-md-end text-start">Description</label>
                                                                                <textarea class="form-control @error('warranty_description') is-invalid @enderror" name="warranty_description"
                                                                                    id="warranty_description_{{ $warranty->id }}" cols="48" rows="3">{{ $warranty['description'] ?? '' }}</textarea>
                                                                                @if ($errors->has('warranty_description'))
                                                                                    <span
                                                                                        class="text-danger">{{ $errors->first('warranty_description') }}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button type="button"
                                                                    class="btn btn-primary mt-3 float-end save-warranty-btn"
                                                                    data-log-id="{{ $warranty->id }}">Update</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            {{-- modals fields above --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="userFiles">
                            <div class="item_name">
                                <div class="whitebox mb-4">
                                    <div class="page-header mb-2">
                                        <h3>Documents</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <input type="file"
                                                class="form-control @error('files') is-invalid @enderror" id="files"
                                                name="files[]" multiple>
                                            @if ($errors->has('files'))
                                                <span class="text-danger">{{ $errors->first('files') }}</span>
                                            @endif
                                            <span class="text-muted">*Supported file type: doc, docx,
                                                xlsx, xls, ppt, pptx, txt, pdf, jpg, jpeg, png, webp, gif</span>
                                        </div>
                                        @php
                                            // print_r($assetFiles);
                                        @endphp
                                        <table id="FacilityFilesList" class="display" width="100%">

                                            <thead>
                                                <tr>
                                                    <th scope="col">S#</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Type</th>
                                                    {{-- <th scope="col">Valid from</th>
                                                        <th scope="col">Valid to</th> --}}
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            {{-- @if ($assetFiles->isNotEmpty()) --}}
                                            <tbody>
                                                @forelse ($assetFiles as $certificate)
                                                    <tr>
                                                        <th scope="row">{{ $loop->iteration }}</th>
                                                        <td>{{ $certificate->name }}</td>
                                                        <td>{{ $certificate->description }}</td>
                                                        <td>{{ $certificate->type }}</td>
                                                        {{-- <td>{{ $certificate->valid_from }}</td>
                                                            <td>{{ $certificate->valid_to }}</td> --}}
                                                        <td><a href="{{ asset($certificate->url) }}"
                                                                class="btn btn-warning btn-sm" target="_blank"
                                                                title="View"><i class="bi bi-eye"></i></a>
                                                            <a data-bs-toggle="modal"
                                                                data-bs-target="#UploadFileModal_{{ $certificate->af_id }}"
                                                                class="link-primary"><i
                                                                    class="fa-regular fa-pen-to-square"></i></a>
                                                            <button type="button" class="link-danger"
                                                                onclick="delete_savedocs('{{ route('supplydocs.delete', $certificate->af_id) }}')"
                                                                data-id="{{ $certificate->af_id }}">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    {{-- view file modal --}}
                                                    <div class="modal fade"
                                                        id="UploadFileModal_{{ $certificate->af_id }}"
                                                        data-bs-keyboard="false" data-bs-backdrop="static">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <!-- Modal body -->
                                                                <div class="modal-body">
                                                                    <h6 class="modal-title">
                                                                        {{ $supply->name }}
                                                                        Documents</h6>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"><i
                                                                            class="fa-solid fa-xmark"></i></button>
                                                                    {{-- <form
                                                                        id="certUpdateForm{{ $certificate->af_id }}"> --}}
                                                                    <div class=""
                                                                        id="ajaxmsgModal{{ $certificate->af_id }}">
                                                                    </div>
                                                                    <div class="whitebox mb-4">
                                                                        <div class="col-md-8">
                                                                            <label
                                                                                for="cert_name_{{ $certificate->af_id }}"
                                                                                class="col-form-label text-md-end text-start">Name</label>
                                                                            <input type="text" class="form-control  "
                                                                                id="cert_name_{{ $certificate->af_id }}"
                                                                                name="cert_name_{{ $certificate->af_id }}"
                                                                                value="{{ $certificate->name }}">
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <label
                                                                                for="cert_description_{{ $certificate->af_id }}"
                                                                                class="col-form-label text-md-end text-start">Description
                                                                            </label>
                                                                            <textarea class="form-control" id="cert_description_{{ $certificate->af_id }}"
                                                                                name="cert_description_{{ $certificate->af_id }}" rows="2">{{ $certificate->description }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-primary mt-3 float-end save-docs-btn"
                                                                        data-log-id="{{ $certificate->af_id }}">Update</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- view file modal --}}
                                                @empty
                                                    <td></td>
                                                    <td></td>
                                                    {{-- <td></td> --}}
                                                    <td><span class="text-info"><strong>No Documents
                                                                Found!</strong></span></td>
                                                    {{-- <td></td> --}}
                                                    <td></td>
                                                    <td></td>
                                                @endforelse
                                            </tbody>
                                            {{-- @endif --}}
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- modals fields below --}}
                <div class="modal fade ShowtocksModal" id="ShowtocksModal" tabindex="-1" role="dialog"
                    aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
                    <div class="modal-dialog  modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <!-- Modal body -->
                            <div class="modal-body">
                                <h6 class="modal-title">Current Stock</h6>
                                <a data-bs-toggle="modal" data-bs-target="#UploadStocksModal"
                                    class="btn btn-primary float-end mt-2 mb-2" style="cursor:pointer"> <i
                                        class="fa-solid fa-plus me-1"></i>Add new
                                </a>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                        class="fa-solid fa-xmark"></i></button>
                                <table class="display table table-striped" id="" width ="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">S#</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Aisle</th>
                                            <th scope="col">Row</th>
                                            <th scope="col">Bin</th>
                                            <th scope="col">Qty on hand</th>
                                            <th scope="col">Min qty</th>
                                            <th scope="col">Max qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($stocks as $stock)
                                            @php
                                                // $stockLocation = json_decode($stock->location, true);
                                                // $stockQuantity = json_decode($stock->quantity, true);
                                            @endphp
                                            <tr class="stock-row" data-id="{{ $stock->id }}"
                                                style="cursor: pointer">
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>
                                                    @if (isset($facilities[$stock->parent_id]))
                                                        {{ $facilities[$stock->parent_id] }}
                                                    @endif
                                                </td>
                                                <td>{{ $stock['stocks_aisle'] }}</td>
                                                <td>{{ $stock['stocks_row'] }}</td>
                                                <td>{{ $stock['stocks_bin'] }}</td>
                                                <td>{{ $stock->stocks_qty_on_hand }}</td>
                                                <td>{{ $stock->stocks_min_qty }}</td>
                                                <td>{{ $stock->stocks_max_qty }}</td>
                                            </tr>
                                        @empty
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><span class="text-info"><strong>No Logs
                                                        Found!</strong></span></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade ShowAssetsModal" id="ShowAssetsModal" tabindex="-1" role="dialog"
                    aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <!-- Modal body -->
                            <div class="modal-body">
                                <h6 class="modal-title">Assets</h6>
                                <a data-bs-toggle="modal" data-bs-target="#CreateAssetModal"
                                    class="btn btn-primary float-end mt-2 mb-2" style="cursor:pointer"> <i
                                        class="fa-solid fa-plus me-1"></i>Add new
                                </a>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                        class="fa-solid fa-xmark"></i></button>
                                <table class="display table table-striped" id="" width ="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Code</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allfacilities as $facility)
                                            <tr class="bom-row" data-type="facility" data-id="{{ $facility->id }}"
                                                style="cursor: pointer">
                                                {{-- <td>Facility</td> --}}
                                                <td>{{ $facility->name }}</td>
                                                <td>{{ $facility->code }}</td>
                                                <td>{{ $facility->status == '1' ? 'Active' : 'Inactive' }}</td>
                                                <td>
                                                    @if (
                                                        $facility->assetAddress &&
                                                            $facility->assetAddress->parent_id &&
                                                            ($parentFacility = $allfacilities->where('id', $facility->assetAddress->parent_id)->first()))
                                                        {{ $parentFacility->name }}
                                                    @endif
                                                </td>
                                                <td style="color: brown">
                                                    {{ 'Facility' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        @foreach ($allequipments as $equipment)
                                            <tr class="bom-row" data-type="equipment" data-id="{{ $equipment->id }}"
                                                style="cursor: pointer">
                                                <td>{{ $equipment->name }}</td>
                                                <td>{{ $equipment->code }}</td>
                                                <td>{{ $equipment->status == '1' ? 'Active' : 'Inactive' }}</td>
                                                <td>
                                                    @if (
                                                        $equipment->assetAddress &&
                                                            $equipment->assetAddress->parent_id &&
                                                            ($parentFacility = $allfacilities->where('id', $equipment->assetAddress->parent_id)->first()))
                                                        {{ $parentFacility->name }}
                                                    @endif
                                                </td>
                                                <td style="color: orange">
                                                    {{ 'Equipment' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        @foreach ($alltools as $tool)
                                            <tr class="bom-row" data-type="tools" data-id="{{ $tool->id }}"
                                                style="cursor: pointer">
                                                <td>{{ $tool->name }}</td>
                                                <td>{{ $tool->code }}</td>
                                                <td>{{ $tool->status == '1' ? 'Active' : 'Inactive' }}</td>
                                                <td>
                                                    @if (
                                                        $tool->assetAddress &&
                                                            $tool->assetAddress->parent_id &&
                                                            ($parentFacility = $allfacilities->where('id', $tool->assetAddress->parent_id)->first()))
                                                        {{ $parentFacility->name }}
                                                    @endif
                                                </td>
                                                <td style="color: rgb(84, 9, 9)">
                                                    {{ 'Tools' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade UploadStocksModal" id="UploadStocksModal" tabindex="-1" role="dialog"
                    aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <!-- Modal body -->
                            <div class="modal-body">
                                <h6 class="modal-title">Stock</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                        class="fa-solid fa-xmark"></i></button>
                                <div class="" id="ajaxStockModal"></div>
                                {{-- <form id="supplyUpdateForm">
                                    @csrf --}}
                                <div class="whitebox mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="stocks_parent_facility"
                                                class="col-form-label text-md-end text-start">Location</label>
                                            <select
                                                class="form-control @error('stocks_parent_facility') is-invalid @enderror"
                                                aria-label="stocks_parent_facility" id="stocks_parent_facility"
                                                name="stocks_parent_facility">
                                                <option value="">--None--</option>
                                                @forelse ($facilities as $id => $facility)
                                                    <option value="{{ $id }}"
                                                        {{ old('stocks_parent_facility') == $id ? 'selected' : '' }}>
                                                        {{ $facility }}
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if ($errors->has('stocks_parent_facility'))
                                                <span id="stocks_parent_facility-error"
                                                    class="text-danger">{{ $errors->first('stocks_parent_facility') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="initial_price"
                                                class="col-form-label text-md-end text-start">Initial price
                                            </label>
                                            <input type="text"
                                                class="form-control @error('initial_price') is-invalid @enderror"
                                                id="initial_price" name="initial_price" placeholder="0.00"
                                                value="{{ old('initial_price') }}">
                                        </div>

                                        <div class="col-md-4">
                                            <label for="stocks_aisle" class="col-form-label text-md-end text-start">Aisle
                                            </label>
                                            <input type="text"
                                                class="form-control @error('stocks_aisle') is-invalid @enderror"
                                                id="stocks_aisle" name="stocks_aisle"
                                                value="{{ old('stocks_aisle') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="stocks_row" class="col-form-label text-md-end text-start">Row
                                            </label>
                                            <input type="text"
                                                class="form-control @error('stocks_row') is-invalid @enderror"
                                                id="stocks_row" name="stocks_row" value="{{ old('stocks_row') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="stocks_bin" class="col-form-label text-md-end text-start">Bin
                                            </label>
                                            <input type="text"
                                                class="form-control @error('stocks_bin') is-invalid @enderror"
                                                id="stocks_bin" name="stocks_bin" value="{{ old('stocks_bin') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="stocks_qty_on_hand"
                                                class="col-form-label text-md-end text-start">Qty
                                                on hand
                                            </label>
                                            <input type="text"
                                                class="form-control @error('stocks_qty_on_hand') is-invalid @enderror"
                                                id="stocks_qty_on_hand" name="stocks_qty_on_hand"
                                                value="{{ old('stocks_qty_on_hand') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="stocks_min_qty"
                                                class="col-form-label text-md-end text-start">Min
                                                qty
                                            </label>
                                            <input type="text"
                                                class="form-control @error('stocks_min_qty') is-invalid @enderror"
                                                id="stocks_min_qty" name="stocks_min_qty"
                                                value="{{ old('stocks_min_qty') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="stocks_max_qty"
                                                class="col-form-label text-md-end text-start">Max
                                                qty
                                            </label>
                                            <input type="text"
                                                class="form-control @error('stocks_max_qty') is-invalid @enderror"
                                                id="stocks_max_qty" name="stocks_max_qty"
                                                value="{{ old('stocks_max_qty') }}">
                                        </div>
                                    </div>
                                </div>
                                {{-- <input type="button" onclick="$('#supplyUpdateForm').submit()"
                                    class="btn btn-primary mt-3 float-end" value="Save"> --}}
                                <input type="button" id="saveStocksBtn" class="btn btn-primary mt-3 float-end"
                                    value="Save">
                                {{-- </form> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="UploadInventoryModal" tabindex="-1" role="dialog" aria-hidden="true"
                    data-bs-keyboard="false" data-bs-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <!-- Modal body -->
                            <div class="modal-body">
                                <h6 class="modal-title">Asset Purchase Information</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                        class="fa-solid fa-xmark"></i></button>
                                <div class="" id="ajaxInventorymsg"></div>
                                <div class="whitebox mb-4">
                                    <div class="row">
                                        <div class="col-md-6 item_name">
                                            <label for="inventory_purchased_from"
                                                class="col-form-label text-md-end text-start">Purchased
                                                From</label>
                                            <select
                                                class="form-control @error('inventory_purchased_from') is-invalid @enderror"
                                                aria-label="inventory_purchased_from" id="inventory_purchased_from"
                                                name="inventory_purchased_from">
                                                <option value="">--Select Business--</option>
                                                @forelse ($businesses as $id => $business)
                                                    <option value="{{ $id }}"
                                                        {{ old('inventory_purchased_from') == $id ? 'selected' : '' }}>
                                                        {{ $business }}
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if ($errors->has('inventory_purchased_from'))
                                                <span
                                                    class="text-danger">{{ $errors->first('inventory_purchased_from') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6 item_name">
                                            <label for="inventory_purchase_currency"
                                                class="col-form-label text-md-end text-start">Purchase
                                                Currency</label>
                                            <select
                                                class="form-control @error('inventory_purchase_currency') is-invalid @enderror"
                                                aria-label="inventory_purchase_currency"
                                                id="inventory_purchase_currency" name="inventory_purchase_currency">
                                                <option value="">--None--</option>
                                                @forelse ($currencies as $id => $currenci)
                                                    <option value="{{ $id }}"
                                                        {{ old('inventory_purchase_currency') == $id ? 'selected' : '' }}>
                                                        {{ $currenci }}
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if ($errors->has('inventory_purchase_currency'))
                                                <span
                                                    class="text-danger">{{ $errors->first('inventory_purchase_currency') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="inventory_date_ordered"
                                                class="col-form-label text-md-end text-start">Date
                                                Ordered
                                            </label>
                                            <input type="date"
                                                class="form-control @error('inventory_date_ordered') is-invalid @enderror"
                                                id="inventory_date_ordered" name="inventory_date_ordered"
                                                value="{{ old('inventory_date_ordered') }}"
                                                min="{{ date('Y-m-d') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inventory_date_received"
                                                class="col-form-label text-md-end text-start">Date
                                                Received
                                            </label>
                                            <input type="date"
                                                class="form-control @error('inventory_date_received') is-invalid @enderror"
                                                id="inventory_date_received" name="inventory_date_received"
                                                value="{{ old('inventory_date_received') }}"
                                                min="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">

                                            <label for="inventory_received_to_msg"
                                                class="col-form-label text-md-end text-start">Received
                                                To
                                            </label>
                                            <div class="input-group">
                                                <input type="hidden" class="form-control"
                                                    name="inventory_received_to" id="inventory_received_to"
                                                    value="">
                                                <input type="text" id="inventory_received_to_msg"
                                                    class="form-control @error('inventory_received_to') is-invalid @enderror"
                                                    value="" readonly>
                                                <a data-bs-toggle="modal" data-bs-target="#ShowtocksModal"
                                                    class="btn btn-primary float-end" style="cursor:pointer"> <i
                                                        class="fa-solid fa-plus me-1"></i>
                                                </a>
                                                @if ($errors->has('inventory_received_to'))
                                                    <span id="inventory_received_to-error"
                                                        class="text-danger">{{ $errors->first('inventory_received_to') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inventory_quantity_received"
                                                class="col-form-label text-md-end text-start">Quantity
                                                Received
                                            </label>
                                            <input type="text"
                                                class="form-control @error('inventory_quantity_received') is-invalid @enderror"
                                                id="inventory_quantity_received" name="inventory_quantity_received"
                                                value="{{ old('inventory_quantity_received') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="inventory_purchase_price_per_unit"
                                                class="col-form-label text-md-end text-start">Purchase Price Per Unit
                                            </label>
                                            <input type="text"
                                                class="form-control @error('inventory_purchase_price_per_unit') is-invalid @enderror"
                                                id="inventory_purchase_price_per_unit"
                                                name="inventory_purchase_price_per_unit"
                                                value="{{ old('inventory_purchase_price_per_unit') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inventory_purchase_price_total"
                                                class="col-form-label text-md-end text-start">Purchase Price
                                                Total
                                            </label>
                                            <input type="text"
                                                class="form-control @error('inventory_purchase_price_total') is-invalid @enderror"
                                                id="inventory_purchase_price_total"
                                                name="inventory_purchase_price_total"
                                                value="{{ old('inventory_purchase_price_total') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="inventory_date_of_expiry"
                                                class="col-form-label text-md-end text-start">Date
                                                of Expiry
                                            </label>
                                            <input type="date"
                                                class="form-control @error('inventory_date_of_expiry') is-invalid @enderror"
                                                id="inventory_date_of_expiry" name="inventory_date_of_expiry"
                                                value="{{ old('inventory_date_of_expiry') }}"
                                                min="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                                <input type="button" id="saveInventoryBtn" class="btn btn-primary mt-3 float-end"
                                    value="Save">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade UploadWarrantyModal" id="UploadWarrantyModal" tabindex="-1" role="dialog"
                    aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <!-- Modal body -->
                            <div class="modal-body">
                                <h6 class="modal-title">Warranty Certificate</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                        class="fa-solid fa-xmark"></i></button>
                                <div class="" id="ajaxWarrantymsg"></div>
                                <div class="item_name">
                                    <div class="whitebox mb-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="warranty_type"
                                                    class="col-form-label text-md-end text-start">Warranty Type
                                                </label>
                                                <select class="form-control @error('warranty_type') is-invalid @enderror"
                                                    aria-label="Warranty Type" id="warranty_type"
                                                    name="warranty_type">
                                                    <option value="">--Select--</option>
                                                    <option value="Basic">
                                                        Basic</option>
                                                    <option value="Extended">
                                                        Extended</option>
                                                </select>
                                                @if ($errors->has('warranty_type'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('warranty_type') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label for="provider"
                                                    class="col-form-label text-md-end text-start">Provider</label>
                                                <select class="form-control @error('provider') is-invalid @enderror"
                                                    aria-label="provider" id="provider" name="provider">
                                                    <option value="">--Select Business--</option>
                                                    @forelse ($businesses as $id => $business)
                                                        <option value="{{ $id }}">
                                                            {{ $business }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('provider'))
                                                    <span class="text-danger">{{ $errors->first('provider') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="warranty_usage_term_type1"
                                                    class="col-form-label text-md-end text-start">Warranty Usage Term Type
                                                </label>
                                                <select
                                                    class="form-control @error('warranty_usage_term_type') is-invalid @enderror"
                                                    aria-label="warranty_usage_term_type" id="warranty_usage_term_type1"
                                                    name="warranty_usage_term_type">
                                                    <option value="">--Select--</option>
                                                    <option value="Date">
                                                        Date</option>
                                                    <option value="Meter">
                                                        Meter reading</option>
                                                    <option value="Production">
                                                        Production time</option>
                                                </select>
                                                @if ($errors->has('warranty_usage_term_type'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('warranty_usage_term_type') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label for="expiry_date"
                                                    class="col-form-label text-md-end text-start">Expiry
                                                    Date</label>
                                                <input type="date"
                                                    class="form-control @error('expiry_date') is-invalid @enderror"
                                                    id="expiry_date" name="expiry_date" value="">
                                                @if ($errors->has('expiry_date'))
                                                    <span class="text-danger">{{ $errors->first('expiry_date') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row" id="meter_reading_fields1">
                                            <div class="col-md-6">
                                                <label for="meter_reading"
                                                    class="col-form-label text-md-end text-start">Meter
                                                    Reading Value Limit
                                                </label>
                                                <input type="text" id="meter_reading" name="meter_reading"
                                                    class="form-control @error('meter_reading') is-invalid @enderror"
                                                    placeholder="0.00" value="">
                                                @if ($errors->has('meter_reading'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('meter_reading') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label for="meter_read_units"
                                                    class="col-form-label text-md-end text-start">Meter
                                                    Reading Units
                                                </label>
                                                <select
                                                    class="form-control @error('meter_read_units') is-invalid @enderror"
                                                    aria-label="Meter read units" id="meter_read_units"
                                                    name="meter_read_units">
                                                    <option value="">--Select--</option>
                                                    @foreach ($MeterReadUnits as $meterReadUnit)
                                                        <option value="{{ $meterReadUnit['id'] }}">
                                                            {{ $meterReadUnit['name'] }}
                                                            ({{ $meterReadUnit['symbol'] }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('meter_read_units'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('meter_read_units') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="certificate_number"
                                                    class="col-form-label text-md-end text-start">Certificate Number
                                                </label>
                                                <input type="text"
                                                    class="form-control @error('certificate_number') is-invalid @enderror"
                                                    id="certificate_number" name="certificate_number" value="">
                                                @if ($errors->has('certificate_number'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('certificate_number') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label for="warranty_description"
                                                    class="col-form-label text-md-end text-start">Description</label>
                                                <textarea class="form-control @error('warranty_description') is-invalid @enderror" name="warranty_description"
                                                    id="warranty_description" cols="48" rows="3"></textarea>
                                                @if ($errors->has('warranty_description'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('warranty_description') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="button" id="saveWarrantyBtn" class="btn btn-primary mt-3 float-end"
                                    value="Save">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade UploadUserModal" id="UploadUserModal" tabindex="-1" role="dialog"
                    aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <!-- Modal body -->
                            <div class="modal-body">
                                <h6 class="modal-title">Personnel</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                        class="fa-solid fa-xmark"></i></button>
                                <div class="" id="ajaxUsermsg"></div>
                                <div class="whitebox mb-4">
                                    <div class="row">
                                        @if ($errors->has('personnel'))
                                            <span id="personnel"
                                                class="text-danger">{{ $errors->first('personnel') }}</span>
                                        @endif
                                        <span id="personnel-error" class="text-warning"></span>
                                        <div class="col-md-6">
                                            <label for="personnel" class="col-form-label text-md-end text-start">User
                                            </label>
                                            <select class="form-control @error('personnel') is-invalid @enderror"
                                                aria-label="personnel" id="personnel" name="personnel">
                                                <option value="">Select</option>
                                                @forelse ($users as $id => $user)
                                                    <option value="{{ $id }}"
                                                        {{ old('personnel') == $id ? 'selected' : '' }}>
                                                        {{ $user }}
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="button" id="saveUserBtn" class="btn btn-primary mt-3 float-end"
                                    value="Save">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade UploadSupBomModal" id="UploadSupBomModal" tabindex="-1" role="dialog"
                    aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <!-- Modal body -->
                            <div class="modal-body">
                                <h6 class="modal-title">Part Supply Assets</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                        class="fa-solid fa-xmark"></i></button>
                                <div class="" id="ajaxbommsg"></div>
                                <div class="whitebox mb-4">
                                    <div class="mb-2">
                                        <label class="">Asset
                                        </label>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="hidden" class="form-control" name="asset" id="asset"
                                            value="">
                                        <input type="hidden" class="form-control" name="asset_type" id="asset_type"
                                            value="">
                                        <input type="text" id="asset_msg"
                                            class="form-control @error('asset') is-invalid @enderror" value=""
                                            readonly>
                                        @if ($errors->has('asset'))
                                            <span class="text-danger">{{ $errors->first('asset') }}</span>
                                        @endif
                                        <label for="asset_new" class="col-form-label text-md-end text-start">
                                        </label>
                                        <a data-bs-toggle="modal" id="asset_new" data-bs-target="#ShowAssetsModal"
                                            class="btn btn-primary float-end" style="cursor:pointer"> <i
                                                class="fa-solid fa-plus me-1"></i>
                                        </a>
                                    </div>
                                    <div class="mb-2">
                                        <label for="quantity" class="col-form-label text-md-end text-start">Qty</label>
                                        <input type="number" id="quantity" name="quantity" class="form-control"
                                            value="{{ old('quantity') }}">
                                        @if ($errors->has('quantity'))
                                            <span class="text-danger">{{ $errors->first('quantity') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <input type="button" id="savesupBomBtn" class="btn btn-primary mt-3 float-end"
                                    value="Save">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade CreateAssetModal" id="CreateAssetModal" data-bs-keyboard="false"
                    data-bs-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <h6 class="modal-title">Create New Asset</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"><i
                                        class="fa-solid fa-xmark"></i></button>
                                <div class="row align-items-center justify-content-center">
                                    @canany(['read-facility', 'create-facility', 'edit-facility', 'delete-facility'])
                                        <div class="col-md-6">
                                            <a href="{{ route('facilities.create') }}" class="border-purple"
                                                target="_blank">
                                                <div class="d-flex">
                                                    <span class="me-2"><img
                                                            src="{{ asset('public/img/location_icon.png') }}"
                                                            alt="img" class="img-fluid"></span>
                                                    <span class="mt-2">Locations or Facilities</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endcanany
                                    @canany(['read-equipment', 'create-equipment', 'edit-equipment', 'delete-equipment'])
                                        <div class="col-md-6">

                                            <a href="{{ route('equipments.create') }}" class="border-purple"
                                                target="_blank">
                                                <div class="d-flex">
                                                    <span class="me-2"><img
                                                            src="{{ asset('public/img/machine_icon.png') }}"
                                                            alt="img" class="img-fluid"></span>
                                                    <span class="mt-2">Equipment or Machines</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endcanany
                                    @canany(['read-tools', 'create-tools', 'edit-tools', 'delete-tools'])
                                        <div class="col-md-6">
                                            <a href="{{ route('tools.create') }}" class="border-purple" target="_blank">
                                                <div class="d-flex">
                                                    <span class="me-2"><img
                                                            src="{{ asset('public/img/tool_icon.png') }}" alt="img"
                                                            class="img-fluid"></span>
                                                    <span class="mt-4">Tools</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endcanany
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- modals fields above --}}
            </div>
        </form>
    </div>



    @push('javascript')
        <script>
            function getRandomInt(min, max) {
                return Math.floor(Math.random() * (max - min + 1)) + min;
            }
            $(document).ready(function() {
                var i = 1;
                var newName = 'New Parts And Supplies #';
                var newCode = 'S' + getRandomInt(1000, 9999);
                if ($('#name').val() == '') {
                    $('#name').val(newName + newCode);
                }
                if ($('#code').val() == '') {
                    $('#code').val(newCode);
                }
                i = i++;
            });
        </script>
        <script>
            $('#inventory_purchase_currency').select2({
                dropdownParent: $('#UploadInventoryModal .modal-content')
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#saveStocksBtn').click(function(e) {
                    e.preventDefault();
                    var formData = $('#supplyUpdateForm').serialize();
                    $.ajax({
                        url: '{{ route('save.stocks') }}',
                        method: 'PUT',
                        data: formData,
                        success: function(response) {
                            // Display success message
                            $('#stocks_parent_facility').removeClass('is-invalid');
                            $('#stocks_parent_facility-error').html('');
                            $('#ajaxStockModal').html('<div class="alert alert-success">' + response
                                .message + '</div>');
                            setTimeout(function() {
                                $('#UploadStocksModal').modal('hide');
                                // Reload the page after 2 seconds
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            }, 500);
                        },
                        error: function(xhr, status, error) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                $('#' + field).addClass('is-invalid');
                                $('#ajaxStockModal').html(
                                    '<div class="alert alert-danger">' +
                                    messages[0] + '</div>'
                                );
                            });
                            // $('#ajaxStockModal').html(
                            //     '<div class="alert alert-danger"> Location is required</div>');
                        }
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                // Add click event listener to each row
                $('.stock-row').click(function() {
                    // Extract the data-id attribute value
                    var stockId = $(this).data('id');
                    $('#ShowtocksModal').modal('hide');
                    // Populate the input field with the extracted value
                    $('#inventory_received_to').val(stockId);
                    $.ajax({
                        url: '{{ route('getSupplyName') }}',
                        type: 'GET',
                        data: {
                            stockId: stockId
                        },
                        success: function(response) {
                            $('#inventory_received_to_msg').val(response.supplyName);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                // Add click event listener to each row
                $('.bom-row').click(function() {
                    // Extract the data-id attribute value
                    var bomId = $(this).data('id');
                    var bomType = $(this).data('type');
                    $('#ShowAssetsModal').modal('hide');
                    // Populate the input field with the extracted value
                    $('#asset').val(bomId);
                    $('#asset_type').val(bomType);
                    $.ajax({
                        url: '{{ route('getAssetName') }}',
                        type: 'GET',
                        data: {
                            bomId: bomId,
                            bomType: bomType
                        },
                        success: function(response) {
                            $('#asset_msg').val(response.assetName);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#savesupBomBtn').click(function(e) {
                    e.preventDefault();
                    var formData = $('#supplyUpdateForm').serialize();
                    $.ajax({
                        url: '{{ route('save.suppliesbom') }}',
                        method: 'PUT',
                        data: formData,
                        success: function(response) {
                            // Display success message
                            $('#asset_msg').removeClass('is-invalid');
                            $('#asset-error').html('');
                            $('#ajaxbommsg').html('<div class="alert alert-success">' +
                                response
                                .message + '</div>');
                            setTimeout(function() {
                                $('#UploadSupBomModal').modal('hide');
                                // Reload the page after 2 seconds
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                $('#asset_msg').addClass('is-invalid');
                                $('#' + field + '-error').html(
                                    '<span class="invalid-feedback">' + messages[0] +
                                    '</span>');
                                $('#ajaxbommsg').html(
                                    '<div class="alert alert-danger"> ' + messages[0] +
                                    ' </div>');
                            });
                        }
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                // Function to calculate and update the total purchase price
                function updateTotalPrice() {
                    var inventory_quantity_received = parseFloat($('#inventory_quantity_received').val());
                    var inventory_purchase_price_per_unit = parseFloat($('#inventory_purchase_price_per_unit').val());
                    var totalPrice = isNaN(inventory_quantity_received) || isNaN(inventory_purchase_price_per_unit) ?
                        0 : (inventory_quantity_received * inventory_purchase_price_per_unit);
                    $('#inventory_purchase_price_total').val(totalPrice.toFixed(
                        2)); // Assuming you want to display the total with 2 decimal places
                }

                // Event listener for the change event on quantity received field
                $('input[id^="inventory_quantity_received"]').on('input', function() {
                    updateTotalPrice();
                });

                // Event listener for the change event on purchase price per unit field
                $('input[id^="inventory_purchase_price_per_unit"]').on('input', function() {
                    updateTotalPrice();
                });

                // Function to validate and set min date for "Date Received" field
                function validateDateReceive() {
                    var dateOrdered = new Date($('#inventory_date_ordered').val());
                    var dateReceivedInput = $('#inventory_date_received');
                    var dateReceived = new Date(dateReceivedInput.val());

                    // Validate that "Date Received" is after "Date Ordered"
                    if (dateReceived < dateOrdered) {
                        dateReceivedInput.val(''); // Clear the value if it's before "Date Ordered"
                        alert('Date Received must be after Date Ordered.');
                    }
                }

                // Event listener for the change event on "Date Ordered" field
                $('input[id^="inventory_date_ordered"]').on('change', function() {
                    validateDateReceive();
                });

                // Event listener for the change event on "Date Received" field
                $('input[id^="inventory_date_received"]').on('change', function() {
                    validateDateReceive();
                });
                $('#saveInventoryBtn').click(function(e) {
                    e.preventDefault();
                    var formData = $('#supplyUpdateForm').serialize();
                    $.ajax({
                        url: '{{ route('save.inventories') }}',
                        method: 'PUT',
                        data: formData,
                        success: function(response) {
                            // Display success message
                            $('#inventory_received_to_msg').removeClass('is-invalid');
                            $('#inventory_received_to-error').html('');
                            $('#ajaxInventorymsg').html('<div class="alert alert-success">' +
                                response
                                .message + '</div>');
                            setTimeout(function() {
                                $('#UploadInventoryModal').modal('hide');
                                // Reload the page after 2 seconds
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                $('#inventory_received_to_msg').addClass('is-invalid');
                                $('#' + field + '-error').html(
                                    '<span class="invalid-feedback">' + messages[0] +
                                    '</span>');
                            });
                            $('#ajaxInventorymsg').html(
                                '<div class="alert alert-danger"> Location is required </div>');
                        }
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#saveWarrantyBtn').click(function(e) {
                    e.preventDefault();
                    var formData = $('#supplyUpdateForm').serialize();
                    $.ajax({
                        url: '{{ route('save.warranties') }}',
                        method: 'PUT',
                        data: formData,
                        success: function(response) {
                            // Display success message
                            $('#ajaxWarrantymsg').html('<div class="alert alert-success">' +
                                response
                                .message + '</div>');
                            setTimeout(function() {
                                $('#UploadWarrantyModal').modal('hide');
                                // Reload the page after 2 seconds
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, messages) {});
                        }
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#saveUserBtn').click(function(e) {
                    e.preventDefault();
                    var formData = $('#supplyUpdateForm').serialize();
                    $.ajax({
                        url: '{{ route('save.users') }}',
                        method: 'PUT',
                        data: formData,
                        success: function(response) {
                            // Display success message
                            $('#personnel-error').html('');
                            $('#personnel').removeClass('is-invalid');
                            $('#ajaxUsermsg').html('<div class="alert alert-success">' +
                                response
                                .message + '</div>');
                            setTimeout(function() {
                                $('#UploadUserModal').modal('hide');
                                // Reload the page after 2 seconds
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            }, 1000);
                        },
                        error: function(xhr) {
                            $('#personnel-error').html('');
                            $('#personnel').addClass('is-invalid');
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $('#personnel-error').append(
                                    '<div class="alert alert-danger">' + value + '</div'
                                );
                            });
                        },
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#warranty_usage_term_type1').change(function() {
                    var selectedOption = $(this).val();
                    if (selectedOption === 'Date' || selectedOption === '') {
                        $('#meter_reading_fields1').hide();
                    } else {
                        $('#meter_reading_fields1').show();
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#warranty_usage_term_type2').change(function() {
                    var selectedOption = $(this).val();
                    if (selectedOption === 'Date' || selectedOption === '') {
                        $('#meter_reading_fields2').hide();
                    } else {
                        $('#meter_reading_fields2').show();
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('.save-docs-btn').click(function() {
                    var logId = $(this).data('log-id');
                    var docsName = $('#cert_name_' + logId).val();
                    var docsDescription = $('#cert_description_' + logId).val();

                    var url = "{{ route('save.supplydocs') }}";
                    var data = {
                        log_id: logId,
                        docsName: docsName,
                        docsDescription: docsDescription,
                        _token: '{{ csrf_token() }}'
                    };

                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: data,
                        success: function(response) {
                            // Handle success response
                            console.log(response);
                            if (response.hasOwnProperty('success')) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    customClass: {
                                        title: 'SwalToastBoxtitle',
                                        icon: 'SwalToastBoxIcon',
                                        popup: 'SwalToastBoxhtml'
                                    },
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });
                                Toast.fire({
                                    icon: "success",
                                    title: response.success
                                });
                            }
                            // Close modal if needed
                            $('#UploadFileModal_' + logId).modal('hide');
                            setTimeout(function() {
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }, 1000);
                        },
                        error: function(xhr) {
                            // Handle error response
                            var errors = xhr.responseJSON.errors;
                            if (errors) {
                                var errorMessage = xhr.responseJSON.message || 'An error occurred';
                                var errorList = '';
                                for (var key in errors) {
                                    if (errors.hasOwnProperty(key)) {
                                        errorList += errors[key].join('<br>') + '<br>';
                                    }
                                }
                                const Toast1 = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    customClass: {
                                        title: 'SwalToastBoxtitle', // Add your custom class here
                                        icon: 'SwalToastBoxIcon', // Add your custom class here
                                        popup: 'SwalToastBoxhtml' // Add your custom class here
                                    },
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });
                                Toast1.fire({
                                    icon: "error",
                                    title: errorMessage,
                                    html: errorList
                                });
                            }
                        }
                    });

                });
            });
        </script>
        <script>
            function delete_savedocs(url, targetId) {
                if (confirm("Are you sure to Permanently Delete?")) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',

                        success: function(response) {
                            swal("Success", response.success, "success");
                            setTimeout(function() {
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            swal("Error!", error, "error");
                        }
                    });
                }
            }
        </script>

        <script>
            $(document).ready(function() {
                $('.save-warranty-btn').click(function() {
                    var logId = $(this).data('log-id');
                    var warranty_type = $('#warranty_type_' + logId).val();
                    var provider = $('#provider_' + logId).val();
                    var warranty_usage_term_type = $('#warranty_usage_term_type2_' + logId).val();
                    var expiry_date = $('#expiry_date_' + logId).val();
                    var meter_reading = $('#meter_reading_' + logId).val();
                    var meter_read_units = $('#meter_read_units_' + logId).val();
                    var certificate_number = $('#certificate_number_' + logId).val();
                    var warranty_description = $('#warranty_description_' + logId).val();

                    var url = "{{ route('save.supplywarranties') }}";
                    var data = {
                        log_id: logId,
                        warranty_type: warranty_type,
                        provider: provider,
                        warranty_usage_term_type: warranty_usage_term_type,
                        expiry_date: expiry_date,
                        meter_reading: meter_reading,
                        meter_read_units: meter_read_units,
                        certificate_number: certificate_number,
                        warranty_description: warranty_description,
                        _token: '{{ csrf_token() }}'
                    };

                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: data,
                        success: function(response) {
                            // Handle success response
                            console.log(response);
                            if (response.hasOwnProperty('success')) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    customClass: {
                                        title: 'SwalToastBoxtitle',
                                        icon: 'SwalToastBoxIcon',
                                        popup: 'SwalToastBoxhtml'
                                    },
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });
                                Toast.fire({
                                    icon: "success",
                                    title: response.success
                                });
                            }
                            // Close modal if needed
                            $('#EditwarrantyModal_' + logId).modal('hide');
                            setTimeout(function() {
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }, 1000);
                        },
                        error: function(xhr) {
                            // Handle error response
                            var errors = xhr.responseJSON.errors;
                            if (errors) {
                                var errorMessage = xhr.responseJSON.message || 'An error occurred';
                                var errorList = '';
                                for (var key in errors) {
                                    if (errors.hasOwnProperty(key)) {
                                        errorList += errors[key].join('<br>') + '<br>';
                                    }
                                }
                                const Toast1 = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    customClass: {
                                        title: 'SwalToastBoxtitle', // Add your custom class here
                                        icon: 'SwalToastBoxIcon', // Add your custom class here
                                        popup: 'SwalToastBoxhtml' // Add your custom class here
                                    },
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });
                                Toast1.fire({
                                    icon: "error",
                                    title: errorMessage,
                                    html: errorList
                                });
                            }
                        }
                    });

                });
            });
        </script>
        <script>
            function delete_supplywarranties(url, targetId) {
                if (confirm("Are you sure to Permanently Delete?")) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',

                        success: function(response) {
                            swal("Success", response.success, "success");
                            setTimeout(function() {
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            swal("Error!", error, "error");
                        }
                    });
                }
            }
        </script>
        <script>
            $(document).ready(function() {
                // Add click event listener to each row
                $('.bom-row-modal').click(function() {
                    // Extract the data-id attribute value
                    var bomId = $(this).data('id');
                    var bomType = $(this).data('type');
                    var parttableid = $(this).data('parttableid');

                    $('#ShowAssetsModal_' + parttableid).modal('hide');
                    // Populate the input field with the extracted value
                    $('#asset_' + parttableid).val(bomId);
                    $('#asset_type_' + parttableid).val(bomType);
                    $.ajax({
                        url: '{{ route('getAssetName') }}',
                        type: 'GET',
                        data: {
                            bomId: bomId,
                            bomType: bomType
                        },
                        success: function(response) {
                            $('#asset_msg_' + parttableid).val(response.assetName);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                // Add click event listener to each row
                $('.inventories-row-modal').click(function() {
                    // Extract the data-id attribute value
                    var stockId = $(this).data('id');
                    var tableid = $(this).data('tableid');

                    $('#ShowtocksModal_' + tableid).modal('hide');
                    // Populate the input field with the extracted value
                    $('#inventory_received_to_' + tableid).val(stockId);

                    $.ajax({
                        url: '{{ route('getSupplyName') }}',
                        type: 'GET',
                        data: {
                            stockId: stockId,
                        },
                        success: function(response) {
                            $('#inventory_received_to_msg_' + tableid).val(response.supplyName);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('.save-parts-btn').click(function() {
                    var logId = $(this).data('log-id');
                    var asset = $('#asset_' + logId).val();
                    var asset_type = $('#asset_type_' + logId).val();
                    var quantity = $('#quantity_' + logId).val();

                    var url = "{{ route('save.supplyparts') }}";
                    var data = {
                        log_id: logId,
                        asset: asset,
                        asset_type: asset_type,
                        quantity: quantity,
                        _token: '{{ csrf_token() }}'
                    };

                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: data,
                        success: function(response) {
                            // Handle success response
                            console.log(response);
                            if (response.hasOwnProperty('success')) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    customClass: {
                                        title: 'SwalToastBoxtitle',
                                        icon: 'SwalToastBoxIcon',
                                        popup: 'SwalToastBoxhtml'
                                    },
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });
                                Toast.fire({
                                    icon: "success",
                                    title: response.success
                                });
                            }
                            // Close modal if needed
                            $('#EditBOMModal_' + logId).modal('hide');
                            setTimeout(function() {
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }, 1000);
                        },
                        error: function(xhr) {
                            // Handle error response
                            var errors = xhr.responseJSON.errors;
                            if (errors) {
                                var errorMessage = xhr.responseJSON.message || 'An error occurred';
                                var errorList = '';
                                for (var key in errors) {
                                    if (errors.hasOwnProperty(key)) {
                                        errorList += errors[key].join('<br>') + '<br>';
                                    }
                                }
                                const Toast1 = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    customClass: {
                                        title: 'SwalToastBoxtitle', // Add your custom class here
                                        icon: 'SwalToastBoxIcon', // Add your custom class here
                                        popup: 'SwalToastBoxhtml' // Add your custom class here
                                    },
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });
                                Toast1.fire({
                                    icon: "error",
                                    title: errorMessage,
                                    html: errorList
                                });
                            }
                        }
                    });

                });
            });
        </script>
        <script>
            function delete_supplyparts(url, targetId) {
                if (confirm("Are you sure to Permanently Delete?")) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        success: function(response) {
                            swal("Success", response.success, "success");
                            setTimeout(function() {
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            swal("Error!", error, "error");
                        }
                    });
                }
            }
        </script>
        <script>
            $(document).ready(function() {

                $('.save-stocks-btn').click(function() {
                    var logId = $(this).data('log-id');
                    var ParentFaciliy = $('#stocks_parent_facility_' + logId).val();
                    var initial_price = $('#initial_price_' + logId).val();
                    var stocks_aisle = $('#stocks_aisle_' + logId).val();
                    var stocks_row = $('#stocks_row_' + logId).val();
                    var stocks_bin = $('#stocks_bin_' + logId).val();
                    var stocks_qty_on_hand = $('#stocks_qty_on_hand_' + logId).val();
                    var stocks_min_qty = $('#stocks_min_qty_' + logId).val();
                    var stocks_max_qty = $('#stocks_max_qty_' + logId).val();
                    var assetID = $('#AssetID').val();

                    var url = "{{ route('save.supplystocks') }}";
                    var data = {
                        log_id: logId,
                        assetID: assetID,
                        ParentFaciliy: ParentFaciliy,
                        initial_price: initial_price,
                        stocks_aisle: stocks_aisle,
                        stocks_row: stocks_row,
                        stocks_bin: stocks_bin,
                        stocks_qty_on_hand: stocks_qty_on_hand,
                        stocks_min_qty: stocks_min_qty,
                        stocks_max_qty: stocks_max_qty,
                        _token: '{{ csrf_token() }}'
                    };

                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: data,
                        success: function(response) {
                            // Handle success response
                            console.log(response);
                            if (response.hasOwnProperty('success')) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    customClass: {
                                        title: 'SwalToastBoxtitle',
                                        icon: 'SwalToastBoxIcon',
                                        popup: 'SwalToastBoxhtml'
                                    },
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });
                                Toast.fire({
                                    icon: "success",
                                    title: response.success
                                });
                            }
                            // Close modal if needed
                            $('#UpdateStocksModal_' + logId).modal('hide');
                            setTimeout(function() {
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }, 1000);
                        },
                        error: function(xhr) {
                            // Handle error response
                            var errors = xhr.responseJSON.errors;
                            if (errors) {
                                var errorMessage = xhr.responseJSON.message || 'An error occurred';
                                var errorList = '';
                                for (var key in errors) {
                                    if (errors.hasOwnProperty(key)) {
                                        errorList += errors[key].join('<br>') + '<br>';
                                    }
                                }
                                const Toast1 = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    customClass: {
                                        title: 'SwalToastBoxtitle', // Add your custom class here
                                        icon: 'SwalToastBoxIcon', // Add your custom class here
                                        popup: 'SwalToastBoxhtml' // Add your custom class here
                                    },
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });
                                Toast1.fire({
                                    icon: "error",
                                    title: errorMessage,
                                    html: errorList
                                });
                            }
                        }
                    });

                });
            });
        </script>
        <script>
            function delete_stockdetails(url, targetId) {
                if (confirm("Are you sure to Permanently Delete?")) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        success: function(response) {
                            swal("Success", response.success, "success");
                            setTimeout(function() {
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            swal("Error!", error, "error");
                        }
                    });
                }
            }
        </script>
        <script>
            $(document).ready(function() {
                // Function to calculate and update the total purchase price
                function updateTotalPrice(logId) {
                    var inventory_quantity_received = parseFloat($('#inventory_quantity_received_' + logId).val());
                    var inventory_purchase_price_per_unit = parseFloat($('#inventory_purchase_price_per_unit_' + logId)
                        .val());
                    var totalPrice = isNaN(inventory_quantity_received) || isNaN(inventory_purchase_price_per_unit) ?
                        0 : (inventory_quantity_received * inventory_purchase_price_per_unit);
                    $('#inventory_purchase_price_total_' + logId).val(totalPrice.toFixed(
                        2)); // Assuming you want to display the total with 2 decimal places
                }

                // Event listener for the change event on quantity received field
                $('input[id^="inventory_quantity_received_"]').on('input', function() {
                    var logId = $(this).attr('id').split('_').pop();
                    updateTotalPrice(logId);
                });

                // Event listener for the change event on purchase price per unit field
                $('input[id^="inventory_purchase_price_per_unit_"]').on('input', function() {
                    var logId = $(this).attr('id').split('_').pop();
                    updateTotalPrice(logId);
                });
                // Function to validate and set min date for "Date Received" field
                function validateDateReceived(logId) {
                    var dateOrdered = new Date($('#inventory_date_ordered_' + logId).val());
                    var dateReceivedInput = $('#inventory_date_received_' + logId);
                    var dateReceived = new Date(dateReceivedInput.val());

                    // Validate that "Date Received" is after "Date Ordered"
                    if (dateReceived < dateOrdered) {
                        dateReceivedInput.val(''); // Clear the value if it's before "Date Ordered"
                        alert('Date Received must be after Date Ordered.');
                    }
                }

                // Event listener for the change event on "Date Ordered" field
                $('input[id^="inventory_date_ordered_"]').on('change', function() {
                    var logId = $(this).attr('id').split('_').pop();
                    validateDateReceived(logId);
                });

                // Event listener for the change event on "Date Received" field
                $('input[id^="inventory_date_received_"]').on('change', function() {
                    var logId = $(this).attr('id').split('_').pop();
                    validateDateReceived(logId);
                });
                $('.save-inventories-btn').click(function() {
                    var logId = $(this).data('log-id');
                    var assetID = $('#AssetID').val();
                    var inventory_purchased_from = $('#inventory_purchased_from_' + logId).val();
                    var inventory_purchase_currency = $('#inventory_purchase_currency_' + logId).val();
                    var inventory_date_ordered = $('#inventory_date_ordered_' + logId).val();
                    var inventory_date_received = $('#inventory_date_received_' + logId).val();
                    var inventory_received_to = $('#inventory_received_to_' + logId).val();
                    var inventory_quantity_received = $('#inventory_quantity_received_' + logId).val();
                    var inventory_purchase_price_per_unit = $('#inventory_purchase_price_per_unit_' + logId)
                        .val();
                    var inventory_purchase_price_total = $('#inventory_purchase_price_total_' + logId).val();
                    var inventory_date_of_expiry = $('#inventory_date_of_expiry_' + logId).val();

                    var url = "{{ route('save.supplyinventories') }}";
                    var data = {
                        log_id: logId,
                        assetID: assetID,
                        inventory_purchased_from: inventory_purchased_from,
                        inventory_purchase_currency: inventory_purchase_currency,
                        inventory_date_ordered: inventory_date_ordered,
                        inventory_date_received: inventory_date_received,
                        inventory_received_to: inventory_received_to,
                        inventory_quantity_received: inventory_quantity_received,
                        inventory_purchase_price_per_unit: inventory_purchase_price_per_unit,
                        inventory_purchase_price_total: inventory_purchase_price_total,
                        inventory_date_of_expiry: inventory_date_of_expiry,
                        _token: '{{ csrf_token() }}'
                    };

                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: data,
                        success: function(response) {
                            // Handle success response
                            console.log(response);
                            if (response.hasOwnProperty('success')) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    customClass: {
                                        title: 'SwalToastBoxtitle',
                                        icon: 'SwalToastBoxIcon',
                                        popup: 'SwalToastBoxhtml'
                                    },
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });
                                Toast.fire({
                                    icon: "success",
                                    title: response.success
                                });
                            }
                            // Close modal if needed
                            $('#UpdateInventoryModal_' + logId).modal('hide');
                            setTimeout(function() {
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }, 1000);
                        },
                        error: function(xhr) {
                            // Handle error response
                            var errors = xhr.responseJSON.errors;
                            if (errors) {
                                var errorMessage = xhr.responseJSON.message || 'An error occurred';
                                var errorList = '';
                                for (var key in errors) {
                                    if (errors.hasOwnProperty(key)) {
                                        errorList += errors[key].join('<br>') + '<br>';
                                    }
                                }
                                const Toast1 = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    customClass: {
                                        title: 'SwalToastBoxtitle', // Add your custom class here
                                        icon: 'SwalToastBoxIcon', // Add your custom class here
                                        popup: 'SwalToastBoxhtml' // Add your custom class here
                                    },
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });
                                Toast1.fire({
                                    icon: "error",
                                    title: errorMessage,
                                    html: errorList
                                });
                            }
                        }
                    });

                });
            });
        </script>
        <script>
            function delete_inventoriesdetails(url, targetId) {
                if (confirm("Are you sure to Permanently Delete?")) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        success: function(response) {
                            swal("Success", response.success, "success");
                            setTimeout(function() {
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            swal("Error!", error, "error");
                        }
                    });
                }
            }
        </script>
    @endpush
@endsection
