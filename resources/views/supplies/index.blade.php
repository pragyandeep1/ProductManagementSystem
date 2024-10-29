@extends('layouts.app')
@section('content')
    <!-- Begin Page Content -->
    <div class="page-content container">
        <div class="wrapper">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="page-header">
                        <h3>Supplies List</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    @can('create-supply')
                        <a href="{{ route('supplies.create') }}" class="btn btn-primary float-end"><i
                                class="bi bi-plus-circle"></i>
                            Add New
                            Supply</a>
                    @endcan
                </div>
            </div>
            <div class="whitebox">
                <table id="SupplyList" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">S#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Code</th>
                            <th scope="col">Location</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($supplies as $supply)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $supply->name }}</td>
                                <td>{{ $supply->code }}</td>
                                @php
                                    $stockCount = count($supply->stocks);
                                @endphp
                                <td style="{{ $stockCount <= 1 ? '' : 'color: #2993c6; cursor: pointer;' }}">

                                    @if ($stockCount <= 1)
                                        @foreach ($supply->stocks as $stock)
                                            @if (isset($facilities[$stock->parent_id]))
                                                {{ $facilities[$stock->parent_id] }} (aisle: {{ $stock->stocks_aisle }},
                                                row: {{ $stock->stocks_row }}, bin: {{ $stock->stocks_bin }})<br>
                                            @endif
                                        @endforeach
                                    @else
                                        <span class="multiple-locations-{{ $supply->id }}" title="Show Locations">Multiple
                                            Locations</span>
                                        <div id="locations-list-{{ $supply->id }}" style="display: none;">
                                            @foreach ($supply->stocks as $stock)
                                                @if (isset($facilities[$stock->parent_id]))
                                                    {{ $loop->iteration }}. {{ $facilities[$stock->parent_id] }} (aisle:
                                                    {{ $stock->stocks_aisle }},
                                                    row: {{ $stock->stocks_row }}, bin: {{ $stock->stocks_bin }})<br>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                    @push('javascript')
                                        <script>
                                            $(document).ready(function() {
                                                $('.multiple-locations-{{ $supply->id }}').click(function() {
                                                    $('#locations-list-{{ $supply->id }}').dialog({
                                                        modal: true,
                                                        title: "Multiple Locations",
                                                        width: 400,
                                                        resizable: false,
                                                        buttons: {
                                                            "Close": function() {
                                                                $(this).dialog('close');
                                                            }
                                                        }
                                                    });
                                                });
                                            });
                                        </script>
                                    @endpush

                                </td>
                                {{-- <td style="color: #2993c6">
                                    @foreach ($supply->stocks as $stock)
                                        @if (isset($facilities[$stock->parent_id]))
                                            {{ $facilities[$stock->parent_id] }} (aisle: {{ $stock->stocks_aisle }}, row:
                                            {{ $stock->stocks_row }}, bin: {{ $stock->stocks_bin }})<br>
                                        @endif
                                    @endforeach


                                </td> --}}
                                {{-- <td>{!! $supply->description !!}</td> --}}
                                <td>
                                    <form action="{{ route('supplies.destroy', $supply->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        {{-- <a href="{{ route('supplies.show', $supply->id) }}"
                                            class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> </a> --}}

                                        @can('edit-supply')
                                            <a href="{{ route('supplies.edit', $supply->id) }}" class="link-primary"><i
                                                    class="fa-regular fa-pen-to-square"></i></a>
                                        @endcan

                                        @can('delete-supply')
                                            <button type="submit" class="link-danger"
                                                onclick="return confirm('Do you want to delete this supply?');"><i
                                                    class="fa-solid fa-trash-can"></i></button>
                                        @endcan
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <td></td>
                            <td></td>
                            <td>
                                <span class="text-danger">
                                    <strong>No Supply Found!</strong>
                                </span>
                            </td>
                            <td></td>
                            <td></td>
                        @endforelse
                    </tbody>
                </table>
                {{-- {{ $supplies->links() }} --}}
            </div>
        </div>
    </div>
    @push('javascript')
        {{-- <script>
            $(document).ready(function() {
                $('.multiple-locations').hover(function() {
                    $(this).next('.locations-list').toggle();
                });
            });
        </script> --}}
    @endpush
@endsection
