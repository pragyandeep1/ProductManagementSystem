@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="page-content container">
        <div class="wrapper">
            <div class="row align-items-center mb-3">
                <div class="col-md-9">
                    <div class="page-header">
                        <h3> Edit Asset</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('products.index') }}" class="btn btn-primary float-end">
                        <i class="fa-solid fa-list me-1"></i>All Assets
                    </a>
                </div>
            </div>
            <form action="{{ route('products.update', $product->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row g-2">
                    <div class="col-md-6 col-lg-8">
                        <div class="item_name">
                            <div class="whitebox mb-4">

                                <div class="mb-3 row">
                                    <label for="name"
                                        class="col-md-2 col-form-label text-md-end text-start">Name</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ $product->name }}">
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="description"
                                        class="col-md-2 col-form-label text-md-end text-start">Description</label>
                                    <div class="col-md-10">
                                        <textarea class="ckeditor form-control @error('description') is-invalid @enderror" id="description" name="description">{{ $product->description }}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="text-danger">{{ $errors->first('description') }}</span>
                                        @endif
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
                                    <?php
                                    $current_date_time = \Carbon\Carbon::now();
                                    echo $current_date_time->format('jS F, Y h:i A');
                                    ?>
                                </div>
                                {{-- <div class="mb-3 ">
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Status:</option>
                                        <option value="1">Active</option>
                                        <option value="2">Disable</option>
                                    </select>
                                </div> --}}
                                <input type="submit" class="btn btn-primary" value="Publish">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection