@extends('layouts/app')
@section('title', $breadcrumbs[count($breadcrumbs) - 1]['name'])

@section('content')
    @include('layouts/panels/breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <section class="content text-xs">
        <div class="container-fluid">
            <div class="card card-solid">

                <div class="row">
                    <div class="col-3">
                        <!-- Main content -->
                        <div class="p-3 mb-3">
                            @include('components.print.header', ['header' => 'selling', 'detail' => 'selling_details', 'party' => 'customers', 'party_name' => 'Customer', 'query' => $query])
                            @include('components.print.body', ['header' => 'selling', 'detail' => 'selling_details', 'party' => 'customers', 'party_name' => 'Customer', 'query' => $query])
                            @include('components.print.footer')
                        </div>
                        <!-- /.invoice -->
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('page-script')
    <script>
        window.print();

        //close display after print
        window.addEventListener('afterprint', (event) => {
            window.location.href = "{{ route('selling.selling.create') }}";
        });
    </script>
@endsection
