<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Accounting\CashFlow;
use App\Models\Accounting\Bank;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CashFlowController extends Controller
{
    private function GenerateCode($date = '')
    {
        if ($date == '') { $date = Carbon::now();
        } else { $date = Carbon::parse($date); }

        $result = CashFlow::whereDate('date_input', '=', $date->format('Y-m-d'))->count() + 1;
        $result = "CF-" . $date->format('ymd') . "-" . substr("0000{$result}", -4);

        return $result;
    }    



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"],
            ['link' => "accounting.cashflows.index", 'name' => "Cashflows"]
        ];

        if (Request::get("date_from")) {
            $date_from = date('Y-m-d', strtotime(Request::get('date_from')));
            $date_to = date('Y-m-d', strtotime(Request::get('date_to')));    
        } else {
            $date_from = Carbon::now()->addDays(-31);
            $date_to = Carbon::now();
        }

        $query = CashFlow::with('banks', 'users')->whereBetween('date_input', [$date_from, $date_to])->get();
        return view('content.accounting.cashflows.index', compact('query', 'date_from', 'date_to'), ['breadcrumbs' => $breadcrumbs]);        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"],
            ['link' => "accounting.cashflows.index", 'name' => "Cashflows"],
            ['link' => "accounting.cashflows.create", 'name' => "Create Cashflow"]
        ];

        $date_input = Carbon::now();
        $invoice = $this->GenerateCode($date_input);

        $banks = Bank::get();

        return view('content.accounting.cashflows.create', compact('invoice', 'date_input', 'banks'), ['breadcrumbs' => $breadcrumbs]);        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $date_input = date('Y-m-d', strtotime(Request::get('date_input')));
        $code = $this->GenerateCode($date_input);

        $cashflow = CashFlow::create([
            'code' => $code,
            'title' => Request::get('title'),
            'date_input' => $date_input,
            'debet' => Request::get('debet'),
            'credit' => Request::get('credit'),
            'bank_id' => Request::get('bank_id'),
            'user_id' => Auth::user()->id,
        ]);

        if (Request::get('is_print') == 0) {
            return redirect()->route('accounting.cashflows.create')->with('message', 'create success');
        } else { 
            return redirect()->route('accounting.cashflows.print', $cashflow->id);
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
    public function edit(CashFlow $cashflow)
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "accounting.cashflows.index", 'name' => "Cashflows"], ['link' => "accounting/cashflows/edit/$cashflow->id", 'name' => "Edit Cashflow"]
        ];

        $query = CashFlow::with('banks')->where('id', '=', $cashflow->id)->first();
        $banks = Bank::get();

        return view('content.accounting.cashflows.edit', compact('query', 'banks'), ['breadcrumbs' => $breadcrumbs]);         
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CashFlow $cashflow, Request $request)
    {
        $date_input = date('Y-m-d', strtotime(Request::get('date_input')));

        $cashflow->update([
            'title' => Request::get('title'),
            'date_input' => $date_input,
            'debet' => Request::get('debet'),
            'credit' => Request::get('credit'),
            'bank_id' => Request::get('bank_id'),
            'user_id' => Auth::user()->id,
        ]);

        if (Request::get('is_print') == 0) {
            return redirect()->route('accounting.cashflows.index')->with('message', 'update success');
        } else { 
            return redirect()->route('accounting.cashflows.print', $cashflow->id);
        }            
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CashFlow $cashflow)
    {
        $cashflow->delete();
        
        return redirect()->route('accounting.cashflows.index')->with('message', 'delete success');        
    }



    public function print(CashFlow $cashflow)
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"],
            ['link' => "accounting.cashflows.index", 'name' => "Cashflows"],
            ['link' => "accounting.cashflows.create", 'name' => "Create Cashflow"], 
            ['link' => "accounting/cashflows/print/$cashflow->id", 'name' => "Print"]
        ];

        $query = CashFlow::with('banks', 'users')->where('id', '=', $cashflow->id)->first();

        return view('content.accounting.cashflows.print', compact('query'), ['breadcrumbs' => $breadcrumbs]);
    }    
}
