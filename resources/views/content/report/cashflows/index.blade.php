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
                            <label class="form-label fs-5" for="type">Type</label>
                            <select onchange="selectType(this.value)" class="form-control"
                                name="type" id="type" required>
                                <option value="0" selected="selected">Summary</option>
                                <option value="1">Detail</option>
                            </select>
                        </div>

                        <div class="col-md-3 col-6 mb-2 d-flex align-items-end">
                            <button type="button" id="btnSearch" name="btnSearch" class="btn btn-primary show"
                            onclick='show()'>
                            <i class="fa fa-search"></i>
                        </button>
                        </div>

                        <div class="col-md-3 col-6 mb-2">
                            
                        </div>
                    </div>

                    <div class="row mt-2" id="dataView" hidden>
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
@endsection

@section('page-script')
    <!-- / datetimepicker -->
    <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <script>
        $('#show_date_from').datetimepicker({
            format: 'DD-MMM-YYYY'
        });

        selectType(document.getElementById('type').value);

        function show() {
            document.getElementById('dataView').hidden = true;
            createHeader(document.getElementById('type').value);
            document.getElementById('use-tBody').innerHTML = "";
            
            $.ajax({
                dataType: 'json',
                type: "GET",
                url: '{{ env('APP_URL') }}' + "/api/report/cashflows/" + document.getElementById('date_from').value + "/" + document.getElementById('type').value,

                beforeSend: function() {
                    setButton();
                },
                complete: function() {
                    setButton();
                },
                success: function(res) {
                    let iCol = 0;
                    if (document.getElementById('type').value == 0) {
                        iCol = 32;
                    } else {
                        iCol = 94;
                    }        
                    
                    if (res.length > 0) {  
                        for (let index = 0; index < res.length; index++) {     
                            var html = 
                                '<tr>' +
                                    '<td>' + res[index]['title'] + '</td>'
                            ;   
                        
                            let sCashflows = 0;
                            let sDebet = 0;
                            let sCredit = 0;

                            for (let col = 1; col <= 31; col++) {  
                                sDebet = formatNumber(res[index]['debet_date' + col.toString().padStart(2, '0')], 0);
                                if (sDebet == 0) { sDebet = ""; }   

                                sCredit = formatNumber(res[index]['credit_date' + col.toString().padStart(2, '0')], 0);
                                if (sCredit == 0) { sCredit = ""; }   
                                
                                sCashflows = formatNumber(parseFloat(res[index]['debet_date' + col.toString().padStart(2, '0')]) - parseFloat(res[index]['credit_date' + col.toString().padStart(2, '0')]), 0);
                                if (sCashflows == 0) { sCashflows = ""; }   
                                


                                
                                if (document.getElementById('type').value == 0) {
                                    html += 
                                        '<td class="text-right">' + sCashflows + '</td>'
                                    ;                                     
                                }
                                else if (document.getElementById('type').value == 1)
                                {
                                    html += 
                                        '<td class="text-right">' + sDebet + '</td>' +
                                        '<td class="text-right">' + sCredit + '</td>' +
                                        '<td class="text-right" style="background-color: #e5ffc5">' + sCashflows + '</td>'
                                    ;
                                }
                            }

                            html += 
                                '</tr>';

                            $('#use-tBody').append(html);            
                        }
                    }  else {
                        $("#use-tBody").append(
                            '<tr>' +
                                '<td colspan="' + iCol + '">' +
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

        function selectType(value) {
            document.getElementById('dataView').hidden = true;
            // createHeader(value);
        }
        
        function createHeader(value) {
            document.getElementById('use-tThead').innerHTML = "";

            if (value == 0) {
                var html = 
                    '<tr>' +
                        '<th style="background-color: #f0f0f0">Title</th>'
                ;

                for (let index = 1; index <= 31; index++) {   
                    var dt = new Date(document.getElementById('date_from').value);
                    dt.setDate(dt.getDate() + (index - 1));

                    if (isWeekEnd(dt) == 'Saturday') {
                        html += '<th class="text-center" style="background-color: #b9dcfd">' + formatDate(new Date(dt), [{month: 'numeric'}, {day: 'numeric'}], '-') + '</th>';                                               
                    }
                    else if (isWeekEnd(dt) == 'Sunday') {
                        html += '<th class="text-center" style="background-color: #fec8c8">' + formatDate(new Date(dt), [{month: 'numeric'}, {day: 'numeric'}], '-') + '</th>';                                                                       
                    }
                    else {
                        html += '<th class="text-center" style="background-color: #f0f0f0">' + formatDate(new Date(dt), [{month: 'numeric'}, {day: 'numeric'}], '-') + '</th>';                                               
                    }
                    
                }

                html += '</tr>';

                $('#use-tThead').append(html);
            } else if (value == 1) {
                var html = 
                    '<tr>' +
                        '<th class="align-middle" style="background-color: #f0f0f0" rowspan="2">Title</th>'
                ;

                for (let index = 1; index <= 31; index++) {   
                    var dt = new Date(document.getElementById('date_from').value);
                    dt.setDate(dt.getDate() + (index - 1));

                    if (isWeekEnd(dt) == 'Saturday') {
                        html += '<th class="text-center" style="background-color: #b9dcfd" colspan="3">' + formatDate(new Date(dt), [{month: 'numeric'}, {day: 'numeric'}], '-') + '</th>';                                               
                    }
                    else if (isWeekEnd(dt) == 'Sunday') {
                        html += '<th class="text-center" style="background-color: #fec8c8" colspan="3">' + formatDate(new Date(dt), [{month: 'numeric'}, {day: 'numeric'}], '-') + '</th>';                                                                       
                    }
                    else {
                        html += '<th class="text-center" style="background-color: #f0f0f0" colspan="3">' + formatDate(new Date(dt), [{month: 'numeric'}, {day: 'numeric'}], '-') + '</th>';                                               
                    }
                }

                html += '</tr>';




                for (let index = 1; index <= 31; index++) {   
                    var dt = new Date(document.getElementById('date_from').value);
                    dt.setDate(dt.getDate() + (index - 1));

                    if (isWeekEnd(dt) == 'Saturday') {
                        html += 
                            '<th class="text-center" style="background-color: #b9dcfd">Debet</th>' +
                            '<th class="text-center" style="background-color: #b9dcfd">Credit</th>' +
                            '<th class="text-center" style="background-color: #b9dcfd">Balance</th>'
                        ;                                               
                    }
                    else if (isWeekEnd(dt) == 'Sunday') {
                        html += 
                            '<th class="text-center" style="background-color: #fec8c8">Debet</th>' +
                            '<th class="text-center" style="background-color: #fec8c8">Credit</th>' +
                            '<th class="text-center" style="background-color: #fec8c8">Balance</th>'
                        ;                                               
                    }
                    else {
                        html += 
                            '<th class="text-center" style="background-color: #f0f0f0">Debet</th>' +
                            '<th class="text-center" style="background-color: #f0f0f0">Credit</th>' +
                            '<th class="text-center" style="background-color: #f0f0f0">Balance</th>'
                        ;                                               
                    }
                }

                html += '</tr>';

                $('#use-tThead').append(html);            
            }
        }
        
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
        
        function isWeekEnd (date) {
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
