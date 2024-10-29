@extends('layouts.app')
@section('content')

    <!-- Begin Page Content -->
    <div class="page-content container">
        <div class="wrapper">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="page-header">
                        <h3>Business List</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    @can('create-business')
                        <a href="{{ route('businesses.create') }}" class="btn btn-primary float-end"><i
                                class="bi bi-plus-circle"></i>
                            Add New
                            Business</a>
                    @endcan
                </div>
            </div>
            <div class="whitebox">
                <table id="BusinessList" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">S#</th>
                            <th scope="col">Code</th>
                            <th scope="col">Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">City</th>
                            <th scope="col">Province</th>
                            <th scope="col">Country</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($businesses as $business)
                            @php
                                $address = json_decode($business->location, true);
                            @endphp
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $business->code }}</td>
                                <td>{{ $business->name }}</td>
                                <td>{{ $address['address'] ?? '' }}</td>
                                <td>
                                    @foreach ($cities as $data)
                                        {{ ($address['city'] ?? '') == $data->id ? $data->name : '' }}
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($states as $data)
                                        {{ ($address['state'] ?? '') == $data->id ? $data->name : '' }}
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($countries as $data)
                                        {{ ($address['country'] ?? '') == $data->id ? $data->name : '' }}
                                    @endforeach
                                </td>
                                <td>
                                    <form action="{{ route('businesses.destroy', $business->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        {{-- <a href="{{ route('businesses.show', $business->id) }}"
                                            class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> </a> --}}

                                        @can('edit-business')
                                            <a href="{{ route('businesses.edit', $business->id) }}" class="link-primary"><i
                                                    class="fa-regular fa-pen-to-square"></i></a>
                                        @endcan

                                        @can('delete-business')
                                            <button type="submit" class="link-danger"
                                                onclick="return confirm('Do you want to delete this business?');"><i
                                                    class="fa-solid fa-trash-can"></i></button>
                                        @endcan
                                    </form>
                                </td>



                            </tr>
                        @empty
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <span class="text-info">
                                    <strong>No Business Found!</strong>
                                </span>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        @endforelse
                    </tbody>
                </table>
                {{-- {{ $businesses->links() }} --}}
            </div>
        </div>
    </div>
@endsection
