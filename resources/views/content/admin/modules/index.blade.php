@extends('layouts/app')
@section('title', $breadcrumbs[count($breadcrumbs) - 1]['name'])

@section('content')
    @include('layouts/panels/breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-solid">
                <div class="card-body">

                    <div class="mb-2 d-flex justify-content-start justify-content-md-end d-print-none">
                        <button type="button" onclick='create()' class="btn btn-dark">
                            <i class="fa fa-plus"></i>
                            <span class="ms-2">Create</span>
                        </button>
                    </div>

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Descript</th>
                                <th>Active</th>
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
                                        {{ $data->description }}
                                    </td>
                                    <td>
                                        {{-- <input type="checkbox" @if ($data->is_active === 1) checked @endif disabled /> --}}
                                        {{ $data->is_active }}
                                    </td>
                                    <td>
                                        {{ $data->updated_at }}
                                    </td>
                                    <td class="d-print-none">
                                        <a href="{{ route('admin.modules.edit', $data->id) }}">
                                            <span class="badge bg-warning p-1"><i class="fa fa-edit"></i> Edit</span>
                                        </a>

                                        <a onclick="return confirm('Are you sure?')"
                                            href="{{ route('admin.modules.destroy', $data->id) }}">
                                            <span class="badge bg-danger p-1"><i class="fa fa-trash"></i> Delete</span>
                                        </a>
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
            window.location.href = "{{ route('admin.modules.create') }}";
        }
    </script>
@endsection
