@extends('layouts/app')
@section('title', $breadcrumbs[count($breadcrumbs) - 1]['name'])

@section('content')
    @include('layouts/panels/breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-solid">
                <form class="form" action="{{ route('accounting.cashflows.store') }}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label fs-5" for="code">Slip</label>
                                        <input type="text" class="form-control" id="code" name="code"
                                            placeholder="Slip" value="{{ $invoice }}" disabled required />
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label class="form-label fs-5" for="date_input">Date Input</label>
                                        
                                        <div class="input-group date" id="show_date_input" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" data-target="#show_date_input" id="date_input" name="date_input" placeholder="DD-MMM-YYYY" value="{{ date('d-M-Y', strtotime($date_input)) }}"
                                            required/>
                                            <div class="input-group-append" data-target="#show_date_input" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label class="form-label fs-5" for="title">Title</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            placeholder="Title" value="" autofocus required />
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label class="form-label fs-5" for="debet">Debet</label>
                                        <input type="number" step="any" class="form-control" id="debet"
                                            name="debet" placeholder="Debet" value="0" required />
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label class="form-label fs-5" for="credit">Credit</label>
                                        <input type="number" step="any" class="form-control" id="credit"
                                            name="credit" placeholder="Credit" value="0" required />
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label class="form-label fs-5" for="bank_id">Method</label>
                                        <select class="mt-2 form-control bankSelect2" style="width: 100%;" name="bank_id"
                                            id="bank_id" required>
                                            <option value="0" selected="selected">On Hand</option>
                                            @foreach ($banks as $data)
                                                <option value="{{ $data->id }}">
                                                    {{ $data->account_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">

                            </div>
                        </div>
                    </div>

                    <div class="p-2 card-footer d-print-none">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary me-2" type="submit">
                                <i class="fa fa-save"></i>
                                <span class="ms-2">Save</span>
                            </button>
                            <button type="button" onclick='backToList()' class="btn btn-dark">
                                <i class="fa fa-share"></i>
                                <span class="ms-2">Cancel</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">

    <!-- / datetimepicker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection

@section('page-script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <!-- / datetimepicker -->
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <script>
        $('#show_date_input').datetimepicker({
            format: 'DD-MMM-YYYY'
        });

        $('.bankSelect2').select2({
            theme: 'bootstrap4'
        })

        loadData();
        function loadData() {
            var msg = {!! json_encode(Session::get('message')) !!};
            if (msg == 'create success') {
                toastr.success(msg)
            }
        }

        function backToList() {
            window.location.href = "{{ route('accounting.cashflows.index') }}";
        }
    </script>
@endsection
