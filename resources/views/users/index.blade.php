@extends('layouts.app')
@section('content')
    <!-- Begin Page Content -->
    <div class="page-content container">
        <div class="wrapper">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="page-header">
                        <h3>Manage Users</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    @can('create-user')
                        <a href="{{ route('users.create') }}" class="btn btn-primary float-end"><i class="bi bi-plus-circle"></i>
                            Add New
                            User</a>
                    @endcan
                </div>
            </div>
            <div class="whitebox">
                <table id="UsersList" class="table table-striped nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">S#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Roles</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td><a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @forelse ($user->getRoleNames() as $role)
                                        <span class="badge bg-primary">{{ $role }}</span>
                                    @empty
                                    @endforelse
                                </td>
                                <td>
                                    {{-- {{$user->userInfo}} --}}
                                    @if ($user->userInfo && $user->userInfo->status !== null)
                                        @if ($user->userInfo->status == 1)
                                            <input type="button" class="user_status btn btn-success"
                                                id="userstatus{{ $user->id }}"
                                                @can('edit-user') onclick="ChangeStatus('{{ $user->id }}')" @endcan
                                                value="Active">
                                        @else
                                            <input type="button" class="user_status btn btn-secondary"
                                                id="userstatus{{ $user->id }}"
                                                @can('edit-user') onclick="ChangeStatus('{{ $user->id }}')" @endcan
                                                value="Disabled">
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        {{-- <a href="{{ route('users.show', $user->id) }}" class="btn btn-warning btn-sm"><i
                                                class="bi bi-eye"></i></a> --}}

                                        @if (in_array('Super Admin', $user->getRoleNames()->toArray() ?? []))
                                            @if (Auth::user()->hasRole('Super Admin'))
                                                <a href="{{ route('users.edit', $user->id) }}" class="link-primary"><i
                                                        class="fa-regular fa-pen-to-square"></i></a>
                                            @endif
                                        @else
                                            @can('edit-user')
                                                <a href="{{ route('users.edit', $user->id) }}" class="link-primary"><i
                                                        class="fa-regular fa-pen-to-square"></i></a>
                                            @endcan

                                            @can('delete-user')
                                                @if (Auth::user()->id != $user->id)
                                                    <button type="submit" class="link-danger"
                                                        onclick="return confirm('Do you want to delete this user?');"><i
                                                            class="fa-solid fa-trash-can"></i></button>
                                                @endif
                                            @endcan
                                        @endif

                                    </form>
                                </td>
                            </tr>
                        @empty
                            <td></td>
                            <td></td>
                            <td>
                                <span class="text-danger">
                                    <strong>No User Found!</strong>
                                </span>
                            </td>
                            <td></td>
                            <td></td>
                        @endforelse
                    </tbody>
                </table>

                {{-- {{ $users->links() }} --}}

            </div>
        </div>
    </div>
    @push('javascript')
        <script>
            function ChangeStatus(id) {
                var statusElement = $('#userstatus' + id);

                if (statusElement.val() == 'Disabled') {
                    statusElement.removeClass('btn-secondary');
                    statusElement.addClass('btn-success');
                } else {
                    statusElement.removeClass('btn-success');
                    statusElement.addClass('btn-secondary');
                }
                var StausVal = $('#userstatus' + id).val();
                if (StausVal == 'Active') {
                    var StausVal2 = 0;
                } else if (StausVal == 'Disabled') {
                    var StausVal2 = 1;
                }
                // alert('status is changed for' + id + 'and value is' + StausVal);
                $.ajax({
                    url: "{{ url('ChangeStatus') }}/" + id,
                    type: "POST",
                    data: {
                        status: StausVal2,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.success) {
                            statusElement.val(res.value);
                            Swal.fire({
                                icon: 'success',
                                title: 'Status Updated!',
                                text: res.message,
                                showConfirmButton: false,
                                timer: 2000
                            });
                            // console.log('Status updated successfully');
                        } else {
                            console.log('Failed to update status');
                        }
                    },
                    error: function() {
                        alert('Error updating status');
                    }
                });
            }
        </script>
    @endpush
@endsection
