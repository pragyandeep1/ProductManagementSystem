@extends('layouts.app')
@section('content')
    @php
        // echo '<pre>';
        // echo json_encode($positions);
        // echo '</pre>';
    @endphp
    <!-- Begin Page Content -->
    <div class="page-content container">
        <div class="wrapper">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="page-header">
                        <h3>Manage Positions</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    @can('create-position')
                        <a href="{{ route('positions.create') }}" class="btn btn-primary float-end"><i
                                class="bi bi-plus-circle"></i>
                            Add New
                            Position</a>
                    @endcan
                </div>
            </div>
            <div class="whitebox">
                <table id="PositionsList" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Hierarchy</th>
                            {{-- <th>Name</th> --}}
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @push('javascript')
        <script>
            const positions = @json($positions);
            // Function to sort positions recursively within their parent-child relationship
            function sortPositions(positions) {
                // positions.sort((a, b) => {
                //     return a.id - b.id; // Sort positions by ID
                // });

                // Sort children recursively
                positions.forEach(position => {
                    if (position.children && position.children.length > 0) {
                        sortPositions(position.children);
                    }
                });
            }

            // Sort positions
            sortPositions(positions.data);

            // Function to flatten positions hierarchy
            function flattenPositions(positions) {
                let flattened = [];
                positions.forEach(position => {
                    flattened.push(position);
                    if (position.children && position.children.length > 0) {
                        flattened = flattened.concat(flattenPositions(position.children));
                    }
                });
                return flattened;
            }

            // Flatten positions hierarchy
            const flattenedPositions = flattenPositions(positions.data);

            // Map the sorted positions to organisationData
            const organisationData = flattenedPositions.map(position => ({
                tt_key: position.id,
                tt_parent: position.parent_id ? position.parent_id : 0,
                name: position.name,
                description: position.description,
                action: `<form id="deleteForm${position.id}" action="{{ route('positions.destroy', '') }}/${position.id}" method="post">
                @csrf
                @method('DELETE')
                <a href="{{ url('positions') }}/${position.id}/edit" class="link-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                <button type="submit" class="link-danger" onclick="return confirm('Do you want to delete this position?');"><i class="fa-solid fa-trash-can"></i></button>
            </form>`
            }));
            console.log(organisationData);
            // Initializing TreeTable with the extracted data
            $('#PositionsList').treeTable({
                "data": organisationData,
                "columns": [{
                        "data": "name"
                    },
                    // {
                    //     "data": "name"
                    // },
                    {
                        "data": "description"
                    },
                    {
                        "data": "action",
                        "render": function(data, type, row) {
                            return row.action;
                        }
                    }
                ],
                order: [
                    [1, 'asc'],
                ]
            });
        </script>
    @endpush
@endsection
