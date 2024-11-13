<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Accounting\Bank;

class BankController extends Controller
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
        if (app($this->can_access())->access('banks')->access[0]->can_view == 0) {
            return abort(401);
        } 

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "accounting.banks.index", 'name' => "Banks"]
        ];

        $query = Bank::get();
        return view('content.accounting.banks.index', compact('query'), ['breadcrumbs' => $breadcrumbs]);    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (app($this->can_access())->access('banks')->access[0]->can_create == 0) {
            return abort(401);
        } 

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "accounting.banks.index", 'name' => "Banks"], ['link' => "accounting.banks.create", 'name' => "Create Bank"]
        ];

        return view('content.accounting.banks.create', ['breadcrumbs' => $breadcrumbs]);  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (app($this->can_access())->access('banks')->access[0]->can_create == 0) {
            return abort(401);
        } 

        Bank::create([
            'account_number' => Request::get('account_number'),
            'account_name' => Request::get('account_name'),
            'branch_office' => Request::get('branch_office'),
            'behalf_of' => Request::get('behalf_of'),
            'description' => Request::get('description'),
        ]);

        return redirect()->route('accounting.banks.index');         
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
    public function edit(Bank $bank)
    {
        if (app($this->can_access())->access('banks')->access[0]->can_update == 0) {
            return abort(401);
        } 

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "accounting.banks.index", 'name' => "Banks"], ['link' => "accounting/banks/edit/$bank->id", 'name' => "Edit Bank"]
        ];

        $query = [
            'id' => $bank->id,
            'account_number' => $bank->account_number,
            'account_name' => $bank->account_name,
            'branch_office' => $bank->branch_office,
            'behalf_of' => $bank->behalf_of,
            'description' => $bank->description,
        ];
        return view('content.accounting.banks.edit', compact('query'), ['breadcrumbs' => $breadcrumbs]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Bank $bank, Request $request)
    {
        if (app($this->can_access())->access('banks')->access[0]->can_update == 0) {
            return abort(401);
        }

        $bank->update([
            'account_number' => Request::get('account_number'),
            'account_name' => Request::get('account_name'),
            'branch_office' => Request::get('branch_office'),
            'behalf_of' => Request::get('behalf_of'),
            'description' => Request::get('description'),
        ]);

        return redirect()->route('accounting.banks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $bank)
    {
        if (app($this->can_access())->access('banks')->access[0]->can_delete == 0) {
            return abort(401);
        } 

        $bank->delete();

        return redirect()->route('accounting.banks.index');  
    }
}
