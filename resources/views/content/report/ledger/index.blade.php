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
                                <input type="text" class="form-control datetimepicker-input" data-target="#show_date_from" id="date_from" name="date_from" placeholder="DD-MMM-YYYY" value="{{ date('d-M-Y', strtotime($date_from)) }}"
                                required/>
                                <div class="input-group-append" data-target="#show_date_from" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-6 mb-2">
                            <label class="form-label fs-5" for="date_to">Date To</label>

                            <div class="input-group date" id="show_date_to" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#show_date_to" id="date_to" name="date_to" placeholder="DD-MMM-YYYY" value="{{ date('d-M-Y', strtotime($date_to)) }}"
                                required/>
                                <div class="input-group-append" data-target="#show_date_to" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-6 mb-2 d-flex align-items-end">
                            <div class="col">
                                <label class="form-label fs-5" for="opt">View</label>
                                <select class="form-control optSelect2"
                                    name="opt" id="opt" required>
                                    <option value="1" selected>Ledger</option>
                                    <option value="2">Modal vs Kewajiban</option>
                                    <option value="3">Cuan</option>
                                </select>    
                            </div>
                            
                            <button type="button" id="btnSearch" name="btnSearch" class="btn btn-primary show"
                                onclick='show()'>
                                <i class="fa fa-search"></i>
                            </button>
                        </div>

                        <div class="col-md-3 col-6 mb-2"></div>                        
                    </div>




                    <div class="row mt-2" id="dataView" hidden>
                        <h4 class="ml-2">Details</h4>
                        <div class="col-12">
                            <table class="table table-bordered table-sm table-responsive text-nowrap">
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
    <link rel="stylesheet" href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
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

        function createHeader() {
            document.getElementById('use-tThead').innerHTML = "";

            var html = 
                '<tr>' +
                    '<th>Account</th>' +
                    '<th class="w-full">Description</th>' +
                    '<th>Debet</th>' +
                    '<th>Credit</th>' +
                    '<th>Balance</th>' +
                '</tr>';

            $('#use-tThead').append(html);
        }

        function show() {
            document.getElementById('dataView').hidden = true;

            createHeader();
            document.getElementById('use-tBody').innerHTML = "";

            var $iSumBeginning = 0;
            var $SumDebet = 0;
            var $SumCredit = 0;
            var $SumBalace = 0;

            $.ajax({
                dataType: 'json',
                type: "GET",
                url: '{{ env('APP_URL') }}' + "/api/report/ledger/" + document.getElementById('date_from').value + "/" + document.getElementById('date_to').value + "/" + document.getElementById('opt').value,

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
                                $iSumBeginning = parseFloat(res[index]['debet']) - parseFloat(res[index]['credit']);
                            } 

                            balance += parseFloat(res[index]['debet']) - parseFloat(res[index]['credit']);

                            if (index != 0) {
                                $SumDebet += parseFloat(res[index]['debet']);
                                $SumCredit += parseFloat(res[index]['credit']);
                            } 

                            var html = 
                                '<tr class="rowCount" id="rowCount_' + index + '" name="rowCount_' + index + '">';

                                html += '<th class="text-center">' + res[index]['code'] + '</th>';                                               

                                html += '<th class="text-left">' + res[index]['name'] + ' (' + res[index]['description'] +')</th>';                                               

                                html += '<th class="text-right">' + formatNumber(res[index]['debet'], 0) + '</th>';
                                html += '<th class="text-right">' + formatNumber(res[index]['credit'], 0) + '</th>';

                            if (balance < 0) {
                                html += '<th class="text-right text-danger">' + formatNumber(balance, 0) + '</th>';
                            }
                            else {
                                html += '<th class="text-right">' + formatNumber(balance, 0) + '</th>';
                            }  

                            $('#use-tBody').append(html);                            
                        }          
                    }  else {
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
    </script>
@endsection
