@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="page-content container">
        <div class="wrapper">
            <div class="row align-items-center mb-3">
                <div class="col-md-9">
                    <div class="page-header">
                        <h3>Facility Information @can('edit-facility')<a href="{{ route('facilities.edit', $facility->id) }}"
                            class="btn btn-primary btn-sm">Edit</a>@endcan</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('facilities.index') }}" class="btn btn-primary float-end">
                        <i class="fa-solid fa-list me-1"></i>All Facilities
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
                                    {{ $facility->name }}
                                </div>
                            </div>
                            <div class="row">
                                <label for="description"
                                    class="col-md-4 col-form-label text-md-end text-start"><strong>Description:</strong></label>
                                <div class="col-md-6" style="line-height: 53px;">
                                    {!! $facility->description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
