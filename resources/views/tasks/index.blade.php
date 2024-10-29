@extends('layouts.app')
@section('content')
    <!-- Begin Page Content -->
    <div class="page-content container">
        <div class="wrapper">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="page-header">
                        <h3>Task List</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    @can('create-tasks')
                        <a href="#" class="btn btn-primary float-end"><i class="bi bi-plus-circle"></i>
                            Add New Task</a>
                    @endcan
                </div>
            </div>
            <div class="whitebox">
                <table id="taskList" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Code</th>
                            <th scope="col">Status</th>
                            <th scope="col">Asset Location</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    {{--@push('javascript')
        <script>
            const positions = @json($tasks);

            // Map the sorted positions to organisationData
            const organisationData = positions.map(position => ({
                tt_key: position.id,
                tt_parent: position.parent_id ? position.parent_id : 0,
                name: position.name,

                status: position.status == 1 ?
                    '<input type="button" class="task_status btn btn-success" value="Active">' :
                    '<input type="button" class="task_status btn btn-secondary" value="Disabled">',
                action: position.is_facility == 1 ?
                `<form id="deleteForm${position.id}" action="{{ route('facilities.destroy', '') }}/${position.id}" method="post">

                @csrf
                @method('DELETE')
                
                <a href="{{ url('facilities') }}/${position.id}/edit" class="link-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                <button type="submit" class="link-danger" onclick="return confirm('Do you want to delete this facility?');"><i class="fa-solid fa-trash-can"></i></button>
            </form>`: 
            (position.is_equipment == 1 ?
                `<form id="deleteForm${position.id}" action="{{ route('equipments.destroy', '') }}/${position.id}" method="post">
                @csrf
                @method('DELETE')
                <a href="{{ url('equipments') }}/${position.id}/edit" class="link-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                <button type="submit" class="link-danger" onclick="return confirm('Do you want to delete this equipment?');"><i class="fa-solid fa-trash-can"></i></button>
            </form>`:
               `<form id="deleteForm${position.id}" action="{{ route('tasks.destroy', '') }}/${position.id}" method="post">
                @csrf
                @method('DELETE')
                <a href="{{ url('tasks') }}/${position.id}/edit" class="link-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                <button type="submit" class="link-danger" onclick="return confirm('Do you want to delete this task?');"><i class="fa-solid fa-trash-can"></i></button>
            </form>`)  
            }));
            
            // Initializing TreeTable with the extracted data
            $('#taskList').treeTable({
                data: organisationData,
                columns: [
                    {data: "name"},
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

                initialState: 'collapsed'
            });
        </script>
    @endpush--}}
@endsection
