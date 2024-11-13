@extends('layouts/app')
@section('title', $breadcrumbs[count($breadcrumbs) - 1]['name'])
@inject('provider', 'App\Http\Controllers\Function\GlobalController')

@section('content')
    @include('layouts/panels/breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-solid">
                <form class="form" action="{{ route('accounting.banks.update', $query['id']) }}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12 mt-3">
                                        <label class="form-label fs-5" for="account_number">Account Number</label>
                                        <input type="text" class="form-control" id="account_number" name="account_number"
                                            placeholder="Account Number" value="{{ $query['account_number'] }}" autofocus required />
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label class="form-label fs-5" for="account_name">Account Name</label>
                                        <input type="text" class="form-control" id="account_name" name="account_name"
                                            placeholder="Account Name" value="{{ $query['account_name'] }}" required />
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label class="form-label fs-5" for="branch_office">Office</label>
                                        <input type="text" class="form-control" id="branch_office" name="branch_office"
                                            placeholder="Office" value="{{ $query['branch_office'] }}" required />
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label class="form-label fs-5" for="behalf_of">Behalf of</label>
                                        <input type="text" class="form-control" id="behalf_of"
                                            name="behalf_of" placeholder="Behalf of" value="{{ $query['behalf_of'] }}" required />
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label class="form-label fs-5" for="description">Description</label>
                                        <textarea name="description" id="description" class="form-control" rows="3" placeholder="Description">{{ $query['description'] }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">

                            </div>
                        </div>
                    </div>

                    <div class="p-2 card-footer d-print-none">
                        <div class="d-flex justify-content-end">
                            @if ($provider::access('banks')->access[0]->can_update == 1)
                                <button class="btn btn-warning me-2" type="submit">
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
            window.location.href = "{{ route('accounting.banks.index') }}";
        }
    </script>
@endsection
