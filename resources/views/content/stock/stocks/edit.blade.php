@extends('layouts/app')
@section('title', $breadcrumbs[count($breadcrumbs) - 1]['name'])

@section('content')
    @include('layouts/panels/breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- Main content -->
    <section class="content d-print-none">
        <div class="container-fluid">

            <div class="card card-solid">
                <form class="form" action="{{ route('stock.stocks.update', $query->id) }}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="mb-2 d-flex justify-content-start justify-content-md-end d-print-none">
                            <button type="button" onclick="deleteData({{ $query->id }})" class="btn btn-danger mr-2">
                                <i class="fa fa-trash"></i>
                                <span class="ms-2">Delete</span>
                            </button>

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
                                    value="{{ $query->title }}" required />
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fs-5" for="date_input">Date Input</label>
                                <input type="date" class="form-control" id="date_input" name="date_input"
                                    placeholder="Date Input" value="{{ date('Y-m-d', strtotime($query->date_input)) }}"
                                    required />
                            </div>
                        </div>




                        <!--transaksi -->
                        <table class="table table-bordered table-striped table-sm mt-2">
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
                                @php
                                    $iNum = 1;
                                @endphp

                                <tr class="rowCount" id="rowCount_{{ $iNum }}">
                                    <th scope="row" hidden>
                                        <input type="text" class="form-control"
                                            id="temps[{{ $iNum }}][stock_id]"
                                            name="temps[{{ $iNum }}][stock_id]" placeholder="stock_id"
                                            value="{{ $query->id }}" />
                                    </th>
                                    <th scope="row" hidden>
                                        <input type="text" class="form-control" id="temps[{{ $iNum }}][id]"
                                            name="temps[{{ $iNum }}][id]" placeholder="id"
                                            value="{{ $query->prod_id }}" />
                                    </th>
                                    <td>
                                        <input type="text" class="form-control"
                                            onkeyup="handleEvt(event,this, {{ $iNum }})"
                                            id="temps[{{ $iNum }}][code]"
                                            name="temps[{{ $iNum }}][code]" placeholder="Code"
                                            value="{{ $query->products->code }}" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="temps[{{ $iNum }}][name]"
                                            name="temps[{{ $iNum }}][name]" placeholder="Product Name"
                                            value="{{ $query->products->code }}" disabled />
                                    </td>
                                    <td>
                                        <input type="number" step="any" class="form-control rate"
                                            id="temps[{{ $iNum }}][rate]"
                                            name="temps[{{ $iNum }}][rate]" placeholder="Rate"
                                            value="{{ $query->rate }}" onkeyup="calculateChange({{ $iNum }})"
                                            required />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control note"
                                            id="temps[{{ $iNum }}][note]"
                                            name="temps[{{ $iNum }}][note]" placeholder="note"
                                            value="{{ $query->note }}" />
                                    </td>
                                    <td class="d-print-none">
                                        <button type="button" class="btn btn-danger" id="btnDelete_{{ $iNum }}"
                                            name="btnDelete_{{ $iNum }}" onclick="deleteRow(event)">
                                            X
                                        </button>
                                    </td>
                                </tr>

                                @php
                                    $iNum = 2;
                                @endphp

                                <!-- new record -->
                                <tr class="rowCount" id="rowCount_{{ $iNum }}">
                                    <th scope="row" hidden>
                                        <input type="text" class="form-control"
                                            id="temps[{{ $iNum }}][stock_id]"
                                            name="temps[{{ $iNum }}][stock_id]" placeholder="stock_id"
                                            value="" />
                                    </th>
                                    <th scope="row" hidden>
                                        <input type="text" class="form-control" id="temps[{{ $iNum }}][id]"
                                            name="temps[{{ $iNum }}][id]" placeholder="id" value="" />
                                    </th>
                                    <td>
                                        <input type="text" class="form-control"
                                            onkeyup="handleEvt(event,this, {{ $iNum }})"
                                            id="temps[{{ $iNum }}][code]"
                                            name="temps[{{ $iNum }}][code]" placeholder="Code" value="" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="temps[{{ $iNum }}][name]"
                                            name="temps[{{ $iNum }}][name]" placeholder="Product Name"
                                            value="" disabled />
                                    </td>
                                    <td>
                                        <input type="number" step="any" class="form-control rate"
                                            id="temps[{{ $iNum }}][rate]"
                                            name="temps[{{ $iNum }}][rate]" placeholder="Rate" value="1"
                                            onkeyup="calculateChange({{ $iNum }})" required />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control note"
                                            id="temps[{{ $iNum }}][note]"
                                            name="temps[{{ $iNum }}][note]" placeholder="note" value="" />
                                    </td>
                                    <td class="d-print-none">
                                        <button type="button" class="btn btn-danger" id="btnDelete_{{ $iNum }}"
                                            name="btnDelete_{{ $iNum }}" onclick="deleteRow(event)">
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
                                    <button class="btn btn-primary me-2" type="submit">
                                        <i class="fa fa-save"></i>
                                        <span class="ms-2">Save</span>
                                    </button>
                                    <button type="button" onclick='cancelTrans({{ $query->id }})' class="btn btn-dark">
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
                                <th>Stock</th>
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
                                    <td>

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
@endsection

@section('page-script')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
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

        function cancelTrans(id) {
            var url = "{{ route('stock.stocks.edit', [':id']) }}";
            url = url.replace(':id', id);
            location.href = url;
        }

        function deleteData(id) {
            if (confirm('Are you sure?')) {
                var url = "{{ route('stock.stocks.destroy', [':id']) }}";
                url = url.replace(':id', id);
                location.href = url;
            }
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
