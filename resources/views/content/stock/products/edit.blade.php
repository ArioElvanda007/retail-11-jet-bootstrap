@extends('layouts/app')
@section('title', $breadcrumbs[count($breadcrumbs) - 1]['name'])

@section('content')
    @include('layouts/panels/breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card card-solid">
                <form class="form" action="{{ route('stock.products.update', $query['id']) }}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label fs-5" for="code">Code</label>
                                        <input type="text" class="form-control" id="code" name="code"
                                            placeholder="Code" value="{{ $query['code'] }}" autofocus required />
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label class="form-label fs-5" for="name">Product Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Name" value="{{ $query['name'] }}" required />
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label class="form-label fs-5" for="price_buy">Price Buy</label>
                                        <input type="number" step="any" class="form-control" id="price_buy"
                                            name="price_buy" placeholder="Price Buy" value="{{ $query['price_buy'] }}" required />
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label class="form-label fs-5" for="price_sell">Price Sell</label>
                                        <input type="number" step="any" class="form-control" id="price_sell"
                                            name="price_sell" placeholder="Price Sell" value="{{ $query['price_sell'] }}" required />
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label class="form-label fs-5" for="stock">Stock (PCS)</label>
                                        <input type="number" step="any" class="form-control" id="stock"
                                            name="stock" placeholder="Stock (PCS)" value="{{ $query['stock'] }}" required />
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        
                                    </div>
                                    
                                    <div class="col-md-12 mt-3">
                                        <div class="form-check mt-1 mr-4">
                                            <input class="form-check-input" type="checkbox" id="is_update"
                                                name="is_update" value = "1" />
                                            <label for="is_update" class="form-check-label">Update Stock</label>
                                        </div>
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
            window.location.href = "{{ route('stock.products.index') }}";
        }
    </script>
@endsection
