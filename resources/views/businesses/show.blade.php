@extends('layouts.app')

@section('content')
    @php
        $current_date_time = \Carbon\Carbon::now();
        // $assetAddress = $business->assetAddress;
        $address = json_decode($business->location, true);
        // $assetGeneralInfo = $business->assetGeneralInfo;
        // $assetPartSuppliesLog = $business->assetPartSuppliesLog;
        // $meterReadings = $business->meterReadings;
        $assetFiles = $business->assetFiles;
        // echo '<pre>';
        // print_r($business);
        // echo '</pre>';
        // print_r($assetAddress);
        // echo $address['address'];
        // print_r($business->assetGeneralInfo);
    @endphp
    <!-- Begin Page Content -->
    <div class="page-content container">
        <div class="wrapper">
            <div class="row mb-2 align-items-center mb-3">
                <div class="col-md-9">
                    <div class="page-header">
                        <h3>Business Information @can('edit-business')
                                <a href="{{ route('businesses.edit', $business->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            @endcan
                        </h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('businesses.index') }}" class="btn btn-primary float-end">
                        <i class="fa-solid fa-list me-1"></i>All Businesses
                    </a>
                </div>
            </div>
            <div class="row mb-2 g-2">
                <div class="col-md-6 col-lg-6">
                    <div class="page-header">
                        <h3>Basic Information</h3>
                    </div>
                    <div class="">
                        <div class="whitebox mb-4">
                            <div class="row mb-2">
                                <label class="col-md-4 text-md-end text-start"><strong>Name:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    {{ $business->name ?? '' }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4  text-md-end text-start"><strong>Code:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    {{ $business->code ?? '' }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4 text-md-end text-start"><strong>Category:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    {{-- @forelse ($categories as $id => $category)
                                        {{ $business->category_id == $id ? $category : '' }}
                                    @empty
                                    @endforelse --}}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4  text-md-end text-start"><strong>Description:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    {!! $business->description !!}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4  text-md-end text-start"><strong>Status:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    @if ($business->status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Disabled</span>
                                    @endif
                                </div>
                            </div>
                            {{-- {{ $business->userInfo->contact_details }} --}}
                            {{-- {{ $business->userInfo }} --}}
                            {{-- {{ $business->userInfo->status }} --}}


                            {{-- {{ $business->certifications->name ? '' }} --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="page-header">

                        <h3>Location</h3>
                    </div>
                    <div class="">
                        <div class="whitebox mb-4">
                            <div class="row mb-2">
                                <label class="col-md-4  text-md-end text-start"><strong>Asset Location:</strong></label>
                                {{-- <div class="col-md-6" style="line-height: 24px;">
                                    @forelse ($facilities as $id => $faciliti)
                                        @if ($assetAddress['parent_id'] == $id)
                                            <span class="text-info"> <a href="{{ route('businesses.show', $id) }}"
                                                    class="btn btn-info btn-sm">{{ $faciliti }}</a><span>
                                        @endif
                                    @empty
                                    @endforelse
                                </div> --}}
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4  text-md-end text-start"><strong>Address:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    {{ $address['address'] ?? '' }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4  text-md-end text-start"><strong>City:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    @foreach ($cities as $data)
                                        {{ ($address['city'] ?? '') == $data->id ? $data->name : '' }}
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4  text-md-end text-start"><strong>State
                                        or
                                        province:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    @foreach ($states as $data)
                                        {{ ($address['state'] ?? '') == $data->id ? $data->name : '' }}
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4  text-md-end text-start"><strong>Country:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    @foreach ($countries as $data)
                                        {{ ($address['country'] ?? '') == $data->id ? $data->name : '' }}
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4  text-md-end text-start"><strong>Zip or
                                        postal
                                        code:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    {{ $address['postcode'] ?? '' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="page-header">
                        <h3>General Information</h3>
                    </div>
                    <div class="">
                        <div class="whitebox mb-4">
                            <div class="row mb-2">
                                <label class="col-md-4 text-md-end text-start"><strong>Account:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    {{-- @foreach ($accounts as $account)
                                        {{ $assetGeneralInfo['accounts_id'] == $account['id'] ? '( ' . $account['code'] . ' ) ' . $account['description'] : '' }}
                                    @endforeach --}}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4  text-md-end text-start"><strong>Charge Departments:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    {{-- @foreach ($departments as $department)
                                        {{ $assetGeneralInfo['charge_department_id'] == $department['id'] ? '( ' . $department['code'] . ' ) ' . $department['description'] : '' }}
                                    @endforeach --}}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4 text-md-end text-start"><strong>Barcode:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    {{-- {{ $assetGeneralInfo['barcode'] ?? '' }} --}}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4  text-md-end text-start"><strong>Notes:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    {{-- {!! $assetGeneralInfo['notes'] ?? '' !!} --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="page-header">
                    <h3>Meter Readings</h3>
                </div>
                <div class="">
                    <div class="whitebox mb-4">
                        <table class="display table table-striped nowrap" id="PositionList" width ="100%">
                            <thead>
                                <tr>
                                    <th scope="col">S#</th>
                                    <th scope="col">Last Reading</th>
                                    <th scope="col">Unit</th>
                                    <th scope="col">Submitted By User</th>
                                    <th scope="col">Date Submitted</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><span class="text-info"><strong>No History
                                                Found!</strong></span></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="page-header">
                    <h3>Documents</h3>
                </div>
                <div class="">
                    <div class="whitebox mb-4">
                        <table id="UsersList" class="table table-striped nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">S#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($assetFiles as $certificate)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $certificate->name }}</td>
                                        <td>{{ $certificate->description }}</td>
                                        <td>{{ $certificate->type }}</td>
                                        <td><a href="{{ asset($certificate->url) }}" class="link-success me-2"
                                                target="_blank" title="View"><i class="fa-regular fa-eye"></i></a>
                                            <a data-bs-toggle="modal"
                                                data-bs-target="#UploadFileModal{{ $certificate->af_id }}"
                                                class="link-primary" style="cursor:pointer"><i
                                                    class="fa-regular fa-pen-to-square"></i></a>
                                            <a class="link-danger" id="cert_delete{{ $certificate->af_id }}"
                                                onclick="deleteCert({{ $certificate->af_id }})" style="cursor:pointer">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    {{-- view file modal --}}
                                    <div class="modal fade" id="UploadFileModal{{ $certificate->af_id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">
                                                        {{ $business->name }}
                                                        Documents</h4>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="" id="ajaxmsgModal{{ $certificate->af_id }}">
                                                    </div>
                                                    <div class="whitebox mb-4">
                                                        <div class="col-md-8">
                                                            <label for="cert_name{{ $certificate->af_id }}"
                                                                class="col-form-label text-md-end text-start">Name</label>
                                                            <input type="text" class="form-control  "
                                                                id="cert_name{{ $certificate->af_id }}"
                                                                value="{{ $certificate->name }}">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label for="cert_description{{ $certificate->af_id }}"
                                                                class="col-form-label text-md-end text-start">Description
                                                            </label>
                                                            <textarea class="form-control  " id="cert_description{{ $certificate->af_id }}" rows="2">{{ $certificate->description }}</textarea>
                                                        </div>
                                                    </div>
                                                    <a id="cert_save{{ $certificate->af_id }}"
                                                        class="btn btn-primary mt-3 float-end"
                                                        onclick="FormSubmission({{ $certificate->af_id }})">Save</a>
                                                    {{-- </form> --}}
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
@endsection
