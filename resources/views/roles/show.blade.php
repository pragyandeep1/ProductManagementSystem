@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="page-content container">
        <div class="wrapper">
            <div class="row align-items-center mb-3">
                <div class="col-md-9">
                    <div class="page-header">
                        <h3>Role Information @can('edit-roles')<a href="{{ route('roles.edit', $role->id) }}"
                            class="btn btn-primary btn-sm">Edit</a>@endcan</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('roles.index') }}" class="btn btn-primary float-end">
                        <i class="fa-solid fa-list me-1"></i>All Roles
                    </a>
                </div>
            </div>
            <div class="row g-2">
                <div class="col-md-6 col-lg-8">
                    <div class="item_name">
                        <div class="whitebox mb-4">

                            <div class="row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                                <div class="col-md-6" style="line-height: 53px;">
                                   <span id="name">{{ $role->name }}</span> 
                                </div>
                            </div>

                            <div class="row">
                                <label for="roles"
                                    class="col-md-4 col-form-label text-md-end text-start"><strong>Permissions:</strong></label>
                                <div class="col-md-6" style="line-height: 53px;">
                                    @if ($role->name == 'Super Admin')
                                        <span id="roles" class="badge bg-primary">All</span>
                                    @else
                                        @forelse ($rolePermissions as $permission)
                                            <span id="roles" class="badge bg-primary">{{ $permission->name }}</span>
                                        @empty
                                        @endforelse
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
