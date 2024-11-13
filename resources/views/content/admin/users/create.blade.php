@extends('layouts/app')
@section('title', $breadcrumbs[count($breadcrumbs) - 1]['name'])
@inject('provider', 'App\Http\Controllers\Function\GlobalController')

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
                                    <input type="text"
                                        class="form-control @if ($errors->has('name')) is-invalid @endif"
                                        id="name" name="name" placeholder="Name" value="{{ old('name') }}"
                                        required />

                                    <div class="invalid-feedback mt-2">{{ $errors->first('name') }}</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="name">Email</label>
                                    <input type="email"
                                        class="form-control @if ($errors->has('email')) is-invalid @endif"
                                        id="email" name="email" placeholder="user@example.com"
                                        value="{{ old('email') }}" required />

                                    <div class="invalid-feedback mt-2">{{ $errors->first('email') }}</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="name">Password</label>
                                    <input type="password"
                                        class="form-control @if ($errors->has('password')) is-invalid @endif"
                                        id="password" name="password" placeholder="Password" value="{{ old('password') }}"
                                        required />

                                    <div class="invalid-feedback mt-2">{{ $errors->first('password') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <span class="mb-3 ml-3">Roles : </span>
                                <div class="d-flex flex-wrap">
                                    @foreach ($roles as $value)
                                        <div class="form-check mt-1 ml-3">
                                            <input class="form-check-input roles" type="checkbox" id="{{ $value->id }}"
                                                name="roles[]" value="{{ $value->id }}" onclick="clickRole()" />

                                            <label for="{{ $value->id }}" class="form-check-label ml-1"
                                                id="name_role_{{ $value->id }}">{{ $value->name }}</label>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="row mt-4 ml-3" id="use-access">
                                    <span>Access : </span>
                                    <table class="table table-bordered table-sm mt-2">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center align-middle" rowspan="2" hidden>
                                                    access_lock</th>
                                                <th scope="col" class="text-center align-middle" rowspan="2" hidden>
                                                    permission_id</th>
                                                <th scope="col" class="text-center align-middle" rowspan="2" hidden>
                                                    module_id</th>
                                                <th scope="col" class="text-center align-middle" rowspan="2">
                                                    Module</th>
                                                <th scope="col" class="text-center align-middle" rowspan="2">Menu
                                                </th>
                                                <th scope="col" class="text-center align-middle">View</th>
                                                <th scope="col" class="text-center align-middle">Create</th>
                                                <th scope="col" class="text-center align-middle">Update</th>
                                                <th scope="col" class="text-center align-middle">Delete</th>
                                            </tr>

                                            <tr>
                                                <th scope="col" class="align-middle text-center">
                                                    <input type="checkbox" id="is_view" name="is_view" onclick='select_is_view()' />
                                                </th>
                                                <th scope="col" class="align-middle text-center">
                                                    <input type="checkbox" id="is_create" name="is_create" onclick='select_is_create()' />
                                                </th>
                                                <th scope="col" class="align-middle text-center">
                                                    <input type="checkbox" id="is_update" name="is_update" onclick='select_is_update()' />
                                                </th>
                                                <th scope="col" class="align-middle text-center">
                                                    <input type="checkbox" id="is_delete" name="is_delete" onclick='select_is_delete()' />
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="use-tbody">
                                            <tr class="rowCount" id="rowCount_1">
                                                <td colspan="8" class="text-center">
                                                    <span class="text-secondary">Please selected roles</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="p-2 card-footer d-print-none">
                        <div class="d-flex justify-content-end">
                            <div class="form-check mt-1 mr-4">
                                <input class="form-check-input" type="checkbox" id="is_send" name="is_send" value = "1"
                                    checked />
                                <label for="is_send" class="form-check-label">Send Mail</label>
                            </div>

                            @if ($provider::access('users')->access[0]->can_create == 1)
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
        function select_is_view(){
            var value = document.getElementById('is_view').checked;
            var chk = document.getElementsByClassName('is_view');  
            for(var i = 0; i < chk.length; i++){                  
                if (document.getElementById("temps[" + i + "][access_lock]").value == "0") {
                    chk[i].checked = value;  
                }
            }  
        }

        function select_is_create(){
            var value = document.getElementById('is_create').checked;
            var chk = document.getElementsByClassName('is_create');  
            for(var i = 0; i < chk.length; i++){                  
                if (document.getElementById("temps[" + i + "][access_lock]").value == "0") {
                    chk[i].checked = value;  
                }
            }  
        }

        function select_is_update(){  
            var value = document.getElementById('is_update').checked;
            var chk = document.getElementsByClassName('is_update');  
            for(var i = 0; i < chk.length; i++){                  
                if (document.getElementById("temps[" + i + "][access_lock]").value == "0") {
                    chk[i].checked = value;  
                }
            }  
        }

        function select_is_delete(){  
            var value = document.getElementById('is_delete').checked;
            var chk = document.getElementsByClassName('is_delete');  
            for(var i = 0; i < chk.length; i++){                  
                if (document.getElementById("temps[" + i + "][access_lock]").value == "0") {
                    chk[i].checked = value;  
                }
            }  
        }

        function clickRole() {
            document.getElementById('use-tbody').innerHTML = "";

            var inputs = document.querySelectorAll('.roles');
            var sid;
            var svalue;
            let slabel = "";
            var shaveCheck = false;
            let slabelCollect = "";
            for (var i = 0; i < inputs.length; i++) {
                sid = inputs[i].id;
                svalue = inputs[i].checked;
                // slabel = document.getElementById('name_role_' + sid).innerHTML;
                slabel = document.getElementById(sid).value;

                if (svalue == true) {
                    shaveCheck = true;
                    if (slabelCollect == "") {
                        slabelCollect = slabel;
                    } else {
                        slabelCollect = slabelCollect + "," +  slabel;
                    }
                }
            }

            if (shaveCheck == true) {
                fillData(slabelCollect);
            } else if (shaveCheck == false) {
                $("#use-tbody").append(
                    '<tr class="rowCount" id="rowCount_1">' +
                    '<td colspan="8" class="text-center">' +
                    '<span class="text-secondary">Please selected roles</span>' +
                    '</td>' +
                    '</tr>'
                );
            }
        }

        function fillData(slabelCollect) {
            if (slabelCollect == "") {
                return;
            }

            $.ajax({
                dataType: 'json',
                type: "GET",
                url: '{{ env('APP_URL') }}' + "/api/global/select-module/create/" + slabelCollect,

                success: function(res) {
                    if (res.length > 0) {
                        var html;
                        for (let index = 0; index < res.length; index++) {
                            if (res[index]['access_lock'] == 1) {
                                html += '<tr class="rowCount" style="background-color:#f5f5f5;" id="rowCount_' +
                                    index + '" name="rowCount_' + index + '">';
                            } else {
                                html += '<tr class="rowCount" id="rowCount_' + index + '" name="rowCount_' +
                                    index + '">';
                            }

                            html += '<td hidden><input type="text" class="form-control" id="temps[' + index + '][access_lock]" name="temps[' + index + '][access_lock]" value="' + res[index]['access_lock'] + '" /></td>';
                            html += '<td hidden><input type="text" class="form-control" id="temps[' + index + '][permission_id]" name="temps[' + index + '][permission_id]" value="' + res[index]['permission_id'] + '" /></td>';
                            html += '<td hidden><input type="text" class="form-control" id="temps[' + index + '][module_id]" name="temps[' + index + '][module_id]" value="' + res[index]['module_id'] + '" /></td>';
                            html += '<td id="temps[' + index + '][permission_name]" name="temps[' + index + '][permission_name]">' + res[index]['permission_name'] + '</td>';
                            html += '<td id="temps[' + index + '][module_name]" name="temps[' + index + '][module_name]">' + res[index]['module_name'] + '</td>';

                            if (res[index]['can_view'] == 1) {
                                if ((res[index]['access_lock'] == 0)) {
                                    html +=
                                        '<td class="align-middle text-center"><input class="is_view" type="checkbox" id="temps[' + index + '][can_view]" name="temps[' + index + '][can_view]" value="1" checked /></td>';
                                } else {
                                    html +=
                                        '<td class="align-middle text-center"><input class="is_view" type="checkbox" id="temps[' + index + '][can_view]" name="temps[' + index + '][can_view]" value="1" checked disabled /></td>';
                                }
                            } else {
                                if ((res[index]['access_lock'] == 0)) {
                                    html +=
                                        '<td class="align-middle text-center"><input class="is_view" type="checkbox" id="temps[' + index + '][can_view]" name="temps[' + index + '][can_view]" value="1" /></td>';
                                } else {
                                    html +=
                                        '<td class="align-middle text-center"><input class="is_view" type="checkbox" id="temps[' + index + '][can_view]" name="temps[' + index + '][can_view]" value="1" disabled /></td>';
                                }
                            }

                            if (res[index]['can_create'] == 1) {
                                if ((res[index]['access_lock'] == 0)) {
                                    html +=
                                        '<td class="align-middle text-center"><input class="is_create" type="checkbox" id="temps[' + index + '][can_create]" name="temps[' + index + '][can_create]" value="1" checked /></td>';
                                } else {
                                    html +=
                                        '<td class="align-middle text-center"><input class="is_create" type="checkbox" id="temps[' + index + '][can_create]" name="temps[' + index + '][can_create]" value="1" checked disabled /></td>';
                                }
                            } else {
                                if ((res[index]['access_lock'] == 0)) {
                                    html +=
                                        '<td class="align-middle text-center"><input class="is_create" type="checkbox" id="temps[' + index + '][can_create]" name="temps[' + index + '][can_create]" value="1" /></td>';
                                } else {
                                    html +=
                                        '<td class="align-middle text-center"><input class="is_create" type="checkbox" id="temps[' + index + '][can_create]" name="temps[' + index + '][can_create]" value="1" disabled /></td>';
                                }
                            }

                            if (res[index]['can_update'] == 1) {
                                if ((res[index]['access_lock'] == 0)) {
                                    html +=
                                        '<td class="align-middle text-center"><input class="is_update" type="checkbox" id="temps[' + index + '][can_update]" name="temps[' + index + '][can_update]" value="1" checked /></td>';
                                } else {
                                    html +=
                                        '<td class="align-middle text-center"><input class="is_update" type="checkbox" id="temps[' + index + '][can_update]" name="temps[' + index + '][can_update]" value="1" checked disabled /></td>';
                                }
                            } else {
                                if ((res[index]['access_lock'] == 0)) {
                                    html +=
                                        '<td class="align-middle text-center"><input class="is_update" type="checkbox" id="temps[' + index + '][can_update]" name="temps[' + index + '][can_update]" value="1" /></td>';
                                } else {
                                    html +=
                                        '<td class="align-middle text-center"><input class="is_update" type="checkbox" id="temps[' + index + '][can_update]" name="temps[' + index + '][can_update]" value="1" disabled /></td>';
                                }
                            }

                            if (res[index]['can_delete'] == 1) {
                                if ((res[index]['access_lock'] == 0)) {
                                    html +=
                                        '<td class="align-middle text-center"><input class="is_delete" type="checkbox" id="temps[' + index + '][can_delete]" name="temps[' + index + '][can_delete]" value="1" checked /></td>';
                                } else {
                                    html +=
                                        '<td class="align-middle text-center"><input class="is_delete" type="checkbox" id="temps[' + index + '][can_delete]" name="temps[' + index + '][can_delete]" value="1" checked disabled /></td>';
                                }
                            } else {
                                if ((res[index]['access_lock'] == 0)) {
                                    html +=
                                        '<td class="align-middle text-center"><input class="is_delete" type="checkbox" id="temps[' + index + '][can_delete]" name="temps[' + index + '][can_delete]" value="1" /></td>';
                                } else {
                                    html +=
                                        '<td class="align-middle text-center"><input class="is_delete" type="checkbox" id="temps[' + index + '][can_delete]" name="temps[' + index + '][can_delete]" value="1" disabled /></td>';
                                }
                            }

                            html += '</tr>';
                        }

                        $("#use-tbody").append(html);

                        //span row
                        var spermission = "";
                        var ipermission = 0;
                        var iipermission = 0;

                        for (let index = 0; index < res.length; index++) {
                            if (spermission == "") {
                                spermission = res[index]['permission_name'];
                                ipermission = 1;
                                iipermission = index;
                            } else if (spermission == res[index]['permission_name']) {
                                spermission = res[index]['permission_name'];
                                ipermission = ipermission + 1;
                            } else if (spermission != res[index]['permission_name']) {
                                //remove row before span
                                for (let r = iipermission + 1; r < iipermission + ipermission; r++) {
                                    document.getElementById("temps[" + r + "][permission_name]").remove();
                                }

                                //execute
                                document.getElementById("temps[" + iipermission + "][permission_name]").rowSpan =
                                    ipermission;

                                iipermission = index;
                                spermission = res[index]['permission_name'];
                                ipermission = 1;
                            }
                        }

                        select_is_create();
                        select_is_update();
                        select_is_delete();
                    } else {
                        $("#use-tbody").append(
                            '<tr class="rowCount" id="rowCount_1">' +
                            '<td colspan="8" class="text-center">' +
                            '<span class="text-secondary">Data roles not found</span>' +
                            '</td>' +
                            '</tr>'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error API connection');
                    return;
                }
            });
        }

        function backToList() {
            window.location.href = "{{ route('admin.users.index') }}";
        }
    </script>
@endsection
