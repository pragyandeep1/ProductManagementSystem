@extends('layouts.app')

@section('content')
    @php
        $current_date_time = \Carbon\Carbon::now();
    @endphp
    <!-- Begin Page Content -->
    <div class="page-content container">
        <form action="{{ route('supplies.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="wrapper">
                <div class="status_bar">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="page-header">
                                <h3>Add New Supply</h3>
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
                                                <option value="1">Active</option>
                                                <option value="0">Disable</option>
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
                <div class="nav_tab_area">
                    <ul class="nav nav-tabs mb-3" id="myTabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" aria-current="page" href="#userBasic">Basic</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#userStock">Stock</a>
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
                            <div class="page-header">
                                <h3>Basic Details</h3>
                            </div>
                            <div class="whitebox mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name" class="col-form-label text-md-end text-start">Supply
                                            name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') }}" autocomplete="off">
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label for="code" class="col-form-label text-md-end text-start">Code</label>
                                        <input type="text" class="form-control @error('code') is-invalid @enderror"
                                            id="code" name="code" value="{{ old('code') }}">
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
                                                    {{ old('category_id') == $id ? 'selected' : '' }}>
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
                                            cols="48" rows="6">{{ old('description') }}</textarea>
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
                                        <div class="page-header">
                                            <h3>General Details</h3>
                                        </div>
                                        <div class="whitebox mb-4">
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
                                                            <option value="{{ $account['id'] }}">
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
                                                            <option value="{{ $department['id'] }}">
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
                                                        value="{{ old('unspc_code') }}">
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
                                                        id="barcode" name="barcode" value="{{ old('barcode') }}">
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
                                                        id="make" name="make" value="{{ old('make') }}">
                                                    @if ($errors->has('make'))
                                                        <span class="text-danger">{{ $errors->first('make') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="model"
                                                        class="col-form-label text-md-end text-start">Model</label>
                                                    <input type="text"
                                                        class="form-control @error('model') is-invalid @enderror"
                                                        id="model" name="model" value="{{ old('model') }}">
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
                                                        value="{{ old('last_price') }}">
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
                                                        value="{{ old('total_stock') }}" readonly>
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
                                                        rows="6">{{ old('notes') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="stockStocks">
                                        <div class="page-header">
                                            <h3>Stocks Details</h3>
                                            {{-- <a data-bs-toggle="modal" data-bs-target="#UploadStocksModal"
                                                    class="btn btn-primary float-end mt-4" style="cursor:pointer"> <i
                                                        class="fa-solid fa-plus me-1"></i>Add new
                                                </a> --}}
                                        </div>
                                        <div class="whitebox mb-4">
                                            <div class="row">
                                                <div class="page-header mt-4">
                                                    <h3>Stock Levels Per Location</h3>
                                                    <hr>
                                                </div>
                                                <table class="display" id="PositionList" width ="100%">
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
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><span class="text-info"><strong>No Logs
                                                                        Found!</strong></span></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="stockInventory">
                                        <div class="page-header">
                                            <h3>Inventory Details</h3>
                                            {{-- <a data-bs-toggle="modal" data-bs-target="#UploadInventoryModal"
                                                    class="btn btn-primary float-end mt-4" style="cursor:pointer"> <i
                                                        class="fa-solid fa-plus me-1"></i>Add new
                                                </a> --}}
                                        </div>
                                        <div class="whitebox mb-4">
                                            <div class="row">
                                                <div class="page-header mt-4">
                                                    <h3>Receipt Line Item</h3>
                                                    <hr>
                                                </div>
                                                <table class="display" id="PositionList" width ="100%">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">S#</th>
                                                            <th scope="col">Qty</th>
                                                            <th scope="col">Purchased from</th>
                                                            <th scope="col">Received to</th>
                                                            <th scope="col">Date Received</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td><span class="text-info"><strong>No Logs
                                                                        Found!</strong></span></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="tab-pane fade" id="userPersonnel">
                                <div class="page-header">
                                    <h3>Personnel</h3>
                                </div>
                                <div class="item_name">
                                    <div class="whitebox mb-4">
                                        <div class="row">
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
                                                @if ($errors->has('personnel'))
                                                    <span class="text-danger">{{ $errors->first('personnel') }}</span>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        <div class="tab-pane fade" id="userWarranties">
                            <div class="page-header">
                                <h3>Warranty Certificate</h3>
                            </div>
                            <div class="item_name">
                                <div class="whitebox mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="warranty_type"
                                                class="col-form-label text-md-end text-start">Warranty Type
                                            </label>
                                            <select class="form-control @error('warranty_type') is-invalid @enderror"
                                                aria-label="Warranty Type" id="warranty_type" name="warranty_type">
                                                <option value="">--Select--</option>
                                                <option value="Basic">Basic</option>
                                                <option value="Extended">Extended</option>
                                            </select>
                                            @if ($errors->has('warranty_type'))
                                                <span class="text-danger">{{ $errors->first('warranty_type') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="provider"
                                                class="col-form-label text-md-end text-start">Provider</label>
                                            <select class="form-control @error('provider') is-invalid @enderror"
                                                aria-label="provider" id="provider" name="provider">
                                                <option value="">--Select Business--</option>
                                                @forelse ($businesses as $id => $business)
                                                    <option value="{{ $id }}"
                                                        {{ old('provider') == $id ? 'selected' : '' }}>
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
                                            <label for="warranty_usage_term_type"
                                                class="col-form-label text-md-end text-start">Warranty Usage Term Type
                                            </label>
                                            <select
                                                class="form-control @error('warranty_usage_term_type') is-invalid @enderror"
                                                aria-label="warranty_usage_term_type" id="warranty_usage_term_type"
                                                name="warranty_usage_term_type">
                                                <option value="">--Select--</option>
                                                <option value="Date">Date</option>
                                                <option value="Meter">Meter reading</option>
                                                <option value="Production">Production time</option>
                                            </select>
                                            @if ($errors->has('warranty_usage_term_type'))
                                                <span
                                                    class="text-danger">{{ $errors->first('warranty_usage_term_type') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="expiry_date" class="col-form-label text-md-end text-start">Expiry
                                                Date</label>
                                            <input type="date"
                                                class="form-control @error('expiry_date') is-invalid @enderror"
                                                id="expiry_date" name="expiry_date">
                                            @if ($errors->has('expiry_date'))
                                                <span class="text-danger">{{ $errors->first('expiry_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row" id="meter_reading_fields">
                                        <div class="col-md-6">
                                            <label for="meter_reading" class="col-form-label text-md-end text-start">Meter
                                                Reading Value Limit
                                            </label>
                                            <input type="text" id="meter_reading" name="meter_reading"
                                                class="form-control @error('meter_reading') is-invalid @enderror"
                                                placeholder="0.00">
                                            @if ($errors->has('meter_reading'))
                                                <span class="text-danger">{{ $errors->first('meter_reading') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="meter_read_units"
                                                class="col-form-label text-md-end text-start">Meter
                                                Reading Units
                                            </label>
                                            <select class="form-control @error('meter_read_units') is-invalid @enderror"
                                                aria-label="Meter read units" id="meter_read_units"
                                                name="meter_read_units">
                                                <option value="">--Select--</option>
                                                @foreach ($MeterReadUnits as $meterReadUnit)
                                                    <option value="{{ $meterReadUnit['id'] }}">
                                                        {{ $meterReadUnit['name'] }} ({{ $meterReadUnit['symbol'] }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('meter_read_units'))
                                                <span class="text-danger">{{ $errors->first('meter_read_units') }}</span>
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
                                                id="certificate_number" name="certificate_number"
                                                value="{{ old('certificate_number') }}">
                                            @if ($errors->has('certificate_number'))
                                                <span
                                                    class="text-danger">{{ $errors->first('certificate_number') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="warranty_description"
                                                class="col-form-label text-md-end text-start">Description</label>
                                            <textarea class="form-control @error('warranty_description') is-invalid @enderror" name="warranty_description"
                                                id="warranty_description" cols="48" rows="6">{{ old('warranty_description') }}</textarea>
                                            @if ($errors->has('warranty_description'))
                                                <span
                                                    class="text-danger">{{ $errors->first('warranty_description') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="userFiles">
                            <div class="page-header">
                                <h3>Documents</h3>
                            </div>
                            <div class="item_name">
                                <div class="whitebox mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="file"
                                                class="form-control @error('files') is-invalid @enderror" id="files"
                                                name="files[]" multiple>
                                            @if ($errors->has('files'))
                                                <span class="text-danger">{{ $errors->first('files') }}</span>
                                            @endif
                                            <span class="text-muted">*Supported file type: doc, docx,
                                                xlsx, xls, ppt, pptx, txt, pdf, jpg, jpeg, png, webp, gif</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- modals fields below --}}
                <div class="modal fade" id="UploadStocksModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Stock</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="" id="ajaxmsgModal"></div>
                                <div class="whitebox mb-4">
                                    <div class="col-md-6 item_name">
                                        <label for="stocks_parent_facility"
                                            class="col-form-label text-md-end text-start">Select
                                            Parent
                                            facility</label>
                                        <select class="form-control @error('stocks_parent_facility') is-invalid @enderror"
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
                                            <span
                                                class="text-danger">{{ $errors->first('stocks_parent_facility') }}</span>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="stocks_aisle" class="col-form-label text-md-end text-start">Aisle
                                            </label>
                                            <input type="text"
                                                class="form-control @error('stocks_aisle') is-invalid @enderror"
                                                id="stocks_aisle" name="stocks_aisle" value="{{ old('stocks_aisle') }}">
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
                                            <label for="stocks_min_qty" class="col-form-label text-md-end text-start">Min
                                                qty
                                            </label>
                                            <input type="text"
                                                class="form-control @error('stocks_min_qty') is-invalid @enderror"
                                                id="stocks_min_qty" name="stocks_min_qty"
                                                value="{{ old('stocks_min_qty') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="stocks_max_qty" class="col-form-label text-md-end text-start">Max
                                                qty
                                            </label>
                                            <input type="text"
                                                class="form-control @error('stocks_max_qty') is-invalid @enderror"
                                                id="stocks_max_qty" name="stocks_max_qty"
                                                value="{{ old('stocks_max_qty') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="UploadInventoryModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Asset Purchase Information</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="" id="ajaxmsgModal"></div>
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
                                                aria-label="inventory_purchase_currency" id="inventory_purchase_currency"
                                                name="inventory_purchase_currency">
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
                                            <input type="datetime-local"
                                                class="form-control @error('inventory_date_ordered') is-invalid @enderror"
                                                id="inventory_date_ordered" name="inventory_date_ordered"
                                                value="{{ old('inventory_date_ordered') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inventory_date_received"
                                                class="col-form-label text-md-end text-start">Date
                                                Received
                                            </label>
                                            <input type="datetime-local"
                                                class="form-control @error('inventory_date_received') is-invalid @enderror"
                                                id="inventory_date_received" name="inventory_date_received"
                                                value="{{ old('inventory_date_received') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="inventory_received_to"
                                                class="col-form-label text-md-end text-start">Received
                                                To
                                            </label>
                                            <select
                                                class="form-control @error('inventory_received_to') is-invalid @enderror"
                                                aria-label="inventory_received_to" id="inventory_received_to"
                                                name="inventory_received_to">
                                                <option value="">--Select Stock--</option>
                                                @forelse ($facilities as $id => $facility)
                                                    <option value="{{ $id }}"
                                                        {{ old('inventory_received_to') == $id ? 'selected' : '' }}>
                                                        {{ $facility }}
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
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
                                                id="inventory_purchase_price_total" name="inventory_purchase_price_total"
                                                value="{{ old('inventory_purchase_price_total') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="inventory_date_of_expiry"
                                                class="col-form-label text-md-end text-start">Date
                                                of Expiry
                                            </label>
                                            <input type="datetime-local"
                                                class="form-control @error('inventory_date_of_expiry') is-invalid @enderror"
                                                id="inventory_date_of_expiry" name="inventory_date_of_expiry"
                                                value="{{ old('inventory_date_of_expiry') }}">
                                        </div>
                                    </div>
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
                $('#warranty_usage_term_type').change(function() {
                    var selectedOption = $(this).val();
                    if (selectedOption === 'Date') {
                        $('#meter_reading_fields').hide();
                    } else {
                        $('#meter_reading_fields').show();
                    }
                });
            });
        </script>
    @endpush
@endsection
