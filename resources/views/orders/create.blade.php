@extends('layouts.app')

@section('content')
    @php
        $current_date_time = \Carbon\Carbon::now()->setTimezone('asia/kolkata');
    @endphp
    <!-- Begin Page Content -->
    <div class="page-content container">
        <form action="{{ route('orders.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="wrapper">
                <div class="status_bar">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="page-header">
                                <h3>Add New Order</h3>
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
                                            <a href="{{ route('orders.index') }}" class="btn btn-primary float-end">
                                                <i class="fa-solid fa-list me-1"></i>All Orders
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
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#userCompletion">Completion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#laborTasks">Labor Tasks</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#parts">Parts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#meterReadings">Meter Readings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#miscCostsPage">Misc Costs Page</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#notifications">Notifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#userFiles">Files</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#worklog">Work Log</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="userBasic">
                            <div class="page-header">
                                <h3>Work Order Administration</h3>
                            </div>
                            <div class="whitebox mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name" class="col-form-label text-md-end text-start">Work Order Status</label>
                                        <select class="form-control" aria-label="work_order_status" id="work_order_id" name="work_order_status">
                                                <option value="">--Select--</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="code" class="col-form-label text-md-end text-start">Asset</label>
                                        <select class="form-control @error('asset_id') is-invalid @enderror"
                                            aria-label="Asset" id="asset_id" name="asset">
                                            <option value="">--Select--</option>
                                            @forelse ($assets as $id => $asset)
                                                <option value="{{ $id }}"
                                                    {{ old('asset_id') == $id ? 'selected' : '' }}>
                                                    {{ $asset }}
                                                </option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @if ($errors->has('code'))
                                            <span class="text-danger">{{ $errors->first('code') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="category_id" class="col-form-label text-md-end text-start">Maintenance Type
                                        </label>
                                        <select class="form-control" aria-label="maintenance_type" id="maintenance_id" name="maintenance_type" data-bs-toggle="modal" data-bs-target="#CreateAssetModal"  style="cursor:pointer">
                                                <option value="">--Select--</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="description"
                                            class="col-form-label text-md-end text-start">Project</label>
                                        <select class="form-control" aria-label="maintenance_type" id="maintenance_id" name="maintenance_type"> -->
                                                <option value="">--Select--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="category_id" class="col-form-label text-md-end text-start">Priority
                                        </label>
                                        <select class="form-control" aria-label="maintenance_type" id="maintenance_id" name="maintenance_type">
                                                <option value="">--Select--</option>
                                                <option value="">Highest</option>
                                                <option value="">High</option>
                                                <option value="">Medium</option>
                                                <option value="">Low</option>
                                                <option value="">Lowest</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="description"
                                            class="col-form-label text-md-end text-start">Suggested Start Date</label>
                                        <input type="date" class="form-control " id="start_date" name="start_date">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="category_id" class="col-form-label text-md-end text-start">Suggested Completion Date
                                        </label>
                                        <input type="date" class="form-control " id="completion_date" name="completion_date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="userGeneral">
                            <div class="item_name">
                                <div class="page-header">
                                    <h3>Location</h3>
                                </div>
                                <div class="whitebox mb-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="summary" class="col-form-label text-md-end text-start">Summary of Issue</label>
                                            <textarea class="form-control" name="summary" id="summary"
                                            cols="48" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="instructions" class="col-form-label text-md-end text-start">Work Instructions</label>
                                            <textarea class="form-control" name="instructions" id="instructions"
                                            cols="48" rows="14"></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="name" class="col-form-label text-md-end text-start">Assigned To User</label>
                                                <select class="form-control" aria-label="assigned_to_user" id="assigned_to_user" name="assigned_to_user">
                                                        <option value="">--Select--</option>
                                                </select>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-10">
                                                    <label for="name" class="col-form-label text-md-end text-start">Estimated Labor</label>
                                                    <input type="text" class="form-control" id="estimated_labor" name="estimated_labor">
                                                </div>
                                                 <div class="col-md-2 mt-4">
                                                     &emsp;&emsp;hours
                                                 </div>
                                            </div>
                                            <div>
                                                <label for="description" class="col-form-label text-md-end text-start">Completed By User</label>
                                                <select class="form-control" aria-label="completed_by_user" id="completed_by_user" name="completed_by_user">
                                                        <option value="">--Select--</option>
                                                </select>
                                            </div>
                                            <div class="d-flex">
                                                <div class="col-md-10">
                                                    <label for="name" class="col-form-label text-md-end text-start">Actual Labor</label>
                                                    <input type="text" class="form-control" id="actual_labor" name="actual_labor">
                                                </div>
                                                 <div class="col-md-2 mt-4">
                                                     &emsp;&emsp;hours
                                                 </div>
                                            </div>
                                            <div>
                                                <label for="date_completed" class="col-form-label text-md-end text-start">Date Completed</label>
                                                <input type="date" class="form-control " id="date_completed" name="date_completed">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="userCompletion">
                            <div class="item_name">
                                <div class="page-header">
                                    <h3>Cost Tracking</h3>
                                </div>
                                <div class="whitebox1 mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name" class="col-form-label text-md-end text-start">Account</label>
                                            <select class="form-control" aria-label="account" id="account" name="account">
                                                    <option value="">--Select--</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="code" class="col-form-label text-md-end text-start">Charge Department</label>
                                            <select class="form-control" aria-label="dept" id="charge_department_id" name="charge_department">
                                                <option value="">--Select--</option>
                                            </select>
                                            @if ($errors->has('code'))
                                                <span class="text-danger">{{ $errors->first('code') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item_name">
                                <div class="page-header">
                                    <h3>Completion Notes</h3>
                                </div>
                                <div class="whitebox1 mb-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="completion_notes" class="col-form-label text-md-end text-start">Completion Notes</label>
                                            <textarea class="form-control" name="completion_notes" id="completion_notes"
                                            cols="48" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="problem" class="col-form-label text-md-end text-start">Problem (briefly outline the problem, if any)</label>
                                            <input type="text" class="form-control" id="problem" name="problem">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="problem" class="col-form-label text-md-end text-start">Root cause (short description of the cause of issue, if any)</label>
                                            <input type="text" class="form-control" id="problem" name="problem">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="problem" class="col-form-label text-md-end text-start">Solution (short description of the solution, if any)</label>
                                            <input type="text" class="form-control" id="problem" name="problem">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item_name">
                                <div class="page-header">
                                    <h3>Admin Notes</h3>
                                </div>
                                <div class="whitebox1 mb-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="completion_notes" class="col-form-label text-md-end text-start">Admin Notes</label>
                                            <textarea class="form-control" name="completion_notes" id="completion_notes"
                                            cols="48" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="laborTasks">
                            <div class="page-header">
                                <h3>Labor Tasks</h3>
                            </div>
                            <ul class="nav nav-tabs" id="myTabs2">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" aria-current="page"
                                        href="#description" id="description">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#assignedTo" id="">Assigned To</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#hrsEstimate" id="hrsEstimate">Hrs Estimate</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" aria-current="page"
                                        href="#hrsSpent" id="hrsSpent">Hrs Spent</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#result" id="result">Result</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#taskNotesCompletion" id="taskNotesCompletion">Task Notes Completion</a>
                                </li>
                            </ul>
                            <div class="whitebox mb-4">
                                <div class="row d-flex">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="text" name="text">
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <p>Enter task description</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="parts">
                            <div class="page-header">
                                <h3>Parts</h3>
                            </div>
                            <div class="item_name">
                                <div class="whitebox mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="parts" class="col-form-label text-md-end text-start">Parts
                                            </label>
                                            <input type="text" id="parts" name="parts"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="meterReadings">
                            <div class="page-header">
                                <h3>Meter Readings</h3>
                            </div>
                            <div class="item_name">
                                <div class="whitebox mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if ($errors->has('meter_reading'))
                                                <span class="text-danger">You cannot enter readings until you select an asset and save your work order.</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="miscCostsPage">
                            <div class="page-header">
                                <h3>Misc Costs Page</h3>
                            </div>
                            <ul class="nav nav-tabs" id="myTabs2">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" aria-current="page"
                                        href="#type" id="type">Type</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" aria-current="page"
                                        href="#description" id="description">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#estQuantity">Est Quantity</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#estUnitCost">Est Unit Cost</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" aria-current="page"
                                        href="#stockGeneral">Est Total Cost</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#quantity" id="quantity">Quantity</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#actualUnitCost" id="actualUnitCost">Actual Unit Cost</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#actualTotalCost" id="actualTotalCost">Actual Total Cost</a>
                                </li>
                            </ul>
                            <div class="item_name">
                                <div class="whitebox mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="miscCostsPage" class="col-form-label text-md-end text-start">
                                            </label>
                                            <input type="text" id="misc_costs_page" name="miscCostsPage"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="notifications">
                            <div class="page-header">
                                <h3>Notifications</h3>
                            </div>
                            <ul class="nav nav-tabs" id="notificationsTabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" aria-current="page" href="#technician" id="technician">Technician</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#notifyOnAssignment" id="notifyOnAssignment">
                                        <i class="fa fa-exclamation" alt="Notify when Work Order is Created and Assigned to Technicians" title="Notify when Work Order is Created and Assigned to Technicians"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#notifyOnStatusChange" id="notifyOnStatusChange">
                                        <i class="fa fa-exchange" alt="Notify if Work Order Status Changes" title="Notify if Work Order Status Changes"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#notifyOnCompletion" id="notifyOnCompletion">
                                        <i class="fa fa-check" alt="Notify when Work Order is Completed" title="Notify when Work Order is Completed"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#notifyOnTaskCompleted" id="notifyOnTaskCompleted">
                                        <i class="fa fa-list" alt="Notify when each Task is Completed" title="Notify when each Task is Completed"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#notifyOnOnlineOffline" id="notifyOnOnlineOffline">
                                        <i class="fa fa-power-off" alt="Notify if Asset is Offline / Online" title="Notify if Asset is Offline / Online"></i>
                                    </a>
                                </li>
                            </ul>
                            <div class="item_name">
                                <div class="whitebox mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="notifications" class="col-form-label text-md-end text-start">
                                            </label>
                                            <input type="text" id="notifications" name="notifications"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="userFiles">
                            <div class="page-header">
                                <h3>Files</h3>
                            </div>
                            <div class="item_name">
                                <div class="whitebox mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="file" class="form-control @error('files') is-invalid @enderror" id="files" name="files[]" multiple>
                                            @if ($errors->has('files'))
                                                <span class="text-danger">{{ $errors->first('files') }}</span>
                                            @endif
                                            <span class="text-muted">*Supported file type: doc, docx, xlsx, xls, ppt, pptx, txt, pdf, jpg, jpeg, png, webp, gif</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="worklog">
                            <div class="page-header">
                                <h3>Work Log</h3>
                            </div>
                            <ul class="nav nav-tabs" id="myTabs2">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" aria-current="page"
                                        href="#user" id="user">User</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#hours_taken" id="hours_taken">Hours Taken</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#inventoryCost" id="inventoryCost">Inventory Cost</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" aria-current="page"
                                    href="#completion_notes" id="completion_notes">Completion Notes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#logDate" id="logDate">Log Date</a>
                                </li>
                            </ul>
                            <div class="whitebox mb-4">
                            </div>
                        </div>
                    </div>
                </div>
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
                var newName = 'New Order #';
                var newCode = 'T' + getRandomInt(1000, 9999);
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
            function toggleDropdown() {
                var oldFaciAddr = document.getElementById('old_faci_addr');
                var newFaciAddr = document.getElementById('faci_new_addr');
                var oldFaciCheckbox = document.getElementById('old_faci_chkbox');
                if (oldFaciCheckbox.checked) {
                    oldFaciAddr.style.display = 'block';
                    newFaciAddr.style.display = 'none';
                }
            }

            function toggleNewAddr() {
                $('#parent_address_warning').hide();
                $('#address_success').hide();
                var oldFaciAddr = document.getElementById('old_faci_addr');
                var newFaciAddr = document.getElementById('faci_new_addr');
                var newFaciCheckbox = document.getElementById('new_faci_chkbox');
                if (newFaciCheckbox.checked) {
                    newFaciAddr.style.display = 'block';
                    oldFaciAddr.style.display = 'none';
                }
            }
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
    @endpush
@endsection
