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

                    <form class="form mb-2" action="{{ route('buying.buying.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-3 col-6 mb-2">
                                <label class="form-label fs-5" for="date_from">Date From</label>

                                <div class="input-group date" id="show_date_from" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#show_date_from" id="date_from" name="date_from" placeholder="DD-MMM-YYYY" value="{{ date('d-M-Y', strtotime($date_from)) }}"
                                    required/>
                                    <div class="input-group-append" data-target="#show_date_from" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div> 
                            </div>

                            <div class="col-md-3 col-6 mb-2">
                                <label class="form-label fs-5" for="date_to">To</label>

                                <div class="input-group date" id="show_date_to" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#show_date_to" id="date_to" name="date_to" placeholder="DD-MMM-YYYY" value="{{ date('d-M-Y', strtotime($date_to)) }}"
                                    required/>
                                    <div class="input-group-append" data-target="#show_date_to" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>                                    
                            </div>

                            <div class="col-md-6 mb-2 d-flex align-items-end">
                                <button type="submit" id="btnSearch" name="btnSearch" class="btn btn-primary">
                                    <i class="fa fa-search"></i>
                                </button>

                                @if ($provider::access('buying')->access[0]->can_create == 1)
                                    <button type="button" onclick='create()' class="ml-2 btn btn-dark">
                                        <i class="fa fa-plus"></i>
                                        <span class="ms-2">Create</span>
                                    </button>                            
                                @endif
                            </div>
                        </div>
                    </form>

                    <table id="example1" class="table table-bordered table-striped table-sm mt-2">
                        <thead>
                            <tr>
                                <th>PO No</th>
                                <th>Date Input</th>
                                <th>Supplier</th>
                                <th>Title</th>
                                <th>Payment</th>
                                <th>Grand Total</th>
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
                                        {{ date('d-M-Y', strtotime($data->date_input)) }}
                                    </td>
                                    <td>
                                        {{ $data['suppliers']['name'] }}
                                    </td>
                                    <td>
                                        {{ $data['title'] }}
                                    </td>
                                    <td>
                                        @if ($data['banks'])
                                            {{ $data['banks']['account_name'] }}                                            
                                        @else
                                            On Hand
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($data->subtotal, 0, '.', ',') }}
                                    </td>
                                    <td>
                                        {{ $data->updated_at }}
                                    </td>
                                    <td class="d-print-none">
                                        @if ($provider::access('buying')->access[0]->can_update == 1)
                                            <a href="{{ route('buying.buying.edit', $data->id) }}">
                                                <span class="badge bg-warning p-1"><i class="fa fa-edit"></i> Edit</span>
                                            </a>
                                        @endif

                                        @if ($provider::access('buying')->access[0]->can_delete == 1)
                                            <a onclick="return confirm('Are you sure?')"
                                                href="{{ route('buying.buying.destroy', $data->id) }}">
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

    <!-- / datetimepicker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection

@section('page-script')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <!-- / datetimepicker -->
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <script>
        $('#show_date_from').datetimepicker({
            format: 'DD-MMM-YYYY'
        });

        $('#show_date_to').datetimepicker({
            format: 'DD-MMM-YYYY'
        });

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
            window.location.href = "{{ route('buying.buying.create') }}";
        }

        loadData();
        function loadData() {
            var msg = {!! json_encode(Session::get('message')) !!};
            if (msg == 'update success') {
                toastr.warning(msg)
            }
        }        
    </script>
@endsection
