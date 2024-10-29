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
                                <th>User</th>
                                <th>Roles</th>
                                <th>Updated</th>
                                <th class="d-print-none">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($query as $data)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img class="rounded-circle" src="{{ $data->profile_photo_url }}" alt="avatar"
                                                height="45" width="45">
                                            <div class="ms-2">
                                                <p class="fw-bold mb-0">{{ $data->name }}</p>
                                                <p class="text-muted mb-0">
                                                    <a href="{{ route('admin.users.verify', $data->id) }}">
                                                        @if ($data->email_verified_at == null)
                                                            <span class="badge bg-danger my-1">Unverified</span>                             
                                                        @else
                                                            <span class="badge bg-success my-1">Verified</span>                                                        
                                                        @endif
                                                    </a>
                                                     {{ $data->email }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @foreach ($data->roles as $subdata)
                                            <span class="badge bg-primary my-1">{{ $subdata->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ $data->updated_at }}
                                    </td>
                                    <td class="d-print-none">
                                        <a href="{{ route('admin.users.resend', $data->id) }}">
                                            <span class="badge bg-success p-1"><i class="fa fa-envelope"></i> Resend</span>
                                        </a>    

                                        @if ($data->name != 'admin' && $data->name != 'Admin')                                            
                                            <a href="{{ route('admin.users.edit', $data->id) }}">
                                                <span class="badge bg-warning p-1"><i class="fa fa-edit"></i> Edit</span>
                                            </a>

                                            <a onclick="return confirm('Are you sure?')"
                                                href="{{ route('admin.users.destroy', $data->id) }}">
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
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
@endsection

@section('page-script')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

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
            window.location.href = "{{ route('admin.users.create') }}";
        }

        loadData();
        function loadData() {
            var msg = {!! json_encode(Session::get('message')) !!};
            if (msg == 'resend success' || msg == 'verify success' || msg == 'unverify success') {
                toastr.success(msg)
            }
        }         
    </script>
@endsection
