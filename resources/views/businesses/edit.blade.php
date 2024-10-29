@extends('layouts.app')

@section('content')
    @php
        $current_date_time = \Carbon\Carbon::now();
        $assetFiles = $location = $contact = [];
        if (isset($business->assetFiles) && $business->assetFiles != 'null') {
            $assetFiles = $business->assetFiles;
        }
        if (isset($business->business_classification) && $business->business_classification != 'null') {
            $business_classification = json_decode($business->business_classification, true);
        }
        if (isset($business->location) && $business->location != 'null') {
            $location = json_decode($business->location, true);
        }
        if (isset($business->contact) && $business->contact != 'null') {
            $contact = json_decode($business->contact, true);
        }
        if (isset($business->assetUser) && $business->assetUser != 'null') {
            $assetUser = $business->assetUser;
        }
        // echo '<pre>';
        // print_r($business);
        // echo '</pre>';
        // print_r($assetAddress);
        // echo $address['address'];
        // print_r($business->assetGeneralInfo);
    @endphp
    <!-- Begin Page Content -->
    <div class="page-content container">
        <form action="{{ route('businesses.update', $business->id) }}" id="businessUpdateForm" method="post"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="wrapper">
                <input type="hidden" value="{{ $business->id }}" name="business_id">
                <div class="status_bar">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="page-header">
                                <h3> Edit Business @if (!empty($business->id))
                                        <span class="text-info"> <a href="javascript:void(0);"
                                                class="btn btn-info btn-sm">{{ $business->name }}
                                                ({{ $business->code }})</a><span>
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
                                                <option value="1" {{ $business->status == 1 ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="0" {{ $business->status == 0 ? 'selected' : '' }}>
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
                                            <a href="{{ route('businesses.index') }}" class="btn btn-primary float-end">
                                                <i class="fa-solid fa-list me-1"></i>All Businesses
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
                            <a class="nav-link" data-bs-toggle="tab" href="#userLocation">Location</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#userPersonnel">Personnel</a>
                        </li> --}}
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
                                        <label for="name" class="col-form-label text-md-end text-start">Business
                                            name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ $business->name }}">
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label for="code" class="col-form-label text-md-end text-start">Code</label>
                                        <input type="text" class="form-control @error('code') is-invalid @enderror"
                                            id="code" name="code" value="{{ $business->code }}">
                                        @if ($errors->has('code'))
                                            <span class="text-danger">{{ $errors->first('code') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="business_classification"
                                            class="col-form-label text-md-end text-start">Business
                                            Classification
                                        </label>
                                        <select
                                            class="form-control multiple-select @error('business_classification') is-invalid @enderror"
                                            aria-label="business_classification" id="business_classification"
                                            name="business_classification[]" multiple>
                                            @forelse ($businessClassification as $id => $classification)
                                                <option value="{{ $id }}"
                                                    {{ in_array($id, $business_classification ?? []) ? 'selected' : '' }}>
                                                    {{ $classification }}
                                                </option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @if ($errors->has('business_classification'))
                                            <span
                                                class="text-danger">{{ $errors->first('business_classification') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label for="description"
                                            class="col-form-label text-md-end text-start">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                                            cols="48" rows="6">{{ $business->description }}</textarea>
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
                                    <h3>Contact Information</h3>
                                </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="primary" class="col-form-label text-md-end text-start">Primary
                                                Contact </label>
                                            <input type="text"
                                                class="form-control @error('contact.primary') is-invalid @enderror"
                                                id="primary" name="contact[primary]"
                                                value="{{ $contact['primary'] ?? '' }}">
                                            @if ($errors->has('contact.primary'))
                                                <span class="text-danger">{{ $errors->first('contact.primary') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="primary" class="col-form-label text-md-end text-start">Primary
                                                Currency</label>
                                            <select
                                                class="form-control single-select @error('currency') is-invalid @enderror"
                                                aria-label="Currency" id="currency" name="currency">
                                                @forelse ($currencies as $id => $currency)
                                                    <option value="{{ $id }}"
                                                        {{ $business->currency == $id ? 'selected' : '' }}>
                                                        {{ $currency }}
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            @if ($errors->has('currency'))
                                                <span class="text-danger">{{ $errors->first('currency') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="phone"
                                                class="col-form-label text-md-end text-start">Phone</label>
                                            <input type="text"
                                                class="form-control @error('contact.phone') is-invalid @enderror"
                                                id="phone" name="contact[phone]"
                                                value="{{ $contact['phone'] ?? '' }}">
                                            @if ($errors->has('contact.phone'))
                                                <span class="text-danger">{{ $errors->first('contact.phone') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone2" class="col-form-label text-md-end text-start">Phone
                                                2</label>
                                            <input type="text"
                                                class="form-control @error('contact.phone2') is-invalid @enderror"
                                                id="phone2" name="contact[phone2]"
                                                value="{{ $contact['phone2'] ?? '' }}">
                                            @if ($errors->has('contact.phone2'))
                                                <span class="text-danger">{{ $errors->first('contact.phone2') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="fax"
                                                class="col-form-label text-md-end text-start">Fax</label>
                                            <input type="text"
                                                class="form-control @error('contact.fax') is-invalid @enderror"
                                                id="fax" name="contact[fax]" value="{{ $contact['fax'] ?? '' }}">
                                            @if ($errors->has('contact.fax'))
                                                <span class="text-danger">{{ $errors->first('contact.fax') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="website" class="col-form-label text-md-end text-start">Web
                                                Site</label>
                                            <input type="text"
                                                class="form-control @error('contact.website') is-invalid @enderror"
                                                id="website" name="contact[website]"
                                                value="{{ $contact['website'] ?? '' }}">
                                            @if ($errors->has('contact.website'))
                                                <span class="text-danger">{{ $errors->first('contact.website') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="email" class="col-form-label text-md-end text-start">Primary
                                                Email</label>
                                            <input type="email"
                                                class="form-control @error('contact.email') is-invalid @enderror"
                                                id="email" name="contact[email]"
                                                value="{{ $contact['email'] ?? '' }}">
                                            @if ($errors->has('contact.email'))
                                                <span class="text-danger">{{ $errors->first('contact.email') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email2" class="col-form-label text-md-end text-start">Secondary
                                                Email
                                            </label>
                                            <input type="email"
                                                class="form-control @error('contact.email2') is-invalid @enderror"
                                                id="email2" name="contact[email2]"
                                                value="{{ $contact['email2'] ?? '' }}">
                                            @if ($errors->has('contact.email2'))
                                                <span class="text-danger">{{ $errors->first('contact.email2') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="userLocation">
                            
                            <div class="item_name">
                                <div class="whitebox mb-4">
								<div class="page-header mb-2">
                                <h3>Location</h3>
                            </div>
                                    <div class="row item_name">
                                        <div class="col-md-12">
                                            <label for="address"
                                                class="col-form-label text-md-end text-start">Address</label>
                                            <textarea class="form-control @error('location.address') is-invalid @enderror" name="location[address]"
                                                id="address" cols="48" rows="2">{{ $location['address'] ?? '' }}</textarea>
                                            @if ($errors->has('location.address'))
                                                <span class="text-danger">{{ $errors->first('location.address') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="country-dd"
                                                class="col-form-label text-md-end text-start">Country</label>
                                            <select id="country-dd" name="location[country]"
                                                value="{{ old('country') }}"
                                                class="form-control single-select @error('location.country') is-invalid @enderror">
                                                <option value="">--Select Country--</option>
                                                @foreach ($countries as $data)
                                                    <option value="{{ $data->id }}"
                                                        {{ ($location['country'] ?? '') == $data->id ? 'selected' : '' }}>
                                                        {{ $data->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('location.country'))
                                                <span class="text-danger">{{ $errors->first('location.country') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="state-dd" class="col-form-label text-md-end text-start">State
                                                or
                                                province</label>
                                            <input type="hidden" id="FetchstateId"
                                                value="{{ $location['state'] ?? '' }}">
                                            <select id="state-dd" name="location[state]"
                                                class="form-control   single-select @error('location.state') is-invalid @enderror">
                                                @if (isset($location['state']))
                                                    {{-- <option value="">HI state</option> --}}
                                                @endif
                                            </select>
                                            @if ($errors->has('location.state'))
                                                <span class="text-danger">{{ $errors->first('location.state') }}</span>
                                            @endif
                                        </div>

                                        <div class="col-md-6">
                                            <label for="city-dd"
                                                class="col-form-label text-md-end text-start">City</label>
                                            <input type="hidden" id="FetchcityId" name="location[city]"
                                                value="{{ $location['city'] ?? '' }}">
                                            <select id="city-dd" name="location[city]"
                                                class="form-control   single-select @error('location.city') is-invalid @enderror">
                                                @if (isset($location['city']))
                                                    {{-- <option>HI city</option> --}}
                                                @endif
                                            </select>
                                            @if ($errors->has('location.city'))
                                                <span class="text-danger">{{ $errors->first('location.city') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="postcode" class="col-form-label text-md-end text-start">Zip or
                                                postal
                                                code</label>
                                            <input type="text"
                                                class="form-control @error('location.postcode') is-invalid @enderror"
                                                id="postcode" name="location[postcode]"
                                                value="{{ $location['postcode'] ?? '' }}">
                                            @if ($errors->has('location.postcode'))
                                                <span class="text-danger">{{ $errors->first('location.postcode') }}</span>
                                            @endif
                                        </div>
                                    </div>
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
                                        <div class="page-header mt-4">
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
                                        <table id="BusinessFilesList" class="display" width="100%">

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
                                                                onclick="delete_savedocs('{{ route('busidocs.delete', $certificate->af_id) }}')"
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
                                                                        {{ $business->name }}
                                                                        Documents</h6>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"><i
                                                                            class="fa-solid fa-xmark"></i></button>
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
            {{-- modals fields below --}}
            <div class="modal fade UploadUserModal" id="UploadUserModal" tabindex="-1" role="dialog"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Personnel</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="" id="ajaxUsermsg"></div>
                            <div class="whitebox mb-4">
                                <div class="row">
                                    @if ($errors->has('personnel'))
                                        <span id="personnel" class="text-danger">{{ $errors->first('personnel') }}</span>
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
            {{-- modals fields above --}}
        </form>
    </div>
    @push('javascript')
        <script>
            function getRandomInt(min, max) {
                return Math.floor(Math.random() * (max - min + 1)) + min;
            }
            $(document).ready(function() {
                var i = 1;
                var newName = 'New Business #';
                var newCode = 'B' + getRandomInt(1000, 9999);
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
                                $("#state-dd").append('<option value="' + value
                                    .id + '">' + value.name + '</option>');
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
                                $("#city-dd").append('<option value="' + value
                                    .id + '">' + value.name + '</option>');
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

            // $(document).ready(function() {
            // var FetchcountryId = $('#FetchcountryId').val();
            var FetchstateId = $('#FetchstateId').val();
            var FetchcityId = $('#FetchcityId').val();

            // fetchLocationName(FetchcountryId, 'country');
            fetchLocationName(FetchstateId, 'state');
            fetchLocationName(FetchcityId, 'city');
            // });
        </script>
        <script>
            $(document).ready(function() {
                $('#saveUserBtn').click(function(e) {
                    e.preventDefault();
                    var formData = $('#businessUpdateForm').serialize();
                    $.ajax({
                        url: '{{ route('save.busiusers') }}',
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
                $('.save-docs-btn').click(function() {
                    var logId = $(this).data('log-id');
                    var docsName = $('#cert_name_' + logId).val();
                    var docsDescription = $('#cert_description_' + logId).val();
                    var url = "{{ route('save.busidocs') }}";
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
    @endpush
@endsection
