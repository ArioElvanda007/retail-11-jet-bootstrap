@extends('layouts/app')
@section('title', $breadcrumbs[count($breadcrumbs) - 1]['name'])

@section('content')
    @include('layouts/panels/breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-solid">
                <form class="form" action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" id="name" name="name" placeholder="Name" value="{{ old('name') }}" required />

                                    <div class="invalid-feedback mt-2">{{ $errors->first('name') }}</div>                                        
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="name">Email</label>
                                    <input type="email" class="form-control @if($errors->has('email')) is-invalid @endif" id="email" name="email" placeholder="user@example.com" value="{{ old('email') }}" required />

                                    <div class="invalid-feedback mt-2">{{ $errors->first('email') }}</div>                                        
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="name">Password</label>
                                    <input type="password" class="form-control @if($errors->has('password')) is-invalid @endif" id="password" name="password" placeholder="Password" value="{{ old('password') }}" required />

                                    <div class="invalid-feedback mt-2">{{ $errors->first('password') }}</div>                                        
                                </div>
                            </div>
                            <div class="col-md-6">
                                <span class="mb-3">Roles : </span>
                                @foreach ($roles as $value)
                                    <div class="form-check mt-1">
                                        <input class="form-check-input" type="checkbox" id="{{ $value->id }}"
                                            name="roles[]" value="{{ $value->id }}" />
                                        <label for="{{ $value->id }}"
                                            class="form-check-label">{{ $value->name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="p-2 card-footer d-print-none">
                        <div class="d-flex justify-content-end">
                            <div class="form-check mt-1 mr-4">
                                <input class="form-check-input" type="checkbox" id="is_send"
                                    name="is_send" value = "1" checked />
                                <label for="is_send" class="form-check-label">Send Mail</label>
                            </div>
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
            window.location.href = "{{ route('admin.users.index') }}";
        }
    </script>
@endsection
