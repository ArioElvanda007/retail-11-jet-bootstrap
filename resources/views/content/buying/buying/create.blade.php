@extends('layouts/app')
@section('title', $breadcrumbs[count($breadcrumbs) - 1]['name'])

@section('content')
    @include('layouts/panels/breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- Main content -->
    <section class="content d-print-none">
        <div class="container-fluid">

            <div class="card card-solid">
                <form class="form" action="{{ route('buying.buying.store') }}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="mb-2 d-flex justify-content-start justify-content-md-end d-print-none">
                            <button type="button" onclick='backToList()' class="btn btn-dark">
                                <i class="fa fa-share"></i>
                                <span class="ms-2">Back To List</span>
                            </button>
                        </div>

                        <div class="row">
                            <div class="col-md-9 mb-4">
                                <!--hader po & date -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label fs-5" for="code">PO Number</label>
                                        <input type="text" class="form-control" id="code" name="code"
                                            placeholder="code" value="{{ $invoice }}" disabled required />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fs-5" for="date_input">Date Input</label>

                                        <div class="input-group date" id="show_date_input" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" data-target="#show_date_input" id="date_input" name="date_input" placeholder="DD-MMM-YYYY" value="{{ date('d-M-Y', strtotime($date_input)) }}"
                                            required/>
                                            <div class="input-group-append" data-target="#show_date_input" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>                                         
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fs-5" for="due_date">Due Date</label>

                                        <div class="input-group date" id="show_due_date" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" data-target="#show_due_date" id="due_date" name="due_date" placeholder="DD-MMM-YYYY" value="{{ date('d-M-Y', strtotime($due_date)) }}"
                                            required/>
                                            <div class="input-group-append" data-target="#show_due_date" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>                                              
                                    </div>
                                </div>

                                <!--supplier -->
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <label class="form-label fs-5" for="supplier_id">Supplier</label>
                                        <select onchange="selectSupplier(this.value)" class="form-control supplierSelect2"
                                            name="supplier_id" id="supplier_id" required>
                                            @foreach ($suppliers as $data)
                                                <option value="{{ $data->id }}">
                                                    {{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label fs-5" for="infoSupplier">Infomation or Supplier</label>
                                        <input type="text" class="form-control" id="infoSupplier" name="infoSupplier"
                                            placeholder="infomation of Supplier" value="" disabled />
                                    </div>
                                </div>

                                <!--title -->
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <label class="form-label fs-5" for="title">Title</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            placeholder="title" value="" />
                                    </div>
                                </div>




                                <!--transaksi -->
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped table-responsive text-nowrap table-sm mt-2">
                                            <thead>
                                                <tr>
                                                    <th scope="col" hidden>ID</th>
                                                    <th scope="col">Code</th>
                                                    <th scope="col">Product</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Rate</th>
                                                    <th scope="col">Total</th>
                                                    <th scope="col">Discount</th>
                                                    <th scope="col">SubTotal</th>
                                                    <th scope="col" class="d-print-none">
                                                        <button type="button" id="btnProduct" name="btnProduct"
                                                            class="btn btn-primary">
                                                            <i class="fa fa-search"></i>
                                                        </button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="use-tBody">
                                                <tr class="rowCount" id="rowCount_1">
                                                    <th scope="row" hidden>
                                                        <input type="text" class="form-control" id="temps[1][id]"
                                                            name="temps[1][id]" placeholder="id" value="" />
                                                    </th>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            onkeyup="handleEvt(event,this, 1)" id="temps[1][code]"
                                                            name="temps[1][code]" placeholder="Code" value="" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="temps[1][name]"
                                                            name="temps[1][name]" placeholder="Product Name"
                                                            value="" disabled />
                                                    </td>
                                                    <td>
                                                        <input type="number" step="any" class="form-control amount"
                                                            id="temps[1][amount]" name="temps[1][amount]"
                                                            placeholder="Amount" value="0"
                                                            onkeyup="calculateChange(1)" required />
                                                    </td>
                                                    <td>
                                                        <input type="number" step="any" class="form-control rate"
                                                            id="temps[1][rate]" name="temps[1][rate]" placeholder="Rate"
                                                            value="1" onkeyup="calculateChange(1)" required />
                                                    </td>
                                                    <td>
                                                        <input type="number" step="any" class="form-control total"
                                                            id="temps[1][total]" name="temps[1][total]"
                                                            placeholder="Total" value="0" disabled />
                                                    </td>
                                                    <td>
                                                        <input type="number" step="any"
                                                            class="form-control discount" id="temps[1][discount]"
                                                            name="temps[1][discount]" placeholder="Discount"
                                                            value="0" onkeyup="calculateChange(1)" required />
                                                    </td>
                                                    <td>
                                                        <input type="number" step="any"
                                                            class="form-control subtotal" id="temps[1][subtotal]"
                                                            name="temps[1][subtotal]" placeholder="Subtotal"
                                                            value="0" disabled />
                                                    </td>
                                                    <td class="d-print-none">
                                                        <button type="button" class="btn btn-danger" id="btnDelete_1"
                                                            name="btnDelete_1" onclick="deleteRow(event)">
                                                            X
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th scope="row" colspan="3">Total</th>
                                                    <td>
                                                        <input type="number" step="any" class="form-control"
                                                            id="rateTotal" name="rateTotal" placeholder="Rate"
                                                            value="0" disabled />
                                                    </td>
                                                    <td>
                                                        <input type="number" step="any" class="form-control"
                                                            id="totalTotal" name="totalTotal" placeholder="Total"
                                                            value="0" disabled />
                                                    </td>
                                                    <td>
                                                        <input type="number" step="any" class="form-control"
                                                            id="discountTotal" name="discountTotal"
                                                            placeholder="Discount" value="0"
                                                            onkeyup="calculateGrandTotal()" />
                                                    </td>
                                                    <td>
                                                        <input type="number" step="any" class="form-control"
                                                            id="subtotalTotal" name="subtotalTotal"
                                                            placeholder="SubTotal" value="0" disabled />
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <!--Summary -->
                            <div class="col-md-3">

                                <div class="card card-primary card-outline">
                                    <div class="card-body">
                                        <ul class="profile-username list-group list-group-unbordered mb-3">
                                            <li>
                                                <b>Grand Total</b>
                                                <h3 class="float-right" id="lblgrandtotal" name="lblgrandtotal">0</h3>
                                            </li>
                                            <li>
                                                <b>Payment</b>
                                                <h3 class="float-right" id="lblpay" name="lblpay">0</h3>
                                            </li>
                                            <li>
                                                <b>Return</b>
                                                <h3 class="float-right" id="lblreturn" name="lblreturn">0</h3>
                                            </li>
                                        </ul>

                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>GrandTotal</b> <a class="float-right"><input type="number"
                                                        step="any" class="form-control" id="grandtotal"
                                                        name="grandtotal" placeholder="GrandTotal" value="0"
                                                        disabled required /></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Payment</b> <a class="float-right"><input type="number"
                                                        step="any" class="form-control" id="pay"
                                                        name="pay" placeholder="Payment" value="0" required
                                                        onkeyup="calculateGrandTotal()" /></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Return</b> <a class="float-right"><input type="number" step="any"
                                                        class="form-control" id="return" name="return"
                                                        placeholder="Return" value="0" disabled required /></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b class="mb-2">Methode :</b>
                                                <select class="mt-2 form-control bankSelect2" style="width: 100%;"
                                                    name="bank_id" id="bank_id" required>
                                                    <option value="0" selected="selected">On Hand</option>
                                                    @foreach ($banks as $data)
                                                        <option value="{{ $data->id }}">
                                                            {{ $data->account_name }}</option>
                                                    @endforeach
                                                </select>
                                            </li>
                                        </ul>

                                        <div class="d-flex justify-content-end d-print-none">
                                            <div class="form-check mt-1 mr-4">
                                                <input class="form-check-input" type="checkbox" id="is_print"
                                                    name="is_print" value = "1" />
                                                <label for="is_print" class="form-check-label">Print</label>
                                            </div>

                                            <button class="btn btn-primary me-2" type="submit">
                                                <i class="fa fa-save"></i>
                                                <span class="ms-2">Save</span>
                                            </button>
                                            <button type="button" onclick='cancelTrans()' class="btn btn-dark">
                                                <i class="fa fa-refresh"></i>
                                                <span class="ms-2">Cancel</span>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->

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
                                <th>Amount</th>
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
                                    <td class="text-right">
                                        {{ number_format($data->price_buy, 0, '.', ',') }}
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

        $('#show_due_date').datetimepicker({
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
        selectSupplier(document.getElementById("supplier_id").value);

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

        $('.supplierSelect2').select2({
            theme: 'bootstrap4'
        })

        $('.bankSelect2').select2({
            theme: 'bootstrap4'
        })

        function backToList() {
            window.location.href = "{{ route('buying.buying.index') }}";
        }

        function cancelTrans() {
            window.location.href = "{{ route('buying.buying.create') }}";
        }

        $("#btnProduct").click(function() {
            $('#frmProduct').modal('toggle')
        });

        function selectSupplier(value) {
            if (value) {
                $.ajax({
                    dataType: 'json',
                    type: "GET",
                    url: '{{ env('APP_URL') }}' + "/api/global/select-supplier/" + value,

                    success: function(res) {
                        if (res) {
                            document.getElementById('infoSupplier').value = res.address + ', Telp: ' + res
                                .telephone;
                        } else {
                            document.getElementById('infoSupplier').value = "";
                        }
                    }
                });
            } else {
                document.getElementById('infoSupplier').value = "";
            }
        }

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
                                document.getElementById('temps[' + index + '][amount]').value = res.price_buy;
                                document.getElementById('temps[' + index + '][rate]').value = 1;
                                document.getElementById('temps[' + index + '][total]').value = res.price_buy;
                                document.getElementById('temps[' + index + '][discount]').value = 0;
                                document.getElementById('temps[' + index + '][subtotal]').value = res.price_buy;

                                addNewRow();
                            } else {
                                alert('Data not found');

                                document.getElementById('temps[' + index + '][id]').value = "";
                                document.getElementById('temps[' + index + '][name]').value = "";
                                document.getElementById('temps[' + index + '][amount]').value = 0;
                                document.getElementById('temps[' + index + '][rate]').value = 0;
                                document.getElementById('temps[' + index + '][total]').value = 0;
                                document.getElementById('temps[' + index + '][discount]').value = 0;
                                document.getElementById('temps[' + index + '][subtotal]').value = 0;
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
                '<input type="number" step="any" class="form-control amount" id="temps[' + rows +
                '][amount]" name="temps[' + rows +
                '][amount]" placeholder="Amount" value="0" onkeyup="calculateChange(' + rows + ')" required />' +
                '</td>' +
                '<td>' +
                '<input type="number" step="any" class="form-control rate" id="temps[' + rows +
                '][rate]" name="temps[' + rows + '][rate]" placeholder="Rate" value="0" onkeyup="calculateChange(' +
                rows + ')" required />' +
                '</td>' +
                '<td>' +
                '<input type="number" step="any" class="form-control total" id="temps[' + rows +
                '][total]" name="temps[' + rows + '][total]" placeholder="Total" value="0" onkeyup="calculateChange(' +
                rows + ')" disabled />' +
                '</td>' +
                '<td>' +
                '<input type="number" step="any" class="form-control discount" id="temps[' + rows +
                '][discount]" name="temps[' + rows +
                '][discount]" placeholder="Discount" value="0"  onkeyup="calculateChange(' + rows + ')"required />' +
                '</td>' +
                '<td>' +
                '<input type="number" step="any" class="form-control subtotal" id="temps[' + rows +
                '][subtotal]" name="temps[' + rows +
                '][subtotal]" placeholder="Subtotal" value="0"  onkeyup="calculateChange(' + rows + ')"disabled />' +
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
            $("#totalTotal").val(result[1]);
            $("#discountTotal").val(result[2]);
            $("#subtotalTotal").val(result[3]);

            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            var total = document.getElementById('totalTotal').value;
            var discount = document.getElementById('discountTotal').value;
            var subtotal = parseFloat(total) - parseFloat(discount);
            var pay = document.getElementById('pay').value;

            document.getElementById('subtotalTotal').value = subtotal;
            document.getElementById('grandtotal').value = subtotal;
            document.getElementById('return').value = parseFloat(pay) - parseFloat(subtotal);

            document.getElementById('lblgrandtotal').innerHTML = parseFloat(document.getElementById('grandtotal').value)
                .toLocaleString();
            document.getElementById('lblpay').innerHTML = parseFloat(document.getElementById('pay').value).toLocaleString();
            document.getElementById('lblreturn').innerHTML = parseFloat(document.getElementById('return').value)
                .toLocaleString();
        }

        function calculateChange(rows) {
            var amount = document.getElementById('temps[' + rows + '][amount]').value;
            var rate = document.getElementById('temps[' + rows + '][rate]').value;
            var total = parseFloat(rate) * parseFloat(amount);
            var discount = document.getElementById('temps[' + rows + '][discount]').value;
            var subtotal = parseFloat(total) - parseFloat(discount);

            document.getElementById('temps[' + rows + '][total]').value = total;
            document.getElementById('temps[' + rows + '][subtotal]').value = subtotal;

            var result = calculateSubTotal()
            $("#rateTotal").val(result[0]);
            $("#totalTotal").val(result[1]);
            $("#discountTotal").val(result[2]);
            $("#subtotalTotal").val(result[3]);

            calculateGrandTotal();
        }

        function calculateSubTotal() {
            var totalRate = 0;
            $('.rate').each(function() {
                totalRate += parseFloat($(this).val());
            });

            var totalTotal = 0;
            $('.total').each(function() {
                totalTotal += parseFloat($(this).val());
            });

            var totalDiscount = 0;
            $('.discount').each(function() {
                totalDiscount += parseFloat($(this).val());
            });

            var totalSubTotal = 0;
            $('.subtotal').each(function() {
                totalSubTotal += parseFloat($(this).val());
            });

            return [totalRate, totalTotal, totalDiscount, totalSubTotal];
        }
    </script>
@endsection
