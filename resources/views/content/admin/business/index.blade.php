@extends('layouts/app')
@section('title', $breadcrumbs[count($breadcrumbs) - 1]['name'])

@section('content')
    @include('layouts/panels/breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-solid">
                <div class="card-body">

                    @if ($query)
                        <div class="card bg-light">
                            {{-- <div class="card-header text-muted border-bottom-0">
                            {{ $query['name'] }}
                        </div> --}}
                            <div class="card-body pt-3">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="lead"><b>{{ $query['name'] }}</b></h2>
                                        <p class="text-muted text-sm"><b>Description: </b> {{ $query['description'] }} </p>
                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                            <li class="small"><span class="fa-li"><i
                                                        class="fas fa-lg fa-building"></i></span>
                                                Address: {{ $query['address'] }}</li>
                                            <li class="small"><span class="fa-li"><i
                                                        class="fas fa-lg fa-phone"></i></span>
                                                Phone #: {{ $query['telephone'] }}</li>
                                            <li class="small"><span class="fa-li"><i
                                                        class="fas fa-lg fa-email"></i></span>
                                                Email #: {{ $query['email'] }}</li>
                                        </ul>

                                        <p class="mt-4 text-muted text-sm">update: {{ $query['updated_at'] }} </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <a href="{{ route('admin.business.edit', $query->id) }}" class="btn btn-sm btn-dark">
                                        <i class="fas fa-pencil mr-2"></i> Update
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center">
                            <p class="text-base font-semibold text-indigo-600">404</p>
                            <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">Page not found</h1>
                            <p class="mt-6 text-base leading-7 text-gray-600">Sorry, we couldn’t find the page you’re
                                looking for.</p>
                            <div class="mt-10 flex items-center justify-center gap-x-6">
                                <a href="{{ route('admin.business.create') }}"
                                    class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Create New</a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('page-script')
    <script>
        function create() {
            window.location.href = "{{ route('admin.business.create') }}";
        }
    </script>
@endsection
