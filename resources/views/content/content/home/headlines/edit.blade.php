@extends('layouts/app')
@section('title', $breadcrumbs[count($breadcrumbs) - 1]['name'])

@section('content')
    @include('layouts/panels/breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-solid">
                <form class="form" action="{{ route('content.home.headlines.update', $query['id']) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12 mt-3">
                                        <label class="form-label fs-5" for="image">Image</label>
                                        {{-- <input type="file" id="image" class="form-control selectImage" name="image"
                                            placeholder="Upload Image" />
                                        @if ($query['image'] != null && file_exists(public_path('storage/' . config('app.dir_img_headline') . '/' . $query['image'])))
                                            <img id="view" class="mt-2" style="height: 300px"
                                                src={{ config('app.url') . '/storage/' . config('app.dir_img_headline') . '/' . $query['image'] }} />
                                        @else
                                            <img id="view" class="mt-2" style="height: 300px"
                                                src="{{ URL::asset('/assets/image/Upload-pana.svg') }}" />
                                        @endif --}}

                                        <div id="inputImg">
                                            <div class="input-group mb-3">
                                                <input type="file" id="image" name="image"
                                                    class="form-control selectImage" placeholder="Upload Image"
                                                    aria-label="Upload Image" aria-describedby="basic-addon2">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-danger" type="button"
                                                        onclick='resetImg()'><i class="fa fa-trash"></i></button>
                                                </div>
                                            </div>

                                            @if (
                                                $query['image'] != null &&
                                                    file_exists(public_path('storage/' . config('app.dir_img_headline') . '/' . $query['image'])))
                                                <img id="view" class="mt-2" style="height: 300px"
                                                    src={{ config('app.url') . '/storage/' . config('app.dir_img_headline') . '/' . $query['image'] }} />
                                            @else
                                                <img id="view" class="mt-2" style="height: 300px"
                                                    src="{{ URL::asset('/assets/image/Upload-pana.svg') }}" />
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="col-md-12 mt-3">
                                    <label class="form-label fs-5" for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                        placeholder="Title" value="{{ $query['title'] }}" autofocus required />
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label class="form-label fs-5" for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Description">{{ $query['description'] }}</textarea>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <input class="form-check-input ml-1" type="checkbox" id="is_active" name="is_active"
                                        {{ $query['is_active'] == 1 ? 'checked' : '' }} />
                                    <label class="form-check-label ml-4" for="is_active">
                                        Active
                                    </label>
                                </div>

                                <div class="col-md-12 mt-3" hidden>
                                    <input class="form-check-input ml-1" type="checkbox" id="is_remove" name="is_remove" />
                                    <label class="form-check-label ml-4" for="is_remove">
                                        is Image Remove
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

@section('page-script')
    <script>
        function backToList() {
            window.location.href = "{{ route('content.home.headlines.index') }}";
        }

        function resetImg() {
            document.getElementById('inputImg').innerHTML = "";

            var url = "{{ URL::asset('/assets/image/Upload-pana.svg') }}";
            var html =          
                '<div class="input-group mb-3">' +
                    '<input type="file" id="image" name="image"' +
                        'class="form-control selectImage" placeholder="Upload Image"' +
                        'aria-label="Upload Image" aria-describedby="basic-addon2">' +
                    '<div class="input-group-append">' +
                        '<button class="btn btn-outline-danger" type="button" onclick="resetImg()"><i class="fa fa-trash"></i></button>' +
                    '</div>' +
                '</div>' +

                '<img id="view" class="mt-2" style="height: 300px" src=' + url + ' />';  
            
            $('#inputImg').append(html);
            $("#is_remove").prop("checked", true);
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
