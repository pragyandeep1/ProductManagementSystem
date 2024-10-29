@extends('layouts.app')
@section('content')
    <?php //print_r($UserInfo);
    $userInfoArray = json_decode($user->userInfo->contact_details, true);
    $CareerInfoArray = json_decode($user->CareerHistory, true);
    //print_r($userInfoArray);
    $current_date_time = \Carbon\Carbon::now();
    ?>
    <!-- Begin Page Content -->
    <div class="page-content container">
        <form action="{{ route('users.update', $user->id) }}" method="post" id="UseruploadForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="wrapper">
                <div class="status_bar">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="page-header">
                                <h3> Edit User @if (!empty($user->emp_id))
                                        <span class="text-info"> <a href="javascript:void(0);"
                                                class="btn btn-warning btn-sm">{{ $user->emp_id }}</a><span>
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
                                                <option value="1" {{ $user->userInfo->status == 1 ? 'selected' : '' }}>
                                                    Active
                                                </option>
                                                <option value="0" {{ $user->userInfo->status == 0 ? 'selected' : '' }}>
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
                            
                            <div class="item_name">
                                <div class="whitebox mb-4">
								<div class="page-header mb-2">
                                <h3>Basic Information</h3>
                            </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name" class="col-form-label text-md-end text-start">Name</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" value="{{ $user->name }}"
                                                autocomplete="off">
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="col-form-label text-md-end text-start">Email
                                                Address</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email" value="{{ $user->email }}"
                                                autocomplete="off">
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
                                                name="password" autocomplete="false" readonly
                                                onfocus="this.removeAttribute('readonly');">
                                            @if ($errors->has('password'))
                                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password_confirmation"
                                                class="col-form-label text-md-end text-start">Confirm
                                                Password</label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation" autocomplete="false" readonly
                                                onfocus="this.removeAttribute('readonly');">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="userContact">
                           
                            <div class="item_name">
                                <div class="whitebox mb-4">
								 <div class="page-header mb-2">
                                <h3>Contact Details</h3>
                            </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="primary_ph" class="col-form-label text-md-end text-start">Primary
                                                Number</label>
                                            <input type="text"
                                                class="form-control @error('contact.primary_ph') is-invalid @enderror"
                                                id="primary_ph" name="contact[primary_ph]"
                                                value="{{ $userInfoArray['primary_ph'] }}">
                                            @if ($errors->has('contact.primary_ph'))
                                                <span
                                                    class="text-danger">{{ $errors->first('contact.primary_ph') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="secondary_ph"
                                                class="col-form-label text-md-end text-start">Secondary
                                                number</label>
                                            <input type="text"
                                                class="form-control @error('secondary_ph') is-invalid @enderror"
                                                id="secondary_ph" name="contact[secondary_ph]"
                                                value="{{ $userInfoArray['secondary_ph'] }}">
                                            @if ($errors->has('secondary_ph'))
                                                <span class="text-danger">{{ $errors->first('secondary_ph') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="address"
                                                class="col-form-label text-md-end text-start">Address</label>
                                            <input type="text"
                                                class="form-control @error('address') is-invalid @enderror" id="address"
                                                name="contact[address]" value="{{ $userInfoArray['address'] }}"
                                                autocomplete="off">
                                            @if ($errors->has('address'))
                                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="address2" class="col-form-label text-md-end text-start">Apartment
                                                or
                                                unit number (optional)</label>
                                            <input type="text"
                                                class="form-control @error('address2') is-invalid @enderror"
                                                id="address2" name="contact[address2]"
                                                value="{{ $userInfoArray['address2'] }}">
                                            @if ($errors->has('address2'))
                                                <span class="text-danger">{{ $errors->first('address2') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="country-dd"
                                                class="col-form-label text-md-end text-start">Country</label>
                                            <input type="hidden" id="FetchcountryId"
                                                value="{{ $userInfoArray['country'] ?? '' }}">
                                            <select id="country-dd" name="contact[country]"
                                                class="form-control single-select @error('country') is-invalid @enderror">
                                                <option value="">--Select Country--</option>
                                                @foreach ($countries as $data)
                                                    <option value="{{ $data->id }}"
                                                        {{ $userInfoArray['country'] == $data->id ? 'selected' : '' }}>
                                                        {{ $data->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('country'))
                                                <span class="text-danger">{{ $errors->first('country') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="state-dd" class="col-form-label text-md-end text-start">State
                                                or
                                                province</label>
                                            <input type="hidden" id="FetchstateId"
                                                value="{{ $userInfoArray['state'] ?? '' }}">
                                            <select id="state-dd" name="contact[state]"
                                                class="form-control   single-select @error('state') is-invalid @enderror">
                                                @if (isset($userInfoArray['state']))
                                                    {{-- <option value="">HI state</option> --}}
                                                @endif
                                            </select>
                                            @if ($errors->has('state'))
                                                <span class="text-danger">{{ $errors->first('state') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="city-dd"
                                                class="col-form-label text-md-end text-start">City</label>
                                            <input type="hidden" id="FetchcityId" name="contact[city]"
                                                value="{{ $userInfoArray['city'] ?? '' }}">
                                            <select id="city-dd" name="contact[city]"
                                                class="form-control   single-select @error('city') is-invalid @enderror">
                                                @if (isset($userInfoArray['city']))
                                                    {{-- <option>HI city</option> --}}
                                                @endif
                                            </select>
                                            @if ($errors->has('city'))
                                                <span class="text-danger">{{ $errors->first('city') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="postcode" class="col-form-label text-md-end text-start">Zip or
                                                postal
                                                code</label>
                                            <input type="text"
                                                class="form-control   @error('contact.postcode') is-invalid @enderror"
                                                id="postcode" name="contact[postcode]"
                                                value="{{ $userInfoArray['postcode'] }}">
                                            @if ($errors->has('contact.postcode'))
                                                <span class="text-danger">{{ $errors->first('contact.postcode') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="userCareer">
                            
                            <?php //print_r($user->CareerHistory);
                            ?>
                            <div class="item_name">
                                <div class="whitebox mb-4">
								<div class="page-header mb-2">
                                <h3>Career development</h3>
                            </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="positions" class="col-form-label text-md-end text-start">Job
                                                Title</label>
                                            <input type="hidden"
                                                value="{{ $user->userInfo->job_title ? $user->userInfo->job_title : '' }}"
                                                name="old_positions">
                                            <select class="form-control   @error('positions') is-invalid @enderror"
                                                aria-label="Positions" id="positions" name="positions">
                                                {{-- <option value="">Select</option> --}}
                                                @forelse ($positions as $id => $position)
                                                    {{-- @if ($position != 'Super Admin') --}}
                                                    <option value="{{ $id }}" {{-- {{ in_array($id, old('positions') ?? []) ? 'selected' : '' }}> --}}
                                                        {{ $user->userInfo->job_title == $id ? 'selected' : '' }}>
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
                                        <div class="col-md-6" id="effectiveDateContainer" style="display: none;">
                                            {{-- style="{{ $user->userInfo->job_title == $id ? 'display: none;' : '' }}" --}}
                                            <label for="effective_date"
                                                class="col-form-label text-md-end text-start">Effective date</label>
                                            <input type="date" id="effective_date" name="effective_date"
                                                value="{{ $user->userInfo->effective_date }}" class="form-control"
                                                min="{{ $user->userInfo->effective_date }}">
                                            @if ($errors->has('effective_date'))
                                                <span class="text-danger">{{ $errors->first('effective_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="page-header mt-4">
                                            <h3>Career history</h3>
                                            <hr>
                                        </div>
                                        {{-- @if (!empty($CareerInfoArray)) --}}
                                        <table class="display" id="PositionList" width ="100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col">S#</th>
                                                    <th scope="col">Position</th>
                                                    <th scope="col">Effective date</th>
                                                    <th scope="col">End date</th>
                                                    <th scope="col">Duration</th>
                                                    {{-- <td>Notes</td> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($CareerInfoArray) > 0)
                                                    @foreach ($CareerInfoArray as $index => $careerInfo)
                                                        @php
                                                            $userPromoted = \App\Models\User::find($user->id);
                                                            $userPromoter = \App\Models\User::find(
                                                                $careerInfo['modified_by'],
                                                            );
                                                            $prevPosition = \App\Models\Position::find(
                                                                $careerInfo['prev_position'],
                                                            );
                                                            $currPosition = \App\Models\Position::find(
                                                                $careerInfo['curr_position'],
                                                            );
                                                            $actionType =
                                                                $careerInfo['prev_position'] >
                                                                $careerInfo['curr_position']
                                                                    ? 'demoted'
                                                                    : 'promoted';
                                                            $effectiveDate = \Carbon\Carbon::parse(
                                                                $careerInfo['effective_date'],
                                                            );
                                                            $endDate = $careerInfo['end_date']
                                                                ? \Carbon\Carbon::parse($careerInfo['end_date'])
                                                                : null;

                                                            // Check if both dates are valid before calculating duration
                                                            if ($effectiveDate && $endDate) {
                                                                $duration = $endDate->diff($effectiveDate);
                                                            } else {
                                                                $duration = null;
                                                            }
                                                        @endphp
                                                        <tr>
                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                            <td>{{ $currPosition->name }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($careerInfo['effective_date'])->format('jS F, Y') }}
                                                            </td>
                                                            <td>{{ $careerInfo['end_date'] ? \Carbon\Carbon::parse($careerInfo['end_date'])->format('jS F, Y') : '--' }}
                                                            </td>
                                                            <td>
                                                                @if ($duration)
                                                                    @if ($duration->y > 0)
                                                                        {{ $duration->y . ' year' . ($duration->y > 1 ? 's' : '') }}
                                                                    @endif
                                                                    @if ($duration->y > 0 && $duration->m > 0)
                                                                        ,
                                                                    @endif
                                                                    @if ($duration->m > 0)
                                                                        {{ $duration->m . ' month' . ($duration->m > 1 ? 's' : '') }}
                                                                    @endif
                                                                    @if ($duration->y > 0 || $duration->m > 0)
                                                                        ,
                                                                    @endif
                                                                    {{ $duration->d . ' day' . ($duration->d > 1 ? 's' : '') }}
                                                                @else
                                                                    --
                                                                @endif
                                                            </td>
                                                            {{-- <td>{!! $careerInfo['ch_notes'] !!}</td> --}}
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            <span class="text-secondary">
                                                                <p>No career history found!</p>
                                                            </span>
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="userFiles">
                            
                            <div class="" id="ajaxmsgTable"></div>
                            <div class="item_name" id="cert_content">
                                <div class="whitebox mb-4">
								<div class="page-header mb-2">
                                <h3>Certifications</h3>
                            </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            {{-- <label for="files" class="col-form-label text-md-end text-start">Upload
                                            Documents</label> --}}

                                            <input type="file"
                                                class="form-control   @error('files') is-invalid @enderror"
                                                id="files" name="files[]" multiple>
                                            @if ($errors->has('files'))
                                                <span class="text-danger">{{ $errors->first('files') }}</span>
                                            @endif
                                            <span class="text-muted">*Supported file type: doc, docx,
                                                xlsx, xls, ppt, pptx, txt, pdf, jpg, jpeg, png, webp, gif</span>
                                        </div>
                                        {{-- <div class="col-md-6">
                                                <a class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#UploadFileModal">Upload Files</a>
                                            </div> --}}
                                        <?php //print_r($user->certifications)
                                        ?>
                                        @if ($user->certifications->isNotEmpty())
                                            <table id="UsersFilesList" class="display" width="100%">
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
                                                <tbody>
                                                    @forelse ($user->certifications as $certificate)
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
                                                                    data-bs-target="#UploadFileModal{{ $certificate->cf_id }}"
                                                                    class="link-primary" style="cursor:pointer"><i
                                                                        class="fa-regular fa-pen-to-square"></i></a>
                                                                <a class="link-danger"
                                                                    id="cert_delete{{ $certificate->cf_id }}"
                                                                    onclick="deleteCert({{ $certificate->cf_id }})"
                                                                    style="cursor:pointer">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        {{-- view file modal --}}
                                                        <div class="modal fade"
                                                            id="UploadFileModal{{ $certificate->cf_id }}"
                                                            data-bs-keyboard="false" data-bs-backdrop="static">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <!-- Modal body -->
                                                                    <div class="modal-body">
                                                                        <h6 class="modal-title">
                                                                            {{ $user->name }}
                                                                            Documents</h6>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"><i
                                                                                class="fa-solid fa-xmark"></i></button>
                                                                        {{-- <form
                                                                                id="certUpdateForm{{ $certificate->cf_id }}"> --}}
                                                                        <div class=""
                                                                            id="ajaxmsgModal{{ $certificate->cf_id }}">
                                                                        </div>
                                                                        <div class="whitebox mb-4">
                                                                            <div class="col-md-8">
                                                                                <label
                                                                                    for="cert_name{{ $certificate->cf_id }}"
                                                                                    class="col-form-label text-md-end text-start">Name</label>
                                                                                <input type="text"
                                                                                    class="form-control  "
                                                                                    id="cert_name{{ $certificate->cf_id }}"
                                                                                    value="{{ $certificate->name }}">
                                                                            </div>
                                                                            {{-- <div class="col-md-8">
                                                                                        <label
                                                                                            for="files{{ $certificate->cf_id }}"
                                                                                            class="col-form-label text-md-end text-start">Re-upload
                                                                                            file</label>
                                                                                        <input type="file"
                                                                                            name="files{{ $certificate->cf_id }}"
                                                                                            id="files{{ $certificate->cf_id }}"
                                                                                            style="font-size: 14px;padding: 10px;
                                                                                            border: 1px solid #cebef7;
                                                                                            border-radius: 5px;">
                                                                                    </div> --}}
                                                                            <div class="col-md-12">
                                                                                <label
                                                                                    for="cert_description{{ $certificate->cf_id }}"
                                                                                    class="col-form-label text-md-end text-start">Description
                                                                                </label>
                                                                                <textarea class="form-control  " id="cert_description{{ $certificate->cf_id }}" rows="2">{{ $certificate->description }}</textarea>
                                                                            </div>
                                                                            {{-- <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <label
                                                                                                for="valid_from{{ $certificate->cf_id }}"
                                                                                                class="col-form-label text-md-end text-start">Valid
                                                                                                from</label>
                                                                                            <input type="date"
                                                                                                class="form-control  "
                                                                                                id="valid_from{{ $certificate->cf_id }}"
                                                                                                name="valid_from"
                                                                                                value=" {{ $certificate->valid_from }}">
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <label
                                                                                                for="valid_to{{ $certificate->cf_id }}"
                                                                                                class="col-form-label text-md-end text-start">Valid
                                                                                                To
                                                                                            </label>
                                                                                            <input type="date"
                                                                                                class="form-control  "
                                                                                                id="valid_to{{ $certificate->cf_id }}"
                                                                                                name="valid_to"
                                                                                                value="{{ $certificate->valid_to }}">
                                                                                        </div>
                                                                                    </div> --}}
                                                                        </div>
                                                                        <a id="cert_save{{ $certificate->cf_id }}"
                                                                            class="btn btn-primary mt-3 float-end"
                                                                            onclick="FormSubmission({{ $certificate->cf_id }})">Save</a>
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
                                                        <td>
                                                            <span class="text-danger">
                                                                <strong>No Documents Found!</strong>
                                                            </span>
                                                        </td>
                                                        {{-- <td></td> --}}
                                                        {{-- <td></td> --}}
                                                        <td></td>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="userRoles">
                            
                            <?php //print_r($user->CareerHistory);
                            ?>
                            <div class="item_name">
                                <div class="whitebox mb-4">
								<div class="page-header mb-2">
                                <h3>Roles</h3>
                            </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if (in_array('Super Admin', $userRoles))
                                                <input type="hidden" value="Super Admin" name="roles[]" readonly>
                                                <span class="badge bg-primary">Super Admin</span>
                                            @else
                                                <select
                                                    class="form-select multiple-select @error('roles') is-invalid @enderror"
                                                    multiple aria-label="Roles" id="roles" name="roles[]">

                                                    @forelse ($roles as $role)
                                                        @if ($role != 'Super Admin')
                                                            <option value="{{ $role }}"
                                                                {{ in_array($role, $userRoles ?? []) ? 'selected' : '' }}>
                                                                {{ $role }}
                                                            </option>
                                                        @endif
                                                    @empty
                                                    @endforelse
                                                </select>
                                                @if ($errors->has('roles'))
                                                    <span class="text-danger">{{ $errors->first('roles') }}</span>
                                                @endif
                                            @endif
                                        </div>
                                        {{-- <div class="col-md-6" id="effectiveDateContainer" style="display: none;">

                                            <label for="effective_date"
                                                class="col-form-label text-md-end text-start">Effective date</label>
                                            <input type="date" id="effective_date" name="effective_date"
                                                value="{{ $user->userInfo->effective_date }}" class="form-control">
                                            @if ($errors->has('effective_date'))
                                                <span class="text-danger">{{ $errors->first('effective_date') }}</span>
                                            @endif
                                        </div> --}}
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
            function FormSubmission(id) {
                var name_cert = $('#cert_name' + id).val();
                var desc_cert = $('#cert_description' + id).val();
                // e.preventDefault();
                $.ajax({
                    url: "{{ url('certification/update') }}/" + id,
                    type: "POST",
                    data: {
                        name: name_cert,
                        description: desc_cert,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        // $('#UploadFileModal' + id).modal('hide');
                        $('#ajaxmsgModal' + id).addClass('alert alert-success');
                        $('#ajaxmsgModal' + id).html(response.message);
                        if ($.fn.DataTable.isDataTable('#UsersFilesList')) {
                            $('#UsersFilesList').DataTable().destroy();
                        }
                        $('#UploadFileModal' + id).on('hidden.bs.modal', function(e) {
                            $('#cert_content').load(' #cert_content', function() {
                                $('#UsersFilesList').DataTable({
                                    responsive: true
                                });
                            });
                        });
                        console.log('Details saved successfully');
                    },
                    error: function(error) {
                        console.error('Error submitting form:', error);
                    }
                });
            }
        </script>
        <script>
            function deleteCert(id) {
                Swal.fire({
                    title: 'Do you want to delete this document?',
                    icon: 'warning',
                    // position: "top-end",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes',
                    customClass: {
                        title: 'SwalAlertBox' // Add your custom class here
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('certification/delete') }}/" + id,
                            type: "DELETE",
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: 'json',
                            success: function(response) {
                                // $('#ajaxmsgTable').addClass('alert alert-warning');
                                // $('#ajaxmsgTable').html(response.message);
                                //Swal.fire('Document Deleted!', response.message, 'success');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Document deleted!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                // location.reload();
                                if ($.fn.DataTable.isDataTable('#UsersFilesList')) {
                                    $('#UsersFilesList').DataTable().destroy();
                                }
                                $('#cert_content').load(' #cert_content', function() {
                                    $('#UsersFilesList').DataTable({
                                        responsive: true
                                    });
                                });
                                console.log('Details deleted successfully');
                            },
                            error: function(error) {
                                console.error('Error deleting document:', error);
                            }
                        });
                    }
                });
            }
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var positionsSelect = document.getElementById('positions');
                var effectiveDateContainer = document.getElementById('effectiveDateContainer');
                var effectiveDateInput = document.getElementById('effective_date');

                positionsSelect.addEventListener('change', function() {
                    effectiveDateContainer.style.display = positionsSelect.value ==
                        '{{ $user->userInfo->job_title }}' ? 'none' : 'block';
                });

                // Set min date for effective date input
                effectiveDateInput.min = '{{ $user->userInfo->effective_date }}';

            });
        </script>
    @endpush
@endsection
