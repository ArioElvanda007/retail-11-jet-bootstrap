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
                            <input type="date" class="form-control" id="date_from" name="date_from" placeholder="Date From"
                                value="{{ date('Y-m-d', strtotime($date_from)) }}" required />
                        </div>

                        <div class="col-md-3 col-6 mb-2">
                            <label class="form-label fs-5" for="date_to">Date To</label>
                            <input type="date" class="form-control" id="date_to" name="date_from" placeholder="Date To"
                                value="{{ date('Y-m-d', strtotime($date_to)) }}" required />
                        </div>

                        <div class="col-md-3 col-6 mb-2 d-flex align-items-end">
                            <button type="button" id="btnSearch" name="btnSearch" class="btn btn-primary show"
                                onclick='show()'>
                                <i class="fa fa-search"></i>
                            </button>
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

@section('page-script')
    <script>
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
                                '<tr>';




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
                                    html += '<th class="text-right text-danger">' + formatNumber(res[index]['debet']) + '</th>';
                                }
                                else {
                                    html += '<th class="text-right">' + formatNumber(res[index]['debet']) + '</th>';
                                }
                            }




                            if (res[index]['description'] == 'Begining') {
                                html += '<th></th>';
                            }
                            else {
                                if (parseFloat(res[index]['credit']) < 0) {
                                    html += '<th class="text-right text-danger">' + formatNumber(res[index]['credit']) + '</th>';
                                }
                                else {
                                    html += '<th class="text-right">' + formatNumber(res[index]['credit']) + '</th>';
                                }                            
                            }




                            if (balance < 0) {
                                html += '<th class="text-right text-danger">' + balance.toLocaleString() + '</th>';
                            }
                            else {
                                html += '<th class="text-right">' + balance.toLocaleString() + '</th>';
                            }  

                            $('#use-tBody').append(html);            
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
                                            html2 += '<span class="text-right text-danger">' + $iSumBeginning.toLocaleString() + '</span>';
                                        } else {
                                            html2 += '<span>' + $iSumBeginning.toLocaleString() + '</span>';
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
                                            html2 += '<span class="text-right text-danger">' + $SumDebet.toLocaleString() + '</span>';
                                        } else {
                                            html2 += '<span>' + $SumDebet.toLocaleString() + '</span>';
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
                                            html2 += '<span class="text-right text-danger">' + $SumCredit.toLocaleString() + '</span>';
                                        } else {
                                            html2 += '<span>' + $SumCredit.toLocaleString() + '</span>';
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
                                            html2 += '<span class="text-right text-danger">' + ($iSumBeginning + $SumDebet - $SumCredit).toLocaleString() + '</span>';
                                        } else {
                                            html2 += '<span>' + ($iSumBeginning + $SumDebet - $SumCredit).toLocaleString() + '</span>';
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
                '<tr>' +
                    '<th>Date</th>' +
                    '<th>Description</th>' +
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
