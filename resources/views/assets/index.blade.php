@extends('layouts.app')
@section('content')

<!-- Begin Page Content -->
<div class="page-content container">
    <div class="wrapper">
        <div class="row align-items-center">
            <div class="col-md-9">
                <div class="page-header">
                    <h3>Assets List</h3>
                </div>
            </div>
            <div class="col-md-3">
                <a data-bs-toggle="modal" data-bs-target="#CreateAssetModal" class="btn btn-primary float-end" style="cursor:pointer"><i class="bi bi-plus-circle"></i> Add New
                    Asset</a>
            </div>
            <!-- Modal Structure -->
            <div class="modal fade" id="CreateAssetModal" data-bs-keyboard="false" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h6 class="modal-title">Create New Asset</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                            <div class="row align-items-center justify-content-center">
                                @canany(['read-facility', 'create-facility', 'edit-facility', 'delete-facility'])
                                <div class="col-md-6">
                                    <a href="{{ route('facilities.create') }}" class="border-purple">
                                        <div class="d-flex">
                                            <span class="me-2"><img src="{{ asset('img/location_icon.png') }}" alt="img" class="img-fluid"></span>
                                            <span class="mt-2">Locations or Facilities</span>
                                        </div>
                                    </a>
                                </div>
                                @endcanany
                                @canany(['read-equipment', 'create-equipment', 'edit-equipment', 'delete-equipment'])
                                <div class="col-md-6">

                                    <a href="{{ route('equipments.create') }}" class="border-purple">
                                        <div class="d-flex">
                                            <span class="me-2"><img src="{{ asset('img/machine_icon.png') }}" alt="img" class="img-fluid"></span>
                                            <span class="mt-2">Equipment or Machines</span>
                                        </div>
                                    </a>
                                </div>
                                @endcanany
                                @canany(['read-tools', 'create-tools', 'edit-tools', 'delete-tools'])
                                <div class="col-md-6">
                                    <a href="{{ route('tools.create') }}" class="border-purple">
                                        <div class="d-flex">
                                            <span class="me-2"><img src="{{ asset('img/tool_icon.png') }}" alt="img" class="img-fluid"></span>
                                            <span class="mt-4">Tools</span>
                                        </div>
                                    </a>
                                </div>
                                @endcanany
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="whitebox">
            <table id="assetsList" class="table table-striped nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Hierarchy</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
            </table>
            </div>
        </div>
    </div>
    @push('javascript')
        <script>
            const positions = @json($assetRelations);

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
                    '<input type="button" class="tool_status btn btn-success" value="Active">' :
                    '<input type="button" class="tool_status btn btn-secondary" value="Disabled">',
                action: position.is_facility == 1 ?
                `<form id="deleteForm${position.id}" action="{{ route('facilities.destroy', '') }}/${position.id}" method="post">
                    @csrf
                    @method('DELETE')
                    
                    <a href="{{ url('facilities') }}/${position.id}/edit" class="link-primary">
                        <i class="fa-regular fa-pen-to-square"></i>
                    </a>
                    <button type="submit" class="link-danger" onclick="return confirm('Do you want to delete this facility?');">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </form>` : 
                (position.is_equipment == 1 ?
                    `<form id="deleteForm${position.id}" action="{{ route('equipments.destroy', '') }}/${position.id}" method="post">
                        @csrf
                        @method('DELETE')
                        <a href="{{ url('equipments') }}/${position.id}/edit" class="link-primary">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                        <button type="submit" class="link-danger" onclick="return confirm('Do you want to delete this equipment?');">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </form>` :
                    `<form id="deleteForm${position.id}" action="{{ route('tools.destroy', '') }}/${position.id}" method="post">
                        @csrf
                        @method('DELETE')
                        <a href="{{ url('tools') }}/${position.id}/edit" class="link-primary">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                        <button type="submit" class="link-danger" onclick="return confirm('Do you want to delete this tool?');">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </form>`)
            }));

            console.log('Organisation Data:', organisationData);

            // Initializing TreeTable with the extracted data
            $('#assetsList').treeTable({
                data: organisationData,
                columns: [
                    { data: "locationIcon" },
                    { data: "name" },
                    { data: "status" },
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