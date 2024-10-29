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
            <div class="row align-items-center mb-3">
                <div class="col-md-9">
                    <div class="page-header">
                        <h3> Edit Business @if (!empty($business->id))
                                <span class="text-info"> <a href="{{ route('businesses.show', $business->id) }}"
                                        class="btn btn-info btn-sm">{{ $business->name }}
                                        ({{ $business->code }})</a><span>
                            @endif
                        </h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('businesses.index') }}" class="btn btn-primary float-end">
                        <i class="fa-solid fa-list me-1"></i>All Businesses
                    </a>
                </div>
            </div>
            <form action="{{ route('businesses.update', $business->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-2">
                    <ul class="nav nav-tabs" id="myTabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" aria-current="page" href="#userBasic">Basic</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#userGeneral">General</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#userLocation">Location</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#userPersonnel">Personnel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#userFiles">Files</a>
                        </li>
                    </ul>
                    <div class="col-md-6 col-lg-8">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="userBasic">
                                <div class="page-header">
                                    <h3>Basic Details</h3>
                                </div>
                                <div class="whitebox mb-4">
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
                                            @if ($errors->has('category_id'))
                                                <span class="text-danger">{{ $errors->first('category_id') }}</span>
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
                                    <div class="page-header">
                                        <h3>Contact Information</h3>
                                    </div>
                                    <div class="whitebox mb-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="primary" class="col-form-label text-md-end text-start">Primary
                                                    Contact </label>
                                                <input type="text"
                                                    class="form-control @error('contact.primary') is-invalid @enderror"
                                                    id="primary" name="contact[primary]"
                                                    value="{{ $contact['primary'] ?? '' }}">
                                                @if ($errors->has('contact.primary'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('contact.primary') }}</span>
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
                                                    <span
                                                        class="text-danger">{{ $errors->first('contact.phone2') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="fax"
                                                    class="col-form-label text-md-end text-start">Fax</label>
                                                <input type="text"
                                                    class="form-control @error('contact.fax') is-invalid @enderror"
                                                    id="fax" name="contact[fax]"
                                                    value="{{ $contact['fax'] ?? '' }}">
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
                                                    <span
                                                        class="text-danger">{{ $errors->first('contact.website') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="email"
                                                    class="col-form-label text-md-end text-start">Primary Email</label>
                                                <input type="email"
                                                    class="form-control @error('contact.email') is-invalid @enderror"
                                                    id="email" name="contact[email]"
                                                    value="{{ $contact['email'] ?? '' }}">
                                                @if ($errors->has('contact.email'))
                                                    <span class="text-danger">{{ $errors->first('contact.email') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label for="email2"
                                                    class="col-form-label text-md-end text-start">Secondary Email
                                                </label>
                                                <input type="email"
                                                    class="form-control @error('contact.email2') is-invalid @enderror"
                                                    id="email2" name="contact[email2]"
                                                    value="{{ $contact['email2'] ?? '' }}">
                                                @if ($errors->has('contact.email2'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('contact.email2') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="userLocation">
                                <div class="page-header">
                                    <h3>Location</h3>
                                </div>
                                <div class="item_name">
                                    <div class="whitebox mb-4">
                                        <div class="row item_name">
                                            <div class="col-md-12">
                                                <label for="address"
                                                    class="col-form-label text-md-end text-start">Address</label>
                                                <textarea class="form-control @error('location.address') is-invalid @enderror" name="location[address]"
                                                    id="address" cols="48" rows="2">{{ $location['address'] ?? '' }}</textarea>
                                                @if ($errors->has('location.address'))
                                                    <span
                                                        class="text-danger">{{ $errors->first('location.address') }}</span>
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
                                                    <span
                                                        class="text-danger">{{ $errors->first('location.country') }}</span>
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
                                                    <span
                                                        class="text-danger">{{ $errors->first('location.state') }}</span>
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
                                                    <span
                                                        class="text-danger">{{ $errors->first('location.postcode') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="userPersonnel">
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
                            </div>
                            <div class="tab-pane fade" id="userFiles">
                                <div class="page-header">
                                    <h3>Documents</h3>
                                </div>
                                <div class="item_name">
                                    <div class="whitebox mb-4">
                                        <div class="row">
                                            <div class="col-md-6 offset-md-4">
                                                <input type="file"
                                                    class="form-control @error('files') is-invalid @enderror"
                                                    id="files" name="files[]" multiple>
                                                @if ($errors->has('files'))
                                                    <span class="text-danger">{{ $errors->first('files') }}</span>
                                                @endif
                                                <span class="text-muted">*Supported file type: doc, docx,
                                                    xlsx, xls, ppt, pptx, txt, pdf, jpg, jpeg, png, webp, gif</span>
                                            </div>
                                            @php
                                                // print_r($assetFiles);
                                            @endphp
                                            <table id="BusinessFilesList" class="display" width="100%">

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
                                                                    class="link-success me-2" target="_blank"
                                                                    title="View"><i class="fa-regular fa-eye"></i></a>
                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#UploadFileModal{{ $certificate->af_id }}"
                                                                    class="link-primary" style="cursor:pointer"><i
                                                                        class="fa-regular fa-pen-to-square"></i></a>
                                                                <a class="link-danger"
                                                                    id="cert_delete{{ $certificate->af_id }}"
                                                                    onclick="deleteCert({{ $certificate->af_id }})"
                                                                    style="cursor:pointer">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        {{-- view file modal --}}
                                                        <div class="modal fade"
                                                            id="UploadFileModal{{ $certificate->af_id }}">
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
                                                                        {{-- <form
                                                                            id="certUpdateForm{{ $certificate->af_id }}"> --}}
                                                                        <div class=""
                                                                            id="ajaxmsgModal{{ $certificate->af_id }}">
                                                                        </div>
                                                                        <div class="whitebox mb-4">
                                                                            <div class="col-md-8">
                                                                                <label
                                                                                    for="cert_name{{ $certificate->af_id }}"
                                                                                    class="col-form-label text-md-end text-start">Name</label>
                                                                                <input type="text"
                                                                                    class="form-control  "
                                                                                    id="cert_name{{ $certificate->af_id }}"
                                                                                    value="{{ $certificate->name }}">
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <label
                                                                                    for="cert_description{{ $certificate->af_id }}"
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
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="additem">
                            <h3>Publish</h3>
                            <div class="additem_body">
                                <div class="mb-3"><i class="fa-solid fa-calendar-days me-2"></i>
                                    {{ $current_date_time->format('jS F, Y h:i A') }}
                                </div>
                                <div class="mb-3">
                                    <h3>Status</h3>
                                    <select class="form-select" aria-label="Default select example" name="status">
                                        <option value="1" {{ $business->status == 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ $business->status == 0 ? 'selected' : '' }}>Disable
                                        </option>
                                    </select>
                                </div>
                                <input type="submit" class="btn btn-primary" value="Publish">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
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
    @endpush
@endsection
