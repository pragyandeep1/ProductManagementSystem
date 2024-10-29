@extends('layouts.app')
@section('content')
    @php
        // echo '<pre>';
        // echo json_encode($facilities);
        // echo '<br>';
        // print_r($facilityRelations);
        // echo json_encode($facilityRelations);
        // echo '</pre>';
    @endphp
    <!-- Begin Page Content -->
    <div class="page-content container">
        <div class="wrapper">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="page-header">
                        {{-- <ul>
                            @foreach ($facilityRelations as $facilityRelation)
                                {{ $facilityRelation }}
                            @endforeach
                        </ul> --}}
                    </div>
                </div>
                <div class="col-md-3">
                    @can('create-position')
                        {{-- <a href="{{ route('positions.create') }}" class="btn btn-primary float-end"><i
                                class="bi bi-plus-circle"></i>
                            Add New
                            Position</a> --}}
                    @endcan
                </div>
            </div>
            <div class="whitebox">
                {{-- <table id="PositionsList" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Hierarchy</th>
                            
                        </tr>
                    </thead>
                </table> --}}
                <table id="PositionsList23" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Hierarchy</th>
                            {{-- <th>Child ID</th> --}}
                            {{-- <th>Created At</th>
                            <th>Updated At</th> --}}
                        </tr>
                    </thead>
                    {{-- <tbody>
                        @foreach ($facilityRelations as $relation)
                            <tr data-tt-id="{{ $relation->id }}" data-tt-parent-id="{{ $relation->parent_id }}">
                                <td>{{ $relation->parent_id }}</td>
                                <td>{{ $relation->child_id }}</td>
                                <td>{{ $relation->created_at }}</td>
                                <td>{{ $relation->updated_at }}</td>
                            </tr>
                        @endforeach
                    </tbody> --}}
                </table>
            </div>
        </div>
    </div>
    @push('javascript')
        {{-- <script>
            const positions = @json($facilityRelations);

            // Check if positions is an object with a data property
            const positionsData = positions.hasOwnProperty('data') ? positions.data : [];

            // Map the sorted positions to organisationData
            const organisationData = positionsData.map(position => ({
                tt_key: position.id,
                tt_parent: position.parent_id,
                name: position.name,
            }));
            console.log(organisationData);
            // Initializing TreeTable with the extracted data
            $('#PositionsList23').treeTable({
                "data": organisationData,
                "columns": [{
                        "data": "name"
                    },
                    // {
                    //     "data": "tt_key"
                    // }
                ],
                order: [
                    [1, 'asc'], // Sort by tt_key
                ]
            });
        </script> --}}
        <script>
            const positions = @json($facilityRelations);

            // Map the sorted positions to organisationData
            const organisationData = positions.map(position => ({
                tt_key: position.id,
                tt_parent: position.parent_id ? position.parent_id : 0,
                name: position.name,
            }));
            console.log(organisationData);
            // Initializing TreeTable with the extracted data
            $('#PositionsList23').treeTable({
                "data": organisationData,
                "columns": [{
                    "data": "name"
                }, ],
                order: [
                    [1, 'asc'],
                ]
            });
        </script>
    @endpush
@endsection
