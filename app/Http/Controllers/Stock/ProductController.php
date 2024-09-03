<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Stock\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "stock.products.index", 'name' => "Products"]
        ];

        $query = Product::get();
        return view('content.stock.products.index', compact('query'), ['breadcrumbs' => $breadcrumbs]);        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
        Product::create([
            'code' => Request::get('code'),
            'name' => Request::get('name'),
            'price_buy' => Request::get('price_buy'),
            'price_sell' => Request::get('price_sell'),
            'description' => Request::get('description'),
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
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "stock.products.index", 'name' => "Products"], ['link' => "stock/products/edit/$product->id", 'name' => "Edit Product"]
        ];

        $query = [
            'id' => $product->id,
            'code' => $product->code,
            'name' => $product->name,
            'price_buy' => $product->price_buy,
            'price_sell' => $product->price_sell,
            'description' => $product->description,
        ];
        return view('content.stock.products.edit', compact('query'), ['breadcrumbs' => $breadcrumbs]);         
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Product $product, Request $request)
    {
        $product->update([
            'code' => Request::get('code'),
            'name' => Request::get('name'),
            'price_buy' => Request::get('price_buy'),
            'price_sell' => Request::get('price_sell'),
            'description' => Request::get('description'),
        ]);

        return redirect()->route('stock.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('stock.products.index');        
    }
}
