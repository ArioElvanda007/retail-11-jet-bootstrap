<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
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
        if (app($this->can_access())->access('dashboard')->access[0]->modules->is_active == 0 || app($this->can_access())->access('dashboard')->access[0]->can_view == 0) {
            return abort(401);
        } 

        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"]
        ];
        
        $dateFrom = Carbon::now()->format('Y-m-d');

        $query = DB::select("CALL spReportDashboard('$dateFrom')");
        $chartSPCMonthly = DB::select("CALL spChartSPCMonthly('$dateFrom')");

        return view('content.dashboard', compact('query', 'chartSPCMonthly', 'dateFrom'), ['breadcrumbs' => $breadcrumbs]);        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
}
