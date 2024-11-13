@extends('layouts/app')
@section('title', $breadcrumbs[count($breadcrumbs) - 1]['name'])

@section('content')
    @include('layouts/panels/breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-solid">
                <form class="form" action="{{ route('admin.permissions.update', $query['id']) }}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="name">Module</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Role name" value="{{ $query['name'] }}" required disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <span class="mb-3">Menu : </span>
                                @if (count($modules) == 0)
                                    <div class="text-secondary mt-2">Not have modules available,..</div>
                                @else
                                    <div class="d-flex flex-wrap">
                                        @foreach ($modules as $value)
                                            <div class="form-check mt-1 ml-3">
                                                <input class="form-check-input" type="checkbox" id="{{ $value->id }}"
                                                    name="modules[]" value="{{ $value->id }}"
                                                    @foreach ($query['modules'] as $key => $v)
                                            @if ($value->id === $v) checked @endif @endforeach />
                                                @if ($value->is_active == 1)
                                                    <label for="{{ $value->id }}"
                                                        class="form-check-label">{{ $value->name }}</label>
                                                @else
                                                    <label for="{{ $value->id }}"
                                                        class="form-check-label text-secondary">{{ $value->name }}</label>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="p-2 card-footer d-print-none">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-warning me-2" type="submit">
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
            window.location.href = "{{ route('admin.permissions.index') }}";
        }
    </script>
@endsection
