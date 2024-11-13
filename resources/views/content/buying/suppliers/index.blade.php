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

                    @if ($provider::access('suppliers')->access[0]->can_create == 1)
                        <div class="mb-2 d-flex justify-content-start justify-content-md-end d-print-none">
                            <button type="button" onclick='create()' class="btn btn-dark">
                                <i class="fa fa-plus"></i>
                                <span class="ms-2">Create</span>
                            </button>
                        </div>                          
                    @endif

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Telp</th>
                                <th>Descript</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th class="d-print-none">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($query as $data)
                                <tr>
                                    <td>
                                        {{ $data->name }}
                                    </td>
                                    <td>
                                        {{ $data->address }}
                                    </td>
                                    <td>
                                        {{ $data->email }}
                                    </td>
                                    <td>
                                        {{ $data->telephone }}
                                    </td>
                                    <td>
                                        {{ $data->description }}
                                    </td>
                                    <td>
                                        {{ $data->created_at }}
                                    </td>
                                    <td>
                                        {{ $data->updated_at }}
                                    </td>
                                    <td class="d-print-none">
                                        @if ($provider::access('suppliers')->access[0]->can_update == 1)
                                            <a href="{{ route('buying.suppliers.edit', $data->id) }}">
                                                <span class="badge bg-warning p-1"><i class="fa fa-edit"></i> Edit</span>
                                            </a>
                                        @endif

                                        @if ($provider::access('suppliers')->access[0]->can_delete == 1)
                                            @if ($data->id != 1)
                                                <a onclick="return confirm('Are you sure?')"
                                                    href="{{ route('buying.suppliers.destroy', $data->id) }}">
                                                    <span class="badge bg-danger p-1"><i class="fa fa-trash"></i> Delete</span>
                                                </a>
                                            @endif
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
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection

@section('page-script')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script>
        $("#example1").DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

        function create() {
            window.location.href = "{{ route('buying.suppliers.create') }}";
        }
    </script>
@endsection
