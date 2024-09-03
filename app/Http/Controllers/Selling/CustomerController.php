<?php

namespace App\Http\Controllers\Selling;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Selling\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "selling.customers.index", 'name' => "Customers"]
        ];

        $query = Customer::get();
        return view('content.selling.customers.index', compact('query'), ['breadcrumbs' => $breadcrumbs]);        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "selling.customers.index", 'name' => "Customers"], ['link' => "selling.customers.create", 'name' => "Create Customer"]
        ];

        return view('content.selling.customers.create', ['breadcrumbs' => $breadcrumbs]);  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Customer::create([
            'name' => Request::get('name'),
            'address' => Request::get('address'),
            'email' => Request::get('email'),
            'telephone' => Request::get('telephone'),
            'description' => Request::get('description'),
        ]);

        return redirect()->route('selling.customers.index'); 
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
    public function edit(Customer $customer)
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "selling.customers.index", 'name' => "Customers"], ['link' => "selling/products/edit/$customer->id", 'name' => "Edit Customer"]
        ];

        $query = [
            'id' => $customer->id,
            'code' => $customer->code,
            'name' => $customer->name,
            'address' => $customer->address,
            'email' => $customer->email,
            'telephone' => $customer->telephone,
            'description' => $customer->description,
        ];
        return view('content.selling.customers.edit', compact('query'), ['breadcrumbs' => $breadcrumbs]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Customer $customer, Request $request)
    {
        $customer->update([
            'name' => Request::get('name'),
            'address' => Request::get('address'),
            'email' => Request::get('email'),
            'telephone' => Request::get('telephone'),
            'description' => Request::get('description'),
        ]);

        return redirect()->route('selling.customers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        if ($customer->id == 1) {
            return redirect()->back();
        }

        $customer->delete();

        return redirect()->route('selling.customers.index');    
    }
}
