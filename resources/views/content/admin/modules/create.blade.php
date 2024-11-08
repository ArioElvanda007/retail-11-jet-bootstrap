@extends('layouts/app')
@section('title', $breadcrumbs[count($breadcrumbs) - 1]['name'])

@section('content')
    @include('layouts/panels/breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-solid">
                <form class="form" action="{{ route('admin.modules.store') }}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12 mt-3">
                                        <label class="form-label fs-5" for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Name" value="" autofocus required />
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label class="form-label fs-5" for="description">Description</label>
                                        <textarea name="description" id="description" class="form-control" rows="3" placeholder="Description"></textarea>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <div class="ml-4">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                                value="1" checked />
                                            <label for="is_active" class="form-check-label fs-5 ms-1">Active</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">

                            </div>
                        </div>
                    </div>

                    <div class="p-2 card-footer d-print-none">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary me-2" type="submit">
                                <i class="fa fa-save"></i>
                                <span class="ms-2">Save</span>
                            </button>
                            <button type="button" onclick='backToList()' class="btn btn-dark">
                                <i class="fa fa-share"></i>
                                <span class="ms-2">Cancel</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('page-script')
    <script>
        function backToList() {
            window.location.href = "{{ route('admin.modules.index') }}";
        }
    </script>
@endsection
