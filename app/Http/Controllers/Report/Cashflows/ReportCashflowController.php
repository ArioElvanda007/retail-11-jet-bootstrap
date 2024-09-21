<?php

namespace App\Http\Controllers\Report\Cashflows;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon;

class ReportCashflowController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['link' => "dashboard", 'name' => "Dashboard"],
            ['link' => "report.cashflows.index", 'name' => "Report Cashflows"]
        ];

        $date_from = Carbon::now();
        return view('content.report.cashflows.index', compact('date_from'), ['breadcrumbs' => $breadcrumbs]);
    }       
}
