@extends('layouts/app')
@section('title', $breadcrumbs[count($breadcrumbs) - 1]['name'])
@inject('provider', 'App\Http\Controllers\Function\GlobalController')

@section('content')
    @include('layouts/panels/breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- Main content -->
    <section class="content d-print-none">
        <div class="container-fluid">

            <div class="card card-solid">
                <form class="form" action="{{ route('stock.stocks.store') }}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="mb-2 d-flex justify-content-start justify-content-md-end d-print-none">
                            <button type="button" onclick='backToList()' class="btn btn-dark">
                                <i class="fa fa-share"></i>
                                <span class="ms-2">Back To List</span>
                            </button>
                        </div>

                        <!--hader po & date -->
                        <div class="row">
                            <div class="col-md-9">
                                <label class="form-label fs-5" for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                                    value="" required />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fs-5" for="date_input">Date Input</label>

                                <div class="input-group date" id="show_date_input" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#show_date_input" id="date_input" name="date_input" placeholder="DD-MMM-YYYY" value="{{ date('d-M-Y', strtotime($date_input)) }}"
                                    required/>
                                    <div class="input-group-append" data-target="#show_date_input" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>                                         
                            </div>
                        </div>




                        <!--transaksi -->
                        <table class="table table-bordered table-striped table-responsive text-nowrap table-sm mt-2">
                            <thead>
                                <tr>
                                    <th scope="col" hidden>StockID</th>
                                    <th scope="col" hidden>ID</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Rate</th>
                                    <th scope="col">Note</th>
                                    <th scope="col" class="d-print-none">
                                        <button type="button" id="btnProduct" name="btnProduct" class="btn btn-primary">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="use-tBody">
                                <tr class="rowCount" id="rowCount_1">
                                    <th scope="row" hidden>
                                        <input type="text" class="form-control" id="temps[1][stock_id]"
                                            name="temps[1][stock_id]" placeholder="stock_id" value="" />
                                    </th>
                                    <th scope="row" hidden>
                                        <input type="text" class="form-control" id="temps[1][id]" name="temps[1][id]"
                                            placeholder="id" value="" />
                                    </th>
                                    <td>
                                        <input type="text" class="form-control" onkeyup="handleEvt(event,this, 1)"
                                            id="temps[1][code]" name="temps[1][code]" placeholder="Code" value="" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="temps[1][name]" name="temps[1][name]"
                                            placeholder="Product Name" value="" disabled />
                                    </td>
                                    <td>
                                        <input type="number" step="any" class="form-control rate" id="temps[1][rate]"
                                            name="temps[1][rate]" placeholder="Rate" value="1"
                                            onkeyup="calculateChange(1)" required />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control note" id="temps[1][note]"
                                            name="temps[1][note]" placeholder="note" value="" />
                                    </td>
                                    <td class="d-print-none">
                                        <button type="button" class="btn btn-danger" id="btnDelete_1" name="btnDelete_1"
                                            onclick="deleteRow(event)">
                                            X
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="row" colspan="2">Total</th>
                                    <td>
                                        <input type="number" step="any" class="form-control" id="rateTotal"
                                            name="rateTotal" placeholder="Rate" value="0" disabled />
                                    </td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>




                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-end d-print-none">
                                    @if ($provider::access('adjustment')->access[0]->can_create == 1)
                                        <button class="btn btn-primary me-2" type="submit">
                                            <i class="fa fa-save"></i>
                                            <span class="ms-2">Save</span>
                                        </button>
                                    @endif
                                    
                                    <button type="button" onclick='cancelTrans()' class="btn btn-dark">
                                        <i class="fa fa-refresh"></i>
                                        <span class="ms-2">Cancel</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->



    <!--/ Product Modal -->
    <div class="modal fade" id="frmProduct">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Products</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="example1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Product</th>
                                <th class="d-print-none">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $data)
                                <tr>
                                    <td>
                                        {{ $data->code }}
                                    </td>
                                    <td>
                                        {{ $data->name }}
                                    </td>
                                    <td class="d-print-none">
                                        <button type="button" class="btn btn-primary btn-sm"
                                            onclick="selectProduct({{ $data }})">
                                            Select
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer d-flex justify-content-start justify-content-md-end d-print-none">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- / Product Modal -->
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">

    <!-- / datetimepicker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection

