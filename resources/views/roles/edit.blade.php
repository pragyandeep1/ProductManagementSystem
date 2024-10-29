@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="page-content container">
        <form action="{{ route('roles.update', $role->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="wrapper">
                <div class="status_bar">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="page-header">
                                <h3> Edit Role</h3>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="float-end">
                                <div class="status_area">
                                    <ul>
                                        <li>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa-solid fa-floppy-disk"></i> Publish
                                            </button>
                                        </li>
                                        <li>
                                            <a href="{{ route('roles.index') }}" class="btn btn-primary float-end">
                                                <i class="fa-solid fa-list me-1"></i>All Roles
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item_name">
                    <div class="whitebox mb-4">
                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ $role->name }}" autocomplete="off">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <span class="col-md-4 col-form-label text-md-end text-start text-dark">Permissions</span>
                            <div class="col-md-6">
                                <div class="scrollable-container" style="height: 210px; overflow-y: auto;">
                                    {{-- <select class="form-select  multiple-select @error('permissions') is-invalid @enderror" multiple
                                                                            aria-label="Permissions" id="permissions" name="permissions[]"
                                                                            style="height: 210px;"> --}}
                                    @forelse ($permissions as $permission)
                                        <div class="form-check">
                                            <input type="checkbox"
                                                class="form-check-input @error('permissions') is-invalid @enderror"
                                                aria-label="Permissions" id="permissions{{ $permission->id }}"
                                                name="permissions[]" value="{{ $permission->id }}"
                                                {{ in_array($permission->id, $rolePermissions ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="permissions{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                        {{-- <option value="{{ $permission->id }}"
                                            {{ in_array($permission->id, $rolePermissions ?? []) ? 'selected' : '' }}>
                                            {{ $permission->name }}
                                            </option> --}}
                                    @empty
                                    @endforelse
                                    {{-- </select> --}}
                                </div>
                                @if ($errors->has('permissions'))
                                    <span class="text-danger">{{ $errors->first('permissions') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
