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
                            {{-- <input type="date" class="form-control" id="date_to" name="date_to" placeholder="Date To"
                                value="{{ date('Y-m-d', strtotime($date_to)) }}" required /> --}}

                            <div class="input-group date" id="show_date_to" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#show_date_to" id="date_to" name="date_to" placeholder="DD-MMM-YYYY" value="{{ date('d-M-Y', strtotime($date_to)) }}"
                                required/>
                                <div class="input-group-append" data-target="#show_date_to" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-6 mb-2 d-flex align-items-end">
                            <div class="d-flex flex-row">
                                <button type="button" id="btnSearch" name="btnSearch" class="btn btn-primary show"
                                    onclick='show()'>
                                    <i class="fa fa-search"></i>
                                </button>

                                <div class="ms-4 mt-2">
                                    <div class="ms-4">
                                        <input class="form-check-input" type="checkbox" id="is_value"
                                            name="is_value" value = "1"/>
                                        <label for="is_value" class="form-check-label">Only Value</label>
                                    </div>    
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-6 mb-2"></div>                        
                    </div>






                    <!-- Info boxes -->
                    <div class="row" id="boxView">
                        
                    </div>
                    <!-- /.row -->



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
@endsection

@section('page-script')
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

        $is_value = true;
        document.getElementById("is_value").checked = $is_value;

        $('#is_value').click(function(){
            if($(this).is(':checked')){
                $is_value = true;
            } else {
                $is_value = false;
            }

            // get value from table with loop
            var table = document.getElementById("use-tBody");       
            let iRow = -1;    
            for (let row of table.rows) 
            {       
                iRow += 1;         
                if ($is_value == true) {
                    let debet = row.cells[2].innerText;
                    let credit = row.cells[3].innerText;

                    if (debet == "0" && credit == "0") {     
                        document.getElementById("rowCount_" + iRow).classList.add('hidden');
                    }
                }
                else 
                {
                    document.getElementById("rowCount_" + iRow).classList.remove('hidden');
                }
            }            
        });

        function show() {
            document.getElementById('dataView').hidden = true;

            createHeader();
            document.getElementById('use-tBody').innerHTML = "";
            document.getElementById('boxView').innerHTML = "";

            var $iSumBeginning = 0;
            var $SumDebet = 0;
            var $SumCredit = 0;
            var $SumBalace = 0;

            $.ajax({
                dataType: 'json',
                type: "GET",
                url: '{{ env('APP_URL') }}' + "/api/report/accounting/" + document.getElementById('date_from').value + "/" + document.getElementById('date_to').value,

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




                            var dt = new Date(res[index]['date_input']);
                            if (isWeekEnd(dt) == 'Saturday') {
                                html += '<th class="text-center" style="background-color: #b9dcfd">' + res[index]['date_input'] + '</th>';                                               
                            }
                            else if (isWeekEnd(dt) == 'Sunday') {
                                html += '<th class="text-center" style="background-color: #fec8c8">' + res[index]['date_input'] + '</th>';                                                                       
                            }
                            else {
                                html += '<th class="text-center">' + res[index]['date_input'] + '</th>';                                               
                            }                                                               



                            if (res[index]['description'] == 'Begining') {
                                html += '<th style="background-color: #fff8c5">' + res[index]['description'] + '</th>';
                            }
                            else {
                                html += '<th>' + res[index]['description'] + '</th>';
                            }




                            if (res[index]['description'] == 'Begining') {
                                html += '<th></th>';
                            }
                            else {
                                if (parseFloat(res[index]['debet']) < 0) {
                                    html += '<th class="text-right text-danger">' + formatNumber(res[index]['debet'], 0) + '</th>';
                                }
                                else {
                                    html += '<th class="text-right">' + formatNumber(res[index]['debet'], 0) + '</th>';
                                }
                            }




                            if (res[index]['description'] == 'Begining') {
                                html += '<th></th>';
                            }
                            else {
                                if (parseFloat(res[index]['credit']) < 0) {
                                    html += '<th class="text-right text-danger">' + formatNumber(res[index]['credit'], 0) + '</th>';
                                }
                                else {
                                    html += '<th class="text-right">' + formatNumber(res[index]['credit'], 0) + '</th>';
                                }                            
                            }




                            if (balance < 0) {
                                // if (index == res.length - 1) {
                                //     html += '<th class="text-right text-danger" style="background-color: #a9e664">' + formatNumber(balance, 0) + '</th>';
                                // }
                                // else {
                                //     html += '<th class="text-right text-danger">' + formatNumber(balance, 0) + '</th>';
                                // }

                                html += '<th class="text-right text-danger">' + formatNumber(balance, 0) + '</th>';
                            }
                            else {
                                // if (index == res.length - 1) {
                                //     html += '<th class="text-right" style="background-color: #a9e664">' + formatNumber(balance, 0) + '</th>';
                                // }
                                // else {
                                //     html += '<th class="text-right">' + formatNumber(balance, 0) + '</th>';
                                // }

                                html += '<th class="text-right">' + formatNumber(balance, 0) + '</th>';
                            }  

                            $('#use-tBody').append(html);      
                            
                            
                            if (res[index]['description'] != 'Begining') {
                                if (res[index]['debet'] == 0 && res[index]['credit'] == 0) {
                                    if ($is_value == true) { document.getElementById("rowCount_" + index).classList.add('hidden'); }
                                    else if ($is_value == false) { document.getElementById("rowCount_" + index).classList.remove('hidden'); }
                                }
                            }
                        }





                        // fill box *******************
                        var html2 =
                        '<div class="col-12 col-sm-6 col-md-3">' +
                            '<div class="info-box">' +
                                '<span class="info-box-icon bg-yellow elevation-1"><i class="fas fa-dollar"></i></span>' +

                                '<div class="info-box-content">' +
                                    '<span class="info-box-text">Beginning</span>' +
                                    '<span class="info-box-number">' +
                                        '<small>Rp.</small> ';
                                        if (parseFloat($iSumBeginning) < 0) {
                                            html2 += '<span class="text-right text-danger">' + formatNumber($iSumBeginning, 0) + '</span>';
                                        } else {
                                            html2 += '<span>' + formatNumber($iSumBeginning, 0) + '</span>';
                                        }

                                        html2 += 
                                    '</span>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-12 col-sm-6 col-md-3">' +
                            '<div class="info-box mb-3">' +
                                '<span class="info-box-icon bg-primary elevation-1"><i class="fas fa-coffee"></i></span>' +

                                '<div class="info-box-content">' +
                                    '<span class="info-box-text">Debet</span>' +
                                    '<span class="info-box-number">' +
                                        '<small>Rp.</small> ';
                                        if (parseFloat($SumDebet) < 0) {
                                            html2 += '<span class="text-right text-danger">' + formatNumber($SumDebet, 0) + '</span>';
                                        } else {
                                            html2 += '<span>' + formatNumber($SumDebet, 0) + '</span>';
                                        }

                                        html2 += 
                                    '</span>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +

                        '<div class="clearfix hidden-md-up"></div>' +

                        '<div class="col-12 col-sm-6 col-md-3">' +
                            '<div class="info-box mb-3">' +
                                '<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-shopping-cart"></i></span>' +

                                '<div class="info-box-content">' +
                                    '<span class="info-box-text">Credit</span>' +
                                    '<span class="info-box-number">' +
                                        '<small>Rp.</small> ';
                                        if (parseFloat($SumCredit) < 0) {
                                            html2 += '<span class="text-right text-danger">' + formatNumber($SumCredit, 0) + '</span>';
                                        } else {
                                            html2 += '<span>' + formatNumber($SumCredit, 0) + '</span>';
                                        }

                                        html2 +=                                         
                                    '</span>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-12 col-sm-6 col-md-3">' +
                            '<div class="info-box mb-3">' +
                                '<span class="info-box-icon bg-success elevation-1"><i class="fas fa-bank"></i></span>' +

                                '<div class="info-box-content">' +
                                    '<span class="info-box-text">Balance</span>' +
                                    '<span class="info-box-number">' +
                                        '<small>Rp.</small> ';
                                        if (parseFloat($iSumBeginning + $SumDebet - $SumCredit) < 0) {
                                            html2 += '<span class="text-right text-danger">' + formatNumber($iSumBeginning + $SumDebet - $SumCredit, 0) + '</span>';
                                        } else {
                                            html2 += '<span>' + formatNumber($iSumBeginning + $SumDebet - $SumCredit, 0) + '</span>';
                                        }

                                        html2 +=                                         
                                    '</span>' +
                                '</div>' +
                            '</div>' +
                        '</div>';

                        $('#boxView').append(html2);            
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
                '<tr class="text-center" style="background-color: #f0f0f0">' +
                    '<th>Date</th>' +
                    '<th class="w-full">Description</th>' +
                    '<th>Debet</th>' +
                    '<th>Credit</th>' +
                    '<th>Balance</th>' +
                '</tr>';

            $('#use-tThead').append(html);
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
