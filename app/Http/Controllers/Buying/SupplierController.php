<?php

namespace App\Http\Controllers\Buying;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Buying\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "buying.suppliers.index", 'name' => "Suppliers"]
        ];

        $query = Supplier::get();
        return view('content.buying.suppliers.index', compact('query'), ['breadcrumbs' => $breadcrumbs]);    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "buying.suppliers.index", 'name' => "Suppliers"], ['link' => "buying.suppliers.create", 'name' => "Create Supplier"]
        ];

        return view('content.buying.suppliers.create', ['breadcrumbs' => $breadcrumbs]);  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Supplier::create([
            'name' => Request::get('name'),
            'address' => Request::get('address'),
            'email' => Request::get('email'),
            'telephone' => Request::get('telephone'),
            'description' => Request::get('description'),
        ]);

        return redirect()->route('buying.suppliers.index'); 
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
    public function edit(Supplier $supplier)
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "buying.suppliers.index", 'name' => "Suppliers"], ['link' => "buying/suppliers/edit/$supplier->id", 'name' => "Edit Supplier"]
        ];

        $query = [
            'id' => $supplier->id,
            'code' => $supplier->code,
            'name' => $supplier->name,
            'address' => $supplier->address,
            'email' => $supplier->email,
            'telephone' => $supplier->telephone,
            'description' => $supplier->description,
        ];
        return view('content.buying.suppliers.edit', compact('query'), ['breadcrumbs' => $breadcrumbs]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Supplier $supplier, Request $request)
    {
        $supplier->update([
            'name' => Request::get('name'),
            'address' => Request::get('address'),
            'email' => Request::get('email'),
            'telephone' => Request::get('telephone'),
            'description' => Request::get('description'),
        ]);

        return redirect()->route('buying.suppliers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        if ($supplier->id == 1) {
            return redirect()->back();
        }

        $supplier->delete();

        return redirect()->route('buying.suppliers.index');  
    }
}
