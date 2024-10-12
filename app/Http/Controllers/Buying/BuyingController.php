<?php

namespace App\Http\Controllers\Buying;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Buying\Buying;
use App\Models\Buying\BuyingDetail;
use App\Models\Buying\Supplier;
use App\Models\Accounting\Bank;
use App\Models\Stock\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BuyingController extends Controller
{
    private function GenerateCode($date = '')
    {
        if ($date == '') {
            $date = Carbon::now();
        } else {
            $date = Carbon::parse($date);
        }

        $result = Buying::whereDate('date_input', '=', $date->format('Y-m-d'))->count() + 1;
        $result = "PO-" . $date->format('ymd') . "-" . substr("0000{$result}", -4);

        return $result;
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"],
            ['link' => "buying.buying.index", 'name' => "Buying"]
        ];

        if (Request::get("date_from")) {
            $date_from = date('Y-m-d', strtotime(Request::get('date_from')));
            $date_to = date('Y-m-d', strtotime(Request::get('date_to')));    
        } else {
            $date_from = Carbon::now()->addDays(-31);
            $date_to = Carbon::now();
        }

        $query = Buying::with('suppliers', 'banks', 'users')->whereBetween('date_input', [$date_from, $date_to])->get();
        return view('content.buying.buying.index', compact('query', 'date_from', 'date_to'), ['breadcrumbs' => $breadcrumbs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"],
            ['link' => "buying.buying.index", 'name' => "Buying"],
            ['link' => "buying.buying.create", 'name' => "Create Buying"]
        ];

        $invoice = $this->GenerateCode();
        $date_input = Carbon::now();
        $due_date = Carbon::now()->addDays(3);

        $suppliers = Supplier::get();
        $banks = Bank::get();
        $products = Product::get();

        return view('content.buying.buying.create', compact('invoice', 'date_input', 'due_date', 'suppliers', 'banks', 'products'), ['breadcrumbs' => $breadcrumbs]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $date_input = date('Y-m-d', strtotime(Request::get('date_input')));
        $due_date = date('Y-m-d', strtotime(Request::get('due_date')));

        $code = $this->GenerateCode($date_input);

        $rate = 0;
        $subtotal = 0;
        foreach (Request::get('temps') as $key => $value) {
            if ($value['id'] != null) {
                $rate += $value['rate'];
                $subtotal += ($value['rate'] * $value['amount']);
            }
        }

        $buying = Buying::create([
            'code' => $code,
            'title' => Request::get('title'),
            'date_input' => $date_input,
            'due_date' => $due_date,
            'rate' => $rate,
            'subtotal' => $subtotal,
            'discount' => Request::get('discountTotal'),
            'pay' => Request::get('pay'),
            'supplier_id' => Request::get('supplier_id'),
            'bank_id' => Request::get('bank_id'),
            'user_id' => Auth::user()->id,
        ]);

        foreach (Request::get('temps') as $key => $value) {
            if ($value['id'] != null) {
                BuyingDetail::create([
                    'buying_id' => $buying->id,
                    'prod_id' => $value['id'],
                    'rate' => $value['rate'],
                    'amount' => $value['amount'],
                    'discount' => $value['discount'],
                ]);
            }
        }

        if (Request::get('is_print') == 0) {
            return redirect()->route('buying.buying.create')->with('message', 'create success');
        } else { 
            return redirect()->route('buying.buying.print', $buying->id);
        }
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
    public function edit(Buying $buying)
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "buying.buying.index", 'name' => "Buying"], ['link' => "buying/buying/edit/$buying->id", 'name' => "Edit Buying"]
        ];

        $query = Buying::with('buying_details', 'buying_details.products', 'suppliers', 'banks', 'users')->where('id', '=', $buying->id)->first();

        $suppliers = Supplier::get();
        $banks = Bank::get();
        $products = Product::get();

        // dd($query);

        return view('content.buying.buying.edit', compact('query', 'suppliers', 'banks', 'products'), ['breadcrumbs' => $breadcrumbs]);         
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Buying $buying, Request $request)
    {
        $date_input = date('Y-m-d', strtotime(Request::get('date_input')));
        $due_date = date('Y-m-d', strtotime(Request::get('due_date')));

        $rate = 0;
        $subtotal = 0;
        foreach (Request::get('temps') as $key => $value) {
            if ($value['id'] != null) {
                $rate += $value['rate'];
                $subtotal += ($value['rate'] * $value['amount']);
            }
        }

        $buying->update([
            'title' => Request::get('title'),
            'date_input' => $date_input,
            'due_date' => $due_date,
            'rate' => $rate,
            'subtotal' => $subtotal,
            'discount' => Request::get('discountTotal'),
            'pay' => Request::get('pay'),
            'supplier_id' => Request::get('supplier_id'),
            'bank_id' => Request::get('bank_id'),
            'user_id' => Auth::user()->id,
        ]);

        BuyingDetail::where('buying_id', '=', $buying->id)->delete();
        foreach (Request::get('temps') as $key => $value) {
            if ($value['id'] != null) {
                BuyingDetail::create([
                    'buying_id' => $buying->id,
                    'prod_id' => $value['id'],
                    'rate' => $value['rate'],
                    'amount' => $value['amount'],
                    'discount' => $value['discount'],
                ]);
            }
        }

        if (Request::get('is_print') == 0) {
            return redirect()->route('buying.buying.index')->with('message', 'update success');
        } else { 
            return redirect()->route('buying.buying.print', $buying->id);
        }        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buying $buying)
    {
        $buying->delete();
        BuyingDetail::where('buying_id', '=', $buying->id)->delete();
        
        return redirect()->route('buying.buying.index')->with('message', 'delete success');
    }

    public function print(Buying $buying)
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"],
            ['link' => "buying.buying.index", 'name' => "Buying"],
            ['link' => "buying.buying.create", 'name' => "Create Buying"], 
            ['link' => "buying/buying/print/$buying->id", 'name' => "Print"]
        ];

        $query = Buying::with('buying_details', 'buying_details.products', 'suppliers', 'banks', 'users')->where('id', '=', $buying->id)->first();

        return view('content.buying.buying.print', compact('query'), ['breadcrumbs' => $breadcrumbs]);
    }
}
