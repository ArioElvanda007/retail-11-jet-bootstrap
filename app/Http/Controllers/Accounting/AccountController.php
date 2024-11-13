<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Accounting\Account;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
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
        if (app($this->can_access())->access('accounts')->access[0]->can_view == 0) {
            return abort(401);
        } 

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "accounting.accounts.index", 'name' => "Accounts"]
        ];

        $query = Account::orderBy('seq', 'asc')->get();
        return view('content.accounting.accounts.index', compact('query'), ['breadcrumbs' => $breadcrumbs]);  
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (app($this->can_access())->access('accounts')->access[0]->can_create == 0) {
            return abort(401);
        }

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "accounting.accounts.index", 'name' => "Accounts"], ['link' => "accounting.accounts.create", 'name' => "Create Account"]
        ];

        $accounts = Account::orderBy('seq', 'asc')->get();
        return view('content.accounting.accounts.create', compact('accounts'), ['breadcrumbs' => $breadcrumbs]);  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (app($this->can_access())->access('accounts')->access[0]->can_create == 0) {
            return abort(401);
        } 


        $seq = 0;
        if (Request::get('seq') != null) {
            $seq = Request::get('seq');
        }

        DB::update("UPDATE accounts SET seq = seq + 2 WHERE seq > $seq + 1;");

        Account::create([
            'seq' => $seq + 1,
            'code' => Request::get('code'),
            'name' => Request::get('name'),
            'position' => Request::get('position') == "" ? null: Request::get('position'),
            'description' => Request::get('description'),
        ]);

        return redirect()->route('accounting.accounts.index');  
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
    public function edit(Account $account)
    {
        if (app($this->can_access())->access('accounts')->access[0]->can_update == 0) {
            return abort(401);
        } 

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "accounting.accounts.index", 'name' => "Accounts"], ['link' => "accounting/accounts/edit/$account->id", 'name' => "Edit Account"]
        ];

        $accounts = Account::where('seq', '<>', $account->seq)->orderBy('seq', 'asc')->get();
        $seq = Account::where('seq', '<', $account->seq)->orderBy('seq', 'desc')->first();

        $query = [
            'id' => $account->id,
            'seq' => $seq == null ? 0: $seq->seq,
            'code' => $account->code,
            'name' => $account->name,
            'position' => $account->position,
            'description' => $account->description,
        ];

        return view('content.accounting.accounts.edit', compact('query', 'accounts'), ['breadcrumbs' => $breadcrumbs]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Account $account, Request $request)
    {
        if (app($this->can_access())->access('accounts')->access[0]->can_update == 0) {
            return abort(401);
        } 

        $seq = 0;
        if (Request::get('seq') != null) {
            $seq = Request::get('seq');
        }

        DB::update("UPDATE accounts SET seq = seq + 2 WHERE seq > $seq + 1;");

        $account->update([
            'seq' => $seq + 1,
            'code' => Request::get('code'),
            'name' => Request::get('name'),
            'position' => Request::get('position') == "" ? null: Request::get('position'),
            'description' => Request::get('description'),
        ]);

        return redirect()->route('accounting.accounts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        if (app($this->can_access())->access('accounts')->access[0]->can_delete == 0) {
            return abort(401);
        } 

        $account->delete();

        return redirect()->route('accounting.accounts.index');  
    }
}
