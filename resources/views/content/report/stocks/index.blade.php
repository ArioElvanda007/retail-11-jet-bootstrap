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

@section('page-script')
    <script>
        selectType(document.getElementById('type').value);

        function show() {
            document.getElementById('dataView').hidden = true;
            createHeader(document.getElementById('type').value);
            document.getElementById('use-tBody').innerHTML = "";
            
            $.ajax({
                dataType: 'json',
                type: "GET",
                url: '{{ env('APP_URL') }}' + "/api/report/stock/" + document.getElementById('date_from').value + "/" + document.getElementById('type').value,

                beforeSend: function() {
                    setButton();
                },
                complete: function() {
                    setButton();
                },
                success: function(res) {
                    let iCol = 0;
                    if (document.getElementById('type').value == 0) {
                        iCol = 33;
                    } else {
                        iCol = 130;
                    }        
                    
                    if (res.length > 0) {  
                        for (let index = 0; index < res.length; index++) {     
                            var html = 
                                '<tr>' +
                                    '<td>' + res[index]['code'] + '</td>' +
                                    '<td>' + res[index]['name'] + '</td>'
                            ;   
                            
                            let iStock = 0;
                            let sAdj = "";
                            let sBuy = "";
                            let sSell = "";
                            let sStock = "";

                            for (let col = 0; col <= 31; col++) {  
                                iStock += parseFloat(res[index]['adj_date' + col.toString().padStart(2, '0')]) + parseFloat(res[index]['buy_date' + col.toString().padStart(2, '0')]) - parseFloat(res[index]['sell_date' + col.toString().padStart(2, '0')]);                           
                                    
                                sAdj = res[index]['adj_date' + col.toString().padStart(2, '0')].toLocaleString();
                                if (sAdj == 0) { sAdj = ""; }
                                if (col == 0) { sAdj = ""; }

                                sBuy = res[index]['buy_date' + col.toString().padStart(2, '0')].toLocaleString();
                                if (sBuy == 0) { sBuy = ""; }
                                if (col == 0) { sBuy = ""; }
                                
                                sSell = res[index]['sell_date' + col.toString().padStart(2, '0')].toLocaleString();
                                if (sSell == 0) { sSell = ""; }
                                if (col == 0) { sSell = ""; }

                                sStock = iStock.toLocaleString();
                                if (sStock == 0) { sStock = ""; }   
                                


                                
                                if (document.getElementById('type').value == 0) {
                                    html += 
                                        '<td class="text-right">' + sStock + '</td>'
                                    ;                                     
                                }
                                else if (document.getElementById('type').value == 1)
                                {
                                    html += 
                                        '<td class="text-right">' + sAdj + '</td>' +
                                        '<td class="text-right">' + sBuy + '</td>' +
                                        '<td class="text-right">' + sSell + '</td>' +
                                        '<td class="text-right" style="background-color: #e5ffc5">' + sStock + '</td>'
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
                        '<th style="background-color: #f0f0f0">Code</th>' +
                        '<th style="background-color: #f0f0f0">Name</th>' +
                        '<th style="background-color: #fff8c5">Begining</th>'
                ;

                for (let index = 0; index < 31; index++) {   
                    var dt = new Date(document.getElementById('date_from').value);
                    dt.setDate(dt.getDate() + index);

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
                        '<th class="align-middle" style="background-color: #f0f0f0" rowspan="2">Code</th>' +
                        '<th class="align-middle" style="background-color: #f0f0f0" rowspan="2">Name</th>' +
                        '<th style="background-color: #fff8c5" class="text-center" colspan="4">Begining</th>'
                ;

                for (let index = 0; index < 31; index++) {   
                    var dt = new Date(document.getElementById('date_from').value);
                    dt.setDate(dt.getDate() + index);

                    if (isWeekEnd(dt) == 'Saturday') {
                        html += '<th class="text-center" style="background-color: #b9dcfd" colspan="4">' + formatDate(new Date(dt), [{month: 'numeric'}, {day: 'numeric'}], '-') + '</th>';                                               
                    }
                    else if (isWeekEnd(dt) == 'Sunday') {
                        html += '<th class="text-center" style="background-color: #fec8c8" colspan="4">' + formatDate(new Date(dt), [{month: 'numeric'}, {day: 'numeric'}], '-') + '</th>';                                                                       
                    }
                    else {
                        html += '<th class="text-center" style="background-color: #f0f0f0" colspan="4">' + formatDate(new Date(dt), [{month: 'numeric'}, {day: 'numeric'}], '-') + '</th>';                                               
                    }
                }

                html += '</tr>';


                html += 
                    '<tr>' +
                        '<th class="text-center" style="background-color: #fff8c5">Adj</th>' +                                            
                        '<th class="text-center" style="background-color: #fff8c5">Buy</th>' +                                            
                        '<th class="text-center" style="background-color: #fff8c5">Sell</th>' +                                            
                        '<th class="text-center" style="background-color: #fff8c5">Stock</th>'
                ;

                for (let index = 0; index < 31; index++) {   
                    var dt = new Date(document.getElementById('date_from').value);
                    dt.setDate(dt.getDate() + index);

                    if (isWeekEnd(dt) == 'Saturday') {
                        html += 
                            '<th class="text-center" style="background-color: #b9dcfd">Adj</th>' +
                            '<th class="text-center" style="background-color: #b9dcfd">Buy</th>' +
                            '<th class="text-center" style="background-color: #b9dcfd">Sell</th>' +
                            '<th class="text-center" style="background-color: #b9dcfd">Stock</th>'
                        ;                                               
                    }
                    else if (isWeekEnd(dt) == 'Sunday') {
                        html += 
                            '<th class="text-center" style="background-color: #fec8c8">Adj</th>' +
                            '<th class="text-center" style="background-color: #fec8c8">Buy</th>' +
                            '<th class="text-center" style="background-color: #fec8c8">Sell</th>' +
                            '<th class="text-center" style="background-color: #fec8c8">Stock</th>'
                        ;                                               
                    }
                    else {
                        html += 
                            '<th class="text-center" style="background-color: #f0f0f0">Adj</th>' +
                            '<th class="text-center" style="background-color: #f0f0f0">Buy</th>' +
                            '<th class="text-center" style="background-color: #f0f0f0">Sell</th>' +
                            '<th class="text-center" style="background-color: #f0f0f0">Stock</th>'
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
