            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        @if (count($breadcrumbs) == 1)
                            <div class="col-sm-12">
                                <h1 class="m-0 text-dark">{{ $breadcrumbs[0]['name'] }}</h1>
                            </div>
                        @elseif (count($breadcrumbs) > 1)
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark">{{ $breadcrumbs[count($breadcrumbs) - 1]['name'] }}</h1>
                            </div>                                        
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    @foreach ($breadcrumbs as $key => $breadcrumb)
                                        @if ($key == count($breadcrumbs) - 1)
                                            <li class="breadcrumb-item active">{{ $breadcrumb['name'] }}</li>
                                        @else
                                            <li class="breadcrumb-item"><a href="{{ route($breadcrumb['link']) }}">{{ $breadcrumb['name'] }}</a>
                                            </li>
                                        @endif
                                    @endforeach    
                                </ol>
                            </div>
                        @endif
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
