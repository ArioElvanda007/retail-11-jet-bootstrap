<?php

namespace App\Http\Controllers\Selling;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Selling\Selling;
use App\Models\Selling\SellingDetail;
use App\Models\Selling\Customer;
use App\Models\Accounting\Bank;
use App\Models\Stock\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SellingController extends Controller
{
    private function GenerateCode($date = '')
    {
        if ($date == '') { $date = Carbon::now();
        } else { $date = Carbon::parse($date); }

        $result = Selling::whereDate('date_input', '=', $date->format('Y-m-d'))->count() + 1;
        $result = "SO-" . $date->format('ymd') . "-" . substr("0000{$result}", -4);

        return $result;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"],
            ['link' => "selling.selling.index", 'name' => "Selling"]
        ];

        if (Request::get("date_from")) {
            $date_from = date('Y-m-d', strtotime(Request::get('date_from')));
            $date_to = date('Y-m-d', strtotime(Request::get('date_to')));    
        } else {
            $date_from = Carbon::now()->addDays(-31);
            $date_to = Carbon::now();
        }

        $query = Selling::with('customers', 'banks', 'users')->whereBetween('date_input', [$date_from, $date_to])->get();
        return view('content.selling.selling.index', compact('query', 'date_from', 'date_to'), ['breadcrumbs' => $breadcrumbs]);        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"],
            ['link' => "selling.selling.index", 'name' => "Selling"],
            ['link' => "selling.selling.create", 'name' => "Create Selling"]
        ];

        $date_input = Carbon::now();
        $due_date = Carbon::now()->addDays(3);
        $invoice = $this->GenerateCode($date_input);

        $customers = Customer::get();
        $banks = Bank::get();
        $products = Product::get();

        return view('content.selling.selling.create', compact('invoice', 'date_input', 'due_date', 'customers', 'banks', 'products'), ['breadcrumbs' => $breadcrumbs]);        
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

        $selling = Selling::create([
            'code' => $code,
            'title' => Request::get('title'),
            'date_input' => $date_input,
            'due_date' => $due_date,
            'rate' => $rate,
            'subtotal' => $subtotal,
            'discount' => Request::get('discountTotal'),
            'pay' => Request::get('pay'),
            'customer_id' => Request::get('customer_id'),
            'bank_id' => Request::get('bank_id'),
            'user_id' => Auth::user()->id,
        ]);

        foreach (Request::get('temps') as $key => $value) {
            if ($value['id'] != null) {
                $products = Product::where('id', '=', $value['id'])->first();

                SellingDetail::create([
                    'selling_id' => $selling->id,
                    'prod_id' => $value['id'],
                    'cogs' => $products->price_buy, 
                    'rate' => $value['rate'],
                    'amount' => $value['amount'],
                    'discount' => $value['discount'],
                ]);
            }
        }

        if (Request::get('is_print') == 0) {
            return redirect()->route('selling.selling.create')->with('message', 'create success');
        } else { 
            return redirect()->route('selling.selling.print', $selling->id);
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
    public function edit(Selling $selling)
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "selling.selling.index", 'name' => "Selling"], ['link' => "selling/selling/edit/$selling->id", 'name' => "Edit Selling"]
        ];

        $query = Selling::with('selling_details', 'selling_details.products', 'customers', 'banks', 'users')->where('id', '=', $selling->id)->first();

        $customers = Customer::get();
        $banks = Bank::get();
        $products = Product::get();

        // dd($query);

        return view('content.selling.selling.edit', compact('query', 'customers', 'banks', 'products'), ['breadcrumbs' => $breadcrumbs]);                 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Selling $selling, Request $request)
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

        $selling->update([
            'title' => Request::get('title'),
            'date_input' => $date_input,
            'due_date' => $due_date,
            'rate' => $rate,
            'subtotal' => $subtotal,
            'discount' => Request::get('discountTotal'),
            'pay' => Request::get('pay'),
            'customer_id' => Request::get('customer_id'),
            'bank_id' => Request::get('bank_id'),
            'user_id' => Auth::user()->id,
        ]);

        SellingDetail::where('selling_id', '=', $selling->id)->delete();
        foreach (Request::get('temps') as $key => $value) {
            if ($value['id'] != null) {
                $products = Product::where('id', '=', $value['id'])->first();

                SellingDetail::create([
                    'selling_id' => $selling->id,
                    'prod_id' => $value['id'],
                    'cogs' => $products->price_buy, 
                    'rate' => $value['rate'],
                    'amount' => $value['amount'],
                    'discount' => $value['discount'],
                ]);
            }
        }

        if (Request::get('is_print') == 0) {
            return redirect()->route('selling.selling.index')->with('message', 'update success');
        } else { 
            return redirect()->route('selling.selling.print', $selling->id);
        }          
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Selling $selling)
    {
        $selling->delete();
        SellingDetail::where('selling_id', '=', $selling->id)->delete();
        
        return redirect()->route('selling.selling.index')->with('message', 'delete success');        
    }

    public function print(Selling $selling)
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"],
            ['link' => "selling.selling.index", 'name' => "Selling"],
            ['link' => "selling.selling.create", 'name' => "Create Selling"], 
            ['link' => "selling/selling/print/$selling->id", 'name' => "Print"]
        ];

        $query = selling::with('selling_details', 'selling_details.products', 'customers', 'banks', 'users')->where('id', '=', $selling->id)->first();

        return view('content.selling.selling.print', compact('query'), ['breadcrumbs' => $breadcrumbs]);
    }    
}
