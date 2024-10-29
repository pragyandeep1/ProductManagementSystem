@extends('layouts.app')
@section('content')
    <!-- Begin Page Content -->
    <div class="page-content container">
        <div class="wrapper">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="page-header">
                        <h3>Manage Roles</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    @can('create-role')
                        <a href="{{ route('roles.create') }}" class="btn btn-primary float-end"><i class="bi bi-plus-circle"></i>
                            Add New Role</a>
                    @endcan
                </div>
            </div>
            <div class="whitebox">

                <table id="RolesList" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">S#</th>
                            <th scope="col">Name</th>
                            <th scope="col" style="width: 250px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        {{-- <a href="{{ route('roles.show', $role->id) }}" class="btn btn-warning btn-sm"><i
                                                class="bi bi-eye"></i></a> --}}

                                        @if ($role->name != 'Super Admin')
                                            @can('edit-role')
                                                <a href="{{ route('roles.edit', $role->id) }}" class="link-primary"><i
                                                        class="fa-regular fa-pen-to-square"></i></a>
                                            @endcan

                                            @can('delete-role')
                                                @if ($role->name != Auth::user()->hasRole($role->name))
                                                    <button type="submit" class="link-danger"
                                                        onclick="return confirm('Do you want to delete this role?');"><i
                                                            class="fa-solid fa-trash-can"></i></button>
                                                @endif
                                            @endcan
                                        @endif

                                    </form>
                                </td>
                            </tr>
                        @empty
                            <td></td>

                            <td>
                                <span class="text-danger">
                                    <strong>No Role Found!</strong>
                                </span>
                            </td>
                            <td></td>
                        @endforelse
                    </tbody>
                </table>
                {{-- {{ $roles->links() }} --}}
            </div>
        </div>
    </div>
@endsection
