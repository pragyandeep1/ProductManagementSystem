@extends('layouts.app')
@push('css')
@endpush
@section('content')
    <!-- Begin Page Content -->
    <div class="page-content container">
        <div class="wrapper">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="page-header">
                        <h3>Facilities List</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    @can('create-facility')
                        <a href="{{ route('facilities.create') }}" class="btn btn-primary float-end"><i
                                class="bi bi-plus-circle"></i>
                            Add New Facility</a>
                    @endcan
                </div>
            </div>
            <div class="whitebox">
                <table id="facilityList" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Location</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @push('javascript')
        <script>
            const positions = @json($facilityRelations);

            // Function to return the appropriate icon HTML based on the position type
            function getIconHtml(type) {
                let iconHtml = '';
                if (type === 'facility') {
                    iconHtml = '<span class="me-2"><img src="{{ asset('img/location_icon.png') }}" alt="img" class="img-fluid" style="width: 24px;height: 24px;"></span>';
                } else if (type === 'equipment') {
                    iconHtml = '<span class="me-2"><img src="{{ asset('img/machine_icon.png') }}" alt="img" class="img-fluid" style="width: 24px;height: 24px;"></span>';
                } else if (type === 'tools') {
                    iconHtml = '<span class="me-2"><img src="{{ asset('img/tool_icon.png') }}" alt="img" class="img-fluid" style="width: 24px;height: 24px;"></span>';
                }
                return iconHtml;
            }

            // Map the sorted positions to organisationData
            const organisationData = positions.map(position => ({
                tt_key: position.id,
                tt_parent: position.parent_id ? position.parent_id : 0,
                locationIcon: getIconHtml(position.type) + position.name,
                name: position.name,
                status: position.status == 1 ?
                    `<input type="button" data-id="${position.id}" class="facility_status btn btn-success" value="Active">` :
                    `<input type="button" data-id="${position.id}" class="facility_status btn btn-secondary" value="Disabled">`,
                action: `<form id="deleteForm${position.id}" action="{{ route('facilities.destroy', '') }}/${position.id}" method="post">
                @csrf
                @method('DELETE')
                <a href="{{ url('facilities') }}/${position.id}/edit" class="link-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                <button type="submit" class="link-danger" onclick="return confirm('Do you want to delete this facility?');"><i class="fa-solid fa-trash-can"></i></button>
            </form>`
            }));

            // Debugging output
            console.log("Organisation Data:", organisationData);

            // Initializing TreeTable with the extracted data
            $('#facilityList').treeTable({
                "data": organisationData,
                "columns": [
                    { "data": "locationIcon" },
                    { "data": "name" },
                    { "data": "status" },
                    { 
                        "data": "action",
                        "render": function(data, type, row) {
                            return row.action;
                        }
                    }
                ],
                order: [
                    [1, 'asc']
                ],
                "columnDefs": [
                    { "orderable": false, "targets": [2, 3] }
                ]
            });
        </script>
    @endpush
@endsection
