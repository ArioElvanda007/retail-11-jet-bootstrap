@extends('layouts/app')
@section('title', $breadcrumbs[count($breadcrumbs) - 1]['name'])
@inject('provider', 'App\Http\Controllers\Function\GlobalController')

@section('content')
    @include('layouts/panels/breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-solid">
                <div class="card-body">
                    <table id="example1" class="table table-sm table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Account Code</th>
                                <th>Account Name</th>
                                <th>Position</th>
                                <th>Descript</th>
                                <th>Updated</th>
                                <th class="d-print-none">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($query as $data)
                                <tr>
                                    <td>
                                        {{ $data->code }}
                                    </td>
                                    <td>
                                        {{ $data->name }}
                                    </td>
                                    <td>
                                        {{ $data->position }}
                                    </td>
                                    <td>
                                        {{ $data->description }}
                                    </td>
                                    <td>
                                        {{ $data->updated_at }}
                                    </td>
                                    <td class="d-print-none">
                                        @if ($provider::access('accounts')->access[0]->can_update == 1)
                                            <a href="{{ route('accounting.accounts.edit', $data->id) }}">
                                                <span class="badge bg-warning p-1"><i class="fa fa-edit"></i> Edit</span>
                                            </a>
                                        @endif

                                        @if ($provider::access('accounts')->access[0]->can_delete == 1)
                                            <a onclick="return confirm('Are you sure?')"
                                                href="{{ route('accounting.accounts.destroy', $data->id) }}">
                                                <span class="badge bg-danger p-1"><i class="fa fa-trash"></i> Delete</span>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.css') }}">

    <style>
        button.colorCreate,
        a.colorCreate {
            color: white !important;
            background-color: black !important;
        },        
    </style>     
@endsection

@section('page-script')
    <script src="{{ asset('assets/plugins/datatables/dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script>
        $("#example1").DataTable({
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
            pageLength: 100,
            scrollY: true,
            
            buttons: [{
                    text: '+ Create',
                    className: 'colorCreate',
                    action: function(e, dt, node, config) {
                        create();
                    }
                },
                'pageLength',
                {
                    extend: 'collection',
                    text: 'Control',
                    buttons: [
                        'copy', 'excel', 'print',
                        {
                            text: 'Visibility',
                            popoverTitle: 'Control',
                            extend: 'colvis',
                            collectionLayout: 'two-column',
                            postfixButtons: ['colvisRestore']
                        }
                    ]
                }           
            ],
            layout: {
                topStart: ['buttons']
            }
        });  

        function create() {
            var can_access = {!! json_encode($provider::access('accounts')->access[0]->can_create) !!};
            if (can_access == 0) {
                alert("Access denied");
                return;
            }

            window.location.href = "{{ route('accounting.accounts.create') }}";
        }
    </script>
@endsection
