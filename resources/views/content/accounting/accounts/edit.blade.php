
@extends('layouts/app')
@section('title', $breadcrumbs[count($breadcrumbs) - 1]['name'])
@inject('provider', 'App\Http\Controllers\Function\GlobalController')

@section('content')
    @include('layouts/panels/breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-solid">
                <form class="form" action="{{ route('accounting.accounts.update', $query['id']) }}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12 mt-3">
                                        <label class="form-label fs-5" for="seq">After</label>
                                        <select class="mt-2 form-control seqSelect2" style="width: 100%;"
                                            name="seq" id="seq" required>
                                            <option value="0" selected="selected">--None--</option>
                                            @foreach ($accounts as $account)
                                                <option value="{{ $account->seq }}" @if ($account->seq == $query['seq']) selected @endif>
                                                    {{ $account->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label class="form-label fs-5" for="code">Account Code</label>
                                        <input type="text" class="form-control" id="code" name="code"
                                            placeholder="Account Code" value="{{ $query['code'] }}" required autofocus/>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label class="form-label fs-5" for="name">Account Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Account Name" value="{{ $query['name'] }}" required/>
                                    </div>


                                    <div class="col-md-12 mt-3">
                                        <label class="form-label fs-5" for="position">position</label>
                                        <select class="mt-2 form-control positionSelect2" style="width: 100%;"
                                            name="position" id="position" placeholder = "DEBET/CREDIT">
                                            <option value="" selected="selected">--None--</option>
                                            <option value="DEBET" @if ($query['position'] == "DEBET") selected @endif>DEBET</option>
                                            <option value="CREDIT" @if ($query['position'] == "CREDIT") selected @endif>CREDIT</option>
                                        </select>
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
                            @if ($provider::access('accounts')->access[0]->can_update == 1)
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

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('page-script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $('.seqSelect2').select2({
            theme: 'bootstrap4'
        })

        $('.positionSelect2').select2({
            theme: 'bootstrap4'
        })
        
        function backToList() {
            window.location.href = "{{ route('accounting.accounts.index') }}";
        }
    </script>
@endsection
