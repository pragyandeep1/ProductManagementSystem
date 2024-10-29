@extends('layouts.app')
@section('content')
    <!-- Begin Page Content -->
    <div class="page-content container">
        <div class="wrapper">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <div class="page-header">
                        <h3>Meter Unit List</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    {{-- @can('create-business') --}}
                    <a href="javascript:void(0)" class="btn btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#addjob"><i class="bi bi-plus-circle"></i>
                        Add New
                    </a>
                    {{-- @endcan --}}
                </div>
            </div>
            <div class="whitebox">
                <table class="datatable table align-middle table-nowrap table-check" id="meter-table">
                    <thead>
                        <tr class="ligth">
                            <th>Sl</th>
                            <th width="35%">Name</th>
                            <th>Symbol</th>
                            <th>Status</th>
                            <th class="">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {{-- -------------------------------------------View Mdal------------------------ --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="view-modal" aria-labelledby="staticBackdropLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body" id="view_modal_body">
                </div>
            </div>
        </div>
    </div>
    {{-- ---------------------- View Mdal End--------------------- --}}

    {{-- ------------------------Edit Mdal------------------------ --}}

    <div class="modal fade" id="editjob-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body" id="edit_modal_body">
                </div>
            </div>
        </div>
    </div>
    {{-- ---------------------- Edit Mdal End--------------------- --}}
    @include('meterunits.add')

    @push('javascript')
        <script type="text/javascript">
            $(function() {
                var i = 1;
                $('#meter-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('meter.index') }}",

                    columns: [{
                            data: null,
                            render: function(data, type, row, meta) {
                                // This function generates serial numbers starting from 1
                                return meta.row + 1;
                            },
                            orderable: false, // This makes the serial number column not orderable
                            searchable: false // This makes the serial number column not searchable
                        },
                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'symbol',
                            name: 'symbol',
                        },
                        {
                            data: 'status',
                            name: 'status',
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    // This callback function ensures that the serial number column is updated whenever the table is redrawn
                    createdRow: function(row, data, index) {
                        $('td', row).eq(0).attr('data-label',
                            'Serial Number'
                        ); // This adds a data-label attribute to the serial number column for accessibility
                    }
                });
            });
        </script>
    @endpush
@endsection
