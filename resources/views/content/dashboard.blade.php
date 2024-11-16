@extends('layouts/app')
@section('title', $breadcrumbs[count($breadcrumbs) - 1]['name'])

@section('content')
    @include('layouts/panels/breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-calendar"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Sales Last Month</span>
                            <span class="info-box-number">
                                <small>Rp.</small>
                                {{ number_format($query[0]->lastMonthSales, 0, '.', ',') }}
                                {{-- <small>%</small> --}}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-calendar"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Sales This Month</span>
                            <span class="info-box-number">
                                <small>Rp.</small>
                                {{ number_format($query[0]->thisMonthSales, 0, '.', ',') }}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Sales Yesterday</span>
                            <span class="info-box-number">
                                <small>Rp.</small>
                                {{ number_format($query[0]->yesterdayDateSales, 0, '.', ',') }}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-shopping-cart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Sales Today</span>
                            <span class="info-box-number">
                                <small>Rp.</small>
                                {{ number_format($query[0]->todayDateSales, 0, '.', ',') }}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>

            <!-- chart -->
            <div class="row">
                <!-- line -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Sales Comparation</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">{{ Carbon\Carbon::parse($dateFrom)->format('Y') }}</span>
                                    <span>Sales Over Time</span>
                                </p>
                            </div>
        
                            <div class="position-relative mb-4">
                                <canvas id="sales-chart" height="200"></canvas>
                            </div>
        
                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-4">
                                    <i class="fas fa-square text-primary"></i> Sales
                                </span>
                                
                                <span class="mr-4">
                                    <i class="fas fa-square text-warning"></i> COGS
                                </span>

                                <span class="mr-4">
                                    <i class="fas fa-square text-danger"></i> Cashflow
                                </span>

                                <span>
                                    <i class="fas fa-square text-success"></i> Cuan
                                </span>
                            </div>
                        </div>
                    </div>        
                </div>                
                <!-- /.line -->

                <!-- donut -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Sales Comparation</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">{{ Carbon\Carbon::parse($dateFrom)->format('Y') }}</span>
                                    <span>Sales Over Time</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->
        
                            <div class="position-relative mb-4">
                                <div class="d-flex flex-row justify-content-center">
                                    <canvas id="donutChart" style="min-height: 200px; height: 200px; max-height: 200px; max-width: 100%;"></canvas>
                                </div>
                            </div>
        
                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2"><i class="fas fa-square" style="color: #ff3939"></i> Jan</span>
                                <span class="mr-2"><i class="fas fa-square" style="color: #ffba39"></i> Feb</span>
                                <span class="mr-2"><i class="fas fa-square" style="color: #ff9039"></i> Mar</span>
                                <span class="mr-2"><i class="fas fa-square" style="color: #fff339"></i> Apr</span>
                                <span class="mr-2"><i class="fas fa-square" style="color: #d5ff39"></i> May</span>
                                <span class="mr-2"><i class="fas fa-square" style="color: #9cff39"></i> Jun</span>
                                <span class="mr-2"><i class="fas fa-square" style="color: #39ff5a"></i> Jul</span>
                                <span class="mr-2"><i class="fas fa-square" style="color: #39ffdb"></i> Aug</span>
                                <span class="mr-2"><i class="fas fa-square" style="color: #39ccff"></i> Sep</span>
                                <span class="mr-2"><i class="fas fa-square" style="color: #3987ff"></i> Oct</span>
                                <span class="mr-2"><i class="fas fa-square" style="color: #8d39ff"></i> Nov</span>
                                <span class="mr-2"><i class="fas fa-square" style="color: #f939ff"></i> Dec</span>
                            </div>
                        </div>
                    </div>        
                </div>
                <!-- /.donut -->
            </div>
            <!-- /.chart -->

        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('page-script')
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
    
    <script>
        var chartSPCMonthly = {!! json_encode($chartSPCMonthly) !!};
        
        var saleSPCMonthly1 = chartSPCMonthly[0]['data_1']; 
        var saleSPCMonthly2 = chartSPCMonthly[0]['data_2']; 
        var saleSPCMonthly3 = chartSPCMonthly[0]['data_3']; 
        var saleSPCMonthly4 = chartSPCMonthly[0]['data_4']; 
        var saleSPCMonthly5 = chartSPCMonthly[0]['data_5']; 
        var saleSPCMonthly6 = chartSPCMonthly[0]['data_6']; 
        var saleSPCMonthly7 = chartSPCMonthly[0]['data_7']; 
        var saleSPCMonthly8 = chartSPCMonthly[0]['data_8']; 
        var saleSPCMonthly9 = chartSPCMonthly[0]['data_9']; 
        var saleSPCMonthly10 = chartSPCMonthly[0]['data_10']; 
        var saleSPCMonthly11 = chartSPCMonthly[0]['data_11']; 
        var saleSPCMonthly12 = chartSPCMonthly[0]['data_12']; 

        var COGSSPCMonthly1 = chartSPCMonthly[1]['data_1']; 
        var COGSSPCMonthly2 = chartSPCMonthly[1]['data_2']; 
        var COGSSPCMonthly3 = chartSPCMonthly[1]['data_3']; 
        var COGSSPCMonthly4 = chartSPCMonthly[1]['data_4']; 
        var COGSSPCMonthly5 = chartSPCMonthly[1]['data_5']; 
        var COGSSPCMonthly6 = chartSPCMonthly[1]['data_6']; 
        var COGSSPCMonthly7 = chartSPCMonthly[1]['data_7']; 
        var COGSSPCMonthly8 = chartSPCMonthly[1]['data_8']; 
        var COGSSPCMonthly9 = chartSPCMonthly[1]['data_9']; 
        var COGSSPCMonthly10 = chartSPCMonthly[1]['data_10']; 
        var COGSSPCMonthly11 = chartSPCMonthly[1]['data_11']; 
        var COGSSPCMonthly12 = chartSPCMonthly[1]['data_12']; 
        
        var cashflowSPCMonthly1 = chartSPCMonthly[2]['data_1']; 
        var cashflowSPCMonthly2 = chartSPCMonthly[2]['data_2']; 
        var cashflowSPCMonthly3 = chartSPCMonthly[2]['data_3']; 
        var cashflowSPCMonthly4 = chartSPCMonthly[2]['data_4']; 
        var cashflowSPCMonthly5 = chartSPCMonthly[2]['data_5']; 
        var cashflowSPCMonthly6 = chartSPCMonthly[2]['data_6']; 
        var cashflowSPCMonthly7 = chartSPCMonthly[2]['data_7']; 
        var cashflowSPCMonthly8 = chartSPCMonthly[2]['data_8']; 
        var cashflowSPCMonthly9 = chartSPCMonthly[2]['data_9']; 
        var cashflowSPCMonthly10 = chartSPCMonthly[2]['data_10']; 
        var cashflowSPCMonthly11 = chartSPCMonthly[2]['data_11']; 
        var cashflowSPCMonthly12 = chartSPCMonthly[2]['data_12']; 

        var profitSPCMonthly1 = chartSPCMonthly[3]['data_1']; 
        var profitSPCMonthly2 = chartSPCMonthly[3]['data_2']; 
        var profitSPCMonthly3 = chartSPCMonthly[3]['data_3']; 
        var profitSPCMonthly4 = chartSPCMonthly[3]['data_4']; 
        var profitSPCMonthly5 = chartSPCMonthly[3]['data_5']; 
        var profitSPCMonthly6 = chartSPCMonthly[3]['data_6']; 
        var profitSPCMonthly7 = chartSPCMonthly[3]['data_7']; 
        var profitSPCMonthly8 = chartSPCMonthly[3]['data_8']; 
        var profitSPCMonthly9 = chartSPCMonthly[3]['data_9']; 
        var profitSPCMonthly10 = chartSPCMonthly[3]['data_10']; 
        var profitSPCMonthly11 = chartSPCMonthly[3]['data_11']; 
        var profitSPCMonthly12 = chartSPCMonthly[3]['data_12']; 
                
        lineSales();
        donutSales();

        function lineSales() {
            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }

            var mode = 'index'
            var intersect = true

            var $salesChart = $('#sales-chart')
            // eslint-disable-next-line no-unused-vars
            var salesChart = new Chart($salesChart, {
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [
                        {
                            type: 'line',
                            data: [saleSPCMonthly1, saleSPCMonthly2, saleSPCMonthly3, saleSPCMonthly4, saleSPCMonthly5, saleSPCMonthly6, saleSPCMonthly7, saleSPCMonthly8, saleSPCMonthly9, saleSPCMonthly10, saleSPCMonthly11, saleSPCMonthly12],
                            backgroundColor: 'transparent',
                            borderColor: '#007bff',
                            pointBorderColor: '#007bff',
                            pointBackgroundColor: '#007bff',
                            fill: false
                        },
                        {
                            type: 'line',
                            data: [COGSSPCMonthly1, COGSSPCMonthly2, COGSSPCMonthly3, COGSSPCMonthly4, COGSSPCMonthly5, COGSSPCMonthly6, COGSSPCMonthly7, COGSSPCMonthly8, COGSSPCMonthly9, COGSSPCMonthly10, COGSSPCMonthly11, COGSSPCMonthly12],
                            backgroundColor: 'tansparent',
                            borderColor: '#e7ed5f',
                            pointBorderColor: '#e7ed5f',
                            pointBackgroundColor: '#e7ed5f',
                            fill: false
                        },
                        {
                            type: 'line',
                            data: [cashflowSPCMonthly1, cashflowSPCMonthly2, cashflowSPCMonthly3, cashflowSPCMonthly4, cashflowSPCMonthly5, cashflowSPCMonthly6, cashflowSPCMonthly7, cashflowSPCMonthly8, cashflowSPCMonthly9, cashflowSPCMonthly10, cashflowSPCMonthly11, cashflowSPCMonthly12],
                            backgroundColor: 'tansparent',
                            borderColor: '#ff4839',
                            pointBorderColor: '#ff4839',
                            pointBackgroundColor: '#ff4839',
                            fill: false
                        },
                        {
                            type: 'line',
                            data: [profitSPCMonthly1, profitSPCMonthly2, profitSPCMonthly3, profitSPCMonthly4, profitSPCMonthly5, profitSPCMonthly6, profitSPCMonthly7, profitSPCMonthly8, profitSPCMonthly9, profitSPCMonthly10, profitSPCMonthly11, profitSPCMonthly12],
                            backgroundColor: 'transparent',
                            borderColor: '#3aba02',
                            pointBorderColor: '#3aba02',
                            pointBackgroundColor: '#3aba02',
                            fill: false
                        },
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: $.extend({
                                beginAtZero: true,
                                suggestedMax: 200
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: false
                            },
                            ticks: ticksStyle
                        }]
                    }
                }
            })
        }

        function donutSales() {
            var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
            var donutData        = {
            // labels: [
            //     'Jan',
            //     'Feb',
            //     'Mar',
            //     'Apr',
            //     'May',
            //     'Jun',
            //     'Jul',
            //     'Aug',
            //     'Sep',
            //     'Oct',
            //     'Nov',
            //     'Dec',
            // ],
            datasets: [
                {
                data: [saleSPCMonthly1, saleSPCMonthly2, saleSPCMonthly3, saleSPCMonthly4, saleSPCMonthly5, saleSPCMonthly6, saleSPCMonthly7, saleSPCMonthly8, saleSPCMonthly9, saleSPCMonthly10, saleSPCMonthly11, saleSPCMonthly12],
                backgroundColor : ['#ff3939', '#ffba39', '#ff9039', '#fff339', '#d5ff39', '#9cff39', '#39ff5a', '#39ffdb', '#39ccff', '#3987ff', '#8d39ff', '#f939ff'],
                }           
            ]
            }
            var donutOptions     = {
                maintainAspectRatio : false,
                responsive : true,
            }
            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })            
        }
    </script>
@endsection
