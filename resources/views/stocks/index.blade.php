@extends('layouts.app')
@section('content')
    <!-- Begin Page Content -->
    <div class="page-content container">
        <div class="wrapper">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="page-header">
                        <h3>Current Stock</h3>
                    </div>
                </div>
                {{-- <div class="col-md-3">
                    @can('create-stock')
                        <a href="{{ route('stocks.create') }}" class="btn btn-primary float-end"><i
                                class="bi bi-plus-circle"></i>
                            Add New
                            Stocks</a>
                    @endcan
                </div> --}}
            </div>
            <div class="whitebox">
                <table id="stocksList" class="table table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">S#</th>
                            <th scope="col">Stock Item</th>
                            <th scope="col">Location</th>
                            <th scope="col">Aisle</th>
                            <th scope="col">Row</th>
                            <th scope="col">Bin</th>
                            <th scope="col">Qty on Hand</th>
                            <th scope="col">Min Qty</th>
                            <th scope="col">Max Qty</th>

                            {{-- <th scope="col">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stocks as $stock)
                            @php
                                $stockLocation = json_decode($stock->location, true);
                                // $stockQuantity = json_decode($stock->quantity, true);
                            @endphp
                            <tr style="cursor: pointer">
                                <th scope="row">{{ $loop->iteration }}</th>

                                <td>{{ $supplies[$stock->asset_id] }}</td>

                                <td>
                                    @if (isset($facilities[$stock->parent_id]))
                                        {{ $facilities[$stock->parent_id] }}
                                    @endif
                                </td>
                                <td>{{ $stock['stocks_aisle'] }}</td>
                                <td>{{ $stock['stocks_row'] }}</td>
                                <td>{{ $stock['stocks_bin'] }}</td>
                                <td>{{ $stock->stocks_qty_on_hand }}</td>
                                <td>{{ $stock->stocks_min_qty }}</td>
                                <td>{{ $stock->stocks_max_qty }}</td>

                                {{-- <td>
                                    <form action="{{ route('stocks.destroy', $stock->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <a href="{{ route('stocks.show', $stock->id) }}" class="btn btn-warning btn-sm"><i
                                                class="bi bi-eye"></i> </a>

                                        @can('edit-stock')
                                            <a href="{{ route('stocks.edit', $stock->id) }}" class="link-primary"><i
                                                    class="fa-regular fa-pen-to-square"></i></a>
                                        @endcan

                                        @can('delete-stock')
                                            <button type="submit" class="link-danger"
                                                onclick="return confirm('Do you want to delete this stock?');"><i
                                                    class="fa-solid fa-trash-can"></i></button>
                                        @endcan
                                    </form>
                                </td> --}}
                            </tr>
                        @empty
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <span class="text-info">
                                    <strong>No Stock Found!</strong>
                                </span>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        @endforelse
                    </tbody>
                </table>
                {{-- {{ $stocks->links() }} --}}
            </div>
        </div>
    </div>
@endsection
