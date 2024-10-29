@extends('layouts.app')
@section('content')
    <!-- Begin Page Content -->
    <div class="page-content container">
        <div class="wrapper">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="page-header">
                        <h3>Equipment List</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    @can('create-equipment')
                        <a href="{{ route('equipments.create') }}" class="btn btn-primary float-end"><i class="bi bi-plus-circle"></i> Add New Equipment</a>
                    @endcan
                </div>
            </div>
            <div class="whitebox">
                <table id="equipmentList" class="table table-striped">
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
            const positions = @json($equipmentRelations);

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
                    '<button type="button" class="equipment_status btn btn-success" data-id="' + position.id + '" data-status="0">Active</button>' :
                    '<button type="button" class="equipment_status btn btn-secondary" data-id="' + position.id + '" data-status="1">Disabled</button>',
                action: position.is_facility == 1 ? 
                    `<form id="deleteForm${position.id}" action="{{ route('facilities.destroy', '') }}/${position.id}" method="post">
                        @csrf
                        @method('DELETE')
                        <a href="{{ url('facilities') }}/${position.id}/edit" class="link-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                        <button type="submit" class="link-danger" onclick="return confirm('Do you want to delete this facility?');"><i class="fa-solid fa-trash-can"></i></button>
                    </form>`:
                    `<form id="deleteForm${position.id}" action="{{ route('equipments.destroy', '') }}/${position.id}" method="post">
                        @csrf
                        @method('DELETE')
                        <a href="{{ url('equipments') }}/${position.id}/edit" class="link-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                        <button type="submit" class="link-danger" onclick="return confirm('Do you want to delete this equipment?');"><i class="fa-solid fa-trash-can"></i></button>
                    </form>`
            }));

            // Initializing TreeTable with the extracted data
            $('#equipmentList').treeTable({
                data: organisationData,
                columns: [
                    {data: "locationIcon"},
                    {data: "name"},
                    {data: "status"},
                    {
                        data: "action",
                        render: function(data, type, row) {
                            return row.action;
                        }
                    }
                ],
                order: [[1, 'asc']],
                "columnDefs": [
                    { "orderable": false, "targets": [2, 3] }
                ]
            });
        </script>
    @endpush
@endsection
