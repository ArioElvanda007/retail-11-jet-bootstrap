@extends('layouts/app')
@section('title', $breadcrumbs[count($breadcrumbs) - 1]['name'])

@section('content')
    @include('layouts/panels/breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-solid">
                <form class="form" action="{{ route('content.home.headlines.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12 mt-3">
                                        <label class="form-label fs-5" for="image">Image</label>
                                        <div id="inputImg">
                                            <div class="input-group mb-3">
                                                <input type="file" id="image" name="image" class="form-control selectImage" placeholder="Upload Image"
                                                    aria-label="Upload Image" aria-describedby="basic-addon2">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-danger" type="button" onclick='resetImg()'><i class="fa fa-trash"></i></button>
                                                </div>
                                            </div>
    
                                            <img id="view" class="mt-2" style="height: 300px"
                                                src="{{ URL::asset('/assets/image/Upload-pana.svg') }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="col-md-12 mt-3">
                                    <label class="form-label fs-5" for="title">After</label>
                                    <select class="mt-2 form-control seq" style="width: 100%;"
                                        name="seq" id="seq" required>
                                        <option value="0" selected="selected">First</option>
                                        @foreach ($seq as $data)
                                            <option value="{{ $data->seq }}">
                                                {{ $data->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label class="form-label fs-5" for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        placeholder="Title" value="" autofocus required />
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label class="form-label fs-5" for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Description"></textarea>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <input class="form-check-input ml-1" type="checkbox" id="is_active" name="is_active"
                                        checked />
                                    <label class="form-check-label ml-4" for="is_active">
                                        Active
                                    </label>
                                </div>
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

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('page-script')
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $('.seq').select2({
            theme: 'bootstrap4'
        })

        function backToList() {
            window.location.href = "{{ route('content.home.headlines.index') }}";
        }

        function resetImg() {
            document.getElementById('inputImg').innerHTML = "";

            var url = "{{ URL::asset('/assets/image/Upload-pana.svg') }}";
            var html = 
                '<div class="input-group mb-3">' +
                    '<input type="file" id="image" name="image" class="form-control selectImage" placeholder="Upload Image" aria-label="Upload Image" aria-describedby="basic-addon2">' +
                    '<div class="input-group-append">' +
                        '<button class="btn btn-outline-danger" type="button" onclick="resetImg()"><i class="fa fa-trash"></i></button>' +
                    '</div>' +
                '</div>' +

                '<img id="view" class="mt-2" style="height: 300px" src=' + url + ' />';     
            
            $('#inputImg').append(html);
        }

        //**** Image *************************
        $(document).on('change', '.selectImage', function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#view').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endsection
