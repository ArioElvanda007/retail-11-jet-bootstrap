<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Stock\Product;
use App\Models\Stock\Stock;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    private function can_access()
    {
        return "App\Http\Controllers\Function\GlobalController";
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (app($this->can_access())->access('products')->access[0]->modules->is_active == 0 || app($this->can_access())->access('products')->access[0]->can_view == 0) {
            return abort(401);
        } 

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "stock.products.index", 'name' => "Products"]
        ];

        $dateFrom = Carbon::now()->format('Y-m-d');
        $query = DB::select("CALL spStock(0, '$dateFrom')"); //Product::get();
        return view('content.stock.products.index', compact('query'), ['breadcrumbs' => $breadcrumbs]);        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (app($this->can_access())->access('products')->access[0]->modules->is_active == 0 || app($this->can_access())->access('products')->access[0]->can_create == 0) {
            return abort(401);
        } 

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "stock.products.index", 'name' => "Products"], ['link' => "stock.products.create", 'name' => "Create Product"]
        ];

        return view('content.stock.products.create', ['breadcrumbs' => $breadcrumbs]);         
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (app($this->can_access())->access('products')->access[0]->modules->is_active == 0 || app($this->can_access())->access('products')->access[0]->can_create == 0) {
            return abort(401);
        } 

        $product = Product::create([
            'code' => Request::get('code'),
            'name' => Request::get('name'),
            'price_buy' => Request::get('price_buy'),
            'price_sell' => Request::get('price_sell'),
            'description' => Request::get('description'),
        ]);

        Stock::create([
            'prod_id' => $product->id,
            'title' => 'create new product',
            'date_input' => Carbon::now()->format('Y-m-d'),
            'rate' => Request::get('stock'),
            'adjust' => Request::get('stock'),
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('stock.products.index');         
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        if (app($this->can_access())->access('products')->access[0]->modules->is_active == 0 || app($this->can_access())->access('products')->access[0]->can_update == 0) {
            return abort(401);
        } 

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "stock.products.index", 'name' => "Products"], ['link' => "stock/products/edit/$product->id", 'name' => "Edit Product"]
        ];

        $dateFrom = Carbon::now()->format('Y-m-d');
        $sp = DB::select("CALL spStock($product->id, '$dateFrom')"); //Product::get();

        $query = [
            'id' => $sp[0]->id,
            'code' => $sp[0]->code,
            'name' => $sp[0]->name,
            'stock' => $sp[0]->stock,
            'price_buy' => $sp[0]->price_buy,
            'price_sell' => $sp[0]->price_sell,
            'description' => $sp[0]->description,
        ];
        return view('content.stock.products.edit', compact('query'), ['breadcrumbs' => $breadcrumbs]);         
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Product $product, Request $request)
    {
        if (app($this->can_access())->access('products')->access[0]->modules->is_active == 0 || app($this->can_access())->access('products')->access[0]->can_update == 0) {
            return abort(401);
        } 

        $product->update([
            'code' => Request::get('code'),
            'name' => Request::get('name'),
            'price_buy' => Request::get('price_buy'),
            'price_sell' => Request::get('price_sell'),
            'description' => Request::get('description'),
        ]);

        if (Request::get('is_update') == 1) {
            $prod_id = $product->id;
            $date_input = Carbon::now()->format('Y-m-d');
            
            $query = DB::select("CALL spStock($prod_id, '$date_input')");
            Stock::create([
                'prod_id' => $product->id,
                'title' => 'update product ' . Carbon::now(),
                'date_input' => Carbon::now()->format('Y-m-d'),
                'stock' => $query[0]->stock,
                'rate' => Request::get('stock') - $query[0]->stock,
                'adjust' => Request::get('stock'),
                'user_id' => Auth::user()->id,
            ]);
        }

        return redirect()->route('stock.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (app($this->can_access())->access('products')->access[0]->modules->is_active == 0 || app($this->can_access())->access('products')->access[0]->can_delete == 0) {
            return abort(401);
        } 

        $product->delete();

        return redirect()->route('stock.products.index');        
    }
}
