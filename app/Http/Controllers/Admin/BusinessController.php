<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App\Models\Business;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "admin.business.index", 'name' => "Business"]
        ];

        $query = Business::first();
        return view('content.admin.business.index', compact('query'), ['breadcrumbs' => $breadcrumbs]);          
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "admin.business.index", 'name' => "Business"], ['link' => "admin.business.create", 'name' => "Create Business"]
        ];

        return view('content.admin.business.create', ['breadcrumbs' => $breadcrumbs]);          
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Business::create([
            'name' => Request::get('name'),
            'address' => Request::get('address'),
            'email' => Request::get('email'),
            'telephone' => Request::get('telephone'),
            'description' => Request::get('description'),
        ]);

        return redirect()->route('admin.business.index');         
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
    public function edit(Business $business)
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"], ['link' => "admin.business.index", 'name' => "Business"], ['link' => "admin/business/edit/$business->id", 'name' => "Edit Business"]
        ];

        $query = [
            'id' => $business->id,
            'code' => $business->code,
            'name' => $business->name,
            'address' => $business->address,
            'email' => $business->email,
            'telephone' => $business->telephone,
            'description' => $business->description,
        ];
        return view('content.admin.business.edit', compact('query'), ['breadcrumbs' => $breadcrumbs]);         
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Business $business, Request $request)
    {
        $business->update([
            'name' => Request::get('name'),
            'address' => Request::get('address'),
            'email' => Request::get('email'),
            'telephone' => Request::get('telephone'),
            'description' => Request::get('description'),
        ]);

        return redirect()->route('admin.business.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
