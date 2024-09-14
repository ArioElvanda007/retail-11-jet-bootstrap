@extends('layouts/app')
@section('title', $breadcrumbs[count($breadcrumbs) - 1]['name'])

@section('content')
    @include('layouts/panels/breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-solid">
                <div class="card-body">

                    <form class="form mb-2" action="{{ route('stock.stocks.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-3 col-6 mb-2">
                                <label class="form-label fs-5" for="date_from">Date From</label>
                                <input type="date" class="form-control" id="date_from" name="date_from"
                                    placeholder="Date From" value="{{ date('Y-m-d', strtotime($date_from)) }}" required />
                            </div>

                            <div class="col-md-3 col-6 mb-2">
                                <label class="form-label fs-5" for="date_to">To</label>
                                <input type="date" class="form-control" id="date_to" name="date_to" placeholder="To"
                                    value="{{ date('Y-m-d', strtotime($date_to)) }}" required />
                            </div>

                            <div class="col-md-6 mb-2 d-flex align-items-end">
                                <button type="submit" id="btnSearch" name="btnSearch" class="btn btn-primary">
                                    <i class="fa fa-search"></i>
                                </button>

                                <button type="button" onclick='create()' class="ml-2 btn btn-dark">
                                    <i class="fa fa-plus"></i>
                                    <span class="ms-2">Create</span>
                                </button>
                            </div>
                        </div>
                    </form>

                    <table id="example1" class="table table-bordered table-striped table-sm mt-2">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date Input</th>
                                <th>Product</th>
                                <th>Stock</th>
                                <th>Rate</th>
                                <th>Adjust</th>
                                <th>Note</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th class="d-print-none">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($query as $data)
                                <tr>
                                    <td>
                                        {{ $data->title }}
                                    </td>
                                    <td>
                                        {{ date('Y-m-d', strtotime($data->date_input)) }}
                                    </td>
                                    <td>
                                        {{ $data['products']['name'] }}
                                    </td>
                                    <td>
                                        {{ $data->stock }}
                                    </td>
                                    <td>
                                        {{ $data->adjust }}
                                    </td>
                                    <td>
                                        {{ $data->rate }}
                                    </td>
                                    <td>
                                        {{ $data->note }}
                                    </td>
                                    <td>
                                        {{ $data->created_at }}
                                    </td>
                                    <td>
                                        {{ $data->updated_at }}
                                    </td>
                                    <td class="d-print-none">
                                        <a href="{{ route('stock.stocks.edit', $data->id) }}">
                                            <span class="badge bg-warning p-1"><i class="fa fa-edit"></i> Edit</span>
                                        </a>

                                        <a onclick="return confirm('Are you sure?')"
                                            href="{{ route('stock.stocks.destroy', $data->id) }}">
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
            window.location.href = "{{ route('stock.stocks.create') }}";
        }

        loadData();
        function loadData() {
            var msg = {!! json_encode(Session::get('message')) !!};
            if (msg == 'update success') {
                toastr.warning(msg)
            }
            else if (msg == 'delete success') {
                toastr.error(msg)
            }
        }        
    </script>
@endsection
