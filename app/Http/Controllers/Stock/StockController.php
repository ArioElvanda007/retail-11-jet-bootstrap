<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Stock\Stock;
use App\Models\Stock\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"],
            ['link' => "stock.stocks.index", 'name' => "Adjustments"]
        ];

        if (Request::get("date_from")) {
            $date_from = date('Y-m-d', strtotime(Request::get('date_from')));
            $date_to = date('Y-m-d', strtotime(Request::get('date_to')));  
        } else {
            $date_from = Carbon::now()->addDays(-31);
            $date_to = Carbon::now();
        }

        $query = Stock::with('products', 'users')->whereBetween('date_input', [$date_from, $date_to])->get();
        dd($query);
        return view('content.stock.stocks.index', compact('query', 'date_from', 'date_to'), ['breadcrumbs' => $breadcrumbs]);               
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"],
            ['link' => "stock.stocks.index", 'name' => "Adjustments"],
            ['link' => "stock.stocks.create", 'name' => "Create Adjustment"]
        ];

        $date_input = Carbon::now();
        $products = Product::get();

        return view('content.stock.stocks.create', compact('date_input', 'products'), ['breadcrumbs' => $breadcrumbs]);         
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        foreach (Request::get('temps') as $key => $value) {
            if ($value['id'] != null) {
                $prod_id = $value['id'];
                $date_input = date('Y-m-d', strtotime(Request::get('date_input')));
               
                $query = DB::select("CALL spStock($prod_id, '$date_input')");
                Stock::create([
                    'prod_id' => $value['id'],
                    'title' => Request::get('title'),
                    'date_input' => $date_input,
                    'stock' => $query[0]->stock,
                    'rate' => $value['rate'] - $query[0]->stock,
                    'adjust' => $value['rate'],
                    'note' => $value['note'],
                    'user_id' => Auth::user()->id,
                ]);
            }
        }

        return redirect()->route('stock.stocks.create')->with('message', 'create success');
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
    public function edit(Stock $stock)
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "stock.stocks.index", 'name' => "Adjustments"], ['link' => "stock/stocks/edit/$stock->id", 'name' => "Edit Adjustment"]
        ];

        $query = Stock::with('products', 'users')->where('id', '=', $stock->id)->first();
        $products = Product::get();

        return view('content.stock.stocks.edit', compact('query', 'products'), ['breadcrumbs' => $breadcrumbs]);            
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        foreach (Request::get('temps') as $key => $value) {
            if ($value['id'] != null) {
                if ($value['stock_id'] != null) {
                    Stock::where('id', '=', $value['stock_id'])->delete();
                }
                
                $prod_id = $value['id'];
                $date_input = date('Y-m-d', strtotime(Request::get('date_input')));

                $query = DB::select("CALL spStock($prod_id, '$date_input')");
                Stock::create([
                    'prod_id' => $value['id'],
                    'title' => Request::get('title'),
                    'date_input' => $date_input,
                    'stock' => $query[0]->stock,
                    'rate' => $value['rate'] - $query[0]->stock,
                    'adjust' => $value['rate'],
                    'note' => $value['note'],
                    'user_id' => Auth::user()->id,
                ]);  
            }          
        }

        return redirect()->route('stock.stocks.index')->with('message', 'update success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        $stock->delete();
        
        return redirect()->route('stock.stocks.index')->with('message', 'delete success');        
    }
}
