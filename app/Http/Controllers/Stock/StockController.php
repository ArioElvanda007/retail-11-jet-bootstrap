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
    private function can_access()
    {
        return "App\Http\Controllers\Function\GlobalController";
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (app($this->can_access())->access('adjustment')->access->count() == 0 || app($this->can_access())->access('adjustment')->access[0]->modules->is_active == 0 || app($this->can_access())->access('adjustment')->access[0]->can_view == 0) {
            return abort(401);
        } 

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"],
            ['link' => "stock.stocks.index", 'name' => "Adjustments"]
        ];

        if (Request::get("date_from")) {
            $date_from = date('Y-m-d', strtotime(Request::get('date_from')));
            $date_to = date('Y-m-d', strtotime(Request::get('date_to')));  
        } else {
            $date_from = date('Y-m-d', strtotime(Carbon::now()->addDays(-30)));
            $date_to = date('Y-m-d', strtotime(Carbon::now()));
        }

        // dd([$date_from, $date_to]);

        // $query = Stock::with('products', 'users')->whereBetween('date_input', [$date_from, $date_to])->get();
        $query = DB::select(
            "SELECT 
                A.id, A.prod_id, B.code, B.name, A.title, A.date_input, A.stock, A.rate, A.adjust, A.note, A.user_id, C.name AS user_entry, A.created_at, A.updated_at
            FROM
                stocks AS A
            LEFT OUTER JOIN
                products AS B ON A.prod_id = B.id
            LEFT OUTER JOIN
                users AS C ON A.user_id = C.id
            WHERE DATE(A.date_input) BETWEEN '$date_from' AND '$date_to'
        ");

        // dd($query);

        return view('content.stock.stocks.index', compact('query', 'date_from', 'date_to'), ['breadcrumbs' => $breadcrumbs]);               
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (app($this->can_access())->access('adjustment')->access->count() == 0 || app($this->can_access())->access('adjustment')->access[0]->modules->is_active == 0 || app($this->can_access())->access('adjustment')->access[0]->can_create == 0) {
            return abort(401);
        }

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
        if (app($this->can_access())->access('adjustment')->access->count() == 0 || app($this->can_access())->access('adjustment')->access[0]->modules->is_active == 0 || app($this->can_access())->access('adjustment')->access[0]->can_create == 0) {
            return abort(401);
        }

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
        if (app($this->can_access())->access('adjustment')->access->count() == 0 || app($this->can_access())->access('adjustment')->access[0]->modules->is_active == 0 || app($this->can_access())->access('adjustment')->access[0]->can_update == 0) {
            return abort(401);
        } 

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
        if (app($this->can_access())->access('adjustment')->access->count() == 0 || app($this->can_access())->access('adjustment')->access[0]->modules->is_active == 0 || app($this->can_access())->access('adjustment')->access[0]->can_update == 0) {
            return abort(401);
        } 

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
        if (app($this->can_access())->access('adjustment')->access->count() == 0 || app($this->can_access())->access('adjustment')->access[0]->modules->is_active == 0 || app($this->can_access())->access('adjustment')->access[0]->can_delete == 0) {
            return abort(401);
        }

        $stock->delete();
        
        return redirect()->route('stock.stocks.index')->with('message', 'delete success');        
    }
}
