@extends('layouts/app')
@section('title', $breadcrumbs[count($breadcrumbs) - 1]['name'])
@inject('provider', 'App\Http\Controllers\Function\GlobalController')

@section('content')
    @include('layouts/panels/breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-solid">
                <form class="form" action="{{ route('admin.business.store') }}" method="POST">
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
                                        <label class="form-label fs-5" for="address">Address</label>
                                        <textarea name="address" id="address" class="form-control" rows="3" placeholder="Address"></textarea>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label class="form-label fs-5" for="email">Email</label>
                                        <input type="email" class="form-control" id="email"
                                            name="email" placeholder="Email" value="" />
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label class="form-label fs-5" for="telephone">Telp</label>
                                        <input type="text" class="form-control" id="telephone"
                                            name="telephone" placeholder="Telephone" required />
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label class="form-label fs-5" for="description">Description</label>
                                        <textarea name="description" id="description" class="form-control" rows="3" placeholder="Description"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">

                            </div>
                        </div>
                    </div>

                    <div class="p-2 card-footer d-print-none">
                        <div class="d-flex justify-content-end">
                            @if ($provider::access('business')->access[0]->can_create == 1)
                                <button class="btn btn-primary me-2" type="submit">
                                    <i class="fa fa-save"></i>
                                    <span class="ms-2">Save</span>
                                </button>
                            @endif

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
            window.location.href = "{{ route('admin.business.index') }}";
        }
    </script>
@endsection
