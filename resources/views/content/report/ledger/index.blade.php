@extends('layouts/app')
@section('title', $breadcrumbs[count($breadcrumbs) - 1]['name'])

@section('content')
    @include('layouts/panels/breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-solid">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-3 col-6 mb-2">
                            <label class="form-label fs-5" for="date_from">Date From</label>

                            <div class="input-group date" id="show_date_from" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input"
                                    data-target="#show_date_from" id="date_from" name="date_from" placeholder="DD-MMM-YYYY"
                                    value="{{ date('d-M-Y', strtotime($date_from)) }}" required />
                                <div class="input-group-append" data-target="#show_date_from" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-6 mb-2">
                            <label class="form-label fs-5" for="date_to">Date To</label>

                            <div class="input-group date" id="show_date_to" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#show_date_to"
                                    id="date_to" name="date_to" placeholder="DD-MMM-YYYY"
                                    value="{{ date('d-M-Y', strtotime($date_to)) }}" required />
                                <div class="input-group-append" data-target="#show_date_to" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-6 mb-2">
                            <div class="col">
                                <label class="form-label fs-5" for="opt">View</label>
                                <select class="form-control" name="opt" id="opt" required>
                                    <option value="1" selected>Ledger</option>
                                    <option value="2">Modal vs Kewajiban</option>
                                    <option value="3">Cuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-6 mb-2 d-flex align-items-end">
                            <div class="col">
                                <label class="form-label fs-5" for="type">Type</label>
                                <select class="form-control" name="type" id="type" required>
                                    <option value="1" selected>Sum</option>
                                    <option value="2">Daily</option>
                                    <option value="3">Monthly</option>
                                    <option value="4">Yearly</option>
                                </select>
                            </div>

                            <button type="button" id="btnSearch" name="btnSearch" class="btn btn-primary show"
                                onclick='showData()'>
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>




                    <div class="row mt-3" id="dataView" hidden>
                        <h4 class="ml-2">Details</h4>
                        <div class="col-12">
                            <table id="tblReport" name="tblReport"
                                class="table table-bordered table-sm table-responsive text-nowrap">
                                <thead id="use-tThead" class="text-sm font-monospace">
                                </thead>
                                <tbody id="use-tBody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('page-style')
    <!-- / datetimepicker -->
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('page-script')
    <!-- / datetimepicker -->
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $('#show_date_from').datetimepicker({
            format: 'DD-MMM-YYYY'
        });

        $('#show_date_to').datetimepicker({
            format: 'DD-MMM-YYYY'
        });

        $('.optSelect2').select2({
            theme: 'bootstrap4'
        })

        function setButton() {
            if (document.getElementById("btnSearch").classList[2] == 'show') {
                document.getElementById("btnSearch").classList.remove("show");
                document.getElementById("btnSearch").classList.add("load");
                document.getElementById('btnSearch').innerHTML = "";
                document.getElementById('btnSearch').innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

                document.getElementById('dataView').hidden = true;
            } else if (document.getElementById("btnSearch").classList[2] == 'load') {
                document.getElementById("btnSearch").classList.remove("load");
                document.getElementById("btnSearch").classList.add("show");
                document.getElementById('btnSearch').innerHTML = "";
                document.getElementById('btnSearch').innerHTML = '<i class="fa fa-search"></i>';

                document.getElementById('dataView').hidden = false;
            }
        }

        function showData() {
            if (document.getElementById('type').value == 1) {
                showSum();
            } else if (document.getElementById('type').value == 2) {
                showDaily();
            } else if (document.getElementById('type').value == 3) {
                showMonthly();
            } else if (document.getElementById('type').value == 4) {
                showYearly();
            }
        }












        function createHeaderSum() {
            document.getElementById('use-tThead').innerHTML = "";

            var html =
                '<tr class="text-center" style="background-color: #f0f0f0">' +
                '<th>Account</th>' +
                '<th class="w-full">Description</th>' +
                '<th>Debet</th>' +
                '<th>Credit</th>' +
                '<th>Balance</th>' +
                '</tr>';

            $('#use-tThead').append(html);
        }

        function showSum() {
            document.getElementById('dataView').hidden = true;

            createHeaderSum();
            document.getElementById('use-tBody').innerHTML = "";

            var $iSumBeginning = 0;
            var $SumDebet = 0;
            var $SumCredit = 0;
            var $SumBalace = 0;

            $.ajax({
                dataType: 'json',
                type: "GET",
                url: '{{ env('APP_URL') }}' + "/api/report/ledger/" + document.getElementById('date_from').value +
                    "/" + document.getElementById('date_to').value + "/" + document.getElementById('opt').value,

                beforeSend: function() {
                    setButton();
                },
                complete: function() {
                    setButton();
                },
                success: function(res) {
                    if (res.length > 0) {
                        let balance = 0;
                        // fill table *******************
                        for (let index = 0; index < res.length; index++) {
                            if (index == 0) {
                                $iSumBeginning = parseFloat(res[index]['debet']) - parseFloat(res[index][
                                    'credit'
                                ]);
                            }

                            balance += parseFloat(res[index]['debet']) - parseFloat(res[index]['credit']);

                            if (index != 0) {
                                $SumDebet += parseFloat(res[index]['debet']);
                                $SumCredit += parseFloat(res[index]['credit']);
                            }

                            var html =
                                '<tr class="rowCount" id="rowCount_' + index + '" name="rowCount_' + index +
                                '">';

                            html += '<th class="text-center">' + res[index]['code'] + '</th>';

                            html += '<th class="text-left">' + res[index]['name'] + ' (' + res[index][
                                'description'
                            ] + ')</th>';

                            html += '<th class="text-right">' + formatNumber(res[index]['debet'], 0) + '</th>';
                            html += '<th class="text-right">' + formatNumber(res[index]['credit'], 0) + '</th>';

                            if (balance < 0) {
                                html += '<th class="text-right text-danger">' + formatNumber(balance, 0) +
                                    '</th>';
                            } else {
                                html += '<th class="text-right">' + formatNumber(balance, 0) + '</th>';
                            }

                            $('#use-tBody').append(html);
                        }
                    } else {
                        $("#use-tBody").append(
                            '<tr>' +
                            '<td colspan=5>' +
                            '<h2 class="p-3 text-secondary">No have data</h2>' +
                            '</td>' +
                            '</tr>'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error API connection');
                    document.getElementById('dataView').hidden = true;
                    return;
                }
            });
        }











        function createHeaderDaily() {
            document.getElementById('use-tThead').innerHTML = "";

            var html =
                '<tr class="text-center" style="background-color: #f0f0f0">' +
                '<th>Account</th>' +
                '<th class="w-full">Description</th>' +
                '<th style="background-color: #fff8c5">Total</th>';

            for (let index = 0; index < 31; index++) {
                var dt = new Date(document.getElementById('date_from').value);
                dt.setDate(dt.getDate() + index);

                const formatter = new Intl.DateTimeFormat('en', { month: 'short' });
                const month = formatter.format(new Date(dt));
                const formatter2 = new Intl.DateTimeFormat('en', { day: 'numeric' });
                const day = formatter2.format(new Date(dt)).padStart(2, '0');

                if (isWeekEnd(dt) == 'Saturday') {
                    html += '<th class="text-center" style="background-color: #b9dcfd">' + day + '-' + month + '</th>';
                } else if (isWeekEnd(dt) == 'Sunday') {
                    html += '<th class="text-center" style="background-color: #fec8c8">' + day + '-' + month + '</th>';
                } else {
                    html += '<th class="text-center" style="background-color: #f0f0f0">' + day + '-' + month + '</th>';
                }

            }

            html += '</tr>';

            $('#use-tThead').append(html);
        }

        function showDaily() {
            document.getElementById('dataView').hidden = true;

            createHeaderDaily();
            document.getElementById('use-tBody').innerHTML = "";

            $.ajax({
                dataType: 'json',
                type: "GET",
                url: '{{ env('APP_URL') }}' + "/api/report/ledger-daily/" + document.getElementById('date_from')
                    .value + "/" + document.getElementById('opt').value,

                beforeSend: function() {
                    setButton();
                },
                complete: function() {
                    setButton();
                },
                success: function(res) {
                    if (res.length > 0) {
                        // fill table *******************
                        var grandtotal = 0;
                        const totalcol = new Array(32).fill(0); // [];

                        for (let index = 0; index < res.length; index++) {
                            var grandtotal_col = 0;
                            var html =
                                '<tr class="rowCount" id="rowCount_' + index + '" name="rowCount_' + index +
                                '">';

                            html += '<th class="text-center">' + res[index]['code'] + '</th>';

                            html += '<th class="text-left">' + res[index]['name'] + ' (' + res[index][
                                'description'
                            ] + ')</th>';

                            html += '<th class="text-right">0</th>';

                            for (let idate = 1; idate <= 31; idate++) {
                                if (parseFloat(res[index]['amount' + idate]) == 0) {
                                    html += '<th class="text-right"></th>';
                                } else if (parseFloat(res[index]['amount' + idate]) < 0) {
                                    html += '<th class="text-right text-danger">' + formatNumber(res[index]['amount' +
                                        idate], 0) + '</th>';
                                } else {
                                    html += '<th class="text-right">' + formatNumber(res[index]['amount' +
                                        idate], 0) + '</th>';
                                }

                                totalcol[idate] += parseFloat(res[index]['amount' + idate]);
                                grandtotal_col += parseFloat(res[index]['amount' + idate]);
                            }

                            $('#use-tBody').append(html);

                            // set grandtotal col
                            grandtotal += parseFloat(grandtotal_col);
                            if (parseFloat(grandtotal_col) == 0) {
                                document.getElementById("tblReport").rows[index + 1].cells[2].innerHTML = '';
                            } else {
                                if (parseFloat(grandtotal_col) < 0) {
                                    document.getElementById("tblReport").rows[index + 1].cells[2].innerHTML =
                                        formatNumber(grandtotal_col, 0);

                                    document.getElementById("tblReport").rows[index + 1].cells[2].classList.add(
                                        "text-danger");
                                } else {
                                    document.getElementById("tblReport").rows[index + 1].cells[2].innerHTML =
                                        formatNumber(grandtotal_col, 0);
                                }
                            }

                            document.getElementById("tblReport").rows[index + 1].cells[2].style
                                .backgroundColor = "#feffe6";
                        }

                        //add row grand total
                        var html =
                            '<tr class="rowCount" id="rowCount_grandtotal" name="rowCount_grandtotal" style="background-color: #f0f0f0">';

                        html += '<th class="text-center" colspan=2>Grand Total</th>';
                        if (parseFloat(grandtotal) == 0) {
                            html += '<th class="text-right" style="background-color: #fff8c5"></th>';
                        } else if (parseFloat(grandtotal) < 0) {
                            html += '<th class="text-right text-danger" style="background-color: #fff8c5">' +
                                formatNumber(grandtotal, 0) + '</th>';
                        } else {
                            html += '<th class="text-right" style="background-color: #fff8c5">' + formatNumber(
                                grandtotal, 0) + '</th>';
                        }

                        for (let idate = 1; idate <= 31; idate++) {
                            if (parseFloat(totalcol[idate]) == 0) {
                                html += '<th class="text-right"></th>';
                            } else if (parseFloat(totalcol[idate]) < 0) {
                                html += '<th class="text-right text-danger">' + formatNumber(totalcol[idate],
                                    0) + '</th>';
                            } else {
                                html += '<th class="text-right">' + formatNumber(totalcol[idate], 0) + '</th>';
                            }
                        }

                        // console.log(totalcol);
                        $('#use-tBody').append(html);
                    } else {
                        $("#use-tBody").append(
                            '<tr>' +
                            '<td colspan=34>' +
                            '<h2 class="p-3 text-secondary">No have data</h2>' +
                            '</td>' +
                            '</tr>'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error API connection');
                    document.getElementById('dataView').hidden = true;
                    return;
                }
            });
        }











        function createHeaderMonthly() {
            document.getElementById('use-tThead').innerHTML = "";

            var html =
                '<tr class="text-center" style="background-color: #f0f0f0">' +
                '<th>Account</th>' +
                '<th class="w-full">Description</th>' +
                '<th style="background-color: #fff8c5">Total</th>';

            for (let index = 0; index < 12; index++) {
                var dt = new Date(document.getElementById('date_from').value);
                dt.setMonth(dt.getMonth() + index);

                const formatter = new Intl.DateTimeFormat('en', { month: 'short' });
                const month = formatter.format(new Date(dt));
                let year = dt.getFullYear();

                html += '<th class="text-center">' + year + '-' + month + '</th>';
            }

            html += '</tr>';

            $('#use-tThead').append(html);
        }

        function showMonthly() {
            document.getElementById('dataView').hidden = true;

            createHeaderMonthly();
            document.getElementById('use-tBody').innerHTML = "";

            $.ajax({
                dataType: 'json',
                type: "GET",
                url: '{{ env('APP_URL') }}' + "/api/report/ledger-monthly/" + document.getElementById('date_from')
                    .value + "/" + document.getElementById('opt').value,

                beforeSend: function() {
                    setButton();
                },
                complete: function() {
                    setButton();
                },
                success: function(res) {
                    if (res.length > 0) {
                        // fill table *******************
                        var grandtotal = 0;
                        const totalcol = new Array(13).fill(0); // [];

                        for (let index = 0; index < res.length; index++) {
                            var grandtotal_col = 0;
                            var html =
                                '<tr class="rowCount" id="rowCount_' + index + '" name="rowCount_' + index +
                                '">';

                            html += '<th class="text-center">' + res[index]['code'] + '</th>';

                            html += '<th class="text-left">' + res[index]['name'] + ' (' + res[index][
                                'description'
                            ] + ')</th>';

                            html += '<th class="text-right">0</th>';

                            for (let idate = 1; idate <= 12; idate++) {
                                if (parseFloat(res[index]['amount' + idate]) == 0) {
                                    html += '<th class="text-right"></th>';
                                } else if (parseFloat(res[index]['amount' + idate]) < 0) {
                                    html += '<th class="text-right text-danger">' + formatNumber(res[index]['amount' +
                                        idate], 0) + '</th>';
                                } else {
                                    html += '<th class="text-right">' + formatNumber(res[index]['amount' +
                                        idate], 0) + '</th>';
                                }

                                totalcol[idate] += parseFloat(res[index]['amount' + idate]);
                                grandtotal_col += parseFloat(res[index]['amount' + idate]);
                            }

                            $('#use-tBody').append(html);

                            // set grandtotal col
                            grandtotal += parseFloat(grandtotal_col);
                            if (parseFloat(grandtotal_col) == 0) {
                                document.getElementById("tblReport").rows[index + 1].cells[2].innerHTML = '';
                            } else {
                                if (parseFloat(grandtotal_col) < 0) {
                                    document.getElementById("tblReport").rows[index + 1].cells[2].innerHTML =
                                        formatNumber(grandtotal_col, 0);

                                    document.getElementById("tblReport").rows[index + 1].cells[2].classList.add(
                                        "text-danger");
                                } else {
                                    document.getElementById("tblReport").rows[index + 1].cells[2].innerHTML =
                                        formatNumber(grandtotal_col, 0);
                                }
                            }

                            document.getElementById("tblReport").rows[index + 1].cells[2].style
                                .backgroundColor = "#feffe6";
                        }

                        //add row grand total
                        var html =
                            '<tr class="rowCount" id="rowCount_grandtotal" name="rowCount_grandtotal" style="background-color: #f0f0f0">';

                        html += '<th class="text-center" colspan=2>Grand Total</th>';
                        if (parseFloat(grandtotal) == 0) {
                            html += '<th class="text-right" style="background-color: #fff8c5"></th>';
                        } else if (parseFloat(grandtotal) < 0) {
                            html += '<th class="text-right text-danger" style="background-color: #fff8c5">' +
                                formatNumber(grandtotal, 0) + '</th>';
                        } else {
                            html += '<th class="text-right" style="background-color: #fff8c5">' + formatNumber(
                                grandtotal, 0) + '</th>';
                        }

                        for (let idate = 1; idate <= 12; idate++) {
                            if (parseFloat(totalcol[idate]) == 0) {
                                html += '<th class="text-right"></th>';
                            } else if (parseFloat(totalcol[idate]) < 0) {
                                html += '<th class="text-right text-danger">' + formatNumber(totalcol[idate],
                                    0) + '</th>';
                            } else {
                                html += '<th class="text-right">' + formatNumber(totalcol[idate], 0) + '</th>';
                            }
                        }

                        // console.log(totalcol);
                        $('#use-tBody').append(html);
                    } else {
                        $("#use-tBody").append(
                            '<tr>' +
                            '<td colspan=15>' +
                            '<h2 class="p-3 text-secondary">No have data</h2>' +
                            '</td>' +
                            '</tr>'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error API connection');
                    document.getElementById('dataView').hidden = true;
                    return;
                }
            });
        }











        function createHeaderYearly() {
            document.getElementById('use-tThead').innerHTML = "";

            var html =
                '<tr class="text-center" style="background-color: #f0f0f0">' +
                '<th>Account</th>' +
                '<th class="w-full">Description</th>' +
                '<th style="background-color: #fff8c5">Total</th>';

            for (let index = 0; index < 12; index++) {
                var dt = new Date(document.getElementById('date_from').value);
                dt.setFullYear(dt.getFullYear() + index);
                let year = dt.getFullYear();

                html += '<th class="text-center">' + year + '</th>';
            }

            html += '</tr>';

            $('#use-tThead').append(html);
        }

        function showYearly() {
            document.getElementById('dataView').hidden = true;

            createHeaderYearly();
            document.getElementById('use-tBody').innerHTML = "";

            $.ajax({
                dataType: 'json',
                type: "GET",
                url: '{{ env('APP_URL') }}' + "/api/report/ledger-yearly/" + document.getElementById('date_from')
                    .value + "/" + document.getElementById('opt').value,

                beforeSend: function() {
                    setButton();
                },
                complete: function() {
                    setButton();
                },
                success: function(res) {
                    if (res.length > 0) {
                        // fill table *******************
                        var grandtotal = 0;
                        const totalcol = new Array(13).fill(0); // [];

                        for (let index = 0; index < res.length; index++) {
                            var grandtotal_col = 0;
                            var html =
                                '<tr class="rowCount" id="rowCount_' + index + '" name="rowCount_' + index +
                                '">';

                            html += '<th class="text-center">' + res[index]['code'] + '</th>';

                            html += '<th class="text-left">' + res[index]['name'] + ' (' + res[index][
                                'description'
                            ] + ')</th>';

                            html += '<th class="text-right">0</th>';

                            for (let idate = 1; idate <= 12; idate++) {
                                if (parseFloat(res[index]['amount' + idate]) == 0) {
                                    html += '<th class="text-right"></th>';
                                } else if (parseFloat(res[index]['amount' + idate]) < 0) {
                                    html += '<th class="text-right text-danger">' + formatNumber(res[index]['amount' +
                                        idate], 0) + '</th>';
                                } else {
                                    html += '<th class="text-right">' + formatNumber(res[index]['amount' +
                                        idate], 0) + '</th>';
                                }

                                totalcol[idate] += parseFloat(res[index]['amount' + idate]);
                                grandtotal_col += parseFloat(res[index]['amount' + idate]);
                            }

                            $('#use-tBody').append(html);

                            // set grandtotal col
                            grandtotal += parseFloat(grandtotal_col);
                            if (parseFloat(grandtotal_col) == 0) {
                                document.getElementById("tblReport").rows[index + 1].cells[2].innerHTML = '';
                            } else {
                                if (parseFloat(grandtotal_col) < 0) {
                                    document.getElementById("tblReport").rows[index + 1].cells[2].innerHTML =
                                        formatNumber(grandtotal_col, 0);

                                    document.getElementById("tblReport").rows[index + 1].cells[2].classList.add(
                                        "text-danger");
                                } else {
                                    document.getElementById("tblReport").rows[index + 1].cells[2].innerHTML =
                                        formatNumber(grandtotal_col, 0);
                                }
                            }

                            document.getElementById("tblReport").rows[index + 1].cells[2].style
                                .backgroundColor = "#feffe6";
                        }

                        //add row grand total
                        var html =
                            '<tr class="rowCount" id="rowCount_grandtotal" name="rowCount_grandtotal" style="background-color: #f0f0f0">';

                        html += '<th class="text-center" colspan=2>Grand Total</th>';
                        if (parseFloat(grandtotal) == 0) {
                            html += '<th class="text-right" style="background-color: #fff8c5"></th>';
                        } else if (parseFloat(grandtotal) < 0) {
                            html += '<th class="text-right text-danger" style="background-color: #fff8c5">' +
                                formatNumber(grandtotal, 0) + '</th>';
                        } else {
                            html += '<th class="text-right" style="background-color: #fff8c5">' + formatNumber(
                                grandtotal, 0) + '</th>';
                        }

                        for (let idate = 1; idate <= 12; idate++) {
                            if (parseFloat(totalcol[idate]) == 0) {
                                html += '<th class="text-right"></th>';
                            } else if (parseFloat(totalcol[idate]) < 0) {
                                html += '<th class="text-right text-danger">' + formatNumber(totalcol[idate],
                                    0) + '</th>';
                            } else {
                                html += '<th class="text-right">' + formatNumber(totalcol[idate], 0) + '</th>';
                            }
                        }

                        // console.log(totalcol);
                        $('#use-tBody').append(html);
                    } else {
                        $("#use-tBody").append(
                            '<tr>' +
                            '<td colspan=15>' +
                            '<h2 class="p-3 text-secondary">No have data</h2>' +
                            '</td>' +
                            '</tr>'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error API connection');
                    document.getElementById('dataView').hidden = true;
                    return;
                }
            });
        }        













        function formatNumber(amount, decimalCount = 2, decimal = ".", thousands = ",") {
            try {
                decimalCount = Math.abs(decimalCount);
                decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

                const negativeSign = amount < 0 ? "-" : "";

                let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
                let j = (i.length > 3) ? i.length % 3 : 0;

                return negativeSign +
                    (j ? i.substr(0, j) + thousands : '') +
                    i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) +
                    (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
            } catch (e) {
                console.log(e)
            }
        };

        function formatDate(date, options, separator) {
            function format(option) {
                let formatter = new Intl.DateTimeFormat('en', option);
                if (formatter.format(date).length <= 2) {
                    formatter = String(formatter.format(date)).padStart(2, '0')
                } else {
                    formatter = formatter.format(date)
                }

                return formatter;
            }
            return options.map(format).join(separator);
        }

        function isWeekEnd(date) {
            // Check if the day of the week is Saturday (6) or Sunday (0)
            if (date.getDay() == 6) {
                return "Saturday";
            }

            if (date.getDay() == 0) {
                return "Sunday";
            }
        }
    </script>
@endsection
