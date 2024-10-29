@extends('layouts.app')

@section('content')
    @php
        $current_date_time = \Carbon\Carbon::now()->setTimezone('asia/kolkata');
    @endphp
    <!-- Begin Page Content -->
    <div class="page-content container">
        <form action="{{ route('projects.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="wrapper">
                <div class="status_bar">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="page-header">
                                <h3>Project:</h3>
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
                                            <a href="{{ route('projects.index') }}" class="btn btn-primary float-end">
                                                <i class="fa-solid fa-list me-1"></i>All Projects
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
                            <a class="nav-link" data-bs-toggle="tab" href="#scheduledMaintenance">Scheduled Maintenance</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#workOrders">Work Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#technicians">Technicians</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#userFiles">Files</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="userBasic">
                            <div class="whitebox mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name" class="col-form-label text-md-end text-start">Name</label>
                                        <input type="text" class="form-control" id="estimated_labor" name="estimated_labor">
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="category_id" class="col-form-label text-md-end text-start">Description
                                        </label>
                                        <textarea class="form-control" name="summary" id="summary"
                                            cols="48" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="userGeneral">
                            <div class="item_name">
                                <div class="page-header">
                                    <h3>Projected Dates</h3>
                                </div>
                                <div class="whitebox1 mb-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="summary" class="col-form-label text-md-end text-start">Projected Start Date</label>
                                            <input type="date" class="form-control " id="date_completed" name="date_completed">
                                        </div>
                                        <div class="col-md-12">
                                            <label for="summary" class="col-form-label text-md-end text-start">Projected End Date</label>
                                            <input type="date" class="form-control " id="date_completed" name="date_completed">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item_name">
                                <div class="page-header">
                                    <h3>Actual Dates</h3>
                                </div>
                                <div class="whitebox1 mb-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="summary" class="col-form-label text-md-end text-start">Actual Start Date</label>
                                            <input type="date" class="form-control " id="date_completed" name="date_completed">
                                        </div>
                                        <div class="col-md-12">
                                            <label for="summary" class="col-form-label text-md-end text-start">Actual End Date</label>
                                            <input type="date" class="form-control " id="date_completed" name="date_completed">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="scheduledMaintenance">
                            <div class="item_name">
                                <ul class="nav nav-tabs" id="myTabs2">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" aria-current="page"
                                            href="#when" id="when">When</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#code" id="code">Code</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#description" id="description">Description</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#estimated_hrs" id="estimated_hrs">Estimated Hrs</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" aria-current="page"
                                            href="#assigned_user" id="assigned_user">Assigned User</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="workOrders">
                            <div class="item_name"> 
                                <div class="whitebox mb-4">
                                    <ul class="nav nav-tabs" id="myTabs2">
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#code" id="code">Code</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#work_order_status" id="work_order_status">Work Order Status</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#assets" id="assets">Assets</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#description" id="description">Description</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="technicians">
                            <div class="page-header">
                                <h3>Technician</h3>
                            </div>
                            <div class="item_name">
                                <div class="whitebox mb-4">
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
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
