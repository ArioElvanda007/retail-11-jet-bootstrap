<?php

namespace App\Http\Controllers\Buying;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Buying\Buying;
use App\Models\Buying\BuyingDetail;
use App\Models\Buying\Supplier;
use App\Models\Accounting\Bank;
use App\Models\Stock\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BuyingController extends Controller
{
    private function GenerateCode()
    {
        $result = Buying::whereDate('created_at', '=', Carbon::now()->format('Y-m-d'))->count() + 1;
        $result = "PO-" . Carbon::now()->format('ymd') . "-" . substr("0000{$result}", -4);

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
            $date_from = Carbon::parse(Request::get("date_from"));
            $date_to = Carbon::parse(Request::get("date_to"));
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

        $po = $this->GenerateCode();
        $date_input = Carbon::now();
        $due_date = Carbon::now()->addDays(3);

        $suppliers = Supplier::get();
        $banks = Bank::get();
        $products = Product::get();

        return view('content.buying.buying.create', compact('po', 'date_input', 'due_date', 'suppliers', 'banks', 'products'), ['breadcrumbs' => $breadcrumbs]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $code = $this->GenerateCode();

        $rate = 0;
        $subtotal = 0;
        foreach (Request::get('temps') as $key => $value) {
            if ($value['id'] != null) {
                $rate = $rate + $value['rate'];
                $subtotal = $subtotal + ($value['rate'] * $value['amount']);
            }
        }

        $buying = Buying::create([
            'code' => $code,
            'title' => Request::get('title'),
            'date_input' => Request::get('date_input'),
            'due_date' => Request::get('due_date'),
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
