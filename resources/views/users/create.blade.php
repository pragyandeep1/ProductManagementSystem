@extends('layouts.app')

@section('content')
    <?php
    $current_date_time = \Carbon\Carbon::now();
    ?>
    <!-- Begin Page Content -->
    <div class="page-content container">
        <form action="{{ route('users.store') }}" method="post" id="UserEditForm" autocomplete="off"
            enctype="multipart/form-data">
            @csrf
            <div class="wrapper">
                <div class="status_bar">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="page-header">
                                <h3> Add New User</h3>
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
                                            <a href="{{ route('users.index') }}" class="btn btn-primary float-end">
                                                <i class="fa-solid fa-list me-1"></i>All Users
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
                            <a class="nav-link active" data-bs-toggle="tab" aria-current="page" href="#userBasic">Basic
                                Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#userContact">Contact Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#userCareer">Career</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#userFiles">Files</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#userRoles">Roles</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="userBasic">
                            <div class="page-header">
                                <h3>Basic Information</h3>
                            </div>
                            <div class="item_name">
                                <div class="whitebox mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name" class="col-form-label text-md-end text-start">Name</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" value="{{ old('name') }}">
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="col-form-label text-md-end text-start">Email
                                                Address</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email" value="{{ old('email') }}">
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="password"
                                                class="col-form-label text-md-end text-start">Password</label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror" id="password"
                                                name="password">
                                            @if ($errors->has('password'))
                                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password_confirmation"
                                                class="col-form-label text-md-end text-start">Confirm
                                                Password</label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="userContact">
                            <div class="page-header">
                                <h3>Contact Details</h3>
                            </div>
                            <div class="item_name">
                                <div class="whitebox mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="primary_ph" class="col-form-label text-md-end text-start">Primary
                                                Number</label>
                                            <input type="text"
                                                class="form-control @error('contact.primary_ph') is-invalid @enderror"
                                                id="primary_ph" name="contact[primary_ph]"
                                                value="{{ old('primary_ph') }}">
                                            @if ($errors->has('contact.primary_ph'))
                                                <span class="text-danger">{{ $errors->first('contact.primary_ph') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="secondary_ph"
                                                class="col-form-label text-md-end text-start">Secondary
                                                number</label>
                                            <input type="text"
                                                class="form-control @error('contact.secondary_ph') is-invalid @enderror"
                                                id="secondary_ph" name="contact[secondary_ph]"
                                                value="{{ old('secondary_ph') }}">
                                            @if ($errors->has('contact.secondary_ph'))
                                                <span
                                                    class="text-danger">{{ $errors->first('contact.secondary_ph') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="address"
                                                class="col-form-label text-md-end text-start">Address</label>
                                            <input type="text"
                                                class="form-control @error('contact.address') is-invalid @enderror"
                                                id="address" name="contact[address]" value="{{ old('address') }}">
                                            @if ($errors->has('contact.address'))
                                                <span class="text-danger">{{ $errors->first('contact.address') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="address2" class="col-form-label text-md-end text-start">Apartment
                                                or
                                                unit number (optional)</label>
                                            <input type="text"
                                                class="form-control @error('contact.address2') is-invalid @enderror"
                                                id="address2" name="contact[address2]" value="{{ old('address2') }}">
                                            @if ($errors->has('contact.address2'))
                                                <span class="text-danger">{{ $errors->first('contact.address2') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="country"
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
                                            <label for="state" class="col-form-label text-md-end text-start">State
                                                or
                                                province</label>
                                            <select id="state-dd" name="contact[state]" value="{{ old('state') }}"
                                                class="form-control single-select @error('contact.state') is-invalid @enderror">
                                            </select>
                                            @if ($errors->has('contact.state'))
                                                <span class="text-danger">{{ $errors->first('contact.state') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="city"
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
                        </div>
                        <div class="tab-pane fade" id="userCareer">
                            <div class="page-header">
                                <h3>Career development</h3>
                            </div>
                            <div class="item_name">
                                <div class="whitebox mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="positions" class="col-form-label text-md-end text-start">Job
                                                Title</label>
                                            <select class="form-control @error('positions') is-invalid @enderror"
                                                aria-label="Positions" id="positions" name="positions">
                                                {{-- @php print_r($positions); @endphp --}}
                                                <option value="">Select</option>
                                                @forelse ($positions as $id => $position)
                                                    {{-- @if ($position != 'Super Admin') --}}
                                                    <option value="{{ $id }}" {{-- {{ in_array($id, old('positions') ?? []) ? 'selected' : '' }}> --}}
                                                        {{ old('positions') == $id ? 'selected' : '' }}>
                                                        {{ $position }}
                                                    </option>
                                                    {{-- @endif --}}
                                                @empty
                                                @endforelse
                                            </select>
                                            @if ($errors->has('positions'))
                                                <span class="text-danger">{{ $errors->first('positions') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="effective_date"
                                                class="col-form-label text-md-end text-start">Effective date</label>
                                            <input type="date" id="effective_date" name="effective_date"
                                                value="{{ $current_date_time->format('Y-m-d') }}" class="form-control">
                                            @if ($errors->has('effective_date'))
                                                <span class="text-danger">{{ $errors->first('effective_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="userFiles">
                            <div class="page-header">
                                <h3>Certifications</h3>
                            </div>
                            <div class="item_name">
                                <div class="whitebox mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            {{-- <label for="files" class="col-form-label text-md-end text-start">Upload
                                            Documents</label> --}}
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
                        <div class="tab-pane fade" id="userRoles">
                            <div class="page-header">
                                <h3>Roles</h3>
                            </div>
                            <div class="item_name">
                                <div class="whitebox mb-4">
                                    <select class="form-control multiple-select @error('roles') is-invalid @enderror"
                                        aria-label="Roles" id="roles" name="roles[]">
                                        @forelse ($roles as $role)
                                            @if ($role != 'Super Admin')
                                                <option value="{{ $role }}"
                                                    {{ in_array($role, old('roles') ?? []) ? 'selected' : '' }}>
                                                    {{ $role }}
                                                </option>
                                            @endif
                                        @empty
                                        @endforelse
                                    </select>
                                    @if ($errors->has('roles'))
                                        <span class="text-danger">{{ $errors->first('roles') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="tz" id="tz">
        </form>
    </div>
    @push('javascript')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone-with-data-2012-2022.min.js">
        </script>
        <script>
            $(function() {
                // guess user timezone 
                $('#tz').val(moment.tz.guess())
            })
        </script>
        <script>
            jQuery(document).ready(function() {
                $('#myTabs a').click(function(e) {
                    e.preventDefault()
                    $(this).tab('show')
                })
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
    @endpush
@endsection