@section('page-script')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    <!-- / datetimepicker -->
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <script>
        $('#show_date_input').datetimepicker({
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

        loadData();

        function loadData() {
            var msg = {!! json_encode(Session::get('message')) !!};
            if (msg == 'create success') {
                toastr.success(msg)
            }
        }

        document.getElementById('temps[1][code]').focus();

        // disable textbox enter type text (handle submit)
        $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                return false;
            }
        });

        // disable textbox enter type number (handle submit)
        $(document).on('keyup keypress', 'form input[type="number"]', function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                return false;
            }
        });

        function backToList() {
            window.location.href = "{{ route('stock.stocks.index') }}";
        }

        function cancelTrans() {
            window.location.href = "{{ route('stock.stocks.create') }}";
        }

        $("#btnProduct").click(function() {
            $('#frmProduct').modal('toggle')
        });

        //where 13 is the enter button
        function handleEvt(e, obj, pid) {
            if (e.keyCode === 13) {
                if (e.target.name == "temps[" + pid + "][code]") {
                    v = $(obj).val();
                    showProduct(v, pid);
                }
            }
        }

        function selectProduct(data) {
            var total_element = $(".rowCount").length;
            var rows = 1;

            if (total_element > 0) {
                var lastid = $(".rowCount:last").attr("id");
                var split_id = lastid.split("_");
                rows = Number(split_id[1]); // + 1;
            }

            document.getElementById('temps[' + rows + '][code]').value = data['code'];
            showProduct(data['code'], rows);
        }

        function showProduct(value, index) {
            if (value) {
                $.ajax({
                    dataType: 'json',
                    type: "GET",
                    url: '{{ env('APP_URL') }}' + "/api/global/select-product-code/" + value,

                    success: function(res) {
                        if (res) {
                            if (res.id != undefined) {
                                document.getElementById('temps[' + index + '][id]').value = res.id;
                                document.getElementById('temps[' + index + '][name]').value = res.name;
                                document.getElementById('temps[' + index + '][rate]').value = 1;
                                document.getElementById('temps[' + index + '][note]').value = "";

                                addNewRow();
                            } else {
                                alert('Data not found');

                                document.getElementById('temps[' + index + '][stock_id]').value = "";
                                document.getElementById('temps[' + index + '][id]').value = "";
                                document.getElementById('temps[' + index + '][name]').value = "";
                                document.getElementById('temps[' + index + '][rate]').value = 0;
                                document.getElementById('temps[' + index + '][note]').value = "";
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error API connection');
                        return;
                    }
                });
            }
        }

        function addNewRow() {
            var total_element = $(".rowCount").length;
            var rows = 1;

            if (total_element > 0) {
                var lastid = $(".rowCount:last").attr("id");
                var split_id = lastid.split("_");
                rows = Number(split_id[1]) + 1;
            }

            $("#use-tBody").append(
                '<tr class="rowCount" id="rowCount_' + rows + '">' +
                '<th scope="row" hidden>' +
                '<input type="text" class="form-control" id="temps[' + rows + '][stock_id]" name="temps[' + rows +
                '][stock_id]" placeholder="stock_id" value="" />' +
                '</th>' +
                '<th scope="row" hidden>' +
                '<input type="text" class="form-control" id="temps[' + rows + '][id]" name="temps[' + rows +
                '][id]" placeholder="id" value="" />' +
                '</th>' +
                '<td>' +
                '<input type="text" class="form-control" onkeyup="handleEvt(event,this, ' + rows + ')" id="temps[' +
                rows + '][code]" name="temps[' + rows + '][code]" placeholder="Code" value="" />' +
                '</td>' +
                '<td>' +
                '<input type="text" class="form-control" id="temps[' + rows + '][name]" name="temps[' + rows +
                '][name]" placeholder="Product Name" value="" disabled />' +
                '</td>' +
                '<td>' +
                '<input type="number" step="any" class="form-control rate" id="temps[' + rows +
                '][rate]" name="temps[' + rows + '][rate]" placeholder="Rate" value="0" onkeyup="calculateChange(' +
                rows + ')" required />' +
                '</td>' +
                '<td>' +
                '<input type="text" class="form-control note" id="temps[' + rows +
                '][note]" name="temps[' + rows +
                '][note]" placeholder="note" value="" />' +
                '</td>' +
                '<td class="d-print-none">' +
                '<button type="button" class="btn btn-danger" id="btnDelete_' + rows + '" name="btnDelete_' + rows +
                '" onclick="deleteRow(event)">X' +
                '</button>' +
                '</td>' +
                '</tr>'
            );

            document.getElementById('temps[' + rows + '][code]').focus();
            calculateChange(rows);
        }

        function deleteRow(event) {
            var total_element = $(".rowCount").length;
            var rowsLast = 1;

            if (total_element > 0) {
                var lastid = $(".rowCount:last").attr("id");
                var split_id = lastid.split("_");
                rowsLast = Number(split_id[1]);
            }

            var indexBtn = Number(event.target.name.split("_")[1]);

            if (rowsLast != indexBtn) {
                event.target.parentNode.parentNode.remove();
            }

            var result = calculateSubTotal()
            $("#rateTotal").val(result[0]);
        }

        function calculateChange(rows) {
            var rate = document.getElementById('temps[' + rows + '][rate]').value;

            var result = calculateSubTotal()
            $("#rateTotal").val(result[0]);
        }

        function calculateSubTotal() {
            var totalRate = 0;
            $('.rate').each(function() {
                totalRate += parseFloat($(this).val());
            });

            return [totalRate];
        }
    </script>
@endsection
