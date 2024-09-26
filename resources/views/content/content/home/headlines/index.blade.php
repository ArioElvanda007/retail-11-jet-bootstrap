@extends('layouts/app')
@section('title', $breadcrumbs[count($breadcrumbs) - 1]['name'])

@section('content')
    @include('layouts/panels/breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="mb-2 d-flex justify-content-start justify-content-md-end d-print-none">
                <button type="button" onclick='create()' class="btn btn-dark">
                    <i class="fa fa-plus"></i>
                    <span class="ms-2">Create</span>
                </button>
            </div>
            
            @if ($query->count() > 0)
                @foreach ($query as $data)
                    <div class="card bg-light">
                        <div class="card-body pt-3">
                            <div class="row">
                                <div class="col-md-4">
                                    @if ($data->image != null && file_exists(public_path('storage/' . config('app.dir_img_headline') . '/' . $data->image)))
                                        <img src={{ config('app.url') . '/storage/' . config('app.dir_img_headline') . '/' . $data->image }}
                                            class="w-50" />
                                    @else
                                        <img src={{ URL::asset('/assets/image/Images-rafiki.svg') }} class="w-50" />
                                    @endif
                                </div>
                                <div class="col-md-7">
                                    <h2 class="lead"><b>Title: {{ $data->title }}</b></h2>
                                    <p class="text-muted text-sm"><b>Description: </b> {{ $data->description }} </p>

                                    <input class="form-check-input ml-1" type="checkbox" id="is_active" name="is_active"
                                        {{ $data->is_active == 1 ? 'checked' : '' }} disabled/>
                                    <label class="form-check-label ml-4" for="is_active">
                                        Active
                                    </label>

                                    <p class="mt-4 text-muted text-sm">create: {{ $data->created_at }}, update:
                                        {{ $data->updated_at }} </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <a href="{{ route('content.home.headlines.edit', $data->id) }}">
                                    <span class="badge bg-warning p-1"><i class="fa fa-edit"></i> Edit</span>
                                </a>

                                <a onclick="return confirm('Are you sure?')"
                                    href="{{ route('content.home.headlines.destroy', $data->id) }}">
                                    <span class="badge bg-danger p-1"><i class="fa fa-trash"></i> Delete</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center">
                    {{-- <p class="text-base font-semibold text-indigo-600">404</p> --}}
                    <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">No data result</h1>
                    <p class="mt-6 text-base leading-7 text-gray-600">Please create new data for have affected</p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        {{-- <a href="{{ route('content.home.headlines.create') }}"
                            class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Create New</a> --}}
                    </div>
                </div>
            @endif
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection

@section('page-script')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script>
        $("#example1").DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

        function create() {
            window.location.href = "{{ route('content.home.headlines.create') }}";
        }
    </script>
@endsection
