@extends('layouts.app')

@section('content')
    @php
        $current_date_time = \Carbon\Carbon::now();
        $assetAddress = '';
        $assetGeneralInfo = '';
        if (isset($tool->assetAddress) && $tool->assetAddress != 'null') {
            $assetAddress = $tool->assetAddress;
        }
        if (isset($tool->assetAddress['address']) && $assetAddress['address'] != 'null') {
            $address = json_decode($assetAddress['address'], true);
        }
        if (isset($tool->assetGeneralInfo) && $tool->assetGeneralInfo != 'null') {
            $assetGeneralInfo = $tool->assetGeneralInfo;
        }
        if (isset($tool->assetPartSuppliesLog) && $tool->assetPartSuppliesLog != 'null') {
            $assetPartSuppliesLog = $tool->assetPartSuppliesLog;
        }
        if (isset($tool->meterReadings) && $tool->meterReadings != 'null') {
            $meterReadings = $tool->meterReadings;
        }
        if (isset($tool->assetFiles) && $tool->assetFiles != 'null') {
            $assetFiles = $tool->assetFiles;
        }
        if (isset($tool->children) && $tool->children != 'null') {
            $children = $tool->children;
        }
    @endphp
    <!-- Begin Page Content -->
    <div class="page-content container">
        <form action="{{ route('tools.update', $tool->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="wrapper">
                <div class="status_bar">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="page-header">
                                <h3> Edit Tool @if (!empty($tool->id))
                                        <span class="text-info"> <a href="javascript:void(0);"
                                                class="btn btn-info btn-sm">{{ $tool->name }}
                                                ({{ $tool->code }})</a><span>
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
                                                <option value="1" {{ $tool->status == 1 ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="0" {{ $tool->status == 0 ? 'selected' : '' }}>
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
                                            <a href="{{ route('tools.index') }}" class="btn btn-primary float-end">
                                                <i class="fa-solid fa-list me-1"></i>All Tools
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
                            <a class="nav-link" data-bs-toggle="tab" href="#userGeneral">General</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#userContact">Parts/BOM</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#userCareer">Metering/Events</a>
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
                                        <label for="name" class="col-form-label text-md-end text-start">Tool
                                            name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ $tool->name }}">
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label for="code" class="col-form-label text-md-end text-start">Code</label>
                                        <input type="text" class="form-control @error('code') is-invalid @enderror"
                                            id="code" name="code" value="{{ $tool->code }}">
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
                                                    {{ $tool->category_id == $id ? 'selected' : '' }}>
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
                                            cols="48" rows="6">{!! $tool->description !!}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="text-danger">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="userGeneral">
                            <div class="item_name">
                                
                                <div class="whitebox mb-4">
								<div class="page-header mb-2">
                                    <h3>Location</h3>
                                </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="aisle"
                                                class="col-form-label text-md-end text-start">Aisle</label>
                                            <input type="text" class="form-control @error('aisle') is-invalid @enderror"
                                                id="aisle" name="aisle"
                                                value="{{ $assetAddress['aisle'] ?? '' }}">
                                            @if ($errors->has('aisle'))
                                                <span class="text-danger">{{ $errors->first('aisle') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <label for="row"
                                                class="col-form-label text-md-end text-start">Row</label>
                                            <input type="text" class="form-control @error('row') is-invalid @enderror"
                                                id="row" name="row" value="{{ $assetAddress['row'] ?? '' }}">
                                            @if ($errors->has('row'))
                                                <span class="text-danger">{{ $errors->first('row') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <label for="bin"
                                                class="col-form-label text-md-end text-start">Bin</label>
                                            <input type="text" class="form-control @error('bin') is-invalid @enderror"
                                                id="bin" name="bin" value="{{ $assetAddress['bin'] ?? '' }}">
                                            @if ($errors->has('bin'))
                                                <span class="text-danger">{{ $errors->first('bin') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mt-2 mb-2">
                                            <input type="radio" class="@error('old_faci_chkbox') is-invalid @enderror"
                                                id="old_faci_chkbox" name="faci_chkbox" value="1"
                                                {{ isset($facirelation[0]['facility_id']) ? 'checked' : '' }} onclick="toggleDropdown()">
                                            <label for="old_faci_chkbox"
                                                class="col-form-label text-md-end text-start">This tool is located
                                                at:</label>
                                        </div>
                                        <div class="col-md-8 mt-2 mb-2">
                                            <input type="radio" class="@error('new_faci_chkbox') is-invalid @enderror"
                                                id="new_faci_chkbox" name="faci_chkbox" value="0"
                                                {{ isset($equiprelation[0]['equipment_id']) ? 'checked' : 
                                                '' }} onclick="toggleNewAddr()">
                                            <label for="new_faci_chkbox"
                                                class="col-form-label text-md-end text-start">This tool is part
                                                of:</label>
                                        </div>
                                        <div class="col-md-6 item_name old_faci_addr" id="old_faci_addr"
                                            style="display: none;">
                                            <label for="parent_facility" class="col-form-label text-md-end text-start">Select
                                                parent
                                                facility</label>
                                            <select class="form-control @error('parent_facility') is-invalid @enderror"
                                                aria-label="Parent facility" id="parent_facility" name="parent_facility">
                                                <option value="">--None--</option>
                                                @forelse ($facilities as $id => $faciliti)
                                                    <option value="{{ $id }}" 
                                                        {{ isset($facirelation[0]['facility_id']) && $facirelation[0]['facility_id'] == $id ? 'selected' : '' }}>
                                                        {{ $faciliti }}
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if ($errors->has('parent_facility'))
                                                <span class="text-danger">{{ $errors->first('parent_facility') }}</span>
                                            @endif
                                        </div>

                                        <div class="col-md-6 item_name faci_new_addr" id="faci_new_addr"
                                            style="display: none;">
                                            <label for="parent_equipment"
                                                class="col-form-label text-md-end text-start">Select parent
                                                equipment</label>
                                            <select class="form-control @error('parent_equipment') is-invalid @enderror"
                                                aria-label="Parent facility" id="parent_equipment"
                                                name="parent_equipment">
                                                <option value="">--None--</option>
                                                @forelse ($equipments as $id => $equipmen)
                                                    @if ($tool->id != $id)
                                                        <option value="{{ $id }}"
                                                            {{ isset($equiprelation[0]['equipment_id']) && $equiprelation[0]['equipment_id'] == $id ? 'selected' : '' }}>
                                                            {{ $equipmen }}
                                                        </option>
                                                    @endif
                                                @empty
                                                @endforelse
                                            </select>
                                            @if ($errors->has('contact.parent_equipment'))
                                                <span
                                                    class="text-danger">{{ $errors->first('contact.parent_equipment') }}</span>
                                            @endif
                                        </div>
                                        <span id="parent_address_warning" class="text-warning" style="display: none;">No
                                            address inherited.</span>
                                        <span id="address_success" class="text-success" style="display: none;"></span>
                                    </div>
                                
                                <div class="page-header mt-3">
                                    <h3>General Information</h3>
                                </div>
                               
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="account" class="col-form-label text-md-end text-start">Account
                                            </label>
                                            <select class="form-control @error('account') is-invalid @enderror"
                                                aria-label="Account" id="account" name="account">
                                                <option value="">--Select--</option>
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account['id'] }}"
                                                        {{ optional($assetGeneralInfo)->accounts_id == $account['id'] ? 'selected' : '' }}>
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
                                            <label for="department" class="col-form-label text-md-end text-start">Charge
                                                Departments
                                            </label>
                                            <select class="form-control @error('department') is-invalid @enderror"
                                                aria-label="Departments" id="department" name="department">
                                                <option value="">--Select--</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department['id'] }}"
                                                        {{ optional($assetGeneralInfo)->charge_department_id == $department['id'] ? 'selected' : '' }}>
                                        ({{ $department['code'] }}) {{ $department['description'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('department'))
                                                <span class="text-danger">{{ $errors->first('department') }}</span>
                                            @endif
                                            @if (!empty($address))
                                                <p>Address: {{ $address['street'] ?? 'N/A' }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="make"
                                                class="col-form-label text-md-end text-start">Make</label>
                                            <input type="text"
                                                class="form-control @error('make') is-invalid @enderror" id="make"
                                                name="make" value="{{ $assetGeneralInfo['make'] }}">
                                            @if ($errors->has('make'))
                                                <span class="text-danger">{{ $errors->first('make') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="model"
                                                class="col-form-label text-md-end text-start">Model</label>
                                            <input type="text"
                                                class="form-control @error('model') is-invalid @enderror" id="model"
                                                name="model" value="{{ $assetGeneralInfo['model'] }}">
                                            @if ($errors->has('model'))
                                                <span class="text-danger">{{ $errors->first('model') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="serial_number"
                                                class="col-form-label text-md-end text-start">Serial Number
                                            </label>
                                            <input type="text"
                                                class="form-control @error('serial_number') is-invalid @enderror"
                                                id="serial_number" name="serial_number"
                                                value="{{ $assetGeneralInfo['serial_number'] }}">
                                            @if ($errors->has('serial_number'))
                                                <span class="text-danger">{{ $errors->first('serial_number') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="barcode"
                                                class="col-form-label text-md-end text-start">Barcode</label>
                                            <input type="text"
                                                class="form-control @error('barcode') is-invalid @enderror"
                                                id="barcode" name="barcode"
                                                value="{{ $assetGeneralInfo['barcode'] }}">
                                            @if ($errors->has('barcode'))
                                                <span class="text-danger">{{ $errors->first('barcode') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="unspc_code" class="col-form-label text-md-end text-start">Unspc
                                                Code</label>
                                            <input type="text"
                                                class="form-control @error('unspc_code') is-invalid @enderror"
                                                id="unspc_code" name="unspc_code"
                                                value="{{ $assetGeneralInfo['unspc_code'] }}">
                                            @if ($errors->has('unspc_code'))
                                                <span class="text-danger">{{ $errors->first('unspc_code') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="notes"
                                                class="col-form-label text-md-end text-start">Notes</label>
                                            <textarea class="form-control @error('notes') is-invalid @enderror" name="notes" id="notes" cols="48"
                                                rows="6">{!! $assetGeneralInfo['notes'] !!}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="tab-pane fade" id="userContact">
                                <div class="page-header">
                                    <h3>Asset Parts Supplies</h3>
                                </div>
                                <div class="item_name">
                                    <div class="whitebox mb-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="supplies"
                                                    class="col-form-label text-md-end text-start">Part/Supply
                                                </label>
                                                <select class="form-control @error('supplies') is-invalid @enderror"
                                                    aria-label="Supplies" id="supplies" name="supplies">
                                                    <option value="">Select</option>
                                                    @forelse ($supplies as $id => $supply)
                                                        <option value="{{ $supply['id'] }}"
                                                            {{ old('supplies') == $supply['id'] ? 'selected' : '' }}>
                                                            {{ $supply['name'] }}
                                                            ({{ $supply['code'] }})
                                                        </option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                                @if ($errors->has('supplies'))
                                                    <span class="text-danger">{{ $errors->first('supplies') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label for="quantity"
                                                    class="col-form-label text-md-end text-start">Qty</label>
                                                <input type="text" id="quantity" name="quantity"
                                                    class="form-control" value="{{ old('quantity') }}">
                                                @if ($errors->has('quantity'))
                                                    <span class="text-danger">{{ $errors->first('quantity') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="page-header mt-4">
                                                <h3>All Parts Supplies</h3>
                                                <hr>
                                            </div>
                                            <table class="display" id="PositionList" width ="100%">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">S#</th>
                                                        <th scope="col">Part</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col">Submitted By User</th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @forelse ($assetPartSuppliesLog as $suppliesLog)
                                                        @php
                                                            if (
                                                                isset($suppliesLog->part_supply_id) &&
                                                                $suppliesLog->part_supply_id != 'NULL'
                                                            ) {
                                                                $supplyLog = \App\Models\Supplies::find(
                                                                    $suppliesLog->part_supply_id,
                                                                );
                                                            } else {
                                                                $supplyLog = '';
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
                                                                    {{ $supplyLog->name ?? '' }}
                                                                    ({{ $supplyLog->code ?? '' }})
                                                                @endif
                                                            </td>
                                                            <td>{{ $suppliesLog->quantity ?? '' }}</td>
                                                            <td>
                                                                @if (isset($suppliesLog->submitted_by) && $suppliesLog->submitted_by != 'NULL')
                                                                    <a href="{{ route('users.show', $suppliesLog->submitted_by) }}"
                                                                        class="">{{ $submitted_by->name ?? '' }}</a>
                                                                @endif
                                                            </td>

                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td></td>
                                                            <td></td>

                                                            <td><span class="text-info"><strong>No Logs
                                                                        Found!</strong></span></td>
                                                            <td></td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        <div class="tab-pane fade" id="userCareer">
                            
                            <div class="item_name">
                                <div class="whitebox mb-4">
								<div class="page-header mb-2">
                                <h3>Meter Reading</h3>
                            </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="meter_reading" class="col-form-label text-md-end text-start">Meter
                                                Reading
                                            </label>
                                            <input type="text" id="meter_reading" name="meter_reading"
                                                class="form-control" placeholder="0.00"
                                                value="{{ old('meter_reading') }}">
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
                                                    <option value="{{ $meterReadUnit['id'] }}"
                                                        {{ old('meter_read_units') == $meterReadUnit['id'] ? 'selected' : '' }}>
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
                                        <div class="page-header mt-4">
                                            <h3>Recent Meter Readings</h3>
                                            <hr>
                                        </div>
                                        <table class="display" id="PositionList" width ="100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col">S#</th>
                                                    <th scope="col">Last Reading</th>
                                                    <th scope="col">Unit</th>
                                                    <th scope="col">Submitted By User</th>
                                                    <th scope="col">Date Submitted</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- @if (count($meterReadings) > 0) --}}
                                                @forelse ($meterReadings as $reading)
                                                    @php
                                                        if ($reading->meter_units_id != '') {
                                                            $meterReadUnit = \App\Models\MeterReadUnits::find(
                                                                $reading->meter_units_id,
                                                            );
                                                        } else {
                                                            $meterReadUnit = '';
                                                        }
                                                        $submitted_by = \App\Models\User::find($reading->submitted_by);
                                                    @endphp
                                                    <tr>
                                                        <th scope="row">{{ $loop->iteration }}</th>
                                                        <td>{{ $reading->reading_value }}</td>
                                                        <td>
                                                            @if ($reading->meter_units_id)
                                                                {{ $meterReadUnit->name ?? '' }}
                                                                ({{ $meterReadUnit->symbol ?? '' }})
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($reading->submitted_by != '')
                                                                <a href="{{ route('users.show', $reading->submitted_by) }}"
                                                                    class="">{{ $submitted_by->name ?? '' }}</a>
                                                            @endif
                                                        </td>
                                                        <td>{{ $reading->updated_at ? \Carbon\Carbon::parse($reading->updated_at)->format('jS F, Y h:i:s A') : '--' }}
                                                        </td>
                                                        <td>
                                                            <a data-bs-toggle="modal"
                                                                data-bs-target="#EditMeterReadModal_{{ $reading->id }}"
                                                                class="link-primary"><i
                                                                    class="fa-regular fa-pen-to-square"></i></a>

                                                            <button type="button" class="link-danger"
                                                                onclick="delete_toolsmeter('{{ route('toolsmeter.delete', $reading->id) }}')"
                                                                data-id="{{ $reading->id }}">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    {{-- modals fields below --}}
                                                    <div class="modal fade EditMeterReadModal"
                                                        id="EditMeterReadModal_{{ $reading->id }}"
                                                        data-bs-keyboard="false" data-bs-backdrop="static">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <!-- Modal body -->
                                                                <div class="modal-body">
                                                                    <h6 class="modal-title">Meter Readings </h6>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"><i
                                                                            class="fa-solid fa-xmark"></i></button>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label for="meter_reading_{{ $reading->id }}"
                                                                                class="col-form-label text-md-end text-start">Meter
                                                                                Reading
                                                                            </label>
                                                                            <input type="text"
                                                                                id="meter_reading_{{ $reading->id }}"
                                                                                name="meter_reading_{{ $reading->id }}"
                                                                                class="form-control reading-input"
                                                                                placeholder="0.00"
                                                                                value="{{ $reading->reading_value }}">
                                                                            <span
                                                                                class="invalid-feedback meter_reading-error"
                                                                                role="alert"></span>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label
                                                                                for="meter_read_units_{{ $reading->id }}"
                                                                                class="col-form-label text-md-end text-start">Meter
                                                                                Reading Units
                                                                            </label>
                                                                            <select class="form-control meterunit-select"
                                                                                id="meter_read_units_{{ $reading->id }}"
                                                                                name="meter_read_units_{{ $reading->id }}"
                                                                                data-log-id="{{ $reading->id }}">
                                                                                <option value="">--Select--
                                                                                </option>
                                                                                @forelse ($MeterReadUnits as $meterReadUnit)
                                                                                    <option
                                                                                        value="{{ $meterReadUnit['id'] }}"
                                                                                        {{ $reading->meter_units_id == $meterReadUnit['id'] ? 'selected' : '' }}>
                                                                                        {{ $meterReadUnit['name'] }}
                                                                                        ({{ $meterReadUnit['symbol'] }})
                                                                                    </option>
                                                                                @empty
                                                                                @endforelse
                                                                            </select>
                                                                            <span class="invalid-feedback meter-error"
                                                                                role="alert"></span>
                                                                        </div>
                                                                    </div>
                                                                    <button type="button"
                                                                        class="btn btn-primary mt-3 float-end save-meter-btn"
                                                                        data-log-id="{{ $reading->id }}">Update</button>
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
                                                        <td><span class="text-info"><strong>No History
                                                                    Found!</strong></span></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
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
                                                    {{-- <th scope="col">Type</th> --}}
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
                                                        {{-- <td>{{ $certificate->type }}</td> --}}
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
                                                                onclick="delete_toolsdocs('{{ route('toolsdocs.delete', $certificate->af_id) }}')"
                                                                data-id="{{ $certificate->af_id }}">
                                                                <i class="fa-solid fa-trash-can"></i>
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
                                                                        {{ $tool->name }}
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
                                                    {{-- <td></td> --}}
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
            </div>
        </form>
    </div>
    @push('javascript')
        <script>
            jQuery(document).ready(function() {
                $('#myTabs a').click(function(e) {
                    e.preventDefault()
                    $(this).tab('show')
                })
            });
        </script>
        <script>
            function getRandomInt(min, max) {
                return Math.floor(Math.random() * (max - min + 1)) + min;
            }
            $(document).ready(function() {
                var i = 1;
                var newName = 'New Facility #';
                var newCode = 'F' + getRandomInt(1000, 9999);
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
            var FetchcountryId = $('#FetchcountryId').val();
            var FetchstateId = $('#FetchstateId').val();
            var FetchcityId = $('#FetchcityId').val();
            $(document).ready(function() {
                $('#country-dd').on('change', function() {
                    var idCountry = this.value;
                    $("#state-dd").html('');
                    $.ajax({
                        url: "{{ url('api/fetch-states') }}",
                        type: "POST",
                        data: {
                            country_id: idCountry,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(result) {
                            $('#state-dd').html('<option value="">--Select State--</option>');
                            $.each(result.states, function(key, value) {
                                $("#state-dd").append('<option value="' + value.id + '" ' +
                                    (value.id == FetchstateId ? 'selected' : '') +
                                    '>' + value.name + '</option>');
                            });
                            $('#city-dd').html('<option value="">--Select City--</option>');
                        }
                    });
                });
                $('#state-dd').on('change', function() {
                    var idState = this.value;
                    $("#city-dd").html('');
                    $.ajax({
                        url: "{{ url('api/fetch-cities') }}",
                        type: "POST",
                        data: {
                            state_id: idState,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(res) {
                            $('#city-dd').html('<option value="">--Select City--</option>');
                            $.each(res.cities, function(key, value) {
                                $("#city-dd").append('<option value="' + value.id + '" ' +
                                    (value.id == FetchcityId ? 'selected' : '') +
                                    '>' + value.name + '</option>');
                            });
                        }
                    });
                });
            });
        </script>
        <script>
            function fetchLocationName(id, type) {
                $.ajax({
                    url: "{{ url('get-location-name') }}/" + id + "/" + type,
                    type: "GET",
                    dataType: 'json',
                    success: function(result) {
                        $(`#${type}-dd`).text(result.name);
                        $(`#${type}-dd`).append(`<option value="${id}">${result.name}</option>`);
                    },
                    error: function(error) {
                        console.error('Error fetching location name:', error);
                    }
                });
            }

            $(document).ready(function() {
                // var FetchcountryId = $('#FetchcountryId').val();
                var FetchstateId = $('#FetchstateId').val();
                var FetchcityId = $('#FetchcityId').val();

                // fetchLocationName(FetchcountryId, 'country');
                fetchLocationName(FetchstateId, 'state');
                fetchLocationName(FetchcityId, 'city');
            });
        </script>
        <script>
            $(document).ready(function() {
                // Trigger click event based on the initial state of the radio input
                if ($('#old_faci_chkbox').prop('checked')) {
                    toggleDropdown();
                } else if ($('#new_faci_chkbox').prop('checked')) {
                    toggleNewAddr();
                }
                // Function to toggle dropdown based on radio input selection
                function toggleDropdown() {
                    $('#old_faci_addr').show();
                    $('#faci_new_addr').hide().val('');
                    $('#parent_equipment').val('');
                }
                // Function to toggle new address based on radio input selection
                function toggleNewAddr() {
                    $('#parent_address_warning, #address_success').hide();
                    $('#old_faci_addr').hide().val('');
                    $('#parent_facility').val('');
                    $('#faci_new_addr').show();
                }
                // Click event handler for radio inputs
                $('#old_faci_chkbox').click(function() {
                    toggleDropdown();
                });

                $('#new_faci_chkbox').click(function() {
                    toggleNewAddr();
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#parent_facility').change(function() {
                    var parentId = $(this).val();
                    var url = "{{ url('get-parent-address') }}" + '/' + parentId;
                    // Send an AJAX request to retrieve the latest address
                    if (parentId != '') {
                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function(response) {
                                // Update the address span with the retrieved address
                                if (response.address) {
                                    $('#parent_address_warning').hide();
                                    // Update the address or whatever element you want to display the address
                                    $('#address_success').show();

                                    var addressString = response.address;
                                    if (response.city) {
                                        addressString += ', ' + response.city;
                                    }
                                    if (response.state) {
                                        addressString += ', ' + response.state;
                                    }
                                    if (response.country) {
                                        addressString += ', ' + response.country;
                                    }
                                    if (response.postcode) {
                                        addressString += ', Postcode: ' + response.postcode;
                                    }
                                    $('#address_success').text(addressString).removeClass(
                                        'text-info').addClass('text-success');
                                } else {
                                    // If no address is found, display a warning
                                    $('#parent_address_warning').show();
                                    // Clear the address element
                                    $('#address_success').hide().text('');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    } else {
                        $('#parent_address_warning').hide();
                        $('#address_success').show();
                        $('#address_success').text('').removeClass('text-success');
                        $('#address_success').text(
                            'No address inherited.'
                        ).addClass('text-info');

                    }
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#parent_equipment').change(function() {
                    var parentId = $(this).val();
                    var url = "{{ url('get-equip_parent-address') }}" + '/' + parentId;
                    // Send an AJAX request to retrieve the latest address
                    if (parentId != '') {
                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function(response) {
                                // Update the address span with the retrieved address
                                if (response.address) {
                                    $('#parent_address_warning').hide();
                                    // Update the address or whatever element you want to display the address
                                    $('#address_success').show();

                                    var addressString = response.address;
                                    if (response.city) {
                                        addressString += ', ' + response.city;
                                    }
                                    if (response.state) {
                                        addressString += ', ' + response.state;
                                    }
                                    if (response.country) {
                                        addressString += ', ' + response.country;
                                    }
                                    if (response.postcode) {
                                        addressString += ', Postcode: ' + response.postcode;
                                    }
                                    $('#address_success').text(addressString).removeClass(
                                        'text-info').addClass('text-success');
                                } else {
                                    // If no address is found, display a warning
                                    $('#parent_address_warning').show();
                                    // Clear the address element
                                    $('#address_success').hide().text('');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    } else {
                        $('#parent_address_warning').hide();
                        $('#address_success').show();
                        $('#address_success').text('').removeClass('text-success');
                        $('#address_success').text(
                            'No address inherited.'
                        ).addClass('text-info');
                    }
                });
            });
        </script>
        {{-- <script>
            // Function to remember last active tab
            function rememberLastTab() {
                // Get the tabs list
                var tabs = document.querySelectorAll('.nav-link');

                // Get the ID of the last active tab from local storage
                var lastTab = localStorage.getItem('lastTab');

                // If there's a last active tab, activate it
                if (lastTab) {
                    tabs.forEach(function(tab) {
                        if (tab.getAttribute('href') === lastTab) {
                            tab.classList.add('active');
                            document.querySelector(lastTab).classList.add('active');
                        } else {
                            tab.classList.remove('active');
                            document.querySelector(tab.getAttribute('href')).classList.remove('active');
                        }
                    });
                }

                // Add click event listeners to update last active tab
                tabs.forEach(function(tab) {
                    tab.addEventListener('click', function() {
                        localStorage.setItem('lastTab', this.getAttribute('href'));
                    });
                });
            }

            // Call the function when the document is loaded
            document.addEventListener('DOMContentLoaded', function() {
                rememberLastTab();
            });
        </script> --}}
        <script>
            $(document).ready(function() {
                $('.save-meter-btn').click(function() {
                    var logId = $(this).data('log-id');
                    var meterunitId = $('#meter_read_units_' + logId).val();
                    var meterreading = $('#meter_reading_' + logId).val();

                    var url = "{{ route('save.toolsmeter') }}";
                    var data = {
                        log_id: logId,
                        meterunit_id: meterunitId,
                        meterreading: meterreading,
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
                            $('#EditMeterReadModal_' + logId).modal('hide');
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
            function delete_toolsmeter(url, targetId) {
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
                $('.save-docs-btn').click(function() {
                    var logId = $(this).data('log-id');
                    var docsName = $('#cert_name_' + logId).val();
                    var docsDescription = $('#cert_description_' + logId).val();
                    var url = "{{ route('save.toolsdocs') }}";
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
            function delete_toolsdocs(url, targetId) {
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
