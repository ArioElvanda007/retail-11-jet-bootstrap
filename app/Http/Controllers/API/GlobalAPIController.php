<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buying\Supplier;
use App\Models\Stock\Product;

class GlobalAPIController extends Controller
{
    public function selectSupplier(Supplier $supplier)
    {
        $query = [
            'id' => $supplier->id,
            'code' => $supplier->code,
            'name' => $supplier->name,
            'address' => $supplier->address,
            'email' => $supplier->email,
            'telephone' => $supplier->telephone,
            'description' => $supplier->description,
        ];

        return response()->json($query);
    }

    public function selectProductID(Product $product)
    {
        $query = [
            'id' => $product->id,
            'code' => $product->code,
            'name' => $product->name,
            'price_buy' => $product->price_buy,
            'price_sell' => $product->price_sell,
            'description' => $product->description,
        ];

        return response()->json($query);
    }

    public function selectProductCode($product)
    {
        $query = Product::where('code', '=', $product)->first();
        return response()->json($query);
    }
}
