@extends('layouts.app')

@section('content')
    <?php $userInfoArray = json_decode($user->userInfo->contact_details, true); ?>
    <!-- Begin Page Content -->
    <div class="page-content container">
        <div class="wrapper">
            <div class="row mb-2 align-items-center mb-3">
                <div class="col-md-9">
                    <div class="page-header">
                        <h3>{{ $user->name }} Details @can('edit-user')
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            @endcan
                        </h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('users.index') }}" class="btn btn-primary float-end">
                        <i class="fa-solid fa-list me-1"></i>All Users
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
                                    {{ $user->name ?? '' }}
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-md-4  text-md-end text-start"><strong>Email
                                        Address:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    {{ $user->email ?? '' }}
                                </div>
                            </div>


                            <div class="row mb-2">
                                <label class="col-md-4 text-md-end text-start"><strong>Roles:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    @forelse ($user->getRoleNames() as $role)
                                        <span class="badge bg-primary">{{ $role }}</span>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4  text-md-end text-start"><strong>Job
                                        title:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    @forelse ($positions as $id => $position)
                                        @if ($user->userInfo->job_title == $id)
                                            <span class="badge" style="background-color:#5A2CD5">{{ $position }}</span>
                                        @endif
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4  text-md-end text-start"><strong>Status:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    @if ($user->userInfo->status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Disabled</span>
                                    @endif
                                </div>
                            </div>
                            {{-- {{ $user->userInfo->contact_details }} --}}
                            {{-- {{ $user->userInfo }} --}}
                            {{-- {{ $user->userInfo->status }} --}}


                            {{-- {{ $user->certifications->name ? '' }} --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="page-header">
                        <h3>Contact Information</h3>
                    </div>
                    <div class="">
                        <div class="whitebox mb-4">
                            <div class="row mb-2">
                                <label class="col-md-4  text-md-end text-start"><strong>Primary
                                        Number:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    {{ $userInfoArray['primary_ph'] ?? '' }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4  text-md-end text-start"><strong>Secondary
                                        Number:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    {{ $userInfoArray['secondary_ph'] ?? '' }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4  text-md-end text-start"><strong>Address:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    {{ $userInfoArray['address'] ?? '' }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4  text-md-end text-start"><strong>Apartment or
                                        unit number:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    {{ $userInfoArray['address2'] ?? '' }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4  text-md-end text-start"><strong>City:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    @foreach ($cities as $data)
                                        {{ ($userInfoArray['city'] ?? '') == $data->id ? $data->name : '' }}
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4  text-md-end text-start"><strong>State
                                        or
                                        province:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    @foreach ($states as $data)
                                        {{ ($userInfoArray['state'] ?? '') == $data->id ? $data->name : '' }}
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4  text-md-end text-start"><strong>Country:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    @foreach ($countries as $data)
                                        {{ ($userInfoArray['country'] ?? '') == $data->id ? $data->name : '' }}
                                    @endforeach
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-md-4  text-md-end text-start"><strong>Zip or
                                        postal
                                        code:</strong></label>
                                <div class="col-md-6" style="line-height: 24px;">
                                    {{ $userInfoArray['postcode'] ?? '' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="page-header">
                    <h3>Certifications</h3>
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
                                    <th scope="col">Valid from</th>
                                    <th scope="col">Valid to</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($user->certifications as $certificate)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $certificate->name }}</td>
                                        <td>{{ $certificate->description }}</td>
                                        <td>{{ $certificate->type }}</td>
                                        <td>{{ $certificate->valid_from }}</td>
                                        <td>{{ $certificate->valid_to }}</td>
                                        <td><a href="{{ asset($certificate->url) }}" class="" target="_blank"
                                                title="View"><i class="fa-regular fa-eye"></i></a></td>
                                    </tr>
                                @empty
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <span class="text-secondary">
                                            <strong>No Documents Found!</strong>
                                        </span>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
