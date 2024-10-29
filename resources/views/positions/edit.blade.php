@extends('layouts.app')
@push('css')
@endpush
@section('content')
    <!-- Begin Page Content -->
    <div class="page-content container">
        <form action="{{ route('positions.update', $position->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="wrapper">
                <div class="status_bar">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="page-header">
                                <h3> Edit Position</h3>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="float-end">
                                <div class="status_area">
                                    <ul>
                                        <li>
                                            <h3>Select Parent</h3>
                                        </li>
                                        <li>
                                            <select
                                                class="form-select single-select @error('parent_id') is-invalid @enderror"
                                                aria-label="Parent permission" id="parent_id" name="parent_id">
                                                <option value="">--None--</option>
                                                @forelse ($Allpositions as $id => $Allposition)
                                                    @if ($id != $position->id)
                                                        <option value="{{ $id }}"
                                                            {{ $id == $position->parent_id ? 'selected' : '' }}>
                                                            {{ $Allposition }}
                                                        </option>
                                                    @endif
                                                @empty
                                                @endforelse
                                            </select>
                                        </li>
                                        <li>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa-solid fa-floppy-disk"></i> Publish
                                            </button>
                                        </li>
                                        <li>
                                            <a href="{{ route('positions.index') }}" class="btn btn-primary float-end">
                                                <i class="fa-solid fa-list me-1"></i>All Positions
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
                            <label for="name" class="col-md-2 col-form-label text-md-end text-start">Name</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ $position->name }}">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="description"
                                class="col-md-2 col-form-label text-md-end text-start">Description</label>
                            <div class="col-md-10">
                                <textarea class="ckeditor form-control @error('description') is-invalid @enderror" id="description" name="description">{{ $position->description }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="text-danger">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label text-md-end text-start">Hierarchy Tree</label>
                            <div class="col-md-10">
                                <ul id="tree1">
                                    @foreach ($categories as $category)
                                        <li>
                                            {{ $category->name }}
                                            @if (count($category->childs))
                                                @include('modules.ParentPositionTree', [
                                                    'childs' => $category->childs,
                                                ])
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @push('javascript')
    @endpush
@endsection
