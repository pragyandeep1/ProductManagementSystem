@extends('layouts.app')

@section('content')
    @php
        $current_date_time = \Carbon\Carbon::now();
    @endphp
    <!-- Begin Page Content -->
    <div class="page-content container">
        <form action="{{ route('facilities.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="wrapper">
                <div class="status_bar">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="page-header">
                                <h3>Add New Facility</h3>
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
                                            <a href="{{ route('facilities.index') }}" class="btn btn-primary float-end">
                                                <i class="fa-solid fa-list me-1"></i>All Facilities
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
                            <a class="nav-link" data-bs-toggle="tab" href="#userContact">Parts/BOM</a>
                        </li>
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
                                        <label for="name" class="col-form-label text-md-end text-start">Facility
                                            name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') }}">
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
                                            cols="48" rows="3">{{ old('description') }}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="text-danger">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="userGeneral">
                            <div class="item_name whitebox ">
                                <div class="page-header mb-2">
                                    <h3>Location</h3>
                                </div>
                                <div class="mb-2">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="radio" class="@error('old_faci_chkbox') is-invalid @enderror"
                                                id="old_faci_chkbox" name="faci_chkbox" value="1"
                                                onclick="toggleDropdown()">
                                            <label for="old_faci_chkbox"
                                                class="col-form-label text-md-end text-start">This
                                                facility is a part of:</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="radio" class="@error('new_faci_chkbox') is-invalid @enderror"
                                                id="new_faci_chkbox" name="faci_chkbox" value="0"
                                                onclick="toggleNewAddr()">
                                            <label for="new_faci_chkbox"
                                                class="col-form-label text-md-end text-start">This
                                                facility is not part of another location, and is located at:</label>
                                        </div>
                                        <div class="col-md-6 item_name old_faci_addr" id="old_faci_addr"
                                            style="display: none;">
                                            <label for="parent_id" class="col-form-label text-md-end text-start">Select
                                                Parent
                                                facility</label>
                                            <select class="form-control @error('parent_id') is-invalid @enderror"
                                                aria-label="Parent facility" id="parent_id" name="parent_id">
                                                <option value="">--None--</option>
                                                @forelse ($facilities as $id => $facility)
                                                    <option value="{{ $id }}"
                                                        {{ old('parent_id') == $id ? 'selected' : '' }}>
                                                        {{ $facility }}
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                            <div class="new_address_field" id="new_address_field" style="display: none;">
                                                <textarea name="add_address" id="add_address" cols="48" rows="2"></textarea>
                                            </div>
                                            <span id="parent_address_warning" class="text-warning"
                                                style="display: none;">No address given in parent facility</span>
                                            @if ($errors->has('parent_id'))
                                                <span class="text-danger">{{ $errors->first('parent_id') }}</span>
                                            @endif
                                        </div>
                                        <span id="address_success" class="text-success col-md-6"
                                            style="display: none;"></span>
                                    </div>
                                    <div class="item_name faci_new_addr" id="faci_new_addr" style="display: none;">
									 <div class="row">
                                        <div class="col-md-12">
                                            <label for="address"
                                                class="col-form-label text-md-end text-start">Address</label>
                                            <textarea class="form-control @error('contact.address') is-invalid @enderror" name="contact[address]" id="address"
                                                cols="48" rows="2">{{ old('contact.address') }}</textarea>
                                            @if ($errors->has('contact.address'))
                                                <span class="text-danger">{{ $errors->first('contact.address') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="country-dd"
                                                class="col-form-label text-md-end text-start">Country</label>
                                            <select id="country-dd" name="contact[country]" value="{{ old('country') }}"
                                                class="form-control single-select @error('contact.country') is-invalid @enderror">
                                                <option value="">--Select Country--</option>
                                                @foreach ($countries as $data)
                                                    <option value="{{ $data->id }}">
                                                        {{ $data->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('contact.country'))
                                                <span class="text-danger">{{ $errors->first('contact.country') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="state-dd" class="col-form-label text-md-end text-start">State
                                                or
                                                province</label>
                                            <select id="state-dd" name="contact[state]" value="{{ old('state') }}"
                                                class="form-control single-select @error('contact.state') is-invalid @enderror">
                                            </select>
                                            @if ($errors->has('contact.state'))
                                                <span class="text-danger">{{ $errors->first('contact.state') }}</span>
                                            @endif
                                        </div>

                                        <div class="col-md-6">
                                            <label for="city-dd"
                                                class="col-form-label text-md-end text-start">City</label>
                                            <select id="city-dd" name="contact[city]" value="{{ old('city') }}"
                                                class="form-control single-select @error('contact.city') is-invalid @enderror">
                                            </select>
                                            @if ($errors->has('contact.city'))
                                                <span class="text-danger">{{ $errors->first('contact.city') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="postcode" class="col-form-label text-md-end text-start">Zip or
                                                postal
                                                code</label>
                                            <input type="text"
                                                class="form-control @error('contact.postcode') is-invalid @enderror"
                                                id="postcode" name="contact[postcode]" value="{{ old('postcode') }}">
                                            @if ($errors->has('contact.postcode'))
                                                <span class="text-danger">{{ $errors->first('contact.postcode') }}</span>
                                            @endif
                                        </div>
                                    </div>
									</div>
                                </div>
								<hr>
                                <div class="page-header mb-2">
                                    <h3>General Information</h3>
                                </div>
                                <div class="mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="account" class="col-form-label text-md-end text-start">Account
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
                                            <label for="department" class="col-form-label text-md-end text-start">Charge
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
                                                <span class="text-danger">{{ $errors->first('department') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="notes"
                                                class="col-form-label text-md-end text-start">Notes</label>
                                            <textarea class="form-control @error('notes') is-invalid @enderror" name="notes" id="notes" cols="48"
                                                rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="userContact">
                            
                            <div class="item_name">
                                <div class="whitebox mb-4">
								<div class="page-header mb-2">
                                <h3>Asset Parts Supplies</h3>
                            </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="supplies"
                                                class="col-form-label text-md-end text-start">Part/Supply
                                            </label>
                                            <select class="form-control @error('supplies') is-invalid @enderror"
                                                aria-label="Supplies" id="supplies" name="supplies">
                                                <option value="">Select</option>
                                                @forelse ($supplies as $id => $supply)
                                                    <option value="{{ $supply['id'] }}">
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
                                            <input type="text" id="quantity" name="quantity" class="form-control">
                                            @if ($errors->has('quantity'))
                                                <span class="text-danger">{{ $errors->first('quantity') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                                class="form-control" placeholder="0.00">
                                            @if ($errors->has('meter_reading'))
                                                <span class="text-danger">{{ $errors->first('meter_reading') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="meter_read_units"
                                                class="col-form-label text-md-end text-start">Meter
                                                Reading Units
                                            </label>
                                            @php
                                                // print_r($MeterReadUnits);
                                            @endphp
                                            <select class="form-control @error('meter_read_units') is-invalid @enderror"
                                                aria-label="Meter read units" id="meter_read_units"
                                                name="meter_read_units">
                                                <option value="">--Select--</option>
                                                @foreach ($MeterReadUnits as $meterReadUnit)
                                                    <option value="{{ $meterReadUnit['id'] }}">
                                                        {{ $meterReadUnit['name'] }} ({{ $meterReadUnit['symbol'] }})
                                                    </option>
                                                @endforeach
                                                {{-- @forelse ($MeterReadUnits as $symbol => $name)
                                                        <option value="{{ $id }}"
                                                            {{ old('positions') == $id ? 'selected' : '' }}>
                                                            {{ $name }}{{ $symbol }}
                                                        </option>
                                                    @empty
                                                    @endforelse --}}
                                            </select>
                                            @if ($errors->has('meter_read_units'))
                                                <span class="text-danger">{{ $errors->first('meter_read_units') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="userFiles">
                            {{-- <div class="page-header">
                                    <h3>Certifications</h3>
                                </div> --}}
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
                $('#parent_id').change(function() {
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
                            'If this facility is not part of another location,then please select other checkbox and manually enter the address.'
                        ).addClass('text-info');
                        // toggleNewAddr();
                        // $('#new_address_field').show();
                    }
                });
            });
        </script>
    @endpush
@endsection
